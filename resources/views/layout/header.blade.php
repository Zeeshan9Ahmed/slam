<header class="headerbar">
			<a href="#!" class="toggleBtn"><i class="fa-solid fa-bars"></i></a>
			<h1 class="headingMain moveCenter">Venue Dashboard</h1>
			<a href="{{url('admin/settings')}}" class="profileDDown d-flex align-items-center" id="editProfile">
				<div class="nameMain">
					<p>{{auth()->user()->full_name??""}}</p> 
					<span>Venue</span>
				</div>
				<p class="profileImg1 xy-center">
					<img src="{{auth()->user()->avatar??asset('assets/images/avatar.png')}}" alt="img">
				</p>
			</a>
</header>