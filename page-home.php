<?php
/*
 * Template name: Page home
 */
get_header();
?>
<main>
  <section class="slider-home">
    <?php if (have_rows('slides_home')): ?>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <section class="slider owl-theme owl-carousel">
              <?php while (have_rows('slides_home')): the_row(); ?>
                <div class="slide">
                  <?php if ($image = get_sub_field('afbeelding')): ?>
                    <img src="<?= $image['sizes']['large']; ?>" alt="<?php the_title(); ?>" <?= get_row_index() > 1 ? 'loading="lazy"' : ''; ?>>
                  <?php endif; ?>
                  <div class="caption">
                    <div class="container">
                      <div class="row">
                        <div class="col-12">
                          <h3><?php the_sub_field('slide_titel'); ?></h3>
                          <?php the_sub_field('tekst'); ?>

                          <?php if ($slide_btn = get_sub_field('slide_button')): ?> 
                            <a href="<?= $slide_btn['url']; ?>" class="btn" target="<?= $slide_btn['target']; ?>" title="<?= $slide_btn['title']; ?>">
                              <?= $slide_btn['title']; ?>
                            </a>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            </section>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </section>

  <section class="who-us">
    <div class="container">
      <div class="row">
        <div class="col-lg-10 offset-lg-1 col-12">
          <div class="quote-wrap">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php
    $args = array('post_type' => 'post', 'posts_per_page' => 2);
    $cpt_query = new WP_Query($args);
    if ($cpt_query->have_posts()) :
  ?>
  <section class="news news-home">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2>Actueel</h2>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <?php while ($cpt_query->have_posts()) : $cpt_query->the_post();
            $date = get_the_date('j F Y');
            ?>

            <div class="col-md-6 col-12">
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
        ?>
        <div class="col-12">

        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>
</main>
<?php get_footer(); ?>