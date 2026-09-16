@extends('web-layout.main')
@section('content')
    
<section class="auth-wrapper py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-7 col-sm-10">
        <div class="auth-card">
          <div class="text-center mb-4">
            <div class="icon-circle mb-3 mx-auto">
              <i class="fa-solid fa-key"></i>
            </div>
            <h3 class="auth-title">Forgot Password?</h3>
            <p class="auth-subtitle">Enter your registered email address and we'll send you instructions to reset your password.</p>
          </div>

          <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <!-- Email Input -->
            <div class="form-group mb-4">
              <label class="form-label-custom">EMAIL ADDRESS</label>
              <div class="input-group auth-input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                </div>
                <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
              </div>
            </div>

            <!-- Reset Button -->
            <button type="submit" class="btn btn- auth btn-block">Send Reset Link</button>
          </form>

          <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="auth-link small font-weight-bold">
              <i class="fa-solid fa-arrow-left mr-1"></i> Back to Login
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection