let $grid;

jQuery(document).ready(function () {
  startOwlSlider();
  setHamburgerOnClick();
  wrapIframe();
  replaceImgWithSvg();
  setAlignInATag();
  setOnSearch();
  setStoriesGrid();
  setTeamGrid();
  setStoriesHeight();
  openSearch();
  setMoreLessFixGrid();
  setMasonryGrid();
});

jQuery(window).load(function () {
  doCalendarRefresh();
})

jQuery(window).scroll(function () {
  setOnHeaderClass();
});


function doCalendarRefresh() {
  if (myDatePickerOptions == undefined || Object.keys(myDatePickerOptions).length == 0) {
    setTimeout(function () {
      doCalendarRefresh();
    }, 200)
    return;
  };

  for (let fieldId in myDatePickerOptions) {
    fieldId = fieldId.replace("field_", "");

    if (!myDatePickerOptions[`field_${fieldId}`]['inline']) continue;
    if (jQuery(`#input_1_${fieldId}`).length == 0) {
      // retry
      setTimeout(function () {
        doCalendarRefresh();
      }, 200)
      return;
    }

    // we destroy the old datepicker, or just disable it?
    jQuery(`#input_1_${fieldId}`).flatpickr({
      changeMonth: false,
      useMouseWheel: false,
      dateFormat: 'Y-m-d',
      inline: myDatePickerOptions[`field_${fieldId}`]['inline'],
      disable: disabledDates,
      locale: flatpickrLanguage,
    });

    jQuery(`#input_1_${fieldId}`).hide();
    jQuery(`#input_1_${fieldId}`).next().css({ width: '100%' });
  }
}

function setMasonryGrid() {
  inspirationGrid = jQuery('.gallerij .gallerij-grid').isotope({
    itemSelector: '.grid-item',
    masonry: {
      gutter: 25
    }
  });
}

function setMoreLessFixGrid() {
  // fix less and more 
  jQuery('.team-member .less-more').on('click', function (e) {
    let targetGigante = jQuery('.gigante');
    let element = jQuery(this).parents('.team-member');
    let hadClass = element.find('.member-content').hasClass('open');

    // remove gigante class
    jQuery('.gigante').removeClass('gigante');

    // remove class everywhere
    jQuery('.team-member').find('.member-content').removeClass('open');

    // check if we had the class
    if (!hadClass)
      element.find('.member-content').addClass('open');

    //
    if (!hadClass)
      element.parents('.grid-item').addClass('gigante');

    // if we haven't got the class, just stop :3
    if (hadClass) {
      targetGigante.css({ 'margin-bottom': 0 });

      setTimeout(function () {
        $grid.isotope('layout');
      }, 400);
      return;
    }

    setTimeout(function () {
      element.parents('.gigante').css({ 'margin-bottom': 60 });
      $grid.isotope('layout');
    }, 400);
    $grid.isotope('layout');
  });
}

// functions
function wrapIframe() {
  jQuery(".page-content iframe").wrap("<div class='embed-container'></div>");
}

function openSearch() {
  jQuery('.fa-search').on('click', function (e) {
    e.preventDefault();
    jQuery('.search-screen').toggleClass('active');
    jQuery('.menu').removeClass('is-open');
    jQuery('.hamburger').removeClass('is-active');
  });

  jQuery('.btn-search-close').on('click', function () {
    jQuery('.search-screen').removeClass('active');
  });

  jQuery('.btn-lang-close').on('click', function () {
    jQuery('.lang-screen').removeClass('active');
  });
}


function setTeamGrid() {
  // init Isotope
  $grid = jQuery('.team .grid').isotope({
    itemSelector: '.grid-item'
  });

  $grid.imagesLoaded().progress(function () {
    $grid.isotope('layout');
  });

}

function setStoriesGrid() {
  // init Isotope
  $grid = jQuery('.stories-grid').isotope({
    itemSelector: '.story'
  });

  $grid.imagesLoaded().progress(function () {
    $grid.isotope('layout');
  });


  // filter functions
  var filterFns = {
    // show if number is greater than 50
    numberGreaterThan50: function () {
      var number = jQuery(this).find('.number').text();
      return parseInt(number, 10) > 50;
    },
    // show if name ends with -ium
    ium: function () {
      var name = jQuery(this).find('.name').text();
      return name.match(/ium$/);
    }
  };

  // bind filter button click
  jQuery('#filters').on('click', 'button', function () {
    var filterValue = jQuery(this).attr('data-filter');
    // use filterFn if matches value
    filterValue = filterFns[filterValue] || filterValue;
    $grid.isotope({ filter: filterValue });
  });

  // change is-checked class on buttons
  jQuery('.button-group').each(function (i, buttonGroup) {
    var $buttonGroup = jQuery(buttonGroup);
    $buttonGroup.on('click', 'button', function () {
      $buttonGroup.find('.is-checked').removeClass('is-checked');
      jQuery(this).addClass('is-checked');
    });
  });

}

function setStoriesHeight() {
  jQuery('.stories-grid').each(function () {
    var highestBox = 0;
    jQuery('.story', this).each(function () {
      if (jQuery(this).height() > highestBox) {
        highestBox = jQuery(this).height();
      }
    });
    jQuery('.story', this).height(highestBox);
  });

  jQuery('.story-slider').each(function () {
    var highestBox = 0;
    jQuery('.owl-item .slide', this).each(function () {
      if (jQuery(this).height() > highestBox) {
        highestBox = jQuery(this).height();
      }
    });
    jQuery('.owl-item .slide', this).height(highestBox);
  });
}

function setOnSearch() {
  jQuery('.launch-search, .btn-search-close').on('click', function (e) {
    e.preventDefault();

    jQuery('.search-screen').toggleClass('active');
  });
}

function setOnHeaderClass() {
  var togglePosition = 10;
  var currentPosition = jQuery(window).scrollTop();
  if (currentPosition > togglePosition) {
    jQuery("header, main, .navigation").addClass('scrolled');
  } else {
    jQuery("header, main, .navigation").removeClass('scrolled');
  }
}

function startOwlSlider() {

  jQuery(".expertise-slider").owlCarousel({
    loop: true,
    items: 5,
    margin: 25,
    nav: false,
    dots: false,
    lazyload: true,
    autoplay: true,
    slideTransition: 'linear',
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
    autoplaySpeed: 6000,
    responsive: {
      // breakpoint from 0 up
      0: {
        nav: true,
        items: 2
      },
      480: {
        nav: true,
        items: 3
      },
      768: {
        nav: false,
        items: 4
      }
    }
  });

  jQuery('.slider').owlCarousel({
    items: 1,
    nav: false,
    dots: false,
    autoHeight: true,
    autoplay: true,
    loop: true,
    autoplayTimeout: 6000,
    autoplaySpeed: 1000
  });

  jQuery(".clients-slider").owlCarousel({
    loop: true,
    items: 5,
    margin: 5,
    nav: false,
    dots: false,
    lazyload: true,
    autoplay: true,
    slideTransition: 'linear',
    autoplayTimeout: 3000,
    autoplayHoverPause: false,
    autoplaySpeed: 3000,
    responsive: {
      // breakpoint from 0 up
      0: {
        nav: true,
        items: 2
      },
      480: {
        nav: true,
        items: 3
      },
      768: {
        nav: false,
        items: 4
      }
    }
  });

  jQuery('.story-slider').owlCarousel({
    loop: false,
    items: 2,
    margin: 30,
    stagePadding: 100,
    nav: true,
    responsive: {
      // breakpoint from 0 up
      0: {
        nav: true,
        items: 1,
        stagePadding: 0
      },
      768: {
        nav: false,
        items: 2
      },
      1200: {
        nav: false,
        items: 2
      }
    }
  });
}

function replaceImgWithSvg() {
  jQuery('img.svg').each(function () {
    var $img = jQuery(this);
    var imgID = $img.attr('id');
    var imgClass = $img.attr('class');
    var imgURL = $img.attr('src');
    jQuery.get(imgURL, function (data) {
      var $svg = jQuery(data).find('svg');
      if (typeof imgID !== 'undefined') {
        $svg = $svg.attr('id', imgID);
      }
      if (typeof imgClass !== 'undefined') {
        $svg = $svg.attr('class', imgClass + ' replaced-svg');
      }
      $svg = $svg.removeAttr('xmlns:a');
      if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
        $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
      }
      $img.replaceWith($svg);

    }, 'xml');

  });
}

function setHamburgerOnClick() {
  jQuery('.hamburger').on("click", function () {
    // jQuery(".sub-menu").addClass("is-open");
    if (jQuery(this).hasClass('is-active')) {
      jQuery(this).removeClass('is-active');
    } else {
      jQuery(this).addClass("is-active");
    }
    jQuery('.navigation, .navigation ul').toggleClass("is-open");
    jQuery('html').toggleClass("is-active");
  });
}

function setAlignInATag() {
  jQuery('img[class*=align]').each(function (i, e) {
    jQuery(e).parents('a').addClass(jQuery(e).attr('class'));
  });
}

//function setOnRecordView() {
//  inView('.should-animate')
//          .on('enter', function (element) {
//            jQuery(element)
//                    .addClass('animate__animated')
//                    .removeClass('remove__animate');
//          });
//}

//function fetch(options) {
//  return jQuery.ajax({
//    url: ajaxurl,
//    dataType: 'json',
//    data: options,
//    method: "POST"
//  });
//}