<!-- Header Start -->
<header>
  <div class="container">
     <nav class="navbar navbar-expand-lg navbar-light">
  <a class="navbar-brand" href="{{ route('index') }}"><img src="{{ asset($config['logo']) }}" alt=""></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('index') }}">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('about') }}">About Us</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('properties') }}">Properties</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
      </li>
    </ul>
    <div class="form-inline hdr-btn my-2 my-lg-0">
       <a href="{{ route('login') }}">My Account</a>
    </div>
  </div>
</nav> 
  </div>   
</header>
<!-- Header End -->