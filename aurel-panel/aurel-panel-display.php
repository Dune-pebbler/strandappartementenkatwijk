<?php
require_once( get_template_directory() . '/aurel-panel/aurel-panel-display-functions.php' );

function aurel_panel_display_sections() {
		
	global $ap_options, $ap_sections;

	foreach ( $ap_sections as $ap_section ) {
		
		echo ( '<div id="' . $ap_section['id'] .'" class="aurel-panel-section">' );
		echo ( '<h3>' . $ap_section['name'] . '</h3>' . "\n");
		
		foreach ( $ap_options as $key => $ap_option ) {
			
			if ( $ap_option['section'] == $ap_section['id'] ) {
				
				if ( $ap_option['type'] != 'sub-section' ) {
					echo( '<h4 class="aurel-panel-option-name">' . $ap_option['name'] . '</h4>' . "\n" );
					echo( '<p class="aurel-panel-option-desc">' . $ap_option['desc'] . '</p>' . "\n" );
				}
				
				switch ($ap_option['type']) {
					
					case 'input-text' :
						aurel_panel_display_input_text( $key, $ap_option['val'] );
						break;
					
					case 'input-text-w50p' :
						aurel_panel_display_input_text_w50p( $key, $ap_option['val'] );
						break;
						
					case 'textarea' :
						aurel_panel_display_textarea( $key, $ap_option['val'] );
						break;
						
					case 'radio' :
						aurel_panel_display_radio( $key, $ap_option['radio_options'], $ap_option['val'] );
						break;
					
					case 'check-boxes' :
						aurel_panel_display_check_boxes( $key, $ap_option['check_boxes_options'], $ap_option['val'] );
						break;
					
					case 'select' :
						aurel_panel_display_select( $key, $ap_option['select_options'], $ap_option['val'] );
						break;
					
					case 'select-advanced' :
						aurel_panel_display_select_advanced( $key, '', $ap_option['select_options'], $ap_option['val'] );
						break;
						
					case 'sidebar-selector' :
						aurel_panel_display_sidebar_selector( $key, $ap_option['val'] );
						break;
												
					case 'slider-selector' :
						aurel_panel_display_slider_selector( $key, $ap_option['val'] );
						break;
						
					case 'color-picker' :
						aurel_panel_display_color_picker( $key, $ap_option['val'] );
						break;
						
					case 'image-upload' :
						aurel_panel_display_image_upload( $key, $ap_option['val'] );
						break;
					
					case 'slider-manager' :
						aurel_panel_display_slider_manager();
						break;
						
					case 'global-slider-manager' :
						aurel_panel_display_global_slider_manager();
						break;
					
					case 'widget-areas-manager' :
						aurel_panel_display_widget_areas_manager();
						break;
						
					case 'lists-of-posts-manager' :
						aurel_panel_display_posts_options_manager( 'lists-of-posts' );
						break;
						
					case 'categories-manager' :
						aurel_panel_display_posts_options_manager( 'categories' );
						break;
						
					case 'single-posts-manager' :
						aurel_panel_display_posts_options_manager( 'single-posts' );
						break;
						
					case 'translation-manager' :
						aurel_panel_display_translation_manager();
						break;						

					case 'logo-mobile-settings' :
						aurel_panel_display_logo_mobile_settings();
						break;
						
					case 'sub-section' :
						aurel_panel_display_sub_section( $ap_option['desc'] );
						break;
						
					case 'custom' :
						echo( $ap_option['custom_code'] );
						echo("\n");
						break;
				}
				
				if ( ( $ap_option['type'] != 'sub-section' ) && ( $ap_option['type'] != 'logo-mobile-settings' ) ) {
					echo ( '<p class="aurel-panel-section-separator"></p>' );
				}
			}
		}

		echo( '</div>');
	}
}

function aurel_panel_display_global_slider_manager() {
	global $ap_options;
	$ap_slides = $ap_options['ap_slider_manager']['val']; //before 1.2 version
	$ap_sliders = $ap_options['ap_global_slider_manager']['val'];
	
	function aurel_panel_display_slide_content( $slide ) {
	?>
		<a class="aurel-panel-slide-remove" href="#"></a>
		<p>
			Image:<br/><input type="text" class="aurel-panel-slide-image-url" value="<?php echo( $slide['image_url'] ); ?>" />
			<input type="button" class="button for-slide aurel-panel-upload-button" value="Select image" />
		</p>
		<p class="aurel-panel-slide-thumbnail">
			<img src="<?php echo($slide['image_url']); ?>" width="150" />
		</p>
		<p>
			Caption:<br/>
			<textarea class="aurel-panel-slide-caption" cols="10" rows="10"><?php echo( $slide['caption'] ); ?></textarea>
		</p>
		<p>
			Caption text color: <?php aurel_panel_display_color_picker( '', $slide['caption_color'], 'aurel-panel-slide-caption-color', false ); ?>
		</p>
		<p>
			Caption background color: <?php aurel_panel_display_color_picker( '', $slide['caption_background'], 'aurel-panel-slide-caption-background', false ); ?>
		</p>						
		<p>
			Caption background opacity: <input type="text" class="aurel-panel-slide-caption-opacity" value="<?php echo( $slide['caption_opacity'] );?>" />
		</p>
		<p>
			Additional CSS:<br/>
			<textarea class="aurel-panel-slide-css" cols="10" rows="10"><?php echo( $slide['css'] ); ?></textarea>
		</p>
	<?php
	}
	?>
	
	<div id="aurel-panel-slide-markup">
		<?php 
		$slide_markup = array(
			'image_url' => '',
			'caption' => '',
			'caption_color' => $ap_options['ap_title_text_color']['val'],
			'caption_background' => $ap_options['ap_title_background_color']['val'],
			'caption_opacity' => $ap_options['ap_title_background_opacity']['val'],
			'css' => '',
			'visible' => 'yes'
		);
		aurel_panel_display_slide_content( $slide_markup );
		?>
	</div>
	
	<p>
		To add a slider, enter a name below, choose a type, then click the "Add" button.
	</p>
	<p>
		Slider name: <input type="text" id="aurel-panel-slider-name" value="" />
		&nbsp;&nbsp;&nbsp;&nbsp;
		Slider type: 
		<select id="aurel-panel-slider-type">
			<option value="Full-width">Full-width slider</option>
			<option value="Full-screen">Full-screen slider</option>
			<option value="Top-content">Top content slider</option>			
			<option value="Revolution slider">Revolution slider</option>
		</select>
		<input type="button" id="aurel-panel-add-slider" class="button" value="Add" />
	</p>
	
	
	<div id="aurel-panel-sliders">
	<?php foreach ($ap_sliders as $ap_slider) { ?>
		<div class="aurel-panel-slider"> 
			<a href="#" class="aurel-panel-slider-remove"></a>
			<p>Slider name: <strong class="aurel-panel-slider-name"><?php echo($ap_slider['name']); ?></strong></p>
			<p>Slider type: <strong class="aurel-panel-slider-type"><?php echo($ap_slider['type']); ?></strong></p>
			<?php if ( $ap_slider['type'] != 'Revolution slider' ) { ?>
				<a class="aurel-panel-slider-toggle" href="#"></a>
				<?php
				if ( isset( $ap_slider['visible'] ) && ( $ap_slider['visible'] == 'yes' ) ) {
					$visible = ' visible';
				} else {
					$visible = '';
				}
				?>
				<div class="aurel-panel-slider-content-toggable<?php echo( $visible ); ?>">
					<p>Slider options:<br/>
					<?php
					$slider_options = array('Animation speed in ms (how long is the transition)', 'Pause time in ms (how long each slide is displayed)', 'Autoplay (yes/no)');
					if ( $ap_slider['type'] == 'Full-width' ) {
						$slider_options[] = 'Minimum height (in px)';
					}
					if ( $ap_slider['type'] == 'Top-content' ) {
						$slider_options[] = 'Maximum height (in px)';
					}
					/* for compatibility 1.3 -> 1.4 */
					if ( $ap_slider['type'] == 'Full-width' ) {
						if ( !isset($ap_slider['options'][3]) ) {
							$ap_slider['options'][3] = 400;
						}
					}
					if ( $ap_slider['type'] == 'Full-screen' ) {
						if ( sizeof($ap_slider['options']) == 1 ) {
							$ap_slider['options'][1] = $ap_slider['options'][0] * 1000;
							$ap_slider['options'][0] = 1000;
							$ap_slider['options'][2] = 'yes';
						}
					}
					/* end for compatibility */
					for ($i=0; $i<sizeof($slider_options); $i++) { 
						echo($slider_options[$i] . '<br/><input class="aurel-panel-slider-option" type="text" value="' . $ap_slider['options'][$i] . '"/><br/><br/>');
					}
					?>
					</p>
					<div style="display: none;" id="aurel-panel-slide-markup">
					</div>
					<input type="button" class="button aurel-panel-add-slide-before" value="Add a slide" />
					<div class="aurel-panel-slides">
					<?php
					
					foreach ( $ap_slider['slides'] as $slide ) {
						/* begin compatibility (color, background, opacity, css of slide captions were introduced in 1.4.2) */
						if ( !isset($slide['caption_color']) ) {
							$slide['caption_color'] = '#ffffff';
						}
						if ( !isset($slide['caption_background']) ) {
							$slide['caption_background'] = '#000000';
						}
						if ( !isset($slide['caption_opacity']) ) {
							$slide['caption_opacity'] = '75';
						}
						if ( !isset($slide['css']) ) {
							$slide['css'] = '';
						}
						/* end compatibility (color, background, opacity, css of slide captions were introduced in 1.4.2) */
					?>
						<div class="aurel-panel-slide">
							<?php aurel_panel_display_slide_content( $slide ); ?>
						</div>
					<?php
					}
					?>
					</div>
					<input type="button" class="button aurel-panel-add-slide-after" value="Add a slide" />
				</div>
			<?php } else { ?>
				<p>Use the Revolution slider tab to configure this slider.</p>
			<?php } ?>
		</div>
	<?php } ?>
	</div>	
	<input type="hidden" name="ap_global_slider_manager" id="ap_global_slider_manager" />
	<?php
}

function aurel_panel_display_slider_manager() {
	global $ap_options;
	$ap_slides = $ap_options['ap_slider_manager']['val'];
	if ( sizeof($ap_slides) > 0 ) {
?>
	<input type="hidden" name="ap_slider_manager" id="ap_slider_manager" />
	Since the version 1.2 of The Palace theme the way of managing sliders has changed.<br/>
	Please create a slider above and copy/paste the url of images and the captions.<br/>
	Then you can delete your old slides.
	<div id="aurel-panel-slides">
		<?php
		foreach ($ap_slides as $ap_slide) {
		?>
			<div class="aurel-panel-slide">
				<a class="aurel-panel-slide-remove" href="#"></a>
				<p>
					Image (2.5:1 ratio):
					<br/>
					<input type="text" class="aurel-panel-input-slide-image-url" value="<?php echo( $ap_slide['image_url'] ); ?>" />
					<input type="button" class="button aurel-panel-upload-button" value="Select image" />
				</p>
				<p>
					Caption:
					<br/>
					<textarea class="aurel-panel-textarea-slide-caption" cols="10" rows="10"><?php echo( $ap_slide['caption'] ); ?></textarea>
				</p>
			</div>
		<?php
		}
		?>
	</div>
<?php
	}
}

function aurel_panel_display_widget_areas_manager() {
	global $ap_options;
	$ap_sidebars = $ap_options['ap_widget_areas_manager']['val'];
	?>
	<p>
		There are 5 widget areas by default:<br/>
		- the default sidebar<br/>
		- 4 widget areas for the footer
	</p>
	<p>
		You can add widget areas, set them up on the WordPress Widgets page, and then attach them to a page or post using the page custom fields or to a category of posts using the "Category" section of the theme options panel.
	</p>
	<p class="aurel-panel-section-separator"></p>
	<input type="hidden" id="ap_widget_areas_manager" name="ap_widget_areas_manager" value="<?php echo( htmlspecialchars(json_encode($ap_sidebars)) ); ?>" />
	<h3>Widget areas manager</h3>
	<p>
		To add a widget areas, enter a name below then click the "Add" button.
	</p>
	<p>
		Widget area name: <input type="text" id="aurel-panel-widget-area-name" value="" />
		<input type="button" id="aurel-panel-add-widget-area" class="button" value="Add" />
	</p>
	<p>
		<b>Custom Widget areas:</b>
	</p>
	<div id="aurel-panel-widget-areas">
	<?php
	foreach ($ap_sidebars as $ap_sidebar) {
		?>
			<p class="aurel-panel-widget-area"><?php echo($ap_sidebar);?><a class="aurel-panel-widget-area-remove" href="#"></a></p>
		<?php
	}
	?>
	</div>
	<?php
}

function aurel_panel_display_posts_options_manager( $type ) {
	global $ap_options;
	
	if ( $type == 'single-posts' ) {
		$rules = $ap_options['ap_single_posts_manager']['val'];
		$i = 0;
	?>
		<input type="hidden" name="ap_single_posts_manager" id="ap_single_posts_manager" />
		<p>Choose the way single posts are displayed by default.</p>
		<div id="aurel-panel-single-posts-rules">
	<?php
	} elseif ( $type == 'lists-of-posts' ) {
		$rules = $ap_options['ap_lists_of_posts_manager']['val'];
		$i = 1;
	?>
		<input type="hidden" name="ap_lists_of_posts_manager" id="ap_lists_of_posts_manager" />
		<p>Choose the way lists of posts are displayed by default.</p>
		<div id="aurel-panel-lists-of-posts-rules">
	<?php
	} elseif ( $type == 'categories' ) {
		$rules = $ap_options['ap_categories_manager']['val'];
		$i = 2;
	?>
		<input type="hidden" name="ap_categories_manager" id="ap_categories_manager" />
		<p>
		Choose the way categories are displayed.<br/>
		You can order rules by dragging and dropping them: the highest rule has the priority.
		</p>
		<div id="aurel-panel-categories-rules">
	<?php
	}
	foreach ($rules as $rule) {
	?>
		<div class="aurel-panel-posts-rule <?php if ( $type == 'categories' ) { echo( 'rule-sortable aurel-panel-posts-rule-category' ); }?>">
			
			<?php 
			if ( $type == 'categories' ) { 
				if ( $rule['visible'] == 'yes' ) {
					$visible = ' visible';
				} else {
					$visible = '';
				}
			?>
			<a class="aurel-panel-rule-toggle<?php echo( $visible ); ?>" href="#"></a>
			<a class="aurel-panel-rule-remove" href="#"></a>
			<?php } ?>
			
			<input type="hidden" class="ap-posts-rule-n" value="<?php echo( $i ); ?>" />
			
			<div class="aurel-panel-rule-odd-cat">
				<?php 
				if ( $type == 'categories' ) { 
					echo( 'Select a category:' );
					remove_all_filters('get_terms');
					remove_all_filters('list_terms_exclusions');
					remove_all_filters('get_terms_fields');
					remove_all_filters('get_terms_args');
					remove_all_filters('get_terms_orderby');
					remove_all_filters('terms_clauses');
					$categories = get_categories( 'hide_empty=0' );
					$cat_options = array();
					foreach ($categories as $cat) {
						$cat_options[] = array( $cat->slug, $cat->name );
					}
					aurel_panel_display_select_advanced( 'ap-posts-rule-' . $i . 'select-category', 'ap-posts-rule-category', $cat_options, $rule['category'] ); 
				} else { 
					if ( $type == 'single-posts' ) {
						echo( '<b>Single Posts - Default displaying</b>' );
					} else {
						echo( '<b>List of Posts - Default displaying</b>' );
					}
				}
				?>
			</div>
			
			<div class="aurel-panel-rule-even">
				<p>
					Layout you want to use: 
				</p>
				<?php 
				$layout_options = array(
					array( 'full-width', 'Full width' ),
					array( 'one-col-left-sidebar', 'One column and left sidebar' ),
					array( 'one-col-right-sidebar', 'One column and right sidebar' ),
				);
				if ( $type != 'single-posts' ) {
					array_push( $layout_options, array( 'three-cols', 'Three columns' ) );
				}
				aurel_panel_display_select_advanced( 'ap-posts-rule-' . $i . 'select-layout', 'ap-posts-rule-layout', $layout_options, $rule['layout'] ); 
				?>
				<div class="ap-posts-rule-sidebar">
					Sidebar name:
					<?php aurel_panel_display_sidebar_selector( 'ap-posts-rule-' . $i . '-sidebar', $rule['sidebar'] ); ?>
				</div>
			</div>
			
			<?php if ( $type != 'single-posts' ) { ?>
			<div class="aurel-panel-rule-odd">
				<p>
					Display the title of the posts:
				</p>
				<?php 
				aurel_panel_display_radio( 'ap-posts-rule-' . $i . '-display-title', array('yes','no'), $rule['display-title'] ); 
				if ( $type == 'categories' ) { 
					echo( '<p>Display the category title:' );
					if ( ! isset( $rule['display-category-title'] ) ) {
						$rule['display-category-title'] = 'yes';
					}
					aurel_panel_display_radio( 'ap-posts-rule-' . $i . '-display-category-title', array('yes','no'), $rule['display-category-title'] ); 
					echo( '</p>' );
				}
				?>
			</div>
			<?php } ?>
			
			<?php if ( $type == 'single-posts' ) { ?>
			<div class="aurel-panel-rule-odd">
			<?php } else { ?>
			<div class="aurel-panel-rule-even">
			<?php } ?>
				<p>
					Meta informations you want to display:
				</p>
				<?php aurel_panel_display_check_boxes( 'ap-posts-rule-' . $i .'-meta', array('date', 'author', 'categories', 'tags', 'comments'), $rule['meta'] ); ?>
			</div>
			
			<?php if ( $type == 'single-posts' ) { ?>
			<div class="aurel-panel-rule-even">
				<p>
					Disable comments for ALL posts:
				</p>
				<?php aurel_panel_display_radio( 'ap-posts-rule-' . $i . '-disable-comments', array('yes','no'), $rule['disable-comments'] ); ?>
			</div>
			
			<?php } else { ?>
			<div class="aurel-panel-rule-odd">
				<p>
					Show a thumbnail:
				</p>
				<?php aurel_panel_display_radio( 'ap-posts-rule-' . $i . '-show-thumbnail', array('yes','no'), $rule['show-thumbnail'], 'class="ap-posts-rule-show-thumbnail"' ); ?>
				<div class="ap-posts-rule-thumbnail-links">
					<p> 
						Thumbnail links:
					</p>
					<?php aurel_panel_display_radio( 'ap-posts-rule-' . $i . '-thumbnail-links', array('post','full-size image'), $rule['thumbnail-links'] ); ?>
				</div>
			</div>
			
			<div class="aurel-panel-rule-even">
				<p>
					Content you want to display:
				</p>
				<?php aurel_panel_display_radio( 'ap-posts-rule-' . $i . '-content', array('content','excerpt','none'), $rule['content'] ); ?>
			</div>
			
			<div class="aurel-panel-rule-odd">
				<p>
					"Learn more" link:
				</p>
				<?php aurel_panel_display_radio( 'ap-posts-rule-' . $i . '-learn-more', array('none','link','button'), $rule['learn-more'] ); ?>
			</div>
			
				<?php if ( $type == 'categories' ) { ?>
			<div class="aurel-panel-rule-even">
				<p>
					Header image:
				</p>
				<?php aurel_panel_display_image_upload( 'ap-posts-rule-' . $i . '-header-image', $rule['header-image'] ); ?>
				<p>
					- or choose a slider to be displayed as a header:
				</p>
				<?php aurel_panel_display_slider_selector('ap-posts-rule-' . $i . '-slider', $rule['slider'] ); ?>
			</div>
			
			<div class="aurel-panel-rule-odd">
				<p>
					Background image:
				</p>
				<?php 
				// compatibility 1.3 -> 1.4
				if ( !isset($rule['background-image']) ) {
					$rule['background-image'] = '';
				}
				if ( !isset($rule['background-stretch-or-tile']) ) {
					$rule['background-stretch-or-tile'] = 'stretch';
				}
				if ( !isset($rule['background-fixed-or-scrollable']) ) {
					$rule['background-fixed-or-scrollable'] = 'fixed';
				}
				if ( !isset($rule['background-texture']) ) {
					$rule['background-texture'] = 'none';
				}
				if ( !isset($rule['custom-css']) ) {
					$rule['custom-css'] = '';
				}
				// end compatibility
				aurel_panel_display_image_upload( 'ap-posts-rule-' . $i . '-background-image', $rule['background-image'] ); 
				?>
				- or select a background texture:
				
				<?php
				aurel_panel_display_select( 'ap-posts-rule-' . $i . '-background-texture', array('none', 'diamond-1', 'diamond-2', 'floral-1', 'floral-2', 'fabric', 'leather', 'luxury', 'lyonnette', 'pineapple-cut', 'vichy'), $rule['background-texture'], 'class="ap-posts-rule-background-texture"' );
				aurel_panel_display_radio( 'ap-posts-rule-' . $i . '-background-stretch-or-tile', array('stretch','tile'), $rule['background-stretch-or-tile'] );
				aurel_panel_display_radio( 'ap-posts-rule-' . $i . '-background-fixed-or-scrollable', array('fixed','scrollable'), $rule['background-fixed-or-scrollable'] ); 
				?>
			
			</div>
			
			<div class="aurel-panel-rule-even">
				<p>
					Footer image:
				</p>
				<?php aurel_panel_display_image_upload( 'ap-posts-rule-' . $i . '-footer-image', $rule['footer-image'] ); ?>
			</div>
			
			<div class="aurel-panel-rule-odd">
				<p>
					Disable comments:
				</p>
				<?php aurel_panel_display_radio( 'ap-posts-rule-' . $i . '-disable-comments', array('yes','no'), $rule['disable-comments'] ); ?>
			</div>
				
			<div class="aurel-panel-rule-even">
				<p>
					Custom CSS:
				</p>
				<?php aurel_panel_display_textarea( 'ap-posts-rule-' . $i . '-custom-css', $rule['custom-css'] ); ?>
			</div>
			
				<?php
				}
			}
			?>
		</div>
	<?php
		$i++;
	}
	echo ( '</div>' );
	
	if ( $type == 'categories' ) {
	?>
		<p><input type="button" id="aurel-panel-add-categories-rule" class="button" value="Add a rule" /></p>
	<?php
	}
}

function aurel_panel_display_translation_manager() {
	global $ap_options;
	?>
	<p>
	Here is a handy string translator. It's useful if you want to modify just a few strings (e.g. slider captions, "Learn more" text of the buttons, room type names...) and don't want to create a full .po/.mo file. 
	It's not a multi-language plugin. If you want to create a multi-language website you need to use a plugin such as WPML, qTranslate, Polylang...
	</p>
	<hr/>
	<p>
	To add a language enter its code below (e.g: en_UK, fr_FR, ...) and click on "Add language"<br/>
	</p>
	<p>
		<input id="lang-code" type="text" />&nbsp;<input type="button" value="Add language" class="button" data-bind="click: addLang" />
	</p>
	<table>
		<thead>
			<tr>
				<!-- ko foreach: langs -->
				<th><span data-bind="text: code"></span> strings <!-- ko if: code != 'Default' && code != 'en_US' --><a href="#" data-bind="click: $parent.deleteLang"><img src="<?php echo( get_template_directory_uri() . '/aurel-panel/img/cross-circle.png' ); ?>" alt="Delete language"/></a><!-- /ko --></th>
				<!-- /ko -->
				<th></th>
			</tr>
		</thead>
		<tbody data-bind="foreach: strings">
			<tr>
				<!-- ko foreach: $root.langs -->
				<td><input type="text" data-bind="value: $parent.value[code]"></td>
				<!-- /ko -->
				<td><a href="#" id="" data-bind="click: $parent.deleteString"><img src="<?php echo( get_template_directory_uri() . '/aurel-panel/img/cross-circle.png' ); ?>" alt="Delete strings"/></a></td>
			</tr>
		</tbody>
	</table>
	<p>
		<input id="add-string" type="button" class="button" value="Add a string" data-bind="click: addString" />
	</p>
	<p>
		Please note that WordPress use the en_US (American english) language by default.<br/>
		So if you haven't changed the language of your WordPress installation just use the en_US column to modify a string.
	</p>
	<input type="hidden" id="ap_translation_manager" name="ap_translation_manager" value='<?php echo( htmlspecialchars( json_encode( $ap_options['ap_translation_manager']['val'] ) ) ); ?>' />
	<?php
}

function aurel_panel_display_logo_mobile_settings() {
	global $ap_options;
	?>
	<div id="ap-mobile-logo-settings">
		<p>
			Choose a logo image for the mobile mode OR a reducing scale factor.
		</p>
		<h4 class="aurel-panel-option-name">Mobile logo image</h4>
		<p class="aurel-panel-option-desc">Enter an URL or select an image.</p>
		<?php aurel_panel_display_image_upload( 'ap-mobile-logo-img', $ap_options['ap_logo_mobile_settings']['val']['logo-url'] ); ?>
		<h4 class="aurel-panel-option-name">Reducing scale factor</h4>
		<p class="aurel-panel-option-desc">
			How many times the logo should be reduced when switching in mobile mode.
		</p>
		<p>
			<input id="ap-mobile-logo-reducing-scale" type="number" min="1" step="0.1" value="<?php echo( $ap_options['ap_logo_mobile_settings']['val']['reducing-scale-factor'] ); ?>" />
		</p>
		<p class="aurel-panel-section-separator"></p>
		<input type="hidden" id="ap_logo_mobile_settings" name="ap_logo_mobile_settings" value='<?php echo( esc_attr( json_encode( $ap_options['ap_logo_mobile_settings']['val'] ) ) ); ?>' />
	</div>
	<?php
}

function aurel_panel_display() {
	
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	
	global $ap_options, $ap_sections, $ap_message, $ap_theme_name;
	
?>

<div id="aurel-panel">
	
	<h2>Theme options</h2>
	
	<form id="aurel-panel-form" method="post" action="#">
	
		<div id="aurel-panel-wrap">

			<div id="aurel-panel-menu">

				<ul>

					<?php
					foreach ( $ap_sections as $ap_section ) {
						echo ( '<li><a href="#' . $ap_section['id'] .'">' . $ap_section['name'] . '</a></li>');
					}
					?>
					
				</ul>

				<p>
					<?php wp_nonce_field('aurelien-panel'); ?>
					<input type="hidden" id="aurel-panel-action" name="aurel-panel-action" value="save" />
					<input type="button" id="aurel-panel-button-save-options" class="button button-primary" value="Save Options" />
				</p>
				
				<div id="aurel-panel-submit-result"></div>
				<div id="aurel-panel-submit-ajax-loader"></div>
				
			</div>
			
			<div id="aurel-panel-content">
				
				<?php 
				if ($ap_message != '') {
					echo('<p class="aurel-panel-message">' . $ap_message . '</p>');
				}
				remove_all_filters('get_terms');
				remove_all_filters('list_terms_exclusions');
				remove_all_filters('get_terms_fields');
				remove_all_filters('get_terms_args');
				remove_all_filters('get_terms_orderby');
				remove_all_filters('terms_clauses');
				$categories = get_categories( 'hide_empty=0' );
				$passed_cat = array();
				foreach ($categories as $cat) {
					$passed_cat[] = array('name' => $cat->name, 'slug' => $cat->slug);
				}
				echo( '<input type="hidden" name="ap_categories" id="ap_categories" value="' . htmlspecialchars(json_encode($passed_cat)) . '"/>' );
				
				echo( '<input type="hidden" name="ap_template_directory_uri" id="ap_template_directory_uri" value="' . get_template_directory_uri() . '"/>' );
				
				aurel_panel_display_sections(); 
				?>
						
			</div><!-- end aurel-panel-content -->
		
		</div><!-- end aurel-panel-wrap -->
		
	</form>
	
</div>
	
<?php
}
?>