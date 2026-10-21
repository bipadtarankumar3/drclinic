@extends('web.layouts.main')

@section('style')

@endsection


@section('banner')

<div class="banner">
  
    <div class="owl-carousel owl-theme">
     <div class="item">
       <div class="banner-area">
         <div class="banner-img">
           <img src="{{ URL::to('public/assets/web/homeimage/Banner-box-bg.png')}}" alt="" id="desk-img">
           <img src="{{ URL::to('public/assets/web/homeimage/tab-ban-1.png')}}" alt="" id="tab-img">
           <img src="{{ URL::to('public/assets/web/homeimage/mob-ban-1.png')}}" alt="" id="mob-img">
         </div>
         <div class="banner-text-main banner-text-main-dis">
         <div class="banner-text banner-text-ar">
           <h1>Roy Neuro Care</h1>
         <p>COMPASSION. CARE. CURE</p>
         <h4 >Let our expert neurological care provide you.</h4>
         
           <button><a href="appoinment.html" class="more-btn">Book An Appointment</a></button>
         </div>
         <div class="banner-text-img scale-in-center"><img src="{{ URL::to('public/assets/web/homeimage/banner-box-1.png')}}" alt=""></div>
         </div>
       </div>
     </div>
   
     <div class="item">
       <div class="banner-area">
         <div class="banner-img">
           <img src="{{ URL::to('public/assets/web/homeimage/Banner-2.png')}}" alt="" id="desk-img">
           <img src="{{ URL::to('public/assets/web/homeimage/tab-ban-2.png')}}" alt="" id="tab-img">
           <img src="{{ URL::to('public/assets/web/homeimage/mob-ban-2.png')}}" alt="" id="mob-img">
         </div>
         <div class="banner-text-main">
         <div class="banner-text">
           <h1>Critical Moments, <br>
             Experts Hands Touch</h1>
         <h4>Let our expert neurological care provide you with lasting relief.</h4>
         <!-- <div id='preloader'>
           <div class='spinner'>
             <div class='loader'>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
             </div>
             
           </div>
           </div> -->
           <!-- <div class="psi-line"></div> -->
           <button><a href="appoinment.html" class="more-btn">Book An Appointment</a></button>
         </div>
         </div>
       </div>
     </div>
   
     <div class="item">
       <div class="banner-area">
         <div class="banner-img">
           <img src="{{ URL::to('public/assets/web/homeimage/Banner-3.png')}}" alt="" id="desk-img">
           <img src="{{ URL::to('public/assets/web/homeimage/tab-ban-3.png')}}" alt="" id="tab-img">
           <img src="{{ URL::to('public/assets/web/homeimage/mob-ban-3.png')}}" alt="" id="mob-img">
         </div>
         <div class="banner-text-main">
         <div class="banner-text">
           <h1>Put Your Spine Back <br>
             On Track With Us</h1>
         <h4>Let our expert neurological care provide you with lasting relief.</h4>
         <!-- <div id='preloader'>
           <div class='spinner'>
             <div class='loader'>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
             </div>
             
           </div>
           </div>
           <div class="psi-line"></div> -->
           <button><a href="appoinment.html" class="more-btn">Book An Appointment</a></button>
         </div>
         </div>
       </div>
     </div>
   
     <div class="item">
       <div class="banner-area">
         <div class="banner-img">
           <img src="{{ URL::to('public/assets/web/homeimage/Banner-4.png')}}" alt="" id="desk-img">
           <img src="{{ URL::to('public/assets/web/homeimage/tab-ban-4.png')}}" alt="" id="tab-img">
           <img src="{{ URL::to('public/assets/web/homeimage/mob-ban-4.png')}}" alt="" id="mob-img">
         </div>
         <div class="banner-text-main">
         <div class="banner-text">
           <h1>Struggling with Chronic  <br>
             Headaches or Migraines?</h1>
         <h4>Let our expert neurological care provide you with lasting relief.</h4>
         <!-- <div id='preloader'>
           <div class='spinner'>
             <div class='loader'>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
             </div>
             
           </div>
           </div>
           <div class="psi-line"></div> -->
           <button><a href="appoinment.html" class="more-btn">Book An Appointment</a></button>
         </div>
         </div>
       </div>
     </div>
   
     <div class="item">
       <div class="banner-area">
         <div class="banner-img">
           <img src="{{ URL::to('public/assets/web/homeimage/Banner-5.png')}}" alt="" id="desk-img">
           <img src="{{ URL::to('public/assets/web/homeimage/tab-ban-5.png')}}" alt="" id="tab-img">
           <img src="{{ URL::to('public/assets/web/homeimage/mob-ban-5.png')}}" alt="" id="mob-img">
         </div>
         <div class="banner-text-main">
         <div class="banner-text">
           <h1>Relieve Sciatica Pain <br>
             From Best Experts
             </h1>
         <h4>Let our expert neurological care provide you with lasting relief.</h4>
         <!-- <div id='preloader'>
           <div class='spinner'>
             <div class='loader'>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
               <div class='moving-dot'></div>
             </div>
             
           </div>
           </div>
           <div class="psi-line"></div> -->
           <button><a href="appoinment.html" class="more-btn">Book An Appointment</a></button>
         </div>
         </div>
       </div>
     </div>
   
   </div>
   
   </div>

@endsection


@section('content')


<div class="all-popup">
  <div class="allp-pop-up-area">
    <button id="close-bttt"><i class="fa-solid fa-circle-xmark crr"></i></button>
    <div class="pop-h">
      <p>NOTICE</p>
    </div>
    <h1>NO VISITORS BEYOND THIS <br>
      POINT <br>
      HOSPITAL <br>
      HOSPITAL PERSONNEL ONLY </h1>
     
  </div>
</div>

<section>
    <div class="welcome">
    <div class="container">
      <div class="wel-con">
        <div class="wel-head">
          <h1> Welcome To Best Neurophysician in <br> <span>Roy Neuro Centre</span></h1>
        </div>
        <div class="wel-area">
          <p>Roy Neuro Centre, started off in the year 2023, is a pioneering healthcare facility, dedicated to addressing a wide spectrum of neurological disorders. Dr. Ujjawal Roy, the backbone and founder of Roy Neuro Centre top and the best neurophysician in Roy Neuro Center. His exceptional skills, deep empathy, and dedication to patient care have made Harish Neuro Centre the top neurology hospital . His journey is filled with accolades and achievements showcasing his unwavering dedication and passion towards healthcare. He completed his MBBS from the prestigious Guntur Medical College, a seat that he obtained in the 1st attempt itself. On appearing for the post graduation exams, Dr. Harish ranked 18th in the state, thereby opting to pursue General Medicine from the acclaimed KGH, </p>
        </div>
      </div>
    </div>  
  
  <div class="wel-bg"><img src="{{ URL::to('public/assets/web/homeimage/wel-bg.png')}}" alt="" class="girl--swinging"></div>
  
  
    </div>
  </section>
  
  <!-- end welcome -->
  
  <section>
    <div class="director">
      <div class="director-con">
        <div class="director-img" data-aos="fade-right">
            <img src="{{ URL::to('public/assets/web/homeimage/Doctor.png')}}" alt="">
        </div>
        
        <div class="director-text" data-aos="fade-left">
            <div class="director-top">
                <h1>Dr. Ujjawal Roy</h1>
                <h4>Neurophysician</h4>
                <p>Dr. Ujjawal Roy did his MBBS in 2007 and MD in Medicine in 2012 from the renowned University College of Medical Sciences (Delhi University). He worked briefly as a resident in prestigious AIIMS, New Delhi and GTB hospital, New Delhi. He then did his DM in neurology from Bangur Institute of Neurology (IPGMER), Kolkata. He is the member of many prestigious bodies including Association of Physicians of India, Indian Academy of Neurology, American Academy of Neurology and Movement Disorders Society of India. He has more than 20 peer reviewed international papers as a first author to his credit. He is a reviewer of many reputed journals including prestigious “Neurological Sciences” by Elsevier’s and the BMJ. He has presented many papers and delivered lectures in many national and international conferences of Neurology.</p>
            </div>
            <div class="director-bot">
                <div class="director-area">
                 <div class="di-img"><img src="{{ URL::to('public/assets/web/homeimage/doc-1.png')}}" alt="" class="heartbeat"></div>
                 <div class="di-text"><h1>Free Consultation</h1></div>
                </div>
                <div class="director-area">
                    <div class="di-img"><img src="{{ URL::to('public/assets/web/homeimage/doc-2.png')}}" alt="" class="heartbeat"></div>
                    <div class="di-text"><h1>Emergency 24X7</h1></div>
                   </div>
                   <div class="director-area">
                    <div class="di-img"><img src="{{ URL::to('public/assets/web/homeimage/doc-3.png')}}" alt="" class="heartbeat"></div>
                    <div class="di-text"><h1>Modern Technology</h1></div>
                   </div>
        
            </div>
        </div>
        </div>
        <div class="direc-bg"><img src="{{ URL::to('public/assets/web/homeimage/direc-bg.png')}}" alt=""></div>
    </div>
  </section>
  
   <!-- end director -->
  
  <section>
    <div class="Quality">
    <div class="container">
      <div class="quality-con">
        <div class="quality-area">
           <div class="qu-img"><img src="{{ URL::to('public/assets/web/homeimage/qu-1.png')}}" alt=""></div>
           <h1>Quality Services</h1>
            <div class="qua-box"></div>
            <p>Experienced and devoted doctors are ready to help you with your problems.</p>
        </div> 
        <div class="quality-area">
          <div class="qu-img"><img src="{{ URL::to('public/assets/web/homeimage/qu-2.png')}}" alt=""></div>
          <h1>Emergency Care</h1>
           <div class="qua-box"></div>
           <p>We are always ready to help when you need urgent help! Our emergency team is here for you!</p>
       </div>
       <div class="quality-area">
        <div class="qu-img"><img src="{{ URL::to('public/assets/web/homeimage/qu-3.png')}}" alt=""></div>
        <h1>24x7 Services</h1>
         <div class="qua-box"></div>
         <p>Anytime you need help, you may contact us and our receptionist will make an appointment for you.</p>
     </div>
     <div class="quality-area">
      <div class="qu-img"><img src="{{ URL::to('public/assets/web/homeimage/qu-4.png')}}" alt=""></div>
      <h1>Online Appointment</h1>
       <div class="qua-box"></div>
       <p>Experienced and devoted doctors are ready to help you with your problems.</p>
   </div>
  
      </div>
    </div>
  <div class="qua-bg">
    <img src="{{ URL::to('public/assets/web/homeimage/qua-bg-1.png')}}" alt="" class="rotate-center">
  </div>
  <div class="qua-bg-2">
    <img src="{{ URL::to('public/assets/web/homeimage/qua-bg-1.png')}}" alt="" class="rotate-center">
  </div>
  
    </div>
  </section>
  
  <!-- end Quality -->
  
  <section>
   <div class="services">
  <div class="container">
    <div class="ser-con">
      <div class="head">
        <h1>Our Services</h1>
        <p>Roy Neuro Center Speciality is a healthcare provider, par excellence, fast establishing itself as a global industry model in the tertiary healthcare system of India.</p>
      </div>
  <div class="services-main">
    <div class="services-area">
      <div class="hover-lay"></div>
      <div class="ser-img"><img src="{{ URL::to('public/assets/web/homeimage/ser-1.png')}}" alt=""></div>
      <h1>Deep Brain Stimulation</h1>
      <p>Deep brain stimulation (DBS) involves implanting electrodes within certain areas of the brain. These electrodes produce electrical impulses that regulate abnormal impulses. Or the electrical impulses can affect certain cells and chemicals within the brain.</p>
    </div>
    <div class="services-area">
      <div class="hover-lay"></div>
      <div class="ser-img"><img src="{{ URL::to('public/assets/web/homeimage/ser-2.png')}}" alt=""></div>
      <h1>Spinal Cord Stimilation</h1>
      <p>A spinal cord stimulator (SCS) device is surgically placed under your skin and sends a mild electric current to your spinal cord. Thin wires carry current from a pulse generator to the nerve fibers of the spinal cord. When turned on, the SCS stimulates the nerves’</p>
    </div>
    <div class="services-area">
      <div class="hover-lay"></div>
      <div class="ser-img"><img src="{{ URL::to('public/assets/web/homeimage/ser-3.png')}}" alt=""></div>
      <h1>Baclofen Pump</h1>
      <p>A baclofen pump is a little machine that is placed under the skin of one side of the abdomen (belly) near the hip bone. It is used to deliver baclofen directly into the spinal canal.</p>
    </div>
    <div class="services-area">
      <div class="hover-lay"></div>
      <div class="ser-img"><img src="{{ URL::to('public/assets/web/homeimage/ser-4.png')}}" alt=""></div>
      <h1>Brain Tumor</h1>
      <p>A cancerous or non-cancerous mass or growth of abnormal cells in the brain. Tumors can start in the brain, or cancer elsewhere in the body can spread to the brain. Symptoms include new or increasingly strong headaches, blurred vision, loss of balance, confusion.</p>
    </div>
    <div class="services-area">
      <div class="hover-lay"></div>
      <div class="ser-img"><img src="{{ URL::to('public/assets/web/homeimage/ser-5.png')}}" alt=""></div>
      <h1>Epilepsy Surgery</h1>
      <p>Epilepsy surgery involves a neurosurgical procedure where an area of the brain involved in seizures is either resected, ablated, disconnected, or stimulated. The goal is to eliminate seizures or significantly reduce seizure burden. Approximately 60%.</p>
    </div>
    <div class="services-area">
      <div class="hover-lay"></div>
      <div class="ser-img"><img src="{{ URL::to('public/assets/web/homeimage/ser-6.png')}}" alt=""></div>
      <h1>Vagal Nerve Stimulation</h1>
      <p>Vagus nerve stimulation is a medical treatment that involves delivering electrical impulses to the vagus nerve. It is used as an add-on treatment for certain types of intractable epilepsy and treatment-resistant depression</p>
    </div>
  
  
  </div>
  
    </div>
  </div>
  
  <div class="ser-bg-1"><img src="{{ URL::to('public/assets/web/homeimage/ser-bg-1.png')}}" alt="" class="vert-move"></div>
  <div class="ser-bg-2"><img src="{{ URL::to('public/assets/web/homeimage/ser-bg-2.png')}}" alt="" class="vert-move"></div>
   </div> 
  </section>
  
  <!-- end services -->
  
  <section>
    <div class="facility-div">
   
        <div class="facility-con">
          <div class="head">
            <h1>Our Facilities</h1>
            <p>Roy Neuro Center Speciality is a healthcare provider, par excellence, fast establishing itself as a global industry model in the tertiary healthcare system of India.</p>
          </div>
  
          <div class="facility-bot">
            <div class="facility-area" data-aos="fade-right">
             <div class="facility">
              <div class="facility-text">
                <h1>Movement Disorder Services</h1>
                <p>Movement disorders as indicated by the name are the disorders...</p>
              </div>
              <div class="facility-img"><img src="{{ URL::to('public/assets/web/homeimage/fac-1.png')}}" alt=""></div>
             </div>
             <div class="facility">
              <div class="facility-text">
                <h1>Women's Neurology Services</h1>
                <p>Women's neurology services are referred to as the specialised...</p>
              </div>
              <div class="facility-img"><img src="{{ URL::to('public/assets/web/homeimage/fac-2.png')}}" alt=""></div>
             </div>
             <div class="facility">
              <div class="facility-text">
                <h1>Disc Disease Management</h1>
                <p>Disc disease is referred to as the pain in the lower back...</p>
              </div>
              <div class="facility-img"><img src="{{ URL::to('public/assets/web/homeimage/fac-3.png')}}" alt=""></div>
             </div>
  
            </div>
          
  
            <div class="facility-area" data-aos="fade-left">
              <div class="facility">
               <div class="facility-text">
                 <h1>Neurodegenerative Diseases</h1>
                 <p>Movement disorders as indicated by the name are the disorders...</p>
               </div>
               <div class="facility-img"><img src="{{ URL::to('public/assets/web/homeimage/fac-4.png')}}" alt=""></div>
              </div>
              <div class="facility">
               <div class="facility-text">
                 <h1>Paediatric Neurology</h1>
                 <p>Paediatric neurology more popularly known as child...</p>
               </div>
               <div class="facility-img"><img src="{{ URL::to('public/assets/web/homeimage/fac-5.png')}}" alt=""></div>
              </div>
              <div class="facility">
               <div class="facility-text">
                 <h1>Memory Disorders</h1>
                 <p>A little lapse of memory is quite common among all of us...</p>
               </div>
               <div class="facility-img"><img src="{{ URL::to('public/assets/web/homeimage/fac-6.png')}}" alt="" ></div>
              </div>
   
             </div>
          </div>
        </div>
    
  
  <div class="brain"><img src="{{ URL::to('public/assets/web/homeimage/Brain.png')}}" alt=""></div>
  <div class="fac-bg"></div>
  <div class="fac-vec"><img src="{{ URL::to('public/assets/web/homeimage/fac-bg.png')}}" alt=""></div>
  
    </div>
  </section>
  
  <!-- end facility-div -->
  
  <section>
    <div class="Problems">
  <div class="container">
    <div class="problems-con">
      <div class="head">
        <h1>Signs of Neurological Problems</h1>
        <p>Roy Neuro Center Speciality is a healthcare provider, par excellence, fast establishing itself as a global industry model in the tertiary healthcare system of India.</p>
      </div>
  
      <div class="problems-bot">
        <div class="problems-area">
          <h1>Severe 
            headaches
             or migraines</h1>
        </div>
        <div class="problems-area">
          <h1>Chronic lower 
            back or 
            neck pain</h1>
        </div>
        <div class="problems-area">
          <h1>Seizures or
            tremors</h1>
        </div>
        <div class="problems-area">
          <h1>Loss of consciousness</h1>
        </div>
        <div class="problems-area">
          <h1>Confusion or 
            disorientation</h1>
        </div>
        <div class="problems-area">
          <h1>Sudden 
            dizziness or 
            loss of balance</h1>
        </div>
        <div class="problems-area">
          <h1>Concussion</h1>
        </div>
        <div class="problems-area">
          <h1>Memory loss</h1>
        </div>
      </div>
    </div>
  </div>
  
  
  <div class="problem-bg"><img src="{{ URL::to('public/assets/web/homeimage/problem-bg.png')}}" alt=""></div>
  
    </div>
  </section>
  
  <!-- end Problems -->
  
  <section>
    <div class="enqury">
      <div class="container">
        <div class="head">
          <h1>Book Your Visit At Roy Neuro Care</h1>
          <p>Roy Neuro Center Speciality is a healthcare provider, par excellence, fast establishing itself as a global industry model in the tertiary healthcare system of India.</p>
        </div>
        <div class="enque-con">
          <div class="apply-area">
            <div class="apply-div">
                <label for="Name">Your Name *</label><br>
                <input type="text">
            </div>
            <div class="apply-div">
                <label for="number">Your Mobile No. *</label><br>
                <input type="number">
            </div>
            <div class="apply-div">
                <label for="Email">Your Email Address  *</label><br>
                <input type="email">
            </div>
            <div class="apply-div">
                <label for="myfile">Appointment Date</label><br>
                <input type="date">
            </div>
           
        </div>
        <button type="submit"><div class="rid-b"><a class="r-but" href="#">SUBMIT</a></div></button>
  
        </div>
      </div>
    </div>
  </section>
  
  <!-- end enqury -->
  
  <section>
  <div class="client">
    <div class="container">
      <div class="head">
        <h1>Clients Feedback</h1>
        <p>Roy Neuro Center Speciality is a healthcare provider, par excellence, fast establishing itself as a global industry model in the tertiary healthcare system of India.</p>
      </div>
    </div>
    <div class="client-main">
      <div class="testi-cli owl-carousel owl-theme">
        <div class="item">
          <div class="client-area">
            <div class="client-top">
              <div class="testi-img"><img src="{{ URL::to('public/assets/web/homeimage/testi-1.png')}}" alt=""></div>
            <p> Dr. Maharshi is indeed the best neurosurgeon in Jamshedpur. Highly qualified and experienced. He is very warm and caring towards his patients.Brain and Spine are delicate and prone to injury. </p>
          </div>
          <div class="client-bot">
            <div class="icon">
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
            </div>
            <h1>ISHITA ROY</h1>
            <h5>Neuro Patient</h5>
          </div>
          <div class="cli-bg"></div>
            </div>
        </div>
        <div class="item">
          <div class="client-area">
            <div class="client-top">
              <div class="testi-img"><img src="{{ URL::to('public/assets/web/homeimage/testi-1.png')}}" alt=""></div>
            <p> Dr. Maharshi is indeed the best neurosurgeon in Jamshedpur. Highly qualified and experienced. He is very warm and caring towards his patients.Brain and Spine are delicate and prone to injury. </p>
          </div>
          <div class="client-bot">
            <div class="icon">
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
            </div>
            <h1>ISHITA ROY</h1>
            <h5>Neuro Patient</h5>
          </div>
          <div class="cli-bg"></div>
            </div>
        </div>
        <div class="item">
          <div class="client-area">
            <div class="client-top">
              <div class="testi-img"><img src="{{ URL::to('public/assets/web/homeimage/testi-1.png')}}" alt=""></div>
            <p> Dr. Maharshi is indeed the best neurosurgeon in Jamshedpur. Highly qualified and experienced. He is very warm and caring towards his patients.Brain and Spine are delicate and prone to injury. </p>
          </div>
          <div class="client-bot">
            <div class="icon">
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
            </div>
            <h1>ISHITA ROY</h1>
            <h5>Neuro Patient</h5>
          </div>
          <div class="cli-bg"></div>
            </div>
        </div>
        <div class="item">
          <div class="client-area">
            <div class="client-top">
              <div class="testi-img"><img src="{{ URL::to('public/assets/web/homeimage/testi-1.png')}}" alt=""></div>
            <p> Dr. Maharshi is indeed the best neurosurgeon in Jamshedpur. Highly qualified and experienced. He is very warm and caring towards his patients.Brain and Spine are delicate and prone to injury. </p>
          </div>
          <div class="client-bot">
            <div class="icon">
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
              <i class="fa-solid fa-star star"></i>
            </div>
            <h1>ISHITA ROY</h1>
            <h5>Neuro Patient</h5>
          </div>
          <div class="cli-bg"></div>
            </div>
        </div>
        
    </div>
  
    </div>
  </div>
  </section>
  
  
  <!-- end client -->
  
  <section>
    <div class="gallery">
      <div class="container">
        <div class="head">
          <h1>Our Gallery</h1>
          <p>Roy Neuro Center Speciality is a healthcare provider, par excellence, fast establishing itself as a global industry model in the tertiary healthcare system of India.</p>
        </div>
      </div>
      <div class="gallery-main">
        <div class="gall owl-carousel owl-theme">
          <div class="item">
            <div class="gallery-area">
            <div class="gal-img"><img src="{{ URL::to('public/assets/web/homeimage/gal-1.png')}}" alt=""></div>
            <div class="gal-overlay">
              <div class="plu">
                <div class="plus-ar" data-popup-open="popup-1">
                  <i class="fa-solid fa-plus plus"></i>
                </div>
               </div>
            </div>
            </div>
          </div>
          <div class="item">
            <div class="gallery-area">
            <div class="gal-img"><img src="{{ URL::to('public/assets/web/homeimage/gal-2.png')}}" alt=""></div>
            <div class="gal-overlay">
              <div class="plu">
                <div class="plus-ar" data-popup-open="popup-2">
                  <i class="fa-solid fa-plus plus"></i>
                </div>
               </div>
            </div>
            </div>
          </div>
          <div class="item">
            <div class="gallery-area">
            <div class="gal-img"><img src="{{ URL::to('public/assets/web/homeimage/gal-3.png')}}" alt=""></div>
            <div class="gal-overlay">
              <div class="plu">
                <div class="plus-ar" data-popup-open="popup-3">
                  <i class="fa-solid fa-plus plus"></i>
                </div>
               </div>
            </div>
            </div>
          </div>
          <div class="item">
            <div class="gallery-area">
            <div class="gal-img"><img src="{{ URL::to('public/assets/web/homeimage/gal-4.png')}}" alt=""></div>
            <div class="gal-overlay">
              <div class="plu">
                <div class="plus-ar" data-popup-open="popup-4">
                  <i class="fa-solid fa-plus plus"></i>
                </div>
               </div>
            </div>
            </div>
          </div>
          <div class="item">
            <div class="gallery-area">
            <div class="gal-img"><img src="{{ URL::to('public/assets/web/homeimage/gal-5.png')}}" alt=""></div>
            <div class="gal-overlay">
              <div class="plu">
                <div class="plus-ar" data-popup-open="popup-5">
                  <i class="fa-solid fa-plus plus"></i>
                </div>
               </div>
            </div>
            </div>
          </div>
          <div class="item">
            <div class="gallery-area">
            <div class="gal-img"><img src="{{ URL::to('public/assets/web/homeimage/gal-6.png')}}" alt=""></div>
            <div class="gal-overlay">
              <div class="plu">
                <div class="plus-ar" data-popup-open="popup-6">
                  <i class="fa-solid fa-plus plus"></i>
                </div>
               </div>
            </div>
            </div>
          </div>
          <div class="item">
            <div class="gallery-area">
            <div class="gal-img"><img src="{{ URL::to('public/assets/web/homeimage/gal-7.png')}}" alt=""></div>
            <div class="gal-overlay">
              <div class="plu">
                <div class="plus-ar" data-popup-open="popup-7">
                  <i class="fa-solid fa-plus plus"></i>
                </div>
               </div>
            </div>
            </div>
          </div>
          
      </div>
  
      <div class="popup" data-popup="popup-1">
        <div class="popup-inner">
           <img src="{{ URL::to('public/assets/web/homeimage/gal-1.png')}}" alt="">
            <!-- <p><a data-popup-close="popup-1" href="#">Close</a></p> -->
            <a class="popup-close" data-popup-close="popup-1" href="#">x</a>
        </div>
      </div>
      
      <div class="popup" data-popup="popup-2">
        <div class="popup-inner">
           <img src="{{ URL::to('public/assets/web/homeimage/gal-2.png')}}" alt="">
            <!-- <p><a data-popup-close="popup-1" href="#">Close</a></p> -->
            <a class="popup-close" data-popup-close="popup-2" href="#">x</a>
        </div>
      </div>
  
      <div class="popup" data-popup="popup-3">
        <div class="popup-inner">
           <img src="{{ URL::to('public/assets/web/homeimage/gal-3.png')}}" alt="">
            <!-- <p><a data-popup-close="popup-1" href="#">Close</a></p> -->
            <a class="popup-close" data-popup-close="popup-3" href="#">x</a>
        </div>
      </div>
  
      <div class="popup" data-popup="popup-4">
        <div class="popup-inner">
           <img src="{{ URL::to('public/assets/web/homeimage/gal-4.png')}}" alt="">
            <!-- <p><a data-popup-close="popup-1" href="#">Close</a></p> -->
            <a class="popup-close" data-popup-close="popup-4" href="#">x</a>
        </div>
      </div>
  
   <div class="popup" data-popup="popup-5">
        <div class="popup-inner">
           <img src="{{ URL::to('public/assets/web/homeimage/gal-5.png')}}" alt="">
            <!-- <p><a data-popup-close="popup-1" href="#">Close</a></p> -->
            <a class="popup-close" data-popup-close="popup-5" href="#">x</a>
        </div>
      </div>
  
      <div class="popup" data-popup="popup-6">
        <div class="popup-inner">
           <img src="{{ URL::to('public/assets/web/homeimage/gal-6.png')}}" alt="">
            <!-- <p><a data-popup-close="popup-1" href="#">Close</a></p> -->
            <a class="popup-close" data-popup-close="popup-6" href="#">x</a>
        </div>
      </div>
  
      <div class="popup" data-popup="popup-7">
        <div class="popup-inner">
           <img src="{{ URL::to('public/assets/web/homeimage/gal-7.png')}}" alt="">
            <!-- <p><a data-popup-close="popup-1" href="#">Close</a></p> -->
            <a class="popup-close" data-popup-close="popup-7" href="#">x</a>
        </div>
      </div>
  
  
  
  
  
      </div>
    </div>
    </section>
    
    <!-- end gallery -->
  
  
@endsection
