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

	<style>
		.success {
			width: fit-content !important;
			padding: 0px 120px !important;
		}

		.success p {
			font-size: 18px !important;
		}

		.error {
			width: fit-content !important;
			padding: 0px 120px !important;
		}

		.error p {
			font-size: 18px !important;
		}
	</style>
	<!-- STYLE SHEETS -->
</head>

<body>

	@if($errors->any())

	@endif
	<section class="initial-sec signup-sec">
		<div class="container-fluid p-0">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 initialCol1 p-0">
					<div class="leftWrap xy-center">
						<form class="genForm login-form" id="category-form">
							<div class="mobileLogo">
								<img src="assets/images/logo.png" alt="img" class="w-100">
							</div>
							<h1 class="heading mb-4 text-center">Create a <span>New Account!</span></h1>
							@csrf
							<div class="form-group mb-3">
								<label class="genLabel">Full Name</label>
								<div class="relClass">
									<input type="text" placeholder="Enter Full Name" name="full_name" id="full_name" class="genInput type2" required>
								</div>
							</div>



							<div class="form-group mb-3">
								<label class="genLabel">Email</label>
								<div class="relClass">
									<input type="Email" placeholder="Enter Email" name="email" id="email" class="genInput type2" required>
								</div>
							</div>

							<div class="form-group mb-3">
								<label class="genLabel">Password</label>
								<div class="relClass">
									<input type="password" name="password" id="password" class="genInput type2" placeholder="Enter Password" onChange="onChange()" required>
								</div>
							</div>

							<div class="form-group mb-3">
								<label class="genLabel">Confirm Password</label>
								<div class="relClass">
									<input type="password" name="confirm" id="confirm" placeholder="Enter Confirm Password" class="genInput type2" onChange="onChange()" required>
								</div>
							</div>

							<div class="form-group mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2" required>
									<label class="form-check-label" for="flexCheckDefault2">
										Agree to Terms & Conditions
									</label>
								</div>

							</div>
							<div class="form-group">
								<button type="button" id="category-btn" class="genBtn loginBtn">Sign up</button>
							</div>

							<div class="form-group mt-4">
								<p class="btmText text-center">Already have an Account <a href="{{url('admin/venue/login')}}">Login Now</a></p>
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
	{{-- <script src="{{asset('assets/js/custom.js')}}"></script> --}}
	<script src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('assets/js/datatable1.js')}}"></script>
	<script src="{{asset('assets/js/jquery.growl.js')}}"></script>
	<script src="{{asset('assets/js/notifIt.js')}}"></script>
	<script src="{{asset('assets/js/rainbow.js')}}"></script>
	<script src="{{asset('assets/js/sample.js')}}"></script>
	<script>
		function onChange() {
			const password = document.querySelector('input[name=password]');
			const confirm = document.querySelector('input[name=confirm]');
			if (confirm.value === password.value) {
				confirm.setCustomValidity('');
			} else {
				confirm.setCustomValidity('Passwords do not match');
			}
		}
	</script>

	<script>
		/** Create category */

		function isEmail(email) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}

		function isStrongPassword(password) {
			var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
			return regex.test(password);

		}
		$(document).on('click', '#category-btn', function(event) {

			event.preventDefault();
			full_name = $('#full_name').val();
			email = $('#email').val();
			password = $('#password').val();
			confirm = $('#confirm').val();

			if (!full_name) {
				not('Full Name field is required', 'error')
				return;
			} else if (!email) {
				not('Email address field is required', 'error');
				return;
			} else if (!isEmail(email)) {
				not('Please enter valid email address.', 'error');
				return;
			} else if (!(password)) {
				not('Password Field is required.', 'error');
				return;
			} else if (!isStrongPassword(password)) {
				not('Password should be of 8 characters long (should contain uppercase, lowercase, number and special character).', 'error');
				return;
			} else if (!(confirm)) {
				not('Confirm Password Field is required.', 'error');
				return;
			}  else if (password !== confirm) {
				not('Password and Confirm Password must be same.', 'error');
				return;
			} else if ($('input[type=checkbox]:checked').length == 0) {
				not("Please Accept Terms & Conditions", 'error');
				return;
			}

			$.post("{{url('admin/venue/signup')}}", $('#category-form').serialize(), function(response) {
				if (response.status > 0) {
					console.log(response)
					not(response.message, 'success');

					localStorage.setItem('email', response.data.email)
					localStorage.setItem('type', response.data.type)
					// return;
					window.location.href = response.redirect_url;
				} else {
					not(response.message, 'error');
				}
			}, 'json');
		});

		$(document).ready(function() {

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