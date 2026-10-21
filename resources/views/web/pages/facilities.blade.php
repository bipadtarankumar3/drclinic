@extends('web.layouts.main')

@section('style')
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/facilities/faciliti-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/facilities/faciliti-responsive.css')}}">

@endsection

    
@section('banner')

<div class="banner-2">
    <div class="banner-2-img">
        <img src="{{ URL::to('public/assets/web/facilitieimage/Banner.png')}}" alt="">
    </div>
    <div class="ban-2-text">
        <h1>Facilities</h1>
    </div>
    </div>

@endsection


@section('content')



<!-- END nav-banner-main-area -->

<section>
    <div class="benefit">
     <div class="container">
       <div class="head">
         <h1>Roy Neuro Facilities</h1>
         <p>ROY NEURO CENTER is committed to providing efficient, effective and timely healthcare to its patients through the best medical support in a clean and hygienic environment.We value team spirit and believe in true and effective teamwork. We respect our colleagues and work round the clock and in seamless coordination with each other. We believe in free flow of communication between the staff and management, across the board. <br>
           At Roy Neuro, the right person, on the right job, at the right time is the key to organisational and personal success.
         </p>
   
       </div>
       <div class="benefit-con">
          <div class="ben-head">
           <p>Who can benefit our Neuro </p>
          </div>
          <div class="benefit-bot">
           <img src="{{ URL::to('public/assets/web/facilitieimage/ben.png')}}" alt="">
          </div>
       </div>
     </div>
    </div>
   </section>
   
   <!-- end benefit -->
   
   <section>
     <div class="Therapies">
       <div class="container">
         <div class="therapi-head">
           <p>Neuro Rehabilitation Therapies</p>
         </div>
         <div class="therapies-con">
           <div class="therapi-area">
             <div class="therapy-img"><img src="{{ URL::to('public/assets/web/facilitieimage/therapy-1.png')}}" alt=""></div>
             <div class="therapy-text">
               <h1>Physical Medicine 
                 & Rehab</h1>
             </div>
           </div>
   
           <div class="therapi-area">
             <div class="therapy-img"><img src="{{ URL::to('public/assets/web/facilitieimage/therapy-2.png')}}" alt=""></div>
             <div class="therapy-text">
               <h1>Occupational Therapy</h1>
             </div>
           </div>
   
           <div class="therapi-area">
             <div class="therapy-img"><img src="{{ URL::to('public/assets/web/facilitieimage/therapy-3.png')}}" alt=""></div>
             <div class="therapy-text">
               <h1>Physiotherapy</h1>
             </div>
           </div>
   
           <div class="therapi-area">
             <div class="therapy-img"><img src="{{ URL::to('public/assets/web/facilitieimage/therapy-4.png')}}" alt=""></div>
             <div class="therapy-text">
               <h1>Respiratory Therapy</h1>
             </div>
           </div>
   
           <div class="therapi-area">
             <div class="therapy-img"><img src="{{ URL::to('public/assets/web/facilitieimage/therapy-5.png')}}" alt=""></div>
             <div class="therapy-text">
               <h1>Speech & Swallow 
                 Therapy</h1>
             </div>
           </div>
   
           <div class="therapi-area">
             <div class="therapy-img"><img src="{{ URL::to('public/assets/web/facilitieimage/therapy-6.png')}}" alt=""></div>
             <div class="therapy-text">
               <h1>Phychology Medicine 
                 & Rehab</h1>
             </div>
           </div>
   
           <div class="therapi-area">
             <div class="therapy-img"><img src="{{ URL::to('public/assets/web/facilitieimage/therapy-7.png')}}" alt=""></div>
             <div class="therapy-text">
               <h1>Intergrative  Therapy</h1>
             </div>
           </div>
   
           <div class="therapi-area">
             <div class="therapy-img"><img src="{{ URL::to('public/assets/web/facilitieimage/therapy-8.png')}}" alt=""></div>
             <div class="therapy-text">
               <h1>Nutrition Therapy</h1>
             </div>
           </div>
   
   
         </div>
       </div>
     </div>
   </section>
   
   <!--end Therapies -->
   
   <section>
   <div class="comprehensive">
     <div class="container">
       <div class="compre-head"><h1>Your treatment takes comprehensive care</h1></div>
       <div class="comprehensive-con">
         <div class="comprehensive-area">
           <img src="{{ URL::to('public/assets/web/facilitieimage/com-1.png')}}" alt="" class="shake-vertical">
           <h1>No. 1 Transition Care</h1>
           <p>India’s First Dedicated Transition Care Chain for Neurology, Cardiology, Oncology and Healthy Ageing.</p>
         </div>
         <div class="comprehensive-area">
           <img src="{{ URL::to('public/assets/web/facilitieimage/com-2.png')}}" alt="" class="shake-vertical">
           <h1>Expert Team</h1>
           <p>Our all-inclusive personalized packages enable total transparency and assurance of no hidden costs.</p>
         </div>
         <div class="comprehensive-area">
           <img src="{{ URL::to('public/assets/web/facilitieimage/com-3.png')}}" alt="" class="shake-vertical">
           <h1>Holistic Recovery</h1>
           <p>All-inclusive & integrative rehabilitation for your physical and emotional well being</p>
         </div>
         <div class="comprehensive-area">
           <img src="{{ URL::to('public/assets/web/facilitieimage/com-4.png')}}" alt="" class="shake-vertical">
           <h1>Protocol-Driven Approach</h1>
           <p>Highly trained and experienced professionals who are specialized in rehab care.</p>
         </div>
         <div class="comprehensive-area">
           <img src="{{ URL::to('public/assets/web/facilitieimage/com-5.png')}}" alt="" class="shake-vertical">
           <h1>Home-Like Environment</h1>
           <p>A very homely atmosphere with informal spaces which adds to your comfort levels.</p>
         </div>
         <div class="comprehensive-area">
           <img src="{{ URL::to('public/assets/web/facilitieimage/com-6.png')}}" alt="" class="shake-vertical">
           <h1>Personalized Attention</h1>
           <p>We help and support you to get back to the highest level of recovery possible while you are at our facility.</p>
         </div>
   
   <div class="com-box-1"></div>
   <div class="com-box-2"></div>
   <div class="com-box-3"></div>
       </div>
     </div>
   <div class="comprehen-bg"><img src="{{ URL::to('public/assets/web/facilitieimage/comper-vec.png')}}" alt=""></div>
   </div>
   </section>
   


@endsection