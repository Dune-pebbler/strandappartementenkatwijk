<footer>
  <div class="footer-top">
    <?php $footerImage = get_field('footer_foto', 'option'); ?>
    <figure>
      <img src="<?= $footerImage['sizes']['large']; ?>" loading="lazy" class="footer-img" alt="<?php echo get_post_meta($footerImage['ID'], '_wp_attachment_image_alt', true); ?>" />
    </figure>
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-4">
          <h4><?php _e('Links', 'strandappartement'); ?></h4>
          <?php wp_nav_menu(['theme_location' => 'footer-1']); ?>
        </div>
        <div class="col-12 col-lg-4">
          <h4><?php _e('Contact', 'strandappartement'); ?></h4>
          <div class="contact-options">
            <?php the_field('adres', 'option'); ?>
            <a href="tel:+31<?php the_field('telefoonnummer', 'option'); ?>" title="Bel Strandappartement Katwijk"><i class="fas fa-phone-alt"></i> 0<?php the_field('telefoonnummer', 'option'); ?></a>
            <a href="mailto:<?php the_field('emailadres', 'option'); ?>" title="Mail Strandappartement Katwijk"><i class="far fa-envelope"></i> <?php the_field('emailadres', 'option'); ?></a>
          </div>
          <ul class="social-icons">
            <?php if ($facebook = get_field('facebook_url', 'options')) : ?>
              <li>
                <a href="<?= $facebook; ?>" title="<?= get_bloginfo('title'); ?> facebook" target="_blank">
                  <i class="fab fa-facebook-f"></i>
                </a>
              </li>
            <?php endif; ?> 

            <?php if ($linkedin = get_field('linkedin_url', 'options')) : ?>
              <li>
                <a href="<?= $linkedin; ?>" title="<?= get_bloginfo('title'); ?> linkedin" target="_blank">
                  <i class="fab fa-linkedin-in"></i>
                </a>
              </li>
            <?php endif; ?>

            <?php if ($instagram = get_field('instagram_url', 'options')): ?>
              <li>
                <a href="<?= $instagram; ?>" title="<?= get_bloginfo('title'); ?> instagram" target="_blank">
                  <i class="fab fa-instagram"></i>
                </a>
              </li>
            <?php endif; ?>


            <?php if ($twitter = get_field('twitter_url', 'options')): ?>
              <li>
                <a href="<?= $twitter; ?>" title="<?= get_bloginfo('title'); ?> twitter" target="_blank">
                  <i class="fab fa-twitter"></i>
                </a>
              </li>
            <?php endif; ?>

            <?php if ($youtube = get_field('youtube_url', 'options')): ?>
              <li>
                <a href="<?= $youtube; ?>" title="<?= get_bloginfo('title'); ?> youtube" target="_blank">
                  <i class="fab fa-youtube"></i>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
        <div class="col-12 col-lg-4">
          <div class="logo footer-logo">
            <a href="<?= site_url(); ?>" title="Strandappartement Katwijk">
              <img src="<?php echo get_template_directory_uri(); ?>/img/logo-color.svg" loading="lazy" alt="Strandappartement Katwijk" />
            </a>
          </div> 
        </div> 
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <p>
        &copy; <?php echo date('Y'); ?> Strandappartement Katwijk | <a href="<?= get_page_link(3); ?>" title="Privacy statement" target="_blank"><?php _e('Privacy statement', 'strandappartement'); ?></a>
      </p>
      <a href="https://dunepebbler.nl" target="blank"><?php _e('Website door', 'strandappartement'); ?> Dune Pebbler</a>
    </div>
  </div>
</footer>

<ul class="side-buttons">
  <li><a href="<?= get_page_link(14); ?>" class="side-btn" title="Contact met Strandappartement Katwijk"><?php _e('Contact', 'strandappartement'); ?></a></li>
  <li><a href="<?= get_page_link(445); ?>" class="side-btn contra" title="Appartement boeken bij Strandappartement Katwijk"><?php _e('Appartement boeken', 'strandappartement'); ?></a></li>
</ul>

<div class="search-screen">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <form id="searchform" role="search" method="get" action="/">
          <div class="input-group"><input class="form-control" id="s" type="text" value="<?php the_search_query(); ?>" placeholder="<?php _e('Zoeken naar...', 'strandappartement'); ?>" name="s" /><span class="input-group-btn"><button class="btn-search-close" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
            </span><span class="input-group-btn"><button class="btn-search" type="submit"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php wp_footer(); ?>

<script src="<?= get_stylesheet_directory_uri(); ?>/assets/owlcarousel/owl.carousel.min.js" type="text/javascript"></script>
<script src="<?= get_stylesheet_directory_uri(); ?>/js/in-view.js" type="text/javascript"></script>
<script src="<?= get_stylesheet_directory_uri(); ?>/js/masonry.js" type="text/javascript"></script>
<script src="<?= get_stylesheet_directory_uri(); ?>/js/isotope.js" type="text/javascript"></script>
<script src="<?= get_stylesheet_directory_uri(); ?>/js/imagesLoaded.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="<?= get_stylesheet_directory_uri(); ?>/js/flatpickr.nl.js"></script>
<script src="<?= get_stylesheet_directory_uri(); ?>/assets/fancybox/jquery.fancybox.min.js" type="text/javascript"></script>
<script src="<?= get_stylesheet_directory_uri(); ?>/js/main.js" type="text/javascript"></script>
</body> 

</html>