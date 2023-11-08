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
						<form action="" class="genForm login-form" id="change_password-form">
							<div class="mobileLogo">
								<img src="{{asset('assets/images/logo.png')}}" alt="img" class="w-100">
							</div>
							@csrf
							<h1 class="heading mb-4 text-center">Change Password</h1>

							<div class="form-group mb-3">
								<div class="relClass">
									<input type="password" name="new_password" id="new_password" required placeholder="New Password" class="genInput type2">
								</div>
							</div>

							<div class="form-group mb-3">
								<div class="relClass">
									<input type="password" name="current_password" id="current_password" required placeholder="Confirm Password" class="genInput type2">
								</div>
							</div>

							<div class="form-group mt-4">
								<button type="button" id="change_password" class="genBtn">Update</button>
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
		function isStrongPassword(password) {
			var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
			return regex.test(password);

		}
		$("#change_password").click(function(event) {
			event.preventDefault();

			let new_password = $('#new_password').val();
			let current_password = $('#current_password').val();
			if (!new_password) {
				not('New Password Field is required', 'error')
				return;

			} else if (!isStrongPassword(new_password)) {
				not('Password should be of 8 characters long (should contain uppercase, lowercase, number and special character).', 'error');
				return;
			} else if (new_password !== current_password) {
				not('Password and Confirm Password must be same.', 'error');
				return;
			}
			// return ;
			let email = localStorage.getItem('email');
			let reference_code = localStorage.getItem('reference_code');
			// console.log(reference_code,email)
			$.ajax({

				url: "{{url('admin/venue/change-password')}}",
				type: "POST",
				data: {
					new_password,
					email,
					reference_code,
					"_token": "{{ csrf_token() }}",
				},
				success: function(data) {

					if (data.status == 1) {

						not(data.message, 'success');
						localStorage.removeItem("email");
						localStorage.removeItem("type");
						localStorage.removeItem("reference_code");
						window.location.href = data.redirect_url;
					} else if (data.status == 0) {
						not(data.message, 'error');
					}
				},
				error: function(error) {
					console.log(error, 'dfasf');
				}
			});
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