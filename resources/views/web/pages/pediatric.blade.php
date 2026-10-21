@extends('web.layouts.main')

    
@section('banner')


<div class="banner-2">
    <div class="banner-2-img">
        <img src="{{ URL::to('public/assets/web/pediatric/Banner.png')}}" alt="">
    </div>
    <div class="ban-2-text">
        <h1>Pediatric Neurology</h1>
    </div>
    </div>

@endsection

@section('content')


<section>
    <div class="stroke">
      <div class="head">
        <h1>Pediatric Neurological Treatment</h1>
        <p>Neurological problems in kids happen when something is unusual in the brain, the nervous system or the muscle cells. </p>
      </div>
    
    <div class="stoke-bot">
      <div class="stoke-img image-wrapper shine"><img src="{{ URL::to('public/assets/web/pediatric/img.png')}}" alt=""></div>
      <div class="stoke-text">
        <p><span>N</span>eurological problems in kids happen when something is unusual in the brain, the nervous system or the muscle cells. These problems can differ from epilepsy to migraine headaches to tic or movement disorders and more. Get the best treatment for child neurology disorder in Bellary from children neurologist in Bellary, Dr. Ujjawal Roy.<br><br>
          While it's difficult to tell when to look for specific clinical care for your kid, our best child neuro specialist in Bellary suggest a fast assessment by child specialist if your kid is showing a decrease in developmental milestones. For instance, it's a warning sign that your kid has lost a skill that they had previously mastered like walking, talking, or feeding themselves.<br><br>
          Early diagnosis and intervention is the key. If your kid's normal behaviour has changed decisively, call their pediatrician for an assessment</p>
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
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/pediatric/Symp-1.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Headaches</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/pediatric/Symp-2.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Epilepsy</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/pediatric/Symp-3.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Seizures</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/pediatric/Symp-4.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Stroke</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/pediatric/Symp-5.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>ALS</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/pediatric/Symp-6.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Alzheimer's Disease </h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/pediatric/Symp-7.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Parkinson's Disease</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/pediatric/Symp-8.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Dementia</h1></div>
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
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/pediatric/pre-1.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>Do not leave child alone</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/pediatric/pre-2.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>keep the room free of obstacales</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/pediatric/pre-3.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>Accompany the child</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/pediatric/pre-4.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>keep rails of crib and bed raised & 
              castores locked </p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/pediatric/pre-5.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>never sleep with the child with aramchair</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/pediatric/pre-6.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>Know the effect of the medicines that the childs takes</p></div>
          </div>
    
        </div>
      </div>
    </div>
    </section>
    
    <!-- end preventive -->
    
    



@endsection