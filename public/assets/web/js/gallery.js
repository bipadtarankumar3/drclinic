$(document).ready(function(){
    $('.gallery-text-ar').on('click', function(){
    // get the data attribute
    var tab_id = $(this).attr('data-tab');
    // remove the default classes
    $('.gallery-text-ar').removeClass('current');
    $('.gallery-img').removeClass('current');
    // add new classes on mouse click
    $(this).addClass('current');
    $('#'+tab_id).addClass('current');
    });
    });

 // end tab


  const tabs = document.querySelectorAll('[data-tab-target]')
const tabContents = document.querySelectorAll('[data-tab-content]')

tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    const target = document.querySelector(tab.dataset.tabTarget)
    tabContents.forEach(tabContent => {
      tabContent.classList.remove('active')
    })
    tabs.forEach(tab => {
      tab.classList.remove('active')
    })
    tab.classList.add('active')
    target.classList.add('active')
  })
})

// end tab


$('.owl-carousel').owlCarousel({
  loop:true,
  margin:10,
  nav:true,
  dots:false,
  autoplay:true,
  autoplayTimeout:2000,
  autoplayHoverPause:true,
  responsive:{
      0:{
          items:1
      },
      600:{
          items:2
      },
      1000:{
          items:4
      }
  }
})




















