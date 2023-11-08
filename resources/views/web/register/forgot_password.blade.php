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
	<section class="initial-sec login-sec">
		<div class="container-fluid p-0">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 initialCol1 p-0">
					<div class="leftWrap xy-center relClass">
						<form action="" class="genForm login-form" id="reset_password-form">
							<div class="mobileLogo">
								<img src="{{asset('assets/images/logo.png')}}" alt="img" class="w-100">
							</div>
							@csrf
							<h1 class="heading mb-4 text-center">Reset Password</h1>

							<div class="form-group mb-3">
								<div class="relClass">
									<input type="email" name="email" required placeholder="Enter Email Address" class="genInput type2">
								</div>
							</div>

							<div class="form-group mt-4">
								<button type="button" id="reset_password" class="genBtn">Send</button>
							</div>
						</form>
						<a href="{{url('admin/venue/login')}}" class="backBtn xy-center"><i class="fa-solid fa-angle-left"></i></a>
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
		$(document).on('click', '#reset_password', function(event) {

			event.preventDefault();
			$.post("{{url('admin/venue/forgot-password')}}", $('#reset_password-form').serialize(), function(response) {

				console.log('response', response)
				// return;
				if (response.status > 0) {
					localStorage.setItem('email', response.data.email)
					localStorage.setItem('type', response.data.type)
					not('OTP has been Sent on your Email Address', 'success')
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
				msg: " </b>" + msg + " ",
				type: color
			});
		}
	</script>
	<!-- JAVASCRIPT SHEETS -->
	<!-- JAVASCRIPT SHEETS -->
</body>

</html>