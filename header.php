<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title><?php wp_title(); ?></title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo get_template_directory_uri(); ?>/stylesheets/bootstrap/bootstrap.css" rel="stylesheet"> 
    <link href="<?php echo get_template_directory_uri(); ?>/assets/fontawesome/css/all.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo get_template_directory_uri(); ?>/assets/owlcarousel/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/assets/fancybox/jquery.fancybox.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo get_template_directory_uri() . '/stylesheets/style.css?v=' . filemtime(get_template_directory() . '/stylesheets/style.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="https://use.typekit.net/wcq6ele.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <script type="text/javascript">
      let flatpickrLanguage = '<?= ICL_LANGUAGE_CODE; ?>';
    </script>
    <?php wp_head(); ?> 
  </head>
  <body <?php body_class(); ?>>
    <header>
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="logo">
              <a href="<?= site_url(); ?>" title="Strandappartement Katwijk">
                <img src="<?php echo get_template_directory_uri(); ?>/img/logo.svg" loading="lazy" alt="Strandappartement Katwijk" />
              </a>
            </div> 
            <nav class="navigation">
              <?php
              wp_nav_menu([
                  'theme_location' => 'primary'
              ]);
              ?>
              <div class="hamburger hamburger--slider">
                <div class="hamburger-box">
                  <div class="hamburger-inner"></div>
                </div>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </header>