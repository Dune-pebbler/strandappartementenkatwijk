<?php get_header(); ?>
<main>
  <section class="banner">
    <?php $featured_img_url = get_the_post_thumbnail_url($post->ID, 'large'); ?>
    <?php $thumbnail_id = get_post_thumbnail_id($post->ID); ?>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <img src="<?= $featured_img_url; ?>" loading="lazy" alt="<?php echo get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); ?>" />
        </div>
      </div>
    </div>
  </section>
  <section class="intro">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="intro-content">
            <h1><?php the_title(); ?></h1>
            <?php
            $date = get_the_date('j F Y');
            ?>
            <span><?php echo $date; ?></span>
            <?php the_content(); ?>
          </div>
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
                <a href="<?= $button['url']; ?>" title="<?= $button['title']; ?>" target="<?= $button['target']; ?>" class="btn btn-secondary" title="btn"><?= $button['title']; ?></a>
              <?php endif; ?>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </section>
  <?php endif; ?>
  
  <section class="back">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <a href="<?= get_page_link(388); ?>" class="btn" title="Terug naar overzicht">Terug naar overzicht</a>
        </div>
      </div>
    </div>
  </section>

</main>
<?php get_footer(); ?> 

