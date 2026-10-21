@extends('web.layouts.main')


@section('style')


<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/paralysis/paralysis-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/paralysis/paralysis-responsive.css')}}">
 
@endsection

    
@section('banner')


<div class="banner-2">
    <div class="banner-2-img">
        <img src="{{ URL::to('public/assets/web/paralysis/Banner.png')}}" alt="">
    </div>
    <div class="ban-2-text">
        <h1>Paralysis/Stroke</h1>
    </div>
    </div>

@endsection

@section('content')


<section>
    <div class="stroke">
      <div class="head">
        <h1>NEURO / STROKE  SERVICES</h1>
        <p>A brain stroke, also known as a cerebrovascular accident or CVA, is a sudden and severe disruption of blood flow to a part of the brain, which can cause damage to brain cells and impair various functions. Strokes are majorly classified into two: ischemic and hemorrhagic.</p>
      </div>
    
    <div class="stoke-bot">
      <div class="stoke-img image-wrapper shine"><img src="{{ URL::to('public/assets/web/paralysis/para-img.png')}}" alt=""></div>
      <div class="stoke-text">
        <p> <span>I</span>schemic strokes account for approximately 85% of all stroke cases. They occur when a blood clot (thrombus) or a piece of a clot (embolus) blocks a cerebral blood vessel, preventing oxygen and essential nutrients from reaching the affected brain tissue. The lack of blood supply leads to the rapid death of brain cells, causing the symptoms associated with a stroke. <br><br>
          Hemorrhagic strokes, on the other hand, are caused by the rupture or leakage of a blood vessel in the brain. This type of stroke accounts for about 15% of stroke cases and can be further classified into two categories: intracerebral hemorrhage (ICH) and subarachnoid hemorrhage (SAH). ICH occurs when a blood vessel within the brain's tissue ruptures, while SAH happens when a blood vessel located on the brain's surface ruptures, causing blood to leak into the space surrounding the brain. <br><br>
          Other possible signs include dizziness, loss of balance, and severe pain in the face, arm, or leg on one side of the body. It is crucial to recognize these symptoms and seek immediate medical attention, as timely intervention can significantly impact the outcome of the stroke.</p>
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
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/paralysis/Symp-1.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>sudden severe headache</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/paralysis/Symp-2.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>one sided numbness</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/paralysis/Symp-3.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>confusion</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/paralysis/Symp-4.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>trouble speaking</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/paralysis/Symp-5.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>difficulty seeing</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/paralysis/Symp-6.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Vertigo</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/paralysis/Symp-7.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Dizzyness</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/paralysis/Symp-8.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>shaking body</h1></div>
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
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/paralysis/pre-1.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>maintaining a healthy lifestyle</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/paralysis/pre-2.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>regular exercise</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/paralysis/pre-3.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>managing blood pressure</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/paralysis/pre-4.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>a balanced diet</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/paralysis/pre-5.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>addressing risk factors such as smoking, 
              excessive alcohol consumption, and diabetes.</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/paralysis/pre-6.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>maintaining a healthy weight.</p></div>
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