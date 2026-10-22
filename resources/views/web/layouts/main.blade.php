<!doctype html>
<html lang="en">
  <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>{{ (isset($currentClinic) && $currentClinic->name) ? $currentClinic->name : 'Healthcare Clinic' }} | {{ isset($title) ? $title : 'Appointments' }}</title>
      <link rel="icon" type="image/png" sizes="32x32" href="{{ (isset($currentClinic) && $currentClinic->logo) ? ($currentClinic->logo_url ?? URL::to('public/' . $currentClinic->logo)) : URL::to('public/assets/web/homeimage/logo.png') }}">
      
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Modern Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

<style>
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    background-color: #f8fafc;
    color: #1e293b;
    overflow-x: hidden;
  }
  html {
    scroll-behavior: smooth;
  }
  .home-area {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background-color: #f8fafc;
  }
  .vital-footer {
    margin-top: auto !important;
  }
  .vital-float-wa {
    position: fixed;
    bottom: 28px;
    right: 28px;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: #25D366;
    color: #ffffff !important;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    box-shadow: 0 6px 22px rgba(37, 211, 102, 0.45);
    z-index: 9999;
    transition: all 0.25s ease;
    text-decoration: none;
  }
  .vital-float-wa:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 28px rgba(37, 211, 102, 0.65);
    color: #ffffff !important;
  }
  @media (max-width: 576px) {
    .vital-float-wa {
      bottom: 20px;
      right: 20px;
      width: 48px;
      height: 48px;
      font-size: 25px;
      box-shadow: 0 4px 16px rgba(37, 211, 102, 0.4);
    }
  }
</style>

@yield('style')

  </head>
  <body>

    <div class="home-area">

      @include('web.layouts.header')

      @yield('banner')

      @yield('content')

      @include('web.layouts.footer')

      @if(isset($currentClinic) && $currentClinic->phone)
      <a target="_blank" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $currentClinic->phone) }}" class="vital-float-wa" title="Chat on WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
      </a>
      @endif

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
  let popup = document.querySelector(".all-popup");
  if (popup) {
    setTimeout(function open(event){
      popup.style.display = "block";
    }, 1000);
  }
});

let closeBtn = document.querySelector("#close-bttt");
if (closeBtn) {
  closeBtn.addEventListener("click", function(){
    let popup = document.querySelector(".all-popup");
    if (popup) popup.style.display = "none";
  });
}
</script>





@yield('js')


  </body>
</html>
























































































































