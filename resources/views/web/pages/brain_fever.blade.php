@extends('web.layouts.main')

    
@section('banner')

<div class="banner-2">
    <div class="banner-2-img">
        <img src="{{ URL::to('public/assets/web/brainimage/Banner.png')}}" alt="">
    </div>
    <div class="ban-2-text">
        <h1>Brain Fever Treatment</h1>
    </div>
    </div>

@endsection

@section('content')



<section>
    <div class="stroke">
      <div class="head">
        <h1>Brain Fever Treatment</h1>
        <p>Brain fever, also known as encephalitis, is an inflammation of the brain caused by infection, either through viral, bacterial, or less commonly, fungal agents.</p>
      </div>
    
    <div class="stoke-bot">
      <div class="stoke-img image-wrapper shine"><img src="{{ URL::to('public/assets/web/brainimage/img.png')}}" alt=""></div>
      <div class="stoke-text">
        <p> <span>B</span>rain fever, also known as encephalitis, is an inflammation of the brain caused by infection, either through viral, bacterial, or less commonly, fungal agents. This condition affects the brain's tissue and can lead to severe complications, including seizures, long-term neurological deficits, or even death.<br><br>
          Bacterial encephalitis is relatively rare but can be more severe than viral encephalitis. Meningitis, an infection of the membranes surrounding the brain and spinal cord, can sometimes progress to encephalitis if the bacteria invade the brain tissue needing evaluation by Best meningitis specialist in RanchiExamples of bacterial pathogens causing encephalitis include Streptococcus pneumoniae, Haemophilus influenzae type B, and Neisseria meningitidis.<br><br>
          Encephalitis can present with a wide range of symptoms, depending on the extent of brain involvement and the specific causative agent. Early symptoms may include fever, headache, vomiting, and general malaise. As the infection progresses, symptoms may worsen, leading to confusion, seizures, altered levels of consciousness, focal neurological deficits, and even coma. <br><br>Fungal encephalitis is an uncommon cause of brain fever, typically occurring in immunocompromised individuals or those with underlying medical conditions.</p>
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
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/brainimage/Symp-1.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Heat fever</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/brainimage/Symp-2.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>vomiting</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/brainimage/Symp-3.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Stiffness</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/brainimage/Symp-4.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>confusion</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/brainimage/Symp-5.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>Rash</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/brainimage/Symp-6.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>fatigue</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/brainimage/Symp-7.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>seizures</h1></div>
             </div>
    
             <div class="sympoms-area">
               <div class="sympoms-img"><img src="{{ URL::to('public/assets/web/brainimage/Symp-8.png')}}" alt=""></div>
               <div class="sympoms-text"><h1>photophobia</h1></div>
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
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/brainimage/pre-1.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>stress management</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/brainimage/pre-2.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>nature based activities</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/brainimage/pre-3.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>Conventional Excercises</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/brainimage/pre-4.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>expressive therapies</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/brainimage/pre-5.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>Avoiadance Of risky substances</p></div>
          </div>
    
          <div class="preven-area">
            <div class="preven-img"><img src="{{ URL::to('public/assets/web/brainimage/pre-6.png')}}" alt="" class="heartbeat"></div>
            <div class="preven-text"><p>Mind-body exercises</p></div>
          </div>
    
        </div>
      </div>
    </div>
    </section>
    
    <!-- end preventive -->
    
    


@endsection