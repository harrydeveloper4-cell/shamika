@extends('web-layout.main')
@section('content')
    

<section class="banner">
  <div class="container">
    <div class="slide-title">
      <h1>Paramount Worldwide Properties</h1>
    </div>   
    <div class="row row-middle">
       
       <div class="col-md-7">
          <div class="slide-cap">
            <span class="small-txt-blu">Welcome</span>
            <h2>Find Your Next Home, Managed with Perfection</h2>
          </div>
       </div>
       <div class="col-md-5">
          <div class="slide-cap-img">
            <img src="{{ asset('images/hero-img.png') }}" alt="">
          </div>
       </div>

    </div>
  </div>
</section>


<section class="aboutus-sec">
  <div class="container">
     <div class="row">
       
       <div class="col-md-6">
          <div class="about-blk">
            <span class="small-txt-blu">ABOUT US</span>
            <h3 class="h3-title">Redefining Seamless Property Management</h3>
            <div class="about-inn">
            <p><b>Our Mission:</b> Deliver exceptional living experiences through transparent, technology-driven, client-focused management.</p>
            <p><b>Tenant First Approach:</b> Modern resident portals for seamless online rent payments, fast maintenance requests, and instant communication</p>
            <p><b>Zero Stress Leasing:</b> Single point of contact for all resident communication, midnight emergencies, and administrative tasks.</p>
            <p><b>Transparent Pricing:</b>Enjoy clear, flat-rate pricing with zero hidden fees.</p>
            </div>
          </div>
       </div>
       <div class="col-md-6">
         <div class="about-blk-img">
           <img src="{{ asset('images/about-img.png') }}" alt="">
         </div> 
       </div>

     </div>
  </div>
</section>


<section class="property-sec">
  <div class="container">
    <div class="prop-title">
      <span class="small-txt-blu">Properties</span>
      <h3 class="h3-title">Seamless Property Management, Tailored For You</h3>
    </div>
    <div class="row">
      
      <div class="col-md-6">
        <a href="{{ route('properties') }}">
        <div class="pro-blk">
          <div class="prop-flx">
            <img src="{{ asset('images/seam-icon1.png') }}" alt="">
            <h4>Premium Property Listings</h4>
          </div>
          <img src="{{ asset('images/seam-img1.png') }}" alt="">
        </div>
        </a>
      </div>
      <div class="col-md-6">
        <a href="">
        <div class="pro-blk">
          <div class="prop-flx">
            <img src="{{ asset('images/seam-icon2.png') }}" alt="">
            <h4>Seamless Online Payments</h4>
          </div>
          <img src="{{ asset('images/seam-img2.png') }}" alt="">
        </div>
        </a>
      </div>

    </div>
  </div>
</section>


<section class="why-us-sec">
  <div class="container">
    <div class="prop-title">
      <span class="small-txt-blu">WHY CHOOSE US</span>
      <h3 class="h3-title">Why We’re the Right Choice</h3>
    </div>
    <div class="row row-middle">
      
      <div class="col-md-6">
        <div class="why-us-img">
          <img src="{{ asset('images/choose-img1-png.png') }}" alt="">
        </div>
      </div>
      <div class="col-md-6">
        <div class="why-us-blk">
          
          <div class="why-us-inn">
            <span><img src="{{ asset('images/choose-icon1.png') }}" alt=""></span>
            <h4>Experience and Expertise</h4>
          </div>

          <div class="why-us-inn">
            <span><img src="{{ asset('images/choose-icon2.png') }}" alt=""></span>
            <h4>Customized Solutions</h4>
          </div>

          <div class="why-us-inn">
            <span><img src="{{ asset('images/choose-icon3.png') }}" alt=""></span>
            <h4>Trust and Reliability</h4>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>


<section class="tmls-sec">
  <div class="container">
    <div class="prop-title">
      <span class="small-txt-blu"><i class="fa fa-paper-plane" aria-hidden="true"></i>Testimonials</span>
      <h3 class="h3-title">Read What Our Tenants Say About Us</h3>
    </div>
    
    <div class="rev-title">
      <h5>Excellent 18,560+ Reviews</h5>
      <ul>
        @for($i = 0; $i < 5; $i++)
          @if($i < $avg)
          <li><i class="fa fa-star" aria-hidden="true"></i></li>
          @else
          <li class="dark-star"><i class="fa fa-star" aria-hidden="true"></i></li>
          @endif
        @endfor
        <li>{{$avg}}/5</li>
      </ul>
    </div>
    <div class="row">
      @foreach($testimonials as $testimonial)
      <div class="col-md-3">
        <div class="tmls-blk">
          <div class="tmls-prof">
            <span><img src="{{ asset($testimonial->image) }}" alt=""></span>
            <div class="prof-title">
              <h5>{{$testimonial->name}}</h5>
              <ul>
              @for($i = 0; $i < 5; $i++)
                @if($i < $testimonial->rating)
                <li><i class="fa fa-star" aria-hidden="true"></i></li>
                @else
                <li class="dark-star"><i class="fa fa-star" aria-hidden="true"></i></li>
                @endif
              @endfor
              </ul>
            </div>
          </div>
          <p>{{$testimonial->message}}</p>
        </div>
      </div>
      @endforeach

    </div>
  </div>
</section>


<section class="get-in-sec">
  <div class="container">
    <div class="prop-title">
      <span class="small-txt-blu"><i class="fa fa-paper-plane" aria-hidden="true"></i>Get in touch</span>
      <h3 class="h3-title">Our Team Will Respond</h3>
    </div>
    <form action="{{ route('submit_inquiry') }}" method="post">
      @csrf
      <div class="row">
        
        <div class="col-md-6"><input type="text" placeholder="Full Name" name="name"></div>
        <div class="col-md-6"><input type="text" placeholder="Email Address" name="email"></div>

        <div class="col-md-6"><input type="text" placeholder="Phone" name="phone"></div>
        <div class="col-md-6"><input type="text" placeholder="Subject" name="subject"></div>

        <div class="col-md-12 text-center">
          <textarea placeholder="How Can We Help You?" name="message"></textarea>
          <button type="submit">Send Message</button>
        </div>

      </div>
    </form>
  </div>
</section>

@endsection
@section('styles')
<style>

  .dark-star{
    color: #999 !important;
  }

</style>
@endsection


