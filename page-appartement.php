<?php
/**
 * Template Name: Appartement
 */
$disabled_dates = get_option('ah_calendars_data_new', []);
$reservations = get_option('ah_reservations', []);

$reserved_dates = array_map(function($reservation){
  $dates = [ 
    $reservation['check_in'],
    $reservation['check_out'],
  ];

  // we check if it is confirmed.
  if( $reservation['status'] != 'confirmed' ) return [];

  // we can than create date ranges.
  $start_date = new DateTime($reservation['check_in']);
  $end_date = new DateTime($reservation['check_out']);

  $interval = DateInterval::createFromDateString('1 day');
  $periode = new DatePeriod($start_date, $interval, $end_date);

  foreach ($periode as $datum) {
      $dates[] = $datum->format('Y-m-d');
  }

  return array_unique($dates);
}, $reservations);

$reserved_dates = array_filter($reserved_dates);
$decoded_dates = json_decode($disabled_dates);
$all_dates = current($decoded_dates);

foreach($reserved_dates as $reservation_date){
  $all_dates = array_merge($all_dates, $reservation_date);
}
$encoded_dates = json_encode($all_dates);


get_header(); ?>

<script type="text/javascript">
let myDatePickerOptions = {};
let disabledDates = <?= $encoded_dates; ?>;

gform.addFilter( 'gform_datepicker_options_pre_init', function( optionsObj, formId, fieldId ) {
    optionsObj.firstDay = 1;
    
    // Check if fieldId is 6 and set inline option to true
    if( fieldId == 6 ){
        optionsObj.inline = true;
    }

    optionsObj.beforeShowDay = function (date) {
        var disabledDays = <?= $encoded_dates; ?>;
        var currentDate = jQuery.datepicker.formatDate('yy-mm-dd', date);

        // jQuery(`#input_1_7`).datepicker('option', 'minDate', jQuery.datepicker.formatDate('yy-mm-dd', new Date()))

        return [disabledDays.indexOf(currentDate) == -1];
    };

    let originalBeforeShowFucntion = optionsObj.beforeShow;

    // Check if fieldId is 8 and set minDate option based on another field's value
    if( fieldId == 8 ){
        
        optionsObj.beforeShow = function (input, inst) {
            let connectedQuery = jQuery(`#input_1_7`);
            let targetQuery = jQuery(this);

            originalBeforeShowFucntion.call(this, input, inst);

            targetQuery.datepicker('option', 'minDate', connectedQuery.val());

            return true;
        };
    } else {
      optionsObj.beforeShow = function (input, inst) {
            let currentDateStamp = new Date();
            originalBeforeShowFucntion.call(this, input, inst);
            console.log(currentDateStamp)
            jQuery(this).datepicker('option', 'minDate', currentDateStamp);

            return true;
        };
    }


    // Prevent previous months for other fields
    // optionsObj.minDate = (new Date()).getTime();

    myDatePickerOptions[`field_${fieldId}`] = optionsObj;

    return optionsObj;
});

</script>

<main>
  <section class="banner">
    <?php $featured_img_url = get_the_post_thumbnail_url($post->ID, 'large'); ?>
    <img src="<?= $featured_img_url; ?>" loading="lazy" alt="" />
  </section>
  <section class="intro">
    <div class="container">
      <div class="row">
        <div class="col-12 col-xl-8">
          <div class="intro-content">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
          </div>
        </div>
        <div class="col-12 col-xl-4">
          <?= do_shortcode('[gravityform id="1" title="true"]'); ?>
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
            <div class="col-12 col-lg-6 block-img">
              <?php if ($image_details = get_sub_field('afbeelding')): ?>
                <img src='<?php echo $image_details['url']; ?>' alt='<?php echo $image_details['alt']; ?>'/>
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
  <section class="impressions"> 
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="center"><?php _e('Appartement impressie', 'strandappartement'); ?></h2>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="grid js-masonry row">
        <?php
        $images = get_field('impressies');

        if ($images):
          ?>
          <?php foreach ($images as $image): ?>
            <div class="grid-item col-xl-4 col-lg-4 col-md-6 col-sm-6">
              <a data-fancybox="gallery" href="<?php echo $image['url']; ?>">
                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
              </a>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>
</main>
<?php 
  get_footer(); 
  ?> 

