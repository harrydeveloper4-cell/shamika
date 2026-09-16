@extends('web-layout.main')
@section('content')
    
<section class="auth-wrapper py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-7 col-sm-10">
        <div class="auth-card">
          <div class="text-center mb-4">
            <h3 class="auth-title">Welcome Back</h3>
            <p class="auth-subtitle">Log in to manage your properties & viewings</p>
          </div>

          <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email Input -->
            <div class="form-group mb-3">
              <label class="form-label-custom">EMAIL ADDRESS</label>
              <div class="input-group auth-input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                </div>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
              </div>
            </div>

            <!-- Password Input -->
            <div class="form-group mb-3">
              <label class="form-label-custom">PASSWORD</label>
              <div class="input-group auth-input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                </div>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
              </div>
            </div>

            <!-- Remember & Forgot -->
            <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="remember_me">
                <label class="custom-control-label small text-muted" for="rememberMe">Remember me</label>
              </div>
              <a href="{{ route('password.request') }}" class="auth-link small">Forgot Password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-auth btn-block">Sign In</button>
          </form>

          <div class="text-center mt-4">
            <span class="small text-muted">Don't have an account?</span>
            <a href="{{ route('register') }}" class="auth-link small font-weight-bold ml-1">Sign Up</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection