@extends('web.layouts.main')


@section('style')


<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/gallery/gallery-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/gallery/gallery-responsive.css')}}">

@endsection

    
@section('banner')

<div class="banner-2">
    <div class="banner-2-img">
        <img src="{{ URL::to('public/assets/web/galleryimage/Banner.png')}}" alt="">
    </div>
    <div class="ban-2-text">
        <h1>Gallery</h1>
    </div>
    </div>

@endsection

@section('content')


<section>
    <div class="gallery">
      <div class="container">
       <div class="gallery-main-ar-yy">
        <div class="head">
          <h1>Our Gallery</h1>
          <p>Roy Neuro Center Speciality is a healthcare provider, par excellence, fast establishing itself as a global industry model in the tertiary healthcare system of India.</p>
        </div>
  
        <div class="gallery-con">
           <div class="gall-top-t">
            <div class="gall-wh-text">
              <div class="gallery-text">
                <div class="gallery-text-ar current" data-tab="tab-1">
                 <p>Brain Tumors</p>
                </div>
                <div class="gallery-text-ar" data-tab="tab-2">
                 <p>Head Injuries and Brain Clots</p>
                </div>
                <div class="gallery-text-ar" data-tab="tab-3">
                 <p>Spinal Dysraphism (pediatric)</p>
                </div>
                <div class="gallery-text-ar" data-tab="tab-4">
                 <p>Nerve Tumor</p>
                </div>
                <div class="gallery-text-ar" data-tab="tab-5">
                 <p>Atlanto-Axial Dislocation</p>
                </div>
                <div class="gallery-text-ar" data-tab="tab-6">
                 <p>Listhesis</p>
                </div>
                <div class="gallery-text-ar" data-tab="tab-7">
                 <p>Bullet Injury</p>
                </div>
                <div class="gallery-text-ar" data-tab="tab-8">
                 <p>Vascular Surgery</p>
                </div>
                <div class="gallery-text-ar" data-tab="tab-9">
                 <p>Cervical Fusion</p>
                </div>
                <div class="gallery-text-ar" data-tab="tab-10">
                 <p>Thoraco Lumber Fusion</p>
                </div>
                <div class="gallery-text-ar" data-tab="tab-11">
                 <p>Spinal Tumors</p>
                </div>
     
              </div>
            </div>
           </div>
  
            <div class="gallery-img current" id="tab-1">
            <div class="gall-img-area">
             <div class="gal-img-top">
              <div class="gal-im active" id="home" data-tab-content><img src="{{ URL::to('public/assets/web/galleryimage/gal-top-1.png')}}" alt=""></div>
  
              <div class="gal-im" id="home2" data-tab-content><img src="{{ URL::to('public/assets/web/galleryimage/gal-top-2.png')}}" alt=""></div>
  
              <div class="gal-im" id="home3" data-tab-content><img src="{{ URL::to('public/assets/web/galleryimage/gal-top-3.png')}}" alt=""></div>
  
              <div class="gal-im" id="home4" data-tab-content><img src="{{ URL::to('public/assets/web/galleryimage/gal-top-4.png')}}" alt=""></div>
  
              <div class="gal-im" id="home5" data-tab-content><img src="{{ URL::to('public/assets/web/galleryimage/gal-top-5.png')}}" alt=""></div>
  
              <div class="gal-im" id="home6" data-tab-content><img src="{{ URL::to('public/assets/web/galleryimage/gal-top-6.png')}}" alt=""></div>
             </div>
  
  
  
             
             <div class="gal-img-bot">
              <div class="gal-bo tab active" data-tab-target="#home"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-1.png')}}" alt=""></div>
  
              <div class="gal-bo tab" data-tab-target="#home2"><img src="{{ URL::to('public/assets/web/galleryimage/brain-bot-1.png')}}" alt=""></div>
  
              <div class="gal-bo tab" data-tab-target="#home3"><img src="{{ URL::to('public/assets/web/galleryimage/brain-bot-2.png')}}" alt=""></div>
  
              <div class="gal-bo tab" data-tab-target="#home4"><img src="{{ URL::to('public/assets/web/galleryimage/brain-bot-3.png')}}" alt=""></div>
  
              <div class="gal-bo tab" data-tab-target="#home5"><img src="{{ URL::to('public/assets/web/galleryimage/brain-bot-4.png')}}" alt=""></div>
  
              <div class="gal-bo tab" data-tab-target="#home6"><img src="{{ URL::to('public/assets/web/galleryimage/brain-bot-5.png')}}" alt=""></div>
  
             </div>
  
            </div>
           </div>
  
           <div class="gallery-img" id="tab-2">
            <div class="gall-img-area">
             <div class="gal-img-top">
              <div class="gal-im active"><img src="{{ URL::to('public/assets/web/galleryimage/inju-top-1.png')}}" alt=""></div>
  
             </div>
  
             
             <div class="gal-img-bot">
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/inju-bot-1.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/inju-bot-2.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/inju-bot-3.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/inju-bot-4.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/inju-bot-5.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/inju-bot-6.png')}}" alt=""></div>
  
             </div>
  
            </div>
           </div>
         
           <div class="gallery-img" id="tab-3">
            <div class="gall-img-area">
             <div class="gal-img-top">
              <div class="gal-im active"><img src="{{ URL::to('public/assets/web/galleryimage/spinal-top-1.png')}}" alt=""></div>
  
             </div>
             
             <div class="gal-img-bot">
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/spinal-bot-1.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-2.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-3.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-4.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-5.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-6.png')}}" alt=""></div>
  
             </div>
  
            </div>
           </div>
  
           <div class="gallery-img" id="tab-4">
            <div class="gall-img-area">
             <div class="gal-img-top">
              <div class="gal-im active"><img src="{{ URL::to('public/assets/web/galleryimage/nerve-top-1.png')}}" alt=""></div>
  
             </div>
  
             
             <div class="gal-img-bot">
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/nerve-bot-1.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-2.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-3.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-4.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-5.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-6.png')}}" alt=""></div>
  
             </div>
  
            </div>
           </div>
  
           <div class="gallery-img" id="tab-5">
            <div class="gall-img-area">
             <div class="gal-img-top">
              <div class="gal-im active"><img src="{{ URL::to('public/assets/web/galleryimage/atlanto-top-1.png')}}" alt=""></div>
  
             </div>
  
             
             <div class="gal-img-bot">
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/atlanto-bot-1.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-2.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-3.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-4.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-5.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-6.png')}}" alt=""></div>
  
             </div>
  
            </div>
           </div>
  
           <div class="gallery-img" id="tab-6">
            <div class="gall-img-area">
             <div class="gal-img-top">
              <div class="gal-im active"><img src="{{ URL::to('public/assets/web/galleryimage/listhesis-top-1.png')}}" alt=""></div>
  
             </div>
  
             
             <div class="gal-img-bot">
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/listhesis-bot-1.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-2.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-3.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-4.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-5.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-6.png')}}" alt=""></div>
  
             </div>
  
            </div>
           </div>
  
           <div class="gallery-img" id="tab-7">
            <div class="gall-img-area">
             <div class="gal-img-top">
              <div class="gal-im active"><img src="{{ URL::to('public/assets/web/galleryimage/gal-top-1.png')}}" alt=""></div>
  
             </div>
  
             
             <div class="gal-img-bot">
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-1.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-2.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-3.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-4.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-5.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-6.png')}}" alt=""></div>
  
             </div>
  
            </div>
           </div>
  
           <div class="gallery-img" id="tab-8">
            <div class="gall-img-area">
             <div class="gal-img-top">
              <div class="gal-im active"><img src="{{ URL::to('public/assets/web/galleryimage/gal-top-1.png')}}" alt=""></div>
  
             </div>
  
             
             <div class="gal-img-bot">
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-1.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-2.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-3.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-4.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-5.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-6.png')}}" alt=""></div>
  
             </div>
  
            </div>
           </div>
  
           <div class="gallery-img" id="tab-9">
            <div class="gall-img-area">
             <div class="gal-img-top">
              <div class="gal-im active"><img src="{{ URL::to('public/assets/web/galleryimage/gal-top-1.png')}}" alt=""></div>
  
             </div>
  
             
             <div class="gal-img-bot">
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-1.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-2.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-3.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-4.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-5.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-6.png')}}" alt=""></div>
  
             </div>
  
            </div>
           </div>
  
           <div class="gallery-img" id="tab-10">
            <div class="gall-img-area">
             <div class="gal-img-top">
              <div class="gal-im active"><img src="{{ URL::to('public/assets/web/galleryimage/gal-top-1.png')}}" alt=""></div>
  
             </div>
  
             
             <div class="gal-img-bot">
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-1.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-2.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-3.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-4.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-5.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-6.png')}}" alt=""></div>
  
             </div>
  
            </div>
           </div>
  
           <div class="gallery-img" id="tab-11">
            <div class="gall-img-area">
             <div class="gal-img-top">
              <div class="gal-im active"><img src="{{ URL::to('public/assets/web/galleryimage/gal-top-1.png')}}" alt=""></div>
  
             </div>
  
             
             <div class="gal-img-bot">
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-1.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-2.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-3.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-4.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-5.png')}}" alt=""></div>
  
              <div class="gal-bo"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bot-6.png')}}" alt=""></div>
  
             </div>
  
            </div>
           </div>
  
        </div>
       </div>
  
      </div>
      <div class="gallery-bg"><img src="{{ URL::to('public/assets/web/galleryimage/gal-bg.png')}}" alt=""></div>
    </div>
  </section>
  
  <!-- end gallery -->
  
  <section>
    <div class="gal-testi">
      <div class="gal-tes-head"><p>Testimonials Videos</p></div>
      <div class="gal-tes-con">
        <div class="owl-carousel owl-theme">
          <div class="item">
            <div class="testi-video">
              <video src="{{ URL::to('public/assets/web/video/testi-video.mp4')}}" autoplay loop muted></video>
            </div>
          </div>
          <div class="item">
            <div class="testi-video">
              <video src="{{ URL::to('public/assets/web/video/testi-video.mp4')}}" autoplay loop muted></video>
            </div>
          </div>
          <div class="item">
            <div class="testi-video">
              <video src="{{ URL::to('public/assets/web/video/testi-video.mp4')}}" autoplay loop muted></video>
            </div>
          </div>
          <div class="item">
            <div class="testi-video">
              <video src="{{ URL::to('public/assets/web/video/testi-video.mp4')}}" autoplay loop muted></video>
            </div>
          </div>
          <div class="item">
            <div class="testi-video">
              <video src="{{ URL::to('public/assets/web/video/testi-video.mp4')}}" autoplay loop muted></video>
            </div>
          </div>
      </div>
      </div>
    </div>
  </section>
  



@endsection



    
@section('js')

<script src="{{ URL::to('public/assets/web/js/gallery.js')}}"></script>

@endsection