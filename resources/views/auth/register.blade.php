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

            <!-- Terms agreement checkbox -->
            <div class="custom-control custom-checkbox mb-4">
              <input type="checkbox" class="custom-control-input" id="termsCondition" required>
              <label class="custom-control-label small text-muted" for="termsCondition">
                I agree to the <a href="#" class="auth-link">Terms & Conditions</a> and <a href="#" class="auth-link">Privacy Policy</a>
              </label>
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