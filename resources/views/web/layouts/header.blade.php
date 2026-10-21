
      <header>
      
      <div class="desk-nav">
        <div class="desk-main">
          <div class="desk-img">
            <a href="https://royneurocare.com/"><img src="{{ URL::to('public/assets/web/homeimage/logo.png')}}" alt=""></a>
          </div>
          {{-- <div class="desk-text">
           <div class="desk-ar"><a href="{{ URL::to('/')}}"><p>Home</p></a></div>
           <div class="desk-ar"><a href="{{ URL::to('about')}}"><p>About Us</p></a></div>
           <div class="desk-ar">
            <li class="dropdown dropdown-1">
              our Treatment <i class="fa-solid fa-caret-down chev"></i>
              <ul class="dropdown_menu dropdown_menu-1">
                <li class="dropdown_item-1"><a href="{{ URL::to('paralysis_stroke')}}">Paralysis/Stroke</a></li>
                <li class="dropdown_item-2"><a href="{{ URL::to('migraine')}}">Headache / Migraine</a></li>
                <li class="dropdown_item-3"><a href="{{ URL::to('fits_treatment')}}">Fits Treatment</a></li>
                  <li class="dropdown_item-4"><a href="{{ URL::to('parkinson_disease')}}">Parkinson’s disease Treatment</a></li>
                  <li class="dropdown_item-5"><a href="{{ URL::to('neck_back_pain')}}">Neck pain & back pain</a></li>
                  <li class="dropdown_item-5"><a href="{{ URL::to('brain_fever')}}">Brain Fever Treatment</a></li>
                  <li class="dropdown_item-5"><a href="{{ URL::to('dizziness_vertigo')}}">Dizziness / Vertigo</a></li>
                  <li class="dropdown_item-5"><a href="{{ URL::to('muscle_disorders')}}">Muscle Disorders</a></li>
                  <li class="dropdown_item-5"><a href="{{ URL::to('memory')}}">Memory Loss / Dementia </a></li>
                  <li class="dropdown_item-5"><a href="{{ URL::to('pediatric ')}}">Pediatric Neurology</a></li>
              </ul>
            </li>
           </div>
           <div class="desk-ar"><a href="{{ URL::to('facilities')}}"><p>Facilities</p></a></div>
           <div class="desk-ar"><a href="{{ URL::to('testimonials')}}"><p>Testimonials</p></a></div>
           <div class="desk-ar">
            <li class="dropdown dropdown-1">
              Gallery<i class="fa-solid fa-caret-down chev"></i>
              <ul class="dropdown_menu dropdown_menu-1 dropdown_menu-2">
                <li class="dropdown_item-1"><a href="{{ URL::to('gallery')}}">Our Gallery</a></li>
                <li class="dropdown_item-2"><a href="{{ URL::to('faq')}}">Faq</a></li>
                <li class="dropdown_item-3"><a href="{{ URL::to('carrer')}}">Career</a></li>
              </ul>
            </li>
           </div>
           <div class="desk-ar"><a href="{{ URL::to('contact')}}"><p>Contact Us</p></a></div>
          </div> --}}
          <div class="desk-appointment">
             <div class="book-an"><a href="https://royneurocare.com/" class="bo-btn">Back</a></div>
          </div>
        </div>
      </div>
      
      
      
      <header class="header" id="header">
        <section class="wrapper container">
           <a href="{{ URL::to('/')}}" class="brand"><img src="{{ URL::to('public/assets/web/homeimage/Logo.png')}}" alt=""></a>
           <div class="book-an"><a href="https://royneurocare.com/" class="bo-btn">Back</a></div>
           <div class="burger" id="burger">
              <span class="burger-line"></span>
              <span class="burger-line"></span>
              <span class="burger-line"></span>
           </div>
           
           <span class="overlay">
            <div class="cross"><i class="fa-solid fa-xmark cross-icon"></i></div>
           </span>
           {{-- <nav class="navbar" id="navbar">
              <ul class="menu" id="menu">
                 <li class="menu-item"><a href="{{ URL::to('/')}}" class="menu-link">HOME</a></li>
                 <li class="menu-item"><a href="{{ URL::to('about')}}" class="menu-link">ABOUT US</a></li>
                 <li class="menu-item menu-dropdown">
                    <span class="menu-link" data-toggle="submenu">OUR TREATMENT<i class="fa-solid fa-chevron-down"></i></span>
                    <ul class="submenu">
                       <li class="submenu-item"><a href="{{ URL::to('paralysis_stroke')}}" class="submenu-link">Paralysis/Stroke</a></li>
                       <li class="submenu-item"><a href="{{ URL::to('migraine')}}" class="submenu-link">Headache / Migraine</a></li>
                       <li class="submenu-item"><a href="{{ URL::to('fits_treatment')}}" class="submenu-link">Fits Treatment</a></li>
                       <li class="submenu-item"><a href="{{ URL::to('parkinson_disease')}}" class="submenu-link">Parkinson’s disease Treatment</a></li>
                       <li class="submenu-item"><a href="{{ URL::to('neck_back_pain')}}" class="submenu-link">Neck pain & back pain</a></li>
                       <li class="submenu-item"><a href="{{ URL::to('brain_fever')}}" class="submenu-link">Brain Fever Treatment</a></li>
                       <li class="submenu-item"><a href="{{ URL::to('dizziness_vertigo')}}" class="submenu-link">Dizziness / Vertigo</a></li>
                       <li class="submenu-item"><a href="{{ URL::to('muscle_disorders')}}" class="submenu-link">Muscle Disorders</a></li>
                       <li class="submenu-item"><a href="{{ URL::to('memory')}}" class="submenu-link">Memory Loss / Dementia </a></li>
                       <li class="submenu-item"><a href="{{ URL::to('pediatric ')}}" class="submenu-link">Pediatric Neurology</a></li>
                    </ul>
                 </li>
      
                 <li class="menu-item"><a href="{{ URL::to('facilities')}}" class="menu-link">FACILITIES</a></li>
                 <li class="menu-item"><a href="{{ URL::to('testimonials')}}" class="menu-link">TESTIMONIALS</a></li>
      
                 <li class="menu-item menu-dropdown">
                    <span class="menu-link" data-toggle="submenu">GALLERY<i class="fa-solid fa-chevron-down"></i></span>
                    <ul class="submenu">
                       <li class="submenu-item"><a href="{{ URL::to('gallery')}}" class="submenu-link">Our Gallery</a></li>
                       <li class="submenu-item"><a href="{{ URL::to('faq')}}" class="submenu-link">Faq</a></li>
                       <li class="submenu-item"><a href="{{ URL::to('carrer')}}" class="submenu-link">Career</a></li>
                    </ul>
                 </li>
                 
                 <li class="menu-item"><a href="{{ URL::to('contact')}}" class="menu-link">CONTACT US</a></li>
                 
              </ul>
      
           </nav> --}}
        </section>
      </header>
      
      
      
      
      
      
      
      </header>
      