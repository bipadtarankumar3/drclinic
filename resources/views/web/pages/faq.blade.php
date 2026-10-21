@extends('web.layouts.main')


@section('style')

<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/faq/faq-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/faq/faq-responsive.css')}}">

@endsection

    
@section('banner')


<div class="banner-2">
    <div class="banner-2-img">
        <img src="{{ URL::to('public/assets/web/appointment/faq-banner.png')}}" alt="">
    </div>
    <div class="ban-2-text">
        <h1>Faq</h1>
    </div>
    </div>

@endsection

@section('content')


<section>
    <div class="faq">
        <div class="head head-4">
            <h1>FAQ</h1>
            <div class="head-line"></div>
          </div>
        <div class="container">
            <div class="faq-area-main">
           
                <div class="faq-area">
                    <div class="accordion-wrapper">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="accordion-one">
                              <div class="accordion">
              
                                <h5>1. What conditions do neurosurgeons treat?</h5>
              
                                <div class="accordion-icon"></div>
                              </div>
              
                              <div class="accordion-content">
                                <p>
                                  Trauma to the brain and spine, blocked arteries, birth defects, aneurysms, chronic low back pain, brain and spinal tumors, and peripheral nerve issues are all treated by neurosurgeons.
                                </p>
                              </div>
                            </div>
                          </div>
              
                          <div class="col-lg-12">
                            <div class="accordion-one">
                              <div class="accordion">
                                <!-- <div class="btn-img">
                                  <img src="{{ URL::to('public/assets/web/aboutimage/line.png')}}" alt="btn-img" />
                                </div> -->
              
                                <h5>2. How do I choose the best neurosurgeon hospital in Chennai?</h5>
              
                                <div class="accordion-icon"></div>
                              </div>
              
                              <div class="accordion-content">
                                <p>
                                  Trauma to the brain and spine, blocked arteries, birth defects, aneurysms, chronic low back pain, brain and spinal tumors, and peripheral nerve issues are all treated by neurosurgeons.
                                </p>
                              </div>
                            </div>
                          </div>
              
                          <div class="col-lg-12">
                            <div class="accordion-one">
                              <div class="accordion">
                                <!-- <div class="btn-img">
                                  <img src="{{ URL::to('public/assets/web/aboutimage/line.png')}}" alt="btn-img" />
                                </div> -->
              
                                <h5>3. What should I expect during my first visit to a neurosurgeon?</h5>
              
                                <div class="accordion-icon"></div>
                              </div>
              
                              <div class="accordion-content">
                                <p>
                                  Trauma to the brain and spine, blocked arteries, birth defects, aneurysms, chronic low back pain, brain and spinal tumors, and peripheral nerve issues are all treated by neurosurgeons.
                                </p>
                              </div>
                            </div>
                          </div>
              
                          <div class="col-lg-12">
                            <div class="accordion-one">
                              <div class="accordion">
                                <!-- <div class="btn-img">
                                  <img src="{{ URL::to('public/assets/web/aboutimage/line.png')}}" alt="btn-img" />
                                </div> -->
              
                                <h5>4. What makes ROY NEURO the best neurosurgeon center in Ranchi?</h5>
              
                                <div class="accordion-icon"></div>
                              </div>
              
                              <div class="accordion-content">
                                <p>
                                  Trauma to the brain and spine, blocked arteries, birth defects, aneurysms, chronic low back pain, brain and spinal tumors, and peripheral nerve issues are all treated by neurosurgeons.
                                </p>
                              </div>
                            </div>
                          </div>
              
                        </div>
                      </div>
                </div> 
            </div>
        </div>
        <div class="faq-main-img"><img src="{{ URL::to('public/assets/web/facilitieimage/faq-frame.png')}}" alt=""></div>
    </div>
  </section> 



@endsection


    
@section('js')

<script src="{{ URL::to('public/assets/web/js/faq.js')}}"></script>

@endsection