@extends('web.layouts.main')


@section('style')
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/about/about-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/about/about-responsive.css')}}">

@endsection

    
@section('banner')

<div class="banner-2">
    <div class="banner-2-img">
        <img src="{{ URL::to('public/assets/web/aboutimage/banner.png')}}" alt="">
    </div>
    <div class="ban-2-text">
        <h1>About Us</h1>
    </div>
    </div>
@endsection

@section('content')

<!-- END nav-banner-main-area -->

<section>
    <div class="overview">
      <div class="container">
          <div class="head">
              <h1>Roy Neuro Overview</h1>
              <p>Roy Neuro Center Speciality is a healthcare provider, par excellence, fast establishing itself as a global industry model in the tertiary healthcare system of India.</p>
            </div>
  
          <div class="over-con">
              <div class="over-img"><img src="{{ URL::to('public/assets/web/aboutimage/doc.png')}}" alt=""></div>
              <div class="over-text">
                  <h1>Dr. Ujjawal Roy</h1>
                  <p>Dr. Ujjawal Roy did his MBBS in 2007 and MD in Medicine in 2012 from the renowned University College of Medical Sciences (Delhi University). He worked briefly as a resident in prestigious AIIMS, New Delhi and GTB hospital, New Delhi. He then did his DM in neurology from Bangur Institute of Neurology (IPGMER), Kolkata. He is the member of many prestigious bodies including Association of Physicians of India, Indian Academy of Neurology, American Academy of Neurology and Movement Disorders Society of India. He has more than 20 peer reviewed international papers as a first author to his credit. He is a reviewer of many reputed journals including prestigious “Neurological Sciences” by Elsevier’s and the BMJ. He has presented many papers and delivered lectures in many national and international conferences of Neurology. He feels blessed to be able to serve his patients which he truly enjoys every day. He has a passion to work in thefield of neurology. He loves having the opportunity to meet and get to know about people of all ages and backgrounds. He feels himself lucky to have opportunity to provide services to his needy patients that, in some cases, can be life changing. He loves Indian music and performs at various charitable ghazal/semi classicalprogrammes. Being a trained Indian classical vocalist he has keen interest in exploring music therapy in treatment of various chronic neurological ailments.</p>
              </div>
          </div>
      </div>
      <div class="over-bg"><img src="{{ URL::to('public/assets/web/aboutimage/over-bg.png')}}" alt=""></div>
    </div>  
  </section>
  
  <!-- end overview -->
  
  <section>
      <div class="mission">
  <div class="container">
      <div class="mission-head"><h4>Our Vision& Mission</h4></div>
  </div>
  
  <div class="mission-main">
      <div class="container">
          <div class="mission-con">
             <div class="mission-area" data-aos="fade-down-right">
              <div class="miss-img"><img src="{{ URL::to('public/assets/web/aboutimage/mis-1.png')}}" alt="" class="scale-up-center"></div>
              <div class="mis-text">
                  <div class="miss-t-top">
                      <h4>Vision</h4>
                  </div>
                  <div class="miss-t-bot">
                      <p>Our vision at Spine City is to be the premier destination for neuro and spine care in Noida and beyond. We aim to set new standards in healthcare by delivering innovative, effective, and compassionate treatment options. Through continuous research, education, and collaboration.</p>
                  </div>
              </div>
             </div>
             <div class="mission-area" data-aos="fade-down-right">
              <div class="miss-img"><img src="{{ URL::to('public/assets/web/aboutimage/mis-2.png')}}" alt="" class="scale-up-center"></div>
              <div class="mis-text">
                  <div class="miss-t-top">
                      <h4>Mission</h4>
                  </div>
                  <div class="miss-t-bot">
                      <p>Expertise: We are dedicated to staying at the forefront of medical advancements in neurology and spine care. Our team of highly trained specialists is committed to continuous learning and skill development.
                          Compassion: We understand the physical and emotional challenges our patients face. </p>
                  </div>
              </div>
             </div>
             <div class="mission-area" data-aos="fade-down-right">
              <div class="miss-img"><img src="{{ URL::to('public/assets/web/aboutimage/mis-3.png')}}" alt="" class="scale-up-center"></div>
              <div class="mis-text">
                  <div class="miss-t-top">
                      <h4>Values</h4>
                  </div>
                  <div class="miss-t-bot">
                      <p>The values statement highlights an organization’s core principles and philosophical ideals. It is used to both inform and guide the decisions and behaviors.The values statement highlights an organization’s core principles and philosophical ideals. It is used to both inform and guide the decisions and behaviors.</p>
                  </div>
              </div>
             </div>
  
          </div>
      </div>
      <div class="mission-box"></div>
  </div>
  
    </div>
  </section>
  
  <!-- end mission -->
  
  <section>
  <div class="Trust">
      <div class="container">
          <div class="head">
              <h1>Why Trust Us</h1>
              <p>Roy Neuro Center Speciality is a healthcare provider, par excellence, fast establishing itself as a global industry model in the tertiary healthcare system of India.</p>
            </div>
      </div>
      <div class="trust-main-area">
          <div class="container">
            <div class="quality">
              <div class="quality-area">
                  <div class="qu-img"><img src="{{ URL::to('public/assets/web/aboutimage/tru-1.png')}}" alt=""></div>
                  <h1>Quality health care</h1>
                   <div class="qua-box"></div>
                   <p>There's no time like the present! If you haven't done so already, it's time to harness the power of positive online Google reviews. At DoctorsInternet.com, we've helped thousands of clients establish a robust and successful.
  
                   </p>
               </div>
               <div class="quality-area">
                  <div class="qu-img"><img src="{{ URL::to('public/assets/web/aboutimage/tru-2.png')}}" alt=""></div>
                  <h1>Only Qualified Doctors
  
                  </h1>
                   <div class="qua-box"></div>
                   <p>There's no time like the present! If you haven't done so already, it's time to harness the power of positive online Google reviews. At DoctorsInternet.com, we've helped thousands of clients establish a robust and successful.
                   </p>
               </div>
               <div class="quality-area">
                  <div class="qu-img"><img src="{{ URL::to('public/assets/web/aboutimage/tru-3.png')}}" alt=""></div>
                  <h1>Medical Research</h1>
                   <div class="qua-box"></div>
                   <p>There's no time like the present! If you haven't done so already, it's time to harness the power of positive online Google reviews. At DoctorsInternet.com, we've helped thousands of clients establish a robust and successful.
  
                   </p>
               </div>
  
            </div>
          </div>   
          <div class="trust-vec"><img src="{{ URL::to('public/assets/web/aboutimage/trust-men.png')}}" alt=""></div> 
      </div>
  
  </div>
  </section>
  
  <!-- end Trust -->
  
  <section>
      <div class="Treatment">
          <div class="container">
              <div class="head">
                  <h1>Our Treatment</h1>
                  <p>Roy Neuro Center Speciality is a healthcare provider, par excellence, fast establishing itself as a global industry model in the tertiary healthcare system of India.</p>
                </div>
                <div class="Treatment-main">
                  <div class="Treatment-1">
                      <div class="Treatment-area" data-aos="fade-right">
                          <div class="terat-img"><img src="{{ URL::to('public/assets/web/aboutimage/treat-1.png')}}" alt="" class="shake-horizontal"></div>
                          <div class="terat-text"><p>Stroke Recovery</p></div>
                      </div>
                      <div class="Treatment-area" data-aos="fade-left">
                          <div class="terat-img"><img src="{{ URL::to('public/assets/web/aboutimage/treat-2.png')}}" alt="" class="shake-horizontal"></div>
                          <div class="terat-text"><p>Epilepsy Treatment</p></div>
                      </div>
                      <div class="Treatment-area" data-aos="fade-right">
                          <div class="terat-img"><img src="{{ URL::to('public/assets/web/aboutimage/treat-3.png')}}" alt="" class="shake-horizontal"></div>
                          <div class="terat-text"><p>Paediatic Neurology</p></div>
                      </div>
                      <div class="Treatment-area" data-aos="fade-left">
                          <div class="terat-img"><img src="{{ URL::to('public/assets/web/aboutimage/treat-4.png')}}" alt="" class="shake-horizontal"></div>
                          <div class="terat-text"><p>Disc Management</p></div>
                      </div>
                      <div class="Treatment-area" data-aos="fade-right">
                          <div class="terat-img"><img src="{{ URL::to('public/assets/web/aboutimage/treat-5.png')}}" alt="" class="shake-horizontal"></div>
                          <div class="terat-text"><p>Movement Disorder</p></div>
                      </div>
                      <div class="Treatment-area" data-aos="fade-left">
                          <div class="terat-img"><img src="{{ URL::to('public/assets/web/aboutimage/treat-6.png')}}" alt="" class="shake-horizontal"></div>
                          <div class="terat-text"><p>Brain Aneurysm</p></div>
                      </div>
                      <div class="Treatment-area" data-aos="fade-right">
                          <div class="terat-img"><img src="{{ URL::to('public/assets/web/aboutimage/treat-7.png')}}" alt="" class="shake-horizontal"></div>
                          <div class="terat-text"><p>Neuro Intensive Care</p></div>
                      </div>
                      <div class="Treatment-area" data-aos="fade-left">
                          <div class="terat-img"><img src="{{ URL::to('public/assets/web/aboutimage/treat-8.png')}}" alt="" class="shake-horizontal"></div>
                          <div class="terat-text"><p>Neuro Degenerative 
                              Disease</p></div>
                      </div>
                      <div class="Treatment-area" data-aos="fade-right">
                          <div class="terat-img"><img src="{{ URL::to('public/assets/web/aboutimage/treat-9.png')}}" alt="" class="shake-horizontal"></div>
                          <div class="terat-text"><p>Memory Disorder</p></div>
                      </div>
                      <div class="Treatment-area" data-aos="fade-left">
                          <div class="terat-img"><img src="{{ URL::to('public/assets/web/aboutimage/treat-10.png')}}" alt="" class="shake-horizontal"></div>
                          <div class="terat-text"><p>Women’s Neurological 
                              Services</p></div>
                      </div>
                  </div>
  
                </div>
          </div>
  </div>
  </section>
  
  <!-- end Treatment -->
  
  <section>
      <div class="Expert">
          <div class="container">
              <div class="head">
                  <h1>We Are Expert</h1>
                  <p>Roy Neuro Center Speciality is a healthcare provider, par excellence, fast establishing itself as a global industry model in the tertiary healthcare system of India.</p>
                </div>
              <div class="Expert-con">
                  <div class="Expert-area">
                      <div class="export-top">
                          <div class="exp-img"><img src="{{ URL::to('public/assets/web/aboutimage/ex.png')}}" alt="" class="scale-up-center"></div>
                          <div class="exp-text"><h2>Minimal invasive surgery</h2></div>
                      </div>
                      <div class="export-bot"><p>Provide treatment using modern minimally invasive brain and spine surgical care.</p></div>
                  </div>
                  <div class="Expert-area">
                      <div class="export-top">
                          <div class="exp-img"><img src="{{ URL::to('public/assets/web/aboutimage/ex.png')}}" alt="" class="scale-up-center"></div>
                          <div class="exp-text"><h2>Neuro-intensive care facility</h2></div>
                      </div>
                      <div class="export-bot"><p>A neuro-intensive care facility is available to provide the best outcome.</p></div>
                  </div>
                  <div class="Expert-area">
                      <div class="export-top">
                          <div class="exp-img"><img src="{{ URL::to('public/assets/web/aboutimage/ex.png')}}" alt="" class="scale-up-center"></div>
                          <div class="exp-text"><h2>Brain tumor treatment</h2></div>
                      </div>
                      <div class="export-bot"><p>Surgical, radiation, and chemotherapy treatment for brain tumor removal.</p></div>
                  </div>
                  <div class="Expert-area">
                      <div class="export-top">
                          <div class="exp-img"><img src="{{ URL::to('public/assets/web/aboutimage/ex.png')}}" alt="" class="scale-up-center"></div>
                          <div class="exp-text"><h2>Complex spine surgery</h2></div>
                      </div>
                      <div class="export-bot"><p>Specializes in minimally invasive spine surgery, spinal tumours and complex spine surgery.</p></div>
                  </div>
  
              </div>
          </div>
      </div>
  </section>



@endsection