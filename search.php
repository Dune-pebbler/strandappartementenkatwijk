<?php 
get_header(); ?>
<main>
  <section class="intro">
    <div class="container">
      <div class="row">
        <div class="col-xl-10 offset-xl-1 col-12">
          <div class="intro-content">
            <h1><?php _e('Zoeken naar:', 'search'); ?> '<?= $_GET['s']; ?>'</h1>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <?php if (have_posts()) : ?>
  <section class="who-us">
      <div class="container">
        <div class="row">
          <div class="col-xl-10 offset-xl-1 col-12">
            <ul class="who-links">
              <?php while (have_posts()) : the_post(); ?>
                <li>
                  <?php $link = get_sub_field('link_naar_pagina'); ?>
                  <a href="<?= get_the_permalink(); ?>" title="<?= get_the_permalink(); ?>">
                    <h3><?php the_title(); ?></h3>
                    <?php if ($intro = get_field('intro')): ?>
                      <?= $intro; ?>
                    <?php else: ?>
                      <?php the_excerpt(); ?>
                    <?php endif; ?>
                  </a>
                </li>
              <?php endwhile; ?>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <?php else: ?>
      <div class="container">
        <div class="result">
          <p><?php _e('Geen resultaten gevonden', 'search'); ?></p>
        </div>
      </div>
    <?php endif; ?>
      </div>
      </div>
    </div>
  </section>
</main>
<?php get_footer(); ?>