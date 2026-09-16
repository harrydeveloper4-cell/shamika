@extends('web-layout.main')
@section('content')
    
<section class="inn-banner">
  <img src="{{ asset('images/inr-banner.png') }}" alt="">
   <div class="container">
     <div class="inn-slide-cap">
       <h2>Find Your Next Home, Managed With Perfection</h2>
     </div>
   </div>
</section>

<div class="container py-4">

  <!-- Gallery Section -->
  <div class="row mb-4">
    <!-- Big Main Image -->
    <div class="col-md-8 mb-2 mb-md-0">
      <div class="main-img-box" data-toggle="modal" data-target="#galleryLightbox">
        <img src="{{ asset($property->main_image) }}" alt="Main Property Image">
      </div>
    </div>
    <!-- Right 3 Thumbnails -->
    <div class="col-md-4 d-flex flex-column justify-content-between">
        @foreach($property->images as $index => $image)
            <div class="thumb-img-box mb-2 position-relative cursor-pointer" data-toggle="modal" data-target="#galleryLightbox" data-slide-to="{{ $index }}">
                
                <img src="{{ asset($image->image_path) }}" alt="Property Image {{ $index + 1 }}" class="img-fluid rounded">

                @if($loop->last && count($property->images) > 1)
                    <div class="more-images-overlay d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-plus text-white mr-1"></i>
                        <span class="text-white font-weight-bold">View All</span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
  </div>

  <!-- Header & Price Row -->
  <div class="row align-items-center mb-4">
    <div class="col-md-8">
      <span class="text-uppercase font-weight-bold" style="font-size: 0.75rem; color: #38b6ff;">For {{ ucfirst($property->purpose) }}</span>
      <h2 class="font-weight-bold mt-1 mb-1">{{ $property->title }}</h2>
      <p class="text-muted small mb-0"><i class="fa-solid fa-location-dot"></i> {{ $property->address }}</p>
    </div>
    <div class="col-md-4">
      <div class="booking-card ml-md-auto" style="max-width: 320px;">
        <div class="text-muted small text-uppercase font-weight-bold">{{ $property->purpose=='rent'?'Monthly Rent':'Price' }} </div>
        <h3 class="font-weight-bold text-dark mb-3">${{ $property->price }}</h3>
        <button class="btn theme-btn btn-block mb-2 py-2">Book a Viewing</button>
        <button class="btn theme-outline-btn btn-block py-1"><i class="fa-regular fa-bookmark"></i> Save</button>
      </div>
    </div>
  </div>

  <!-- Property Overview Card -->
  <div class="row mb-5">
    <div class="col-12">
      <div class="overview-box">
        <h6 class="font-weight-bold text-uppercase mb-3" style="color: #38b6ff;">
          <i class="fa-solid fa-file-lines"></i> Property Overview
        </h6>
        <p class="text-muted" style="line-height: 1.7; font-size: 0.95rem;">
          {{ $property->description }}
        </p>

        <hr class="my-4" />

        <div class="row text-center text-md-left">
          <div class="col-6 col-md-3 mb-3 mb-md-0">
            <small class="text-uppercase text-muted d-block" style="font-size: 0.7rem;">Bedrooms</small>
            <span class="font-weight-bold"><i class="fa-solid fa-house"></i> {{ $property->bedrooms }} {{ ucfirst($property->bedrooms==1?'bedroom':'bedrooms') }} {{ $property->bathrooms }} {{ ucfirst($property->bathrooms==1?'bathroom':'bathrooms') }}</span>
          </div>
          <div class="col-6 col-md-3 mb-3 mb-md-0">
            <small class="text-uppercase text-muted d-block" style="font-size: 0.7rem;">Bathrooms</small>
            <span class="font-weight-bold"><i class="fa-solid fa-bath"></i> {{ $property->bathrooms }} {{ ucfirst($property->bathrooms==1?'bathroom':'bathrooms') }}</span>
          </div>
          <div class="col-6 col-md-3">
            <small class="text-uppercase text-muted d-block" style="font-size: 0.7rem;">Area</small>
            <span class="font-weight-bold"><i class="fa-solid fa-vector-square"></i> {{ $property->area }}</span>
          </div>
          <div class="col-6 col-md-3">
            <small class="text-uppercase text-muted d-block" style="font-size: 0.7rem;">Parking</small>
            <span class="font-weight-bold"><i class="fa-solid fa-car"></i> {{ $property->parking }} {{ ucfirst($property->parking==1?'space':'spaces') }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Detailed Specs Grid -->
   {{--
  <div class="row mb-5">
    <div class="col-md-6 mb-4">
      <div class="section-spec-title">Bedrooms</div>
      <div class="section-spec-sub">Bedrooms: {{ $property->bedrooms }} &bull; Primary Bedroom Dimensions: 10 X 13</div>  
    </div>
    <div class="col-md-6 mb-4">
      <div class="section-spec-title">Other Rooms</div>
      <div class="section-spec-sub">Total Rooms: 3 &bull; Living Room Dimensions: 13 X 14</div>
    </div>
    <div class="col-md-6 mb-4">
      <div class="section-spec-title">Bathrooms</div>
      <div class="section-spec-sub">Full bathrooms: 1</div>
    </div>
    <div class="col-md-6 mb-4">
      <div class="section-spec-title">Laundry</div>
      <div class="section-spec-sub">Outside Laundry Room, Samsung electric washer and dryer</div>
    </div>
    <div class="col-md-6 mb-4">
      <div class="section-spec-title">Heating And Cooling</div>
      <div class="section-spec-sub">Cooling Features: Central Air<br>Heating Features: Central, Electric</div>
    </div>
    <div class="col-md-6 mb-4">
      <div class="section-spec-title">Exterior And Lot Features</div>
      <div class="section-spec-sub">Storage: Patio &amp; porch: Side porch, Screened, rear open area</div>
    </div>
  </div>
    --}}
</div>

<!-- Bootstrap 4 Lightbox Modal -->
<div class="modal fade" id="galleryLightbox" tabindex="-1" role="dialog" aria-labelledby="galleryLightboxLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content bg-dark border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-white" id="galleryLightboxLabel">Property Gallery</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-3">
                <div id="propertyCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner rounded">
                        @foreach($property->images as $index => $image)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img src="{{ asset($image->image_path) }}" class="d-block w-100" alt="Image {{ $index + 1 }}" style="max-height: 500px; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                    
                    @if(count($property->images) > 1)
                        <a class="carousel-control-prev" href="#propertyCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#propertyCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Initialize the carousel
    $(document).ready(function() {
      $('[data-target="#galleryLightbox"]').on('click', function() {
          var slideTo = $(this).data('slide-to');
          $('#propertyCarousel').carousel(slideTo);
      });
  });
</script>
@endsection