@extends('web-layout.main')
@section('content')
    
<section class="inn-banner">
  <img src="{{ asset('images/inr-banner.png') }}" alt="">
   <div class="container">
     <div class="inn-slide-cap">
       <h2>About Us</h2>
     </div>
   </div>
</section>

<section class="abt-param">
  <div class="container">
    <div class="row row-middle">
      <div class="col-md-6">
       <div class="abt-param-blk"> 
        <span class="small-txt-blu">WELCOME</span>
        <h3>About Paramount Worldwide Properties</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. We are dedicated to redefining the standards of luxury living through expert property management.</p>
        <div class="flx-btn">
          <a href="{{ route('properties') }}" class="bg-fill">Browse Properties</a>
          <a href="{{ route('contact') }}" class="bg-dash">Contact Us</a>
        </div>
       </div>
      </div>
      <div class="col-md-6">
        <div class="abt-param-img">
          <img src="{{ asset('images/worldwide-img.png') }}" alt="">
        </div>
      </div>
    </div>
  </div>
</section>


<section class="abt-param weare-sec">
  <div class="container">
    <div class="row row-middle">
      <div class="col-md-6">
        <div class="abt-param-img">
          <img src="{{ asset('images/who-img.png') }}" alt="">
        </div>
      </div>
      <div class="col-md-6">
       <div class="abt-param-blk"> 
        <span class="small-txt-blu">ABOUT US</span>
        <h3>Who We Are</h3>
        <p>Paramount Worldwide Properties is a leader in global real estate management, specializing in the high-end residential sector. We bridge the gap between discerning property owners and premium living experiences through our innovative management strategies.</p>
        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here’.</p>
         <ul>
           <li><i class="fa fa-check-circle" aria-hidden="true"></i>Tailored management for luxury assets</li>
           <li><i class="fa fa-check-circle" aria-hidden="true"></i>Transparent financial reporting</li>
           <li><i class="fa fa-check-circle" aria-hidden="true"></i>24/7 dedicated concierge service</li>
         </ul>
       </div>
      </div>
    </div>
  </div>
</section>

<section class="msion-vsion">
  <div class="container">
    <div class="row">
      
      <div class="col-md-6">
        <div class="msion-blk">
          <span><img src="{{ asset('images/mission-icon.png') }}" alt=""></span>
          <h3>Our Mission</h3>
          <p>To empower property owners by providing seamless, world-class management services that maximize asset value while ensuring an unparalleled living experience for tenants through innovation and dedication.</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="msion-blk">
          <span><img src="{{ asset('images/vision-icon.png') }}" alt=""></span>
          <h3>Our Vision</h3>
          <p>To become the global benchmark for excellence in real estate management, recognized for our commitment to luxury, integrity, and the continuous advancement of the residential landscape.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="counter-sec">
  <div class="container">
    <div class="row">
      
      <div class="col-md-3">
        <div class="counter-blk">
          <img src="{{ asset('images/counter-icon1.png') }}" alt="">
          <h3><span>82</span>%</h3>
          <p>Cases solved</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="counter-blk">
          <img src="{{ asset('images/counter-icon2.png') }}" alt="">
          <h3><span>54</span>%</h3>
          <p>Costs saved</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="counter-blk">
          <img src="{{ asset('images/counter-icon3.png') }}" alt="">
          <h3><span>28</span>%</h3>
          <p>Monthly profit</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="counter-blk">
          <img src="{{ asset('images/counter-icon4.png') }}" alt="">
          <h3><span>98</span>%</h3>
          <p>Happy clients</p>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="values-sec">
  <div class="container">
    <div class="prop-title">
      <span class="small-txt-blu">VALUES</span>
      <h3 class="h3-title">The Principles That Drive Us</h3>
    </div>
    <div class="row">
      
      <div class="col-md-4">
        <div class="msion-blk">
          <span><img src="{{ asset('images/principle-icon4.png') }}" alt=""></span>
          <h3>Tenant Satisfaction</h3>
          <p>We prioritize the comfort and happiness of every resident to ensure long-term stability.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="msion-blk">
          <span><img src="{{ asset('images/principle-icon5.png') }}" alt=""></span>
          <h3>Reliable Service</h3>
          <p>Dependability is our cornerstone, with responsive support available around the clock.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="msion-blk">
          <span><img src="{{ asset('images/principle-icon6.png') }}" alt=""></span>
          <h3>Relationships</h3>
          <p>We build lasting partnerships based on mutual respect and shared long-term goals.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="msion-blk">
          <span><img src="{{ asset('images/principle-icon1.png') }}" alt=""></span>
          <h3>Integrity</h3>
          <p>We conduct all business with unwavering ethics and complete transparency in every transaction.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="msion-blk">
          <span><img src="{{ asset('images/principle-icon2.png') }}" alt=""></span>
          <h3>Transparency</h3>
          <p>Open communication and real-time reporting ensure our clients are always informed about their assets.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="msion-blk">
          <span><img src="{{ asset('images/principle-icon3.png') }}" alt=""></span>
          <h3>Professionalism</h3>
          <p>Our team embodies the highest standards of corporate conduct and industry expertise.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="clientsay-sec">
  <div class="container">
    <div class="prop-title">
      <span class="small-txt-blu">VALUES</span>
      <h3 class="h3-title">The Principles That Drive Us</h3>
    </div>
    <div class="row">
      
     <div class="col-md-6">
       <div class="clientsay-blk">
         <p>“Paramount Worldwide has transformed how I view property investment. Their management is invisible yet omnipresent—everything works perfectly, and my yields have never been higher.”</p>
         <div class="client-blk-inn">
           <img src="{{ asset('images/review-img1.png') }}" alt="">
           <div class="client-blk-tle">
             <h5>James W. Harrison</h5>
             <h6>Portfolio Owner</h6>
           </div>
         </div>
       </div>
     </div>
     <div class="col-md-6">
       <div class="clientsay-blk">
         <p>“As a tenant, I’ve never felt more valued. The response time is incredible, and the quality of the maintenance is beyond what I’ve experienced anywhere else in the city.”</p>
         <div class="client-blk-inn">
           <img src="{{ asset('images/review-img2.png') }}" alt="">
           <div class="client-blk-tle">
             <h5>Sophie Laurent</h5>
             <h6>Executive Resident</h6>
           </div>
         </div>
       </div>
     </div>

    </div>
  </div>
</section>

@endsection
