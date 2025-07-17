<?php if (have_rows('content_blokken')): ?>
  <section class="repeater-content">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <?php while (have_rows('content_blokken')): the_row(); ?>
            <div class="repeater-item">
              <div class='row'>
                <div class="col-xs-12 col-lg-6 image">
                  <figure>
                    <?php if ($image_details = get_sub_field('afbeelding')): ?>
                      <img src='<?php echo $image_details['url']; ?>' alt='<?php echo $image_details['alt']; ?>'/>
                    <?php endif; ?>
                  </figure>
                </div>

                <div class="col-xs-12 col-lg-6 d-flex">
                  <div class='text-container'>
                    <h2><?php the_sub_field('titel'); ?></h2>

                    <?php the_sub_field('content'); ?>
                  </div>
                </div>

              </div>
            </div>
          <?php endwhile; ?> 
        </div>
      </div>
    </div>
  </section> 
<?php endif ?>