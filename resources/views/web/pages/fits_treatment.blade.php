@extends('web.layouts.main')

    
@section('banner')

<div class="banner-2">
    <div class="banner-2-img">
        <img src="{{ URL::to('public/assets/web/fitsimage/Banner.png')}}" alt="">
    </div>
    <div class="ban-2-text">
        <h1>Fits Treatment</h1>
    </div>
    </div>

@endsection

@section('content')



<section>
    <div class="stroke">
      <div class="head">
        <h1>Fits Treatment</h1>
        <p>Fits or seizures are sudden, uncontrolled electrical disturbances in the brain that can cause changes in an individual's behavior, movements, feelings, or levels of consciousness. </p>
      </div>
    
    <div class="stoke-bot">
      <div class="stoke-img image-wrapper shine"><img src="{{ URL::to('public/assets/web/fitsimage/img.png')}}" alt=""></div>
      <div class="stoke-text">
        <p> <span>F</span>its or seizures are sudden, uncontrolled electrical disturbances in the brain that can cause changes in an individual's behavior, movements, feelings, or levels of consciousness. They are a symptom of various underlying conditions, including epilepsy, stroke, brain injuries, or metabolic disorders. Seizures can range from brief and almost imperceptible to long-lasting and severe, with varying degrees of impact on an individual's daily life. <br><br>
          Epilepsy is one of the most commonly seen neurological condition by Neurology specialist.It is characterized by recurrent, unprovoked seizures, and it can significantly impact an individual's quality of life. There are different types of epilepsy, and seizures can manifest in various ways, depending on the part of the brain affected and the specific pattern of electrical activity.<br><br>
          Epilepsy is one of the most commonly seen neurological condition by Neurology specialist. It is characterized by recurrent, unprovoked seizures, and it can significantly impact an individual's quality of life. There are different types of epilepsy, and seizures can manifest in various ways, depending on the part of the brain affected and the specific pattern of electrical activity.</p>
      </div>
    </div>
    </div>
    </section>
    
    <!-- end stroke -->
    
    <section>
      <div class="Symptoms">
                      <div class="container">
                        <div class="symptoms-head"><h1>Symptoms by Best neurology specialist:</h1></div>
                      </div>
         <div class="symptoms-main-area">
          <div class="container">
            
            <div class="sympoms-con">
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/fitsimage/Symp-1.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>sudden severe headache</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/fitsimage/Symp-2.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Sudden fall</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/fitsimage/Symp-3.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Uncontrollable Jerking </h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/fitsimage/Symp-4.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>strange Emotion</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/fitsimage/Symp-5.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Consciousness</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/fitsimage/Symp-6.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Staring</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/fitsimage/Symp-7.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Aura</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/fitsimage/Symp-8.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Anxiety</h1></div>
             </div>
    
           </div>
       </div>
         </div>
      </div>
    </section>
    
    <!-- end Symptoms -->
    
    <section>
    <div class="preventive">
      <div class="container">
        <div class="preventive-head"><h1>Preventive measures include:</h1></div>
        <div class="preven-con">
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/fitsimage/pre-1.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>remaining calm</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/fitsimage/pre-2.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>creating space to avoid injuries by moving
              surrounding furniture and objects</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/fitsimage/pre-3.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>placing a pillow or cushion under their head</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/fitsimage/pre-4.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>noting the time the seizure begins and ends</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/fitsimage/pre-5.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>laying them on their side for protection if
              no cushioning is available</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/fitsimage/pre-6.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>staying with your loved one for the entire 
              seizure </p></div>
          </div>
    
        </div>
      </div>
    </div>
    </section>
    
    <!-- end preventive -->
    
    


@endsection


    
@section('js')

{{-- <script src="{{ URL::to('public/assets/web/js/faq.js')}}"></script> --}}

@endsection