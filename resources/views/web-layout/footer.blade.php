<footer>
 <div class="container">
   <div class="row">
   	
   	<div class="col-md-5">
   	  <div class="ftr-logo">
   	  	<img src="{{ asset($config['footer_logo']) }}" alt="">
   	  </div>		
   	</div>
   	<div class="col-md-3">
     <div class="footer-links">
     	<h5>Used For Link</h5>
     	<ul>
     	  <li><a href="{{ route('index') }}">Home</a></li>	
     	  <li><a href="{{ route('about') }}">About Us</a></li>
     	  <li><a href="{{ route('properties') }}">Properties</a></li>
     	  <li><a href="{{ route('contact') }}">Contact Us</a></li>
     	</ul>
     </div>
   	</div>
   	<div class="col-md-4">
   	  <div class="footer-email">
     	<h5>Used For Link</h5>
     	<ul>
     	  <li><i class="fa fa-envelope" aria-hidden="true"></i>Email:<a href="mailto:{{ $config['emai_link'] }}">{{ $config['emai_link'] }}</a></li>	
     	</ul>
     </div>
   	</div>

   </div>
   <div class="copyrit">
   	 <p>Copyright 2026 | All Rights Reserved. Paramount Worldwide Properties</p>
   </div>
 </div>
</footer>
