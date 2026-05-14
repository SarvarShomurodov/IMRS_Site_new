
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// products carousel
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function(){

  $('.items').slick({
    dots: false,
    infinite: true,
    speed: 800,
    autoplay: false,
    autoplaySpeed: 2000,

    arrows: true,
    prevArrow: '<button type="button" class="slick-prev"><ion-icon name="chevron-back-outline"></ion-icon></button>',
    nextArrow: '<button type="button" class="slick-next"><ion-icon name="chevron-forward-outline"></ion-icon></button>',

    slidesToShow: 4,
    slidesToScroll: 1,

    responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
      }
    },
    ]

  });

  $('.itemsinfogrf').slick({
    dots: false,
    infinite: true,
    speed: 800,
    autoplay: true,
    autoplaySpeed: 2000,

    arrows: true,
    prevArrow: '<button type="button" class="slick-prev"><ion-icon name="chevron-back-outline"></ion-icon></button>',
    nextArrow: '<button type="button" class="slick-next"><ion-icon name="chevron-forward-outline"></ion-icon></button>',

    slidesToShow: 2,
    slidesToScroll: 1,

    responsive: [
    {
      breakpoint: 1186,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
      }
    },
    ]

  });
});


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// top two carousels

(function ($)
  { "use strict"
  $('.carousel_big').slick({
   padding: 0,
   margin: 0,
   autoplayTimeout: 8500,
   smartSpeed: 450,

   dots: true,
   infinite: true,
   autoplay: true,
   speed: 400,
   arrows: true,
   prevArrow: '<button type="button" class="slick-prev"><ion-icon name="chevron-back-outline"></ion-icon></button>',
   nextArrow: '<button type="button" class="slick-next"><ion-icon name="chevron-forward-outline"></ion-icon></button>',
   slidesToShow: 1,
   slidesToScroll: 1,
   responsive: [
   {
    breakpoint: 1024,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1,
      infinite: true,
      arrows: false,
    }
  },
  {
    breakpoint: 992,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1,
      infinite: true,
      arrows: false,
    }
  },
  {
    breakpoint: 768,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
    }
  },
  {
    breakpoint: 480,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
    }
  },
  ]
});
})(jQuery);


// second
(function ($)
  { "use strict"
  $('.carousel_little').slick({
   padding: 0,
   margin: 0,
   autoplayTimeout: 8500,
   smartSpeed: 450,

   dots:true,
   infinite: true,
   autoplay: true,
   speed: 400,
   arrows: true,
   prevArrow: '<button type="button" class="slick-prev"><ion-icon name="chevron-back-outline"></ion-icon></button>',
   nextArrow: '<button type="button" class="slick-next"><ion-icon name="chevron-forward-outline"></ion-icon></button>',
   slidesToShow: 1,
   slidesToScroll: 1,
   responsive: [
   {
    breakpoint: 1024,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1,
      infinite: true,
    }
  },
  {
    breakpoint: 992,
    settings: {
      slidesToShow: 2,
      slidesToScroll: 1,
      infinite: true,
      dots: false
    }
  },
  {
    breakpoint: 768,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1,
    }
  },
  {
    breakpoint: 480,
    settings: {
      slidesToShow: 1,
      slidesToScroll: 1,
    }
  },
  ]
});
})(jQuery);
