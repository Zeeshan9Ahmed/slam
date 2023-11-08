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
	<style>
    .success {
        width: fit-content!important;
        padding: 0px 120px!important;
    }
    .success p {
        font-size: 18px!important;
    }

	.error {
        width: fit-content!important;
        padding: 0px 120px!important;
    }
    .error p {
        font-size: 18px!important;
    }
</style>
	@yield('additional_styles')
	<!-- STYLE SHEETS -->
</head>

<body>

	<section class="initial-sec login-sec">
		<div class="container-fluid p-0">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 initialCol1 p-0">
					<div class="leftWrap xy-center">
						<form id="login_form" class="genForm login-form">
							<div class="mobileLogo">
								<img src="{{asset('assets/images/logo.png')}}" alt="img" class="w-100">
							</div>
							@csrf
							<h1 class="heading mb-4 text-center">Login to <span>your accounts !</span></h1>
							<div class="form-group mb-3">
								<label class="genLabel">Email <span>*</span></label>
								<div class="relClass">
									<input type="email" name="email" id="email" placeholder="Enter Email" class="genInput" required>
									<span>
										<img src="{{asset('assets/images/input-icon-1.png')}}" alt="img" class="inputIcon">
									</span>
								</div>
							</div>
							<div class="form-group mb-3">
								<label class="genLabel">Password</label>
								<div class="relClass">
									<input type="password" name="password" id="password" placeholder="Enter Password" class="genInput" required>
									<span>
										<img src="{{asset('assets/images/input-icon-2.png')}}" alt="img" class="inputIcon">
									</span>
								</div>
							</div>

							<div class="form-group mb-3">
								<a href="{{url('admin/venue/forgot-password')}}" class="forgotBtn">Forgot Password ? <span>Reset</span></a>
							</div>

							<div class="form-group">
								<button type="button" id="login_btn" class="genBtn loginBtn">Login</button>
							</div>

							<div class="form-group mt-4">
								<p class="btmText text-center">Don’t have an Account ? <a href="{{url('admin/venue/signup')}}">Create Account</a></p>
							</div>
						</form>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 initialCol2 p-0">
					<div class="rightWrap xy-center">
						<div class="loginLogo">
							<img src="{{asset('assets/images/logo.png')}}" alt="img" class="w-100">
						</div>
					</div>
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

	@if(Session::has('success')) <input type="hidden" id="mSg" color="success" value="{{ Session::get('success') }}"> @endif
	@if(Session::has('error')) <input type="hidden" id="mSg" color="error" value="{{ Session::get('error') }}"> @endif

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
	{{-- <script src="{{asset('assets/js/audio.js')}}"></script>--}}
	<script src="{{asset('assets/js/custom.js')}}"></script>
	<script src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('assets/js/datatable1.js')}}"></script>
	<script src="{{asset('assets/js/jquery.growl.js')}}"></script>
	<script src="{{asset('assets/js/notifIt.js')}}"></script>
	<script src="{{asset('assets/js/rainbow.js')}}"></script>
	<script src="{{asset('assets/js/sample.js')}}"></script>


	<script>
		function isEmail(email) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}

		function isStrongPassword(password) {
			var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
			return regex.test(password);
		}
		$(document).ready(function() {
			$(document).on('click', '#login_btn', function(event) {

				event.preventDefault();
				var email = $("#email").val()
				var password = $("#password").val()
				
				if (!email) {
					not('Email address field is required', 'error');
					return;
				}
				else if (!isEmail(email)) {
					not('Please enter valid email address.', 'error');
					return;
				}
				else if (!password) {
					not('Password field is required', 'error');
					return;
				}
				// else if (!isStrongPassword(password)) {
				// 	not('Password should be of 8 characters long (should contain uppercase, lowercase, number and special character)', 'error');
				// 	return;
				// }
				// ​
				$.post("{{url('admin/venue/login')}}", $('#login_form').serialize(), function(response) {
					if (response.status > 0) {
						let colour = 'success';
						if (response.data) {
							localStorage.setItem('email', response.data.email)
							localStorage.setItem('type', response.data.type)
							colour = 'error'
						}
						not(response.message, colour);
						window.location.href = response.redirect_url;
					} else {
						not(response.message, 'error');
					}
				}, 'json');
			});
			var msg = $('#mSg').val();
			var color = $('#mSg').attr('color');
			

			if (msg) {
				not(msg, color);
			}
		});

		function not(msg, color) {
			notif({
				msg: "</b>" + msg + " ",
				type: color
			});
		}
	</script>
	<!-- JAVASCRIPT SHEETS -->
	<!-- JAVASCRIPT SHEETS -->
</body>

</html>