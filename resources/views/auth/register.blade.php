@extends('web-layout.main')
@section('content')
    
<section class="auth-wrapper py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8 col-sm-11">
        <div class="auth-card">
          <div class="text-center mb-4">
            <h3 class="auth-title">Create an Account</h3>
            <p class="auth-subtitle">Join us to find and manage your luxury home</p>
          </div>

          <form method="POST" action="{{ route('register') }}">
            @csrf
            <!-- Full Name -->
            <div class="form-group mb-3">
              <label class="form-label-custom">FULL NAME</label>
              <div class="input-group auth-input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                </div>
                <input type="text" class="form-control" name="name" placeholder="John Doe" required>
              </div>
            </div>

            <div class="form-row">
              <!-- Email -->
              <div class="form-group col-md-6 mb-3">
                <label class="form-label-custom">EMAIL ADDRESS</label>
                <div class="input-group auth-input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                  </div>
                  <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
                </div>
              </div>
              <!-- Phone -->
              <div class="form-group col-md-6 mb-3">
                <label class="form-label-custom">PHONE NUMBER</label>
                <div class="input-group auth-input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                  </div>
                  <input type="tel" class="form-control" name="phone" placeholder="+1 234 567 890" required>
                </div>
              </div>
            </div>

            <div class="form-row">
              <!-- Password -->
              <div class="form-group col-md-6 mb-3">
                <label class="form-label-custom">PASSWORD</label>
                <div class="input-group auth-input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                  </div>
                  <input type="password" class="form-control" name="password" placeholder="••••••••" required>
                </div>
              </div>
              <!-- Confirm Password -->
              <div class="form-group col-md-6 mb-3">
                <label class="form-label-custom">CONFIRM PASSWORD</label>
                <div class="input-group auth-input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa-solid fa-shield-halved"></i></span>
                  </div>
                  <input type="password" class="form-control" name="password_confirmation" placeholder="••••••••" required>
                </div>
              </div>
            </div>

            <!-- Account Type Selection Cards -->
            <div class="form-group mb-4">
              <label class="form-label-custom d-block mb-2">Create Account AS</label>
              <div class="row g-3">
                <div class="col-6">
                  <input type="radio" class="btn-check d-none" name="role" id="renter" value="renter" checked required>
                  <label class="role-card w-100 p-3 text-center border rounded cursor-pointer" for="renter">
                    <i class="fa-solid fa-user-tag d-block mb-1 fs-5 text-primary"></i>
                    <span class="fw-bold d-block text-dark small">Renter</span>
                  </label>
                </div>
                <div class="col-6">
                  <input type="radio" class="btn-check d-none" name="role" id="vendor" value="vendor" required>
                  <label class="role-card w-100 p-3 text-center border rounded cursor-pointer" for="vendor">
                    <i class="fa-solid fa-store d-block mb-1 fs-5 text-primary"></i>
                    <span class="fw-bold d-block text-dark small">Vendor</span>
                  </label>
                </div>
              </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-auth btn-block">Create Account</button>
          </form>

          <div class="text-center mt-4">
            <span class="small text-muted">Already have an account?</span>
            <a href="{{ route('login') }}" class="auth-link small font-weight-bold ml-1">Sign In</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@section('styles')
<style>
  .role-card {
    transition: all 0.2s ease-in-out;
    border-color: #e2e8f0 !important;
    background-color: #f8fafc;
  }
  .role-card:hover {
    border-color: #0284c7 !important;
    background-color: #f0f9ff;
  }
  input[type="radio"]:checked + .role-card {
    border-color: #0284c7 !important;
    background-color: #e0f2fe;
    box-shadow: 0 0 0 1px #0284c7;
  }
</style>
@endsection