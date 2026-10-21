@extends('web.layouts.main')

    
@section('banner')

<div class="banner-2">
    <div class="banner-2-img">
        <img src="{{ URL::to('public/assets/web/disease/Banner.png')}}" alt="">
    </div>
    <div class="ban-2-text">
        <h1>Parkinson’s disease Treatment</h1>
    </div>
    </div>

@endsection

@section('content')


<section>
    <div class="stroke">
      <div class="head">
        <h1>Parkinson’s disease Treatment</h1>
        <p>Parkinson's disease is a progressive neurological disorder that affects movement, cognitive function, and overall quality of life.</p>
      </div>
    
    <div class="stoke-bot">
      <div class="stoke-img image-wrapper shine"><img src="{{ URL::to('public/assets/web/disease/img.png')}}" alt=""></div>
      <div class="stoke-text">
        <p> <span>P</span>arkinson's disease is a progressive neurological disorder that affects movement, cognitive function, and overall quality of life. It is characterized by the degeneration of dopamine-producing neurons in a specific region of the brain called the substantia nigra. As these neurons die, the brain's ability to produce dopamine diminishes, leading to a range of symptoms that can worsen over time.<br><br>
          The exact cause of Parkinson's disease remains unknown even to the Best neurologist in Ranchi, but several factors may contribute to its development. Genetic mutations, environmental factors, and a combination of both have been implicated in the disease's onset. Age, gender, and exposure to certain pesticides or toxins may also increase an individual's risk of developing Parkinson's.<br><br>
          Parkinson's disease is typically diagnosed through a combination of medical history, physical examination, and diagnostic tests. No single test can definitively diagnose the disease, so doctors rely on evaluating the patient's symptoms, medical history, and ruling out other potential causes of their symptoms. Imaging studies like magnetic resonance imaging (MRI) or dopamine transporter scans may help confirm the diagnosis in some cases.</p>
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
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/disease/Symp-1.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>sudden severe headache</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/disease/Symp-2.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Sudden fall</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/disease/Symp-3.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Uncontrollable Jerking </h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/disease/Symp-4.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>strange Emotion</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/disease/Symp-5.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Consciousness</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/disease/Symp-6.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Staring</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/disease/Symp-7.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Aura</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/disease/Symp-8.png')}}" alt=""></div>
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
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/disease/pre-1.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>Stooped posture</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/disease/pre-2.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>nature based activities</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/disease/pre-3.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>Conventional Excercises</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/disease/pre-4.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>expressive therapies</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/disease/pre-5.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>Avoiadance Of risky substances</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/disease/pre-6.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>Mind-body exercises</p></div>
          </div>
    
        </div>
      </div>
    </div>
    </section>
    
    <!-- end preventive -->
    
    



@endsection


@section('js')
{{-- <script src="{{ URL::to('public/assets/web/js/testi.js')}}"></script> --}}
 

@endsection