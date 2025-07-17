<?php 
/*
 * Template name: Page Contact
 */
get_header(); ?>
<main>
  <section class="intro">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="intro-content">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-">
          <?= do_shortcode('[gravityform id="2" title="false"]')?>
        </div>
        <div class="col-lg-5 offset-lg-1">
          <div class="contact-details">
            <h3><?php _e('Contact gegevens', 'strandappartement'); ?></h3>
            <?php the_field('adres', 'option'); ?>
            <a href="tel:+31<?php the_field('telefoonnummer', 'option'); ?>" title="Bel Strandappartement Katwijk"><i class="fas fa-phone-alt"></i> 0<?php the_field('telefoonnummer', 'option'); ?></a><br>
            <a href="mailto:<?php the_field('emailadres', 'option'); ?>" title="Mail Strandappartement Katwijk"><i class="far fa-envelope"></i> <?php the_field('emailadres', 'option'); ?></a>
          </div>
          <div class="map">
            <a href="https://www.google.com/maps/dir//Strandappartement+Katwijk,+Boulevard+105,+2225+HB+Katwijk+aan+Zee/@52.2032644,4.3905606,17z/data=!4m9!4m8!1m0!1m5!1m1!1s0x47c5bf4828a05c99:0x5f52e7c65e840b6!2m2!1d4.392754!2d52.2032594!3e0" class="map-route" title="Routebeschrijving strandappartement Katwijk" target="_blank">
              <img src="<?php echo get_template_directory_uri(); ?>/img/map.png" loading="lazy" alt="Routebeschrijving strandappartement katwijk" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <section class="routes">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2><?php _e('Routebeschrijvingen', 'strandappartement'); ?></h2>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-12">
          <h3><?php the_field('route_veld_1_titel'); ?></h3>
          <p><?php the_field('route_veld_1'); ?></p>
        </div>
        <div class="col-md-4 col-12">
          <h3><?php the_field('route_veld_2_titel'); ?></h3>
          <p><?php the_field('route_veld_2'); ?></p>
        </div>
        <div class="col-md-4 col-12">
          <h3><?php the_field('route_veld_3_titel'); ?></h3>
          <p><?php the_field('route_veld_3'); ?></p>
        </div>
      </div>
    </div>
  </section>

  <?php if (have_rows('content_blokken')): ?>
    <section class="content-repeater-blocks">
      <div class="container">
        <?php
        while (have_rows('content_blokken')): the_row();
          ?>
          <div class="row content-block">
            <div class="col-lg-6 col-12 block-img">
              <?php if ($image_details = get_sub_field('afbeelding')): ?>
                <a href="<?php echo $image_details['url']; ?>" data-fancybox="Afbeeldingen" data-caption="<?php echo $image_details['alt']; ?>">
                  <img src='<?php echo $image_details['url']; ?>' alt='<?php echo $image_details['alt']; ?>'/>
                </a>
              <?php endif; ?>
            </div>
            <div class="col-lg-6 col-12 block-content">
              <h2><?php the_sub_field('titel'); ?></h2>

              <?php the_sub_field('content'); ?>

              <?php if ($button = get_sub_field('link')) : ?>
                <a href="<?= $button; ?>" class="btn btn-secondary" title="btn"><?php the_sub_field('knop_tekst'); ?></a>
              <?php endif; ?>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </section>
  <?php endif; ?>

</main>
<?php get_footer(); ?> 

