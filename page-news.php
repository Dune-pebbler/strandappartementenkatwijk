<?php
/**
 * Template Name: Nieuwsoverzicht
 */
?><?php get_header(); ?>
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

  <section class="news">
    <div class="container">
      <div class="row">
        <?php
        $args = array('post_type' => 'post', 'posts_per_page' => -1);
        $cpt_query = new WP_Query($args);
        if ($cpt_query->have_posts()) :
          while ($cpt_query->have_posts()) : $cpt_query->the_post();
            $date = get_the_date('j F Y');
            ?>
            <div class="col-md-6 col-12 news-block">
              <?php $featured_img_url = get_the_post_thumbnail_url($post->ID, 'medium'); ?>
              <a href="<?php the_permalink(); ?>" class="newsItem" title="<?php the_title(); ?>">
                <?php $thumbnail_id = get_post_thumbnail_id($post->ID); ?>
                <img src="<?= $featured_img_url; ?>" loading="lazy" alt="<?php echo get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); ?>" />
                <div class="newsContent">
                  <h3><?php the_title(); ?></h3>
                  <span><?php echo $date; ?></span>
                  <p><?php the_field('intro'); ?></p>
                  <div class="btn">Lees verder</div>
                </div>
              </a>
            </div>
            <?php
          endwhile;
        endif;
        ?>
        <div class="col-12">

        </div>
      </div>
    </div>
  </section>

</main>
<?php get_footer(); ?> 

