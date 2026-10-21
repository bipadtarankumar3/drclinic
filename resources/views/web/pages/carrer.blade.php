@extends('web.layouts.main')


@section('style')

<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/carrer/carrer-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/carrer/carrer-responsive.css')}}">
    
@endsection

    
@section('banner')

<div class="banner-2">
    <div class="banner-2-img">
        <img src="{{ URL::to('public/assets/web/facilitieimage/carrer-Banner.png')}}" alt="">
    </div>
    <div class="ban-2-text">
        <h1>Career</h1>
    </div>
    </div>

@endsection

@section('content')


<section>
    <div class="apply">
        <div class="container">
            <div class="apply-con">
                <div class="head">
                    <h1>Roy Neuro Center</h1>
                    <p>ROY NEURO CENTER is committed to providing efficient, effective and timely healthcare to its patients through the best medical support in a clean and hygienic environment.We value team spirit and believe in true and effective teamwork. We respect our colleagues and work round the clock and in seamless coordination with each other. We believe in free flow of communication between the staff and management, across the board. <br>
                      At Roy Neuro , the right person, on the right job, at the right time is the key to organisational and personal success.
                      
                    </p>
                </div>
                <div class="apply-bot">
                    <h1>Apply Now</h1>
                    <form action="page.php" method="post">
                        <div class="apply-area">
                            <div class="apply-div">
                                <label for="Name">Name *</label><br>
                                <input type="text" placeholder="Your name">
                            </div>
                            <div class="apply-div">
                                <label for="Email">Email *</label><br>
                                <input type="Email" placeholder="Email">
                            </div>
                            <div class="apply-div">
                                <label for="Phone No.">Phone No. *</label><br>
                                <input type="number" placeholder="Phone No.">
                            </div>
                            <div class="apply-div apply-div-2">
                                <label for="myfile">Attach Resume *</label><br>
                                <input type="file" id="myfile" name="myfile">
                            </div>
                            <div class="apply-div apply-div-2">
                                <label for="Job Title">Job Title *</label><br>
                                <input type="text" placeholder=" Enter your job title">
                            </div>
                           
                            <div class="apply-div apply-div-3">
                            <label for="Job Title">Message *</label><br>
                                <textarea placeholder="Message"></textarea>
                            </div>
                            <button type="submit"><div class="rid-b"><a class="r-but" href="#">SUBMIT</a></div></button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
  </section>
  
  
  


@endsection



    
@section('js')


@endsection