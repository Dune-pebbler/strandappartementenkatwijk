<?php
function ap_custom_boxes() {
	add_meta_box( 'ap_custom_box_page_options_id', 'Page Options', 'ap_custom_box_page_options_launch_display', 'page', 'normal', 'high' );
	add_meta_box( 'ap_custom_box_post_options_id', 'Post Options', 'ap_custom_box_post_options_launch_display', 'post', 'normal', 'high' );
}

function ap_custom_box_page_options_launch_display( $post ) {
	ap_custom_box_page_post_options_display( 'page', $post->ID );
}

function ap_custom_box_post_options_launch_display( $post ) {
	ap_custom_box_page_post_options_display( 'post', $post->ID );
}

function ap_custom_box_page_post_options_display( $type, $postID ) {
	global $ap_options;
	require_once( get_template_directory() . '/aurel-panel/aurel-panel-display-functions.php' );
	$fields_desc = '';
	if ( $type == 'post' ) {
		$fields_desc = 'or in the category section ';
	}
?>
<p>
	First line:
</p>
<p>
	<input id="pm-first-line" name="pm-first-line" type="text" class="widefat" value="<?php echo( get_post_meta($postID, 'pm-first-line', true) ); ?>" />
</p>
<?php
$no_feature_image_checked = '';
if ( get_post_meta($postID, 'pm-display-feature-image', true) == 'dont-display-feature-image' ) {
	$no_feature_image_checked = 'checked';
}
$no_title_checked = '';
if ( get_post_meta($postID, 'pm-display-title', true) == 'dont-display-title' ) {
	$no_title_checked = 'checked';
}
?>
<p>
	Do not display the feature image in the content: <input type="checkbox" name="pm-display-feature-image" value="dont-display-feature-image" <?php echo( $no_feature_image_checked ); ?>/>
</p><p>
	Do not display the title: <input type="checkbox" name="pm-display-title" value="dont-display-title" <?php echo( $no_title_checked ); ?>/>
</p>
<p>
	Layout:
</p>
<?php 
$layout_options = array(
	array( 'default', 'Don\'t override default' ),
	array( 'full-width', 'Full width' ),
	array( 'one-col-left-sidebar', 'One column and left sidebar' ),
	array( 'one-col-right-sidebar', 'One column and right sidebar')
);
aurel_panel_display_select_advanced( 'pm-page-layout', 'pm-page-layout', $layout_options, get_post_meta($postID, 'pm-page-layout', true) );  
?>
<div id="pm-page-sidebar">
	<p>
		Sidebar name:
	</p>
	<?php aurel_panel_display_sidebar_selector( 'pm-sidebar-name', get_post_meta($postID, 'pm-sidebar-name', true), true ); ?>
</div>
<p>
	Header image (leave blank to display the default image set in the header section <?php echo( $fields_desc ); ?>of the theme options panel):
</p>
<?php 
aurel_panel_display_image_upload( 'pm-header-image', get_post_meta($postID, 'pm-header-image', true) ); 
?>
<p>
	- or display a slider: 
	<select name="pm-slider-name">
		<option value="no-slider">Choose a slider</option>
		<option value="remove-slider" <?php if ( get_post_meta($postID, 'pm-slider-name', true) == 'remove-slider' ) { echo( 'selected' ); } ?>>Do not display a slider</option>
		<?php
		foreach($ap_options['ap_global_slider_manager']['val'] as $slider) {
			if ( get_post_meta($postID, 'pm-slider-name', true) == $slider['name'] ) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			echo('<option ' . $selected . ' value="' . $slider['name'] . '">' . $slider['name'] . '</option>');
		}
		?>
	</select>
</p>
<?php
$header_map_type = get_post_meta( $postID, 'pm-header-map-type', true );
if ( $header_map_type == '' ) {
	$header_map_type = 'road';
}
?>
<p>
	- or display a header map:
	<br/>&nbsp;&nbsp;&nbsp;&nbsp; - enter lat and lng (coma-separated e.g: 53.337574, -6.259713) : <input id="pm-display-header-map" name="pm-display-header-map" type="text" value="<?php echo( get_post_meta($postID, 'pm-display-header-map', true) ); ?>" />
	<br/>&nbsp;&nbsp;&nbsp;&nbsp; - choose a type: &nbsp;&nbsp;<?php aurel_panel_display_radio( 'pm-header-map-type', array( 'road','satellite' ), $header_map_type, '', false ); ?>
</p>
<p>
	Background image (leave blank to display the default background):
</p>
<?php aurel_panel_display_image_upload( 'pm-background-image', get_post_meta($postID, 'pm-background-image', true) ); ?>
<p>
	If you have set a background image you can choose between the following features:
</p>
<?php 
$tile_or_stretch = get_post_meta($postID, 'pm-background-stretch-or-tile', true);
if ( $tile_or_stretch == '' ) {
	$tile_or_stretch = 'stretch';
}
$fixed_or_scrollable = get_post_meta($postID, 'pm-background-fixed-or-scrollable', true);
if ( $fixed_or_scrollable == '' ) {
	$fixed_or_scrollable = 'fixed';
}
aurel_panel_display_radio( 'pm-background-stretch-or-tile', array('stretch','tile'), $tile_or_stretch);
aurel_panel_display_radio( 'pm-background-fixed-or-scrollable', array('fixed','scrollable'), $fixed_or_scrollable); 
?>
</p>
<p>
	Footer image (leave blank to display the default image set in the footer section <?php echo( $fields_desc ); ?>of the theme options panel):
</p>
<?php aurel_panel_display_image_upload( 'pm-footer-image', get_post_meta($postID, 'pm-footer-image', true) ); ?>
<p>
	Header minimum height (in px - this field will not have any effect for on sliders as their height is defined in the Theme Options panel - leave blank if you don't want to override the default height):
</p>
<p>
	<input id="pm-header-height" name="pm-header-height" type="text" value="<?php echo( get_post_meta($postID, 'pm-header-height', true) ); ?>" />
</p>
<p>
	Custom CSS:
</p>
<p>
	<textarea id="pm-custom-css" name="pm-custom-css" class="widefat"><?php echo( get_post_meta($postID, 'pm-custom-css', true) ); ?></textarea>
</p>


<input type="hidden" id="ap-custom-fields" name="ap-custom-fields" value="ap-custom-fields"/>
<?php
}

add_action( 'add_meta_boxes', 'ap_custom_boxes' );

function ap_custom_boxes_save_postdata( $post_id ) {
	$ap_custom_fields = array(
		'pm-page-layout',
		'pm-sidebar-name',
		'pm-header-image',
		'pm-background-image',
		'pm-background-stretch-or-tile',
		'pm-background-fixed-or-scrollable',
		'pm-slider-name',
		'pm-display-header-map',
		'pm-header-map-type',
		'pm-footer-image',
		'pm-first-line',
		'pm-display-feature-image',
		'pm-display-title',
		'pm-header-height',
		'pm-custom-css'
	);
	if (isset($_POST['ap-custom-fields'])) {
        foreach ($ap_custom_fields as $custom_field) {
			update_post_meta($post_id, $custom_field, trim(stripslashes($_POST[$custom_field])));
        }
    }
}

add_action( 'save_post', 'ap_custom_boxes_save_postdata' );
add_action( 'publish_post', 'ap_custom_boxes_save_postdata');

function custom_boxes_script() {
    wp_enqueue_script('custom-boxes-script', get_template_directory_uri().'/aurel-panel/js/admin-custom-boxes.js', array('jquery'));
}

add_action('admin_print_scripts-post.php', 'custom_boxes_script');
add_action('admin_print_scripts-post-new.php', 'custom_boxes_script');

function custom_boxes_css() {
?>
<style type="text/css" media="screen">
.ap-width-75p {
	width: 75%;
}
</style>
<?php
}

add_action('admin_print_styles-post.php', 'custom_boxes_css');
add_action('admin_print_styles-post-new.php', 'custom_boxes_css');

function category_edit_custom_title( $tag ) {
	$title = '';
	$subtitle = '';
	$ap_category_titles = get_option( 'ap_category_titles' ); 
	$ap_category_subtitles = get_option( 'ap_category_subtitles' ); 
	if ( $ap_category_titles ) {
		if ( isset($ap_category_titles[$tag->term_id]) ) {
			$title = $ap_category_titles[$tag->term_id];
		}
	}	
	if ( $ap_category_subtitles ) {
		if ( isset($ap_category_subtitles[$tag->term_id]) ) {
			$subtitle = $ap_category_subtitles[$tag->term_id];
		}
	}
?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="custom_cat_title">Custom Category Title</label></th>
		<td>
			<input type="text" name="custom_cat_title" id="custom_cat_title" value="<?php echo( $title ); ?>" />
			<p class="description">Custom category title for category archive page.</p>
		</td>
	</tr>	
	<tr class="form-field">
		<th scope="row" valign="top"><label for="custom_cat_subtitle">Custom Category Subtitle</label></th>
		<td>
			<input type="text" name="custom_cat_subtitle" id="custom_cat_subtitle" value="<?php echo( $subtitle ); ?>" />
			<p class="description">Custom category sub-title for category archive page.</p>
		</td>
	</tr>
<?php
}

add_action('edit_category_form_fields', 'category_edit_custom_title');

function category_add_custom_title() {
?>
	<div class="form-field">
		<label for="custom_cat_title">Custom Category Title</label>
		<input type="text" name="custom_cat_title" id="custom_cat_title" />
		<p>Custom category title for category archive page.</p>
	</div>	
	<div class="form-field">
		<label for="custom_cat_subtitle">Custom Category Subtitle</label>
		<input type="text" name="custom_cat_subtitle" id="custom_cat_subtitle" />
		<p>Custom category subtitle for category archive page.</p>
	</div>
<?php
}

add_action('category_add_form_fields', 'category_add_custom_title');

function update_category_custom_title($term_id) {
	if ( (isset($_POST['taxonomy'])) && ($_POST['taxonomy'] == 'category') ) {
		$ap_category_titles = get_option('ap_category_titles');
		$ap_category_subtitles = get_option('ap_category_subtitles');
		$ap_category_titles[$term_id] = strip_tags($_POST['custom_cat_title']);
		$ap_category_subtitles[$term_id] = strip_tags($_POST['custom_cat_subtitle']);
		update_option('ap_category_titles', $ap_category_titles);
		update_option('ap_category_subtitles', $ap_category_subtitles);
	}
}

add_action('create_category', 'update_category_custom_title');
add_action('edited_category', 'update_category_custom_title');

function remove_category_custom_title($term_id) {
	if ( (isset($_POST['taxonomy'])) && ($_POST['taxonomy'] == 'category') ) {
		$ap_category_titles = get_option('ap_category_titles');
		$ap_category_subtitles = get_option('ap_category_subtitles');
		unset($ap_category_titles[$term_id]);
		unset($ap_category_subtitles[$term_id]);
		update_option('ap_category_titles', $ap_category_titles);
		update_option('ap_category_subtitles', $ap_category_subtitles);
	}
}

add_action('deleted_term_taxonomy', 'remove_category_custom_title');
?>