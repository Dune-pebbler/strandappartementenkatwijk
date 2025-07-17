<?php
function ap_widgets_area_init() {
	register_sidebar(
		array(
			'id' => 'default_sidebar', 
			'name' => 'Default sidebar', 
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>'
		)
	); 
	register_sidebar(
		array(
			'id' => 'top', 
			'name' => 'Top area',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'id' => 'footer_1', 
			'name' => 'Footer first column', 
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'id' => 'footer_2', 
			'name' => 'Footer second column', 
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'id' => 'footer_3', 
			'name' => 'Footer third column', 
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>'
		)
	);
	register_sidebar(
		array(
			'id' => 'footer_4', 
			'name' => 'Footer fourth column', 
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">', 
			'after_title' => '</h3>'
		)
	);
	global $ap_options;
	$ap_sidebars = $ap_options['ap_widget_areas_manager']['val'];
	foreach ($ap_sidebars as $ap_sidebar) {
		register_sidebar(
			array(
				'id' => $ap_sidebar, 
				'name' => $ap_sidebar, 
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title">', 
				'after_title' => '</h3>'
			)
		);
	}
}
?>