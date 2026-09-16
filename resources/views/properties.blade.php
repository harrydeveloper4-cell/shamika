@extends('web-layout.main')
@section('content')
    
<section class="inn-banner">
  <img src="{{ asset('images/inr-banner.png') }}" alt="">
   <div class="container">
     <div class="inn-slide-cap">
       <h2>Find Your Next Home, Managed With Perfection</h2>
       <p>Explore our curated collection of luxury properties. From modern urban lofts to sprawling suburban estates, find the perfect space tailored to your lifestyle.</p>
     </div>
   </div>
</section>


<!-- Property List Section -->
  <section class="property-list py-5">
  <div class="container">
    <h2 class="text-center font-weight-bold mb-5">Check Out Our Properties</h2>
    
    <div class="row">
      @foreach($properties as $property)
      
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="property-card">
          <!-- Image Area -->
          <div class="img-wrapper">
            <img src="{{ asset($property->main_image) }}" alt="{{ $property->title }}">
            <span class="badge-rent">{{ ucfirst($property->purpose) }}</span>
            <span class="badge-price">${{ $property->price }} <span>/{{ $property->purpose=='rent'?'mo':'Price' }}</span></span>
          </div>

          <!-- Content Area -->
          <div class="p-3">
            <div class="location-text mb-1">
              <i class="fa-solid fa-location-dot"></i>{{ $property->address }}
            </div>
            <h5 class="property-title mb-2">{{ $property->title }}</h5>
            <p class="text-muted small mb-3">
              {{ $property->description }}
            </p>

            <!-- Feature specs -->
            <div class="features-row d-flex justify-content-between align-items-center mb-3">
              <span><i class="fa-solid fa-house"></i> {{ $property->bedrooms }} Beds</span>
              <span><i class="fa-solid fa-bath"></i> {{ $property->bathrooms }} Baths</span>
              <span><i class="fa-solid fa-vector-square"></i> {{ $property->area }} sqft</span>
              <span><i class="fa-solid fa-car"></i> {{ $property->parking }} parking spaces</span>
            </div>

            <!-- Buttons -->
            <div class="row">
              <div class="col-6 pr-1">
                <a href="{{ route('property.show', $property) }}"  class="bg-fill">View Details</a>
              </div>  
              <div class="col-6 pl-1">
                <button type="button" 
                        class="bg-dash btn-block apply-now-btn" 
                        data-toggle="modal" 
                        data-target="#applyNowModal" 
                        data-property-id="{{ $property->id }}" 
                        data-property-title="{{ $property->title }}">
                    Apply Now
                </button>
            </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Apply Now Modal -->
<div class="modal fade" id="applyNowModal" tabindex="-1" role="dialog" aria-labelledby="applyNowModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="applyNowModalLabel">Apply for Viewing</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      @auth
        <form id="applyViewingForm" action="{{ route('renter.apply-viewing') }}" method="POST">
          @csrf
          <input type="hidden" name="property_id" id="modal_property_id">
          
          <div class="modal-body">
            <div class="form-group mb-3">
              <label class="font-weight-bold">Property</label>
              <input type="text" id="modal_property_title" class="form-control" readonly>
            </div>

            <div class="form-group mb-3">
              <label class="font-weight-bold">Booking Date *</label>
              <input type="date" name="preferred_date" class="form-control" min="{{ date('Y-m-d') }}" required>
            </div>

            <!-- <div class="form-group mb-3">
              <label class="font-weight-bold">Preferred Time Slot *</label>
              <select name="preferred_time" class="form-control" required>
                <option value="10:00 AM - 12:00 PM">10:00 AM - 12:00 PM</option>
                <option value="02:00 PM - 04:00 PM">02:00 PM - 04:00 PM</option>
                <option value="04:00 PM - 06:00 PM">04:00 PM - 06:00 PM</option>
              </select>
            </div> -->

            <div class="form-group mb-3">
              <label class="font-weight-bold">Message / Notes (Optional)</label>
              <textarea name="notes" class="form-control" rows="3" placeholder="Any special instructions..."></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Submit Application</button>
          </div>
        </form>
      @else
        <!-- Guest User Notice -->
        <div class="modal-body text-center py-4">
          <i class="fa-solid fa-lock fa-3x text-warning mb-3"></i>
          <h4>Authentication Required</h4>
          <p class="text-muted">Please log in to your renter account to apply for property viewings[cite: 5].</p>
          <a href="{{ route('login') }}" class="btn btn-primary mr-2">Login</a>
          <a href="{{ route('register') }}" class="btn btn-outline-secondary">Register</a>
        </div>
      @endauth
    </div>
  </div>
</div>

@endsection
@section('scripts')
<script>
  $(document).ready(function() {
      $('.apply-now-btn').on('click', function() {
          var propertyId = $(this).data('property-id');
          var propertyTitle = $(this).data('property-title');
          
          $('#modal_property_id').val(propertyId);
          $('#modal_property_title').val(propertyTitle);
      });
  });
</script>
@endsection

