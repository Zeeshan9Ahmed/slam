<!DOCTYPE html>
<html>
<head>
	<!-- META TAGS-->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="robots" content="noindex" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
	<!-- META TAGS-->
	<title>Calendar App</title>	
	<link rel="icon" href="{{asset('assets/images/favicon.png')}}" />
	<!-- BOOTSTRAP 5 -->	
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
	<!-- BOOTSTRAP 5 -->
	<!-- RESPONSIVE NAVIFATION -->
	<link rel="stylesheet" href="{{asset('assets/css/stellarnav.min.css')}}" />
	<!-- RESPONSIVE NAVIFATION -->
	<!-- SWIPER SLIDER -->
	<link rel="stylesheet" href="{{asset('assets/css/swiper-bundle.min.css')}}">
	<!-- SWIPER SLIDER -->
	<!-- GOOGLE FONTS -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
	<!-- GOOGLE FONTS -->
	<!-- FANCY BOX IMAGE VIEWER -->
	<link rel="stylesheet" href="{{asset('assets/css/jquery.fancybox.min.css')}}" />
	<!-- FANCY BOX IMAGE VIEWER -->
	<!-- FONT AWESOME -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<!-- FONT AWESOME -->
	<!-- DATATABLE SHEETS -->
	<!-- <link rel="stylesheet" href="{{asset('assets/css/dataTable.css')}}"> -->
	<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
	<!-- DATATABLE SHEETS -->
	<!-- STYLE SHEETS -->
	<link rel="stylesheet" href="{{asset('assets/css/datatable1.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}" />

	<link rel="stylesheet" href="{{asset('assets/css/jquery.growl.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/notifIt.css')}}">
	<meta name="X-CSRF-TOKEN" content="{{ csrf_token() }}">

    @yield('additional_styles')
	<!-- STYLE SHEETS -->
</head>
<body>
<section class="gen-sec artist-profile-sec">
	<div class="contianer-fluid p-0">
		<header class="headerbar">
			<a href="#!" class="toggleBtn"><i class="fa-solid fa-bars"></i></a>
			<h1 class="headingMain moveCenter">{{$user->role=="artist"?"Artist":"Guest"}} Profile</h1>
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

		<div class="secRow d-flex">
			
        @include('layout.side-menu')

			<div class="mainContent">
				<div class="artistInfoBox">
					<div class="topInfo pb-3">
					    
						<div class="artistImg">
							<div class="imgBox">
								<img src="{{$user->avatar??asset('assets/images/avatar.png')}}" alt="img">
							</div>
							<div class="textBox">
								<p class="name">{{$user->full_name??""}}</p>
								<p class="mail1">{{$user->email??""}}</p>
							</div>
						</div>

					
						@if($user->role == 'artist')
						<a href="{{url('admin/messages', $user->id)}}" class="genBtn msgBtn" >Messages</a>
						@endif
					</div>
						<div class="followWrap pb-3">
							<div class="followBox text-center bRight pe-2">
								<p class="desc">Followers</p>
								<p class="counts">{{$user->followers_count}}</p>
							</div>
							<div class="followBox text-center ps-2">
								<p class="desc">Following</p>
								<p class="counts">{{$user->following_count}}</p>
							</div>
						</div>
					<div class="row">
						<div class="col-12 pb-4">
							<div class="dataInfo">
								<p class="heading">Bio</p>
								<p class="desc">
									{{$user->bio??"----"}}
								</p>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-12">
							<div class="dataInfo">
								<p class="heading">Skills</p>
								<p class="desc">
									@foreach($user->skills?explode(',',$user->skills):["No Skills Added"] as $skills)
									<span>{{ucfirst($skills)}}</span>
									@endforeach
								</p>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-12">
							<div class="dataInfo">
								<p class="heading">Social</p>
								<div class="desc d-flex align-items-center">
									<div class="me-3">
										<img src="{{asset('assets/images/fb-icon.png')}}" alt="img" class="me-2">
										<span>Facebook</span>
									</div>
									<div>
										<img src="{{asset('assets/images/insta-icon.png')}}" alt="img" class="me-2">
										<span>Instagram</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				@if($user->role == 'artist')
					<div class="songsList">
					<p class="heading mb-3">Portfolio</p>
					<p class="heading subHeading">Audio</p>
					<div class="playlist-ctn mt-4 mb-3"></div>
					
					<p class="heading subHeading">Video</p>
					<div class="playlist-ctn mt-3">

						@foreach($user->video as $video)
						<div class="videoBox xy-center" data-fancybox="gallery" data-src="{{$video->url}}" style="background-image: url({{$video->thumbnail??"https://i1.sndcdn.com/avatars-000228887415-y11o4w-t500x500.jpg"}});">
							<i class="fas fa-play" height="40" width="40" id="p-img-0"></i>
						</div>
						@endforeach
						
					</div>
				</div>
				
					@endif
			</div>

			<div class="audioBox">
				<p class="heading">Sound Tracks Shared</p>
				<div class="audioImg">
					<img src="{{asset('assets/images/player-bg.png')}}" alt="img">

					<div class="actionWtap xy-between">
						<a href="#!" class="actionBtn xy-center" onclick="previous()">
							<!-- <i class="fa-solid fa-backward"></i> -->
							<div id="btn-faws-back">
								<i class='fas fa-step-backward'></i>
							</div>
						</a>
						<a href="#!" class="playAudio xy-center" onclick="toggleAudio()">
							<div id="btn-faws-play-pause">
								<i class='fas fa-play' id="icon-play"></i>
								<i class='fas fa-pause' id="icon-pause" style="display: none"></i>
							</div>
						</a>
						<a href="#!" class="actionBtn xy-center" onclick="next()">
							<div id="btn-faws-next">
								<i class='fas fa-step-forward'></i>
							</div>
						</a>
					</div>
				</div>
				<div class="audioMain">
					<audio class="w-100" id="myAudio" ontimeupdate="onTimeUpdate()">
						<source id="source-audio" src="" type="audio/mpeg">
					</audio>
				</div>
				<div class="player-ctn">
					<div class="infos-ctn">
						<div class="timer">00:00</div>
						<div class="titleAudio"></div>
						<div class="duration">00:00</div>
					</div>
					<div id="myProgress">
						<div id="myBar"></div>
					</div>
				</div>
				<p class="closeAudio xy-center"><i class="fa-solid fa-xmark"></i></p>
			</div>
		</div>
	</div>
</section>

<!-- SUBSCRIPTION MODAL START -->
<div class="modal fade genModal" id="genModal1" tabindex="-1" aria-labelledby="genModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row align-items-center mb-5">
					<div class="col-6">
						<p class="heading">Subscription</p>
						<p class="desc">Monthly Subscriptions / Memberships</p>
					</div>
					<div class="col-6">
						<div class="amount">
							<p class="rate">$30</p>
							<p class="pkgType text-end">Monthy</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<div class="modalSong xy-center">
							<img src="{{asset('assets/images/song-img-1.png')}}" alt="img" class="bgImg">
							<img src="{{asset('assets/images/play-icon1.png')}}" alt="img" class="plyModalBtn">
						</div>
					</div>
					<div class="col-6">
						<div class="modalSong xy-center">
							<img src="assets/images/black.png" alt="img" class="bgImg">
							<img src="{{asset('assets/images/play-icon2.png')}}" alt="img" class="plyModalBtn">
						</div>
					</div>
					<div class="col-12">
						<a href="#!" class="genBtn mt-5 planBtn">Start Plan</a>
					</div>
				</div>	
				<p class="closeBtn xy-center subsCloseBtn" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></p>	
			</div>
		</div>
	</div>
</div>


<!-- BOOTSTRAP 5 -->	
<!-- BOOTSTRAP 5 -->	
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script> 
<!-- BOOTSTRAP 5 -->	
<!-- JQUERY  -->
	
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<!-- JQUERY  -->	
<!-- RESPONSIVE NAVIFATION -->
<script src="{{asset('assets/js/stellarnav.min.js')}}"></script>
<!-- RESPONSIVE NAVIFATION -->
<!-- SWIPER SLIDER -->
<script src="{{asset('assets/js/swiper-bundle.min.js')}}"></script>
<!-- SWIPER SLIDER -->
<!-- FANCY BOX IMAGE VIEWER -->
<script src="{{asset('assets/js/jquery.fancybox.min.js')}}"></script> 
<!-- FANCY BOX IMAGE VIEWER -->
<!-- JAVASCRIPT SHEETS -->
<script src="{{asset('assets/js/Chart2.js')}}"></script>
<script src="{{asset('assets/js/utils.js')}}"></script>
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
        // $(document).ready(function () {
			// console.log(list_audio)
			window.audio_file = <?php echo json_encode($user->audio); ?>;
			console.log(audio_file,'dfdddd')
            
			var msg = $('#mSg').val();
            var color = $('#mSg').attr('color');
            var title = $('#mSg').attr('title');

            if (msg) {
                not(msg, color, title);
            }
        // });

        function not(msg, color, title) 
        {
            notif({
                msg: "<b>" + title + ": </b>" + msg + " ",
                type: color
            });
        }

    </script>
<script src="{{asset('assets/js/audio.js')}}"></script>
{{-- --}} 
<script src="{{asset('assets/js/custom.js')}}"></script>  
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/datatable1.js')}}"></script>
    <script src="{{asset('assets/js/jquery.growl.js')}}"></script>
    <script src="{{asset('assets/js/notifIt.js')}}"></script>
    <script src="{{asset('assets/js/rainbow.js')}}"></script>
    <script src="{{asset('assets/js/sample.js')}}"></script>


	
<!-- JAVASCRIPT SHEETS -->
<!-- JAVASCRIPT SHEETS -->
</body>
</html>
