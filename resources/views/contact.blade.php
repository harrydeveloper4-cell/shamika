@extends('web-layout.main')
@section('content')
    
<section class="inn-banner">
  <img src="{{ asset('images/inr-banner.png') }}" alt="">
   <div class="container">
     <div class="inn-slide-cap">
       <h2>Contact Us</h2>
     </div>
   </div>
</section>

<section class="abt-param">
  <div class="container">
    <div class="row row-middle">
      <div class="col-md-6">
       <div class="abt-param-blk"> 
        <span class="small-txt-blu">GET IN TOUCH</span>
        <h3>We’re Here to Help You Find Your Next Home</h3>
        <p>Whether you are looking for property management solutions or searching for your dream luxury residence, our expert team is ready to assist you in every step.</p>
        <div class="flx-btn">
          <a href="#contact-form" class="bg-fill">Book a Consultation</a>
        </div>
       </div>
      </div>
      <div class="col-md-6">
        <div class="abt-param-img">
          <img src="{{ asset('images/next-img.png') }}" alt="">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact Info Cards Section -->
<section class="contact-cards-sec py-5">
  <div class="container">
    <div class="row">
      <!-- Visit Us Card -->
      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
        <div class="contact-info-card text-center">
          <div class="icon-circle mb-3">
            <i class="fa-solid fa-location-dot"></i>
          </div>
          <h4 class="card-title">Visit Us</h4>
          <p class="card-text mb-0">{{ $config['address'] }}</p>
        </div>
      </div>

      <!-- Call Us Card -->
      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
        <div class="contact-info-card text-center">
          <div class="icon-circle mb-3">
            <i class="fa-solid fa-phone"></i>
          </div>
          <h4 class="card-title">Call Us</h4>
          <p class="card-text mb-0">+{{ $config['phone'] }}<br>Mon – Fri, 9:00 – 18:00</p>
        </div>
      </div>

      <!-- Email Us Card -->
      <div class="col-lg-4 col-md-6 mx-auto">
        <div class="contact-info-card text-center">
          <div class="icon-circle mb-3">
            <i class="fa-solid fa-envelope"></i>
          </div>
          <h4 class="card-title">Email Us</h4>
          <p class="card-text mb-0">{{ $config['email'] }}<br>{{ $config['email_2'] }}</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Get In Touch & Form Section -->
<section class="get-in-touch-sec py-5">
  <div class="container">
    <div class="row align-items-center">
      <!-- Left Content & Stats -->
      <div class="col-lg-6 mb-5 mb-lg-0 pr-lg-5">
        <span class="subheading-badge">GET IN TOUCH</span>
        <h2 class="main-heading mt-2 mb-3">
          Our Team Will Respond To Your Inquiry Within 24 Hours
        </h2>
        <p class="desc-text mb-4">
          Fill out the form below and one of our dedicated property consultants will get in touch with you to discuss your specific requirements. We specialize in tailoring our services to your unique luxury real estate needs.
        </p>

        <!-- Stat 1 -->
        <div class="d-flex align-items-center mb-4">
          <div class="stat-number mr-3">82%</div>
          <div>
            <h6 class="stat-title mb-1">Cases Solved</h6>
            <p class="stat-sub mb-0">Consistent success in high-value negotiation.</p>
          </div>
        </div>

        <!-- Stat 2 -->
        <div class="d-flex align-items-center">
          <div class="stat-number mr-3">98%</div>
          <div>
            <h6 class="stat-title mb-1">Happy Clients</h6>
            <p class="stat-sub mb-0">Top-tier satisfaction from international investors.</p>
          </div>
        </div>
      </div>

      <!-- Right Form Box -->
      <div class="col-lg-6">
        <div class="contact-form-box" id="contact-form">
          <form action="{{ route('submit_inquiry') }}" method="post">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="form-label-custom">FULL NAME</label>
                <input type="text" class="form-control form-control-custom" placeholder="Full Name" name="name">
              </div>
              <div class="form-group col-md-6">
                <label class="form-label-custom">EMAIL ADDRESS</label>
                <input type="email" class="form-control form-control-custom" placeholder="Email Address" name="email">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="form-label-custom">PHONE NUMBER</label>
                <input type="tel" class="form-control form-control-custom" placeholder="Phone" name="phone">
              </div>
              <div class="form-group col-md-6">
                <label class="form-label-custom">SUBJECT</label>
                <input type="text" class="form-control form-control-custom" placeholder="Subject" name="subject">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label-custom">YOUR MESSAGE</label>
              <textarea class="form-control form-control-custom" rows="5" placeholder="How Can We Help You?" name="message"></textarea>
            </div>

            <button type="submit" class="btn btn-submit-custom btn-block py-3 mt-2">Send Message</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Our Flagship Office Section -->
<section class="flagship-sec py-5">
  <div class="container">
    <div class="flagship-card">
      <div class="row no-gutters align-items-center">
        <!-- Text Content -->
        <div class="col-lg-6 p-4 p-md-5">
          <span class="subheading-badge">OUR HQ</span>
          <h2 class="main-heading mt-2 mb-3">Our Flagship Office</h2>
          <p class="desc-text mb-4">
            Located in the heart of Chelsea, our headquarters is designed to provide a serene and professional environment for our international clientele.
          </p>

          <ul class="list-unstyled feature-checklist mb-4">
            <li class="mb-2">
              <i class="fa-solid fa-circle-check mr-2"></i> Complimentary valet parking available
            </li>
            <li class="mb-2">
              <i class="fa-solid fa-circle-check mr-2"></i> Private meeting suites for confidential discussions
            </li>
            <li class="mb-2">
              <i class="fa-solid fa-circle-check mr-2"></i> Multi-lingual support staff on-site
            </li>
          </ul>

          <a href="https://maps.google.com" target="_blank" class="map-link">
            Get Directions on Google Maps <i class="fa-solid fa-arrow-right ml-1"></i>
          </a>
        </div>

        <!-- Image -->
        <div class="col-lg-6">
          <div class="flagship-img-wrap">
            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=1000" alt="Flagship Office">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Frequently Asked Questions (Accordion) -->
<section class="faq-sec py-5">
  <div class="container">
    <div class="text-center mb-5">
      <span class="subheading-badge">FAQS</span>
      <h2 class="main-heading mt-2">Frequently Asked Questions</h2>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="accordion" id="faqAccordion">

        @foreach($faqs as $faq)
          <div class="faq-item mb-3">
            <div class="faq-header" id="heading{{$faq->id}}">
              <button class="btn btn-faq d-flex justify-content-between align-items-center w-100" type="button" data-toggle="collapse" data-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                <span>{{$faq->question}}</span>
                <span class="faq-icon"><i class="fa-solid fa-plus"></i></span>
              </button>
            </div>
            <div id="collapse{{$faq->id}}" class="collapse" aria-labelledby="heading{{$faq->id}}" data-parent="#faqAccordion">
              <div class="faq-body">
                {{$faq->answer}}
              </div>
            </div>
          </div>
        @endforeach
         
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

