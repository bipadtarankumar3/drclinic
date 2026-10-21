<!doctype html>
<html lang="en">
  <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Roy Neuro | {{ isset($title ) ? $title : ''}}</title>
      <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::to('public/assets/web/homeimage/logo.png')}}">
      
    <!-- Bootstrap CSS -->
    <link rel="shortcut icon" href="{{ URL::to('public/assets/web/logo/favicon-32x32.png" type="image/x-icon')}}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi+Ink&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::to('public/assets/web/css/navcss/nav-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/navcss/nav-responsive.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/homecss/hom-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/homecss/responsive-hom.css')}}">

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">


@yield('style')

   
    
  </head>
  <body>

    <div class="home-area">

      <section>

        <div class="nav-banner-main-area">
        
          <div class="nav-area">
        
            <div class="upper-nav">
              <div class="container">
                
              <div class="upper-main">
                <div class="upper-contact">
                  <div class="foot-contact-area">
                    <div class="foot-cin-ic"><a href="https://maps.app.goo.gl/LcxBn6PLfE1FvpcW8"><i class="fa-solid fa-location-dot upper-nav-ic"></i></a></div>
                    <div class="upper-cin-text"><p>Ground Floor, Balaji Bhawan, Chesire Home Road, Bariatu, Ranchi
                      </p></div>
                  </div>
                  <div class="foot-contact-area">
                    <div class="foot-cin-ic"><a href="tel:+91 96317 75097"><i class="fa-solid fa-phone upper-nav-ic"></i></a></div>
                    <div class="upper-cin-text"><p>+91- 96317 75097
                      </p></div>
                  </div>
                  <div class="foot-contact-area">
                    <div class="foot-cin-ic"><a href="mailto:royneurocare@gmail.com"><i class="fa-regular fa-envelope upper-nav-ic"></i></a></div>
                    <div class="upper-cin-text"><p>royneurocare@gmail.com
                      </p></div>
                  </div>
                
                </div>
                <div class="upper-icon">
                  <a href="https://www.facebook.com/RoyNeuroCare"><i class="fa-brands fa-facebook-f fac"></i></a>
                  <a href="#"><i class="fa-brands fa-instagram ins"></i></a>
                  <a href="#"><i class="fa-brands fa-youtube you"></i></a>
                 </div>
              </div>
            
              </div>
            
            </div>
            
            <!-- end upper-nav -->
            

              @include('web.layouts.header')
              
          </div>

          
          @yield('banner')

        </div>
      </section>
            

      

<!-- END nav-banner-main-area -->

@yield('content')


  <!-- start footer -->

@include('web.layouts.footer')

<!-- end footer -->


<div class="floating_btn">
  <a target="_blank" href="#">
    <div class="contact_icon">
      <i class="fa-brands fa-whatsapp my-float"></i>
    </div>
  </a>
</div>

<a id="button"></a>

<a class="phone-icon" href="tel:+91- 96317 75097"><i class="fa-solid fa-mobile-screen-button pho"></i></a>

</div>


    <!-- start java script -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/javascript.util/0.12.12/javascript.util.min.js" integrity="sha512-oHBLR38hkpOtf4dW75gdfO7VhEKg2fsitvHZYHZjObc4BPKou2PGenyxA5ZJ8CCqWytBx5wpiSqwVEBy84b7tw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    
    <script src="{{ URL::to('public/assets/web/js/nav.js')}}"></script>
   <script src="{{ URL::to('public/assets/web/js/index.js')}}"></script>



   <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
   <script>
    AOS.init();
  </script>


<script>
  
window.addEventListener("load", function(){

setTimeout(
    function open(event){
      document.querySelector(".all-popup") .style.display = "block";
    },
   

)

});

document.querySelector("#close-bttt") .addEventListener("click", function(){
document.querySelector(".all-popup") .style.display = "none";


});





</script>





@yield('js')


  </body>
</html>
























































































































