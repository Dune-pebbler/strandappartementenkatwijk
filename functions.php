<?php
global $is_searching;

$enable_clients = false;

# DEFINES
define('MIB_PATH', get_template_directory());
define('MIB_URL', get_template_directory_uri());

# REQUIRES
require_once( get_template_directory() . '/aurel-panel/aurel-panel-options.php' );
require_once( get_template_directory() . '/inc/shortcodes.php' );
require_once( get_template_directory() . '/aurel-hotel/aurel-hotel-init.php' );

# ACTIONS
add_action('wp_enqueue_scripts', 'theme_enqueue_jquery');
add_action('admin_enqueue_scripts', 'admin_enqueue_scripts');
add_action('gform_after_submission', 'gform_add_to_reservation_system', 10, 2);
# FILTERS
add_filter('wp_page_menu_args', 'home_page_menu_args');
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);
add_filter('the_content', 'remove_thumbnail_dimensions', 10);
add_filter('the_content', 'add_image_responsive_class');
add_filter('upload_mimes', 'cc_mime_types');
add_filter('use_block_editor_for_post', '__return_false');
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
add_filter('acf/settings/load_json', 'my_acf_json_load_point');
add_filter('pre_get_posts','theme_search_filter', 9000);

# THEME SUPPORTS
add_theme_support('menus');
add_theme_support('post-thumbnails'); // array for post-thumbnail support on certain post-types.
# IMAGE SIZES
add_image_size('default-thumbnail', 128, 128, true); // true: hard crop or empty if soft crop
add_image_size('medium', 600, 300, true); // true: hard crop or empty if soft crop
add_image_size('large', 1920, 500, true); // true: hard crop or empty if soft crop
add_image_size('medium_large', 500, 500, true); // true: hard crop or empty if soft crop

set_post_thumbnail_size(128, 128, true);

# FUNCTIONS
register_nav_menus(array(
    'primary' => __('Primary Menu', 'project'),
    'footer-1' => __('Footer 1 Menu', 'project'),
    'footer-2' => __('Footer 2 Menu', 'project'),
));

function admin_enqueue_scripts() {
  wp_enqueue_style('flatpickr-css', "https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css");
  wp_enqueue_style('theme-admin-css', get_template_directory_uri() . '/stylesheets/admin.css');

  wp_enqueue_script('moment-js',  get_template_directory_uri() . '/aurel-hotel/moment.js');
  wp_enqueue_script('flatpickr-js', 'https://cdn.jsdelivr.net/npm/flatpickr');
}

function theme_enqueue_jquery() {
  wp_enqueue_script('jquery');
}

function my_acf_json_save_point($path) {
  // update path
  $path = get_stylesheet_directory() . '/acf';

  // return
  return $path;
}

function theme_search_filter($query) {
  global $wp_query, $is_searching;
  // if we are not on search query, we can skip.
  if ( !$query->is_search  ) { return $query; }
  // only on the front end
  if( is_admin() ) return $query;
  // if we are already searching, skip :)
  if( $is_searching ) return $query;

  // switch on the is search variable.
  $is_searching = true;

  $args = [
    'post_type' => ['post', 'page', 'projecten'],
    'posts_per_page' => -1,
    'orderby' => 'post_title',
    'order' => 'ASC',
    'meta_query' => [
      [
        'value' => "{$_GET['s']}",
        'compare' => 'LIKE',
      ]
    ]
  ];

  $post_search_query = new WP_Query([
    'post_type' => ['post', 'page', 'projecten'],
    'posts_per_page' => -1,
    'orderby' => 'post_title',
    'order' => 'ASC',
    's' => $_GET['s'],
  ]);
  $search_query = new WP_Query($args);
  $search_query->is_search = true;

  if( $search_query->have_posts() )
    $wp_query = $query = $search_query;

  $wp_query->posts = $query->posts = $search_query->posts = array_merge($search_query->posts, $post_search_query->posts);
  $wp_query->post_count = $query->post_count = $search_query->post_count = $search_query->post_count + $post_search_query->post_count;

  // reset the is search variabel
  $is_searching = false;

  return $query;

}

function my_acf_json_load_point($paths) {

  // remove original path (optional)
  unset($paths[0]);

  // append path
  $paths[] = get_stylesheet_directory() . '/acf';

  // return
  return $paths;
}

function home_page_menu_args($args) {
  $args['show_home'] = true;
  return $args;
}

function remove_thumbnail_dimensions($html) {
  $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
  return $html;
}

function remove_width_attribute($html) {
  $html = preg_replace('/(width|height)="\d*"\s/', "", $html);
  return $html;
}

function add_image_responsive_class($content) {
  global $post;
  $pattern = "/<img(.*?)class=\"(.*?)\"(.*?)>/i";
  $replacement = '<img$1class="$2 img-responsive"$3>';
  $content = preg_replace($pattern, $replacement, $content);
  return $content;
}

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}

function print_pre($print) {
  echo'<pre>';
  print_r($print);
  echo '</pre>';
}

if( !function_exists('get_svg') ){
  function get_svg($path) {
    // die(__DIR__."/img/{$path}");
    return file_get_contents(__DIR__ . "/img/{$path}");
  }
}

function gform_add_to_reservation_system($entry, $form){
		$resas = get_option( 'ah_reservations', [] );
    $mapper = [
      '1' => 'First-name',
      '3' => 'Last-name',
      '4' => 'Email',
      '5' => 'Telefoonnummer',
      '10' => 'Opmerkingen',
    ];
    $result = [
      'status' => 'pending',
      'check_in_check_out' => 'yes',
      'check_in' => $entry[7],
      'check_out' => $entry[8],
      'received_on' => date("Y-m-d"),
      'replied_on' => [],
      'mail' => $entry[4],
      'room_type' => 'double',
      'data' => [],
    ];

    // build based on mapper.
    foreach($mapper as $id => $label){
      $result['data'][sanitize_title($label)] = $entry[$id];
      $result['data']['room'][] = 'double';
      $result['data']['check-in'] = $entry[7];
      $result['data']['check-in-formatted'] = $entry[7];
      $result['data']['check-out'] = $entry[8];
      $result['data']['check-out-formatted'] = $entry[8];
    }

    // we append it to the resas.
    array_unshift($resas, $result);

    // update the option
    update_option('ah_reservations', $resas);
}

# Random code
// add editor the privilege to edit theme
// get the the role object
$role_object = get_role('editor');
// add $cap capability to this role object
$role_object->add_cap('edit_theme_options');

if (function_exists('acf_add_options_sub_page')) {
  acf_add_options_page();
  acf_add_options_sub_page('Footer');
//     acf_add_options_sub_page( 'Side Menu' );
//     acf_add_options_sub_page( 'Social media' );
}


if ( is_admin() ) { // i.e. back-end

	// aurel-panel-init
	require_once( get_template_directory() . '/aurel-panel/aurel-panel-init.php' );

	// custom fields
	require_once( get_template_directory() . '/inc/custom-fields.php' );
	
	// misc
	function change_media_button_text( $translation, $text, $domain ){
		if ( $text == 'Insert into Post' ) {
			return 'Use this image';
		}
		return $translation;
	}
	add_filter( 'gettext', 'change_media_button_text', 10, 3 );

} else { // !is_admin() i.e. front-end
	
	// comments displaying functions
	require_once( get_template_directory() . '/inc/comments-displaying.php' );
	
	// custom css
	require_once( get_template_directory() . '/inc/custom-css.php' );
	// add_action('wp_head','palace_custom_css');
	
	// enqueue js scripts
	require_once( get_template_directory() . '/inc/enqueue-js-scripts.php' );
	add_action( 'wp_enqueue_scripts', 'ap_enqueue_js_scripts' );

	function load_aq_resizer() {
		// require_once( get_template_directory() . '/img-resizer/aq_resizer.php' );
	}
	// add_action('wp_head', 'load_aq_resizer');

	load_theme_textdomain( 'thepalace', get_template_directory() . '/lang' );
	/* end theme support - image size - language */

	// misc
	if (function_exists('qtrans_convertURL')) {
		add_filter('home_url', 'qtrans_convertURL');
	}
}