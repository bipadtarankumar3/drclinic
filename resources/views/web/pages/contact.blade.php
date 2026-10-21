@extends('web.layouts.main')


@section('style')

<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/contact/contact-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/contact/contact-responsive.css')}}">

@endsection


@section('banner')

    <div class="banner-2">
        <div class="banner-2-img">
            <img src="{{ URL::to('public/assets/web/contactimage/Banner.png')}}" alt="">
        </div>
        <div class="ban-2-text">
            <h1>Contact Us</h1>
        </div>
    </div>
  
@endsection


@section('content')


<!-- END nav-banner-main-area -->

   <!-- <Start Of Contact> -->

    <Section class="contact">
        <div class="container">
          <div class="head">
            <h1>Get In Touch With Us</h1>
            <p>Roy Neuro Center Speciality is a healthcare provider, par excellence, fast establishing itself as a global industry model in the tertiary healthcare system of India.</p>
          </div>
            <div class="contact-con">
  
                  <div class="contact-box">
                    <div class="box-img">
                      <a href="https://maps.app.goo.gl/LcxBn6PLfE1FvpcW8"><i class="fa-solid fa-location-dot contac-ic"></i></a>
                    </div>
                    <div class="box-text">
                      <h1>Address</h1>
                      <p>Ground Floor, Balaji Bhawan, Chesire Home Road, Bariatu, Ranchi</p>
                    </div>
                  </div>
               
                  <div class="contact-box">
                    <div class="box-img">
                      <a href="tel:+91 96317 75097"><i class="fa-solid fa-phone contac-ic"></i></a>
                    </div>
                    <div class="box-text">
                      <h1>Mobile No.</h1>
                      <p>+91-96317 75097</p>
                    </div>
                  </div>
  
                  <div class="contact-box">
                    <div class="box-img">
                      <a href="mailto:royneurocare@gmail.com"><i class="fa-solid fa-envelope-circle-check contac-ic"></i></a>
                    </div>
                    <div class="box-text">
                      <h1>Email-ID</h1>
                      <p>royneurocare@gmail.com</p>
                    </div>
                  </div>
                </div>
            
              <div class="con-form">
  
                   <div class="form-head">
                    <h4>Fill Your Details Here</h4>
                   </div>
                    <form action="page.php" method="post">
  
                      <div class="input">
                        <input type="text" name="name" placeholder="Name">
                      </div>
                      <div class="input">
                        <input type="number" name="number" placeholder="number">
                      </div>
  
                      <div class="input">
                        <input type="email" name="email" placeholder="Email ID">
                      </div>
  
                    <div class="input">
                      <textarea name="message" placeholder="Message"></textarea>
                    </div>
  
                    <button type="submit" class="gbl_btn">Submit </i></button>
  
                    </form>
              </div>
            </div>
    </Section>
  
     <!-- <End Of Contact> -->
  
  <!-- <Start Of Map>      -->
  
  <section class="map">
  
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3661.655858290812!2d85.36145847604405!3d23.400663902111702!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f4e1cb9b7f0b2d%3A0x65b458157b8f261d!2sRoy%20Neuro%20Care%20(Dr%20Ujjawal%20Roy%20Neurology)!5e0!3m2!1sen!2sin!4v1737018352651!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  
  </section>
  
  <!-- <End Of Map>      -->  
  
  


@endsection