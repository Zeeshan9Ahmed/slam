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
						<form action="" class="genForm login-form" id="otp-from"> @csrf
							<div class="mobileLogo">
								<img src="{{asset('assets/images/logo.png')}}" alt="img" class="w-100">
							</div>
							<h1 class="heading mb-4 text-center">Enter OTP</h1>

							<div method="get" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
								<input type="text" id="digit-1" name="digit_1" data-next="digit-2" maxlength="1" placeholder="-">
								<input type="text" id="digit-2" name="digit_2" data-next="digit-3" data-previous="digit-1" maxlength="1" placeholder="-">
								<input type="text" id="digit-3" name="digit_3" data-next="digit-4" data-previous="digit-2" maxlength="1" placeholder="-">
								<input type="text" id="digit-4" name="digit_4" data-next="digit-5" data-previous="digit-3" maxlength="1" placeholder="-">
								<input type="text" id="digit-5" name="digit_5" data-next="digit-6" data-previous="digit-4" maxlength="1" placeholder="-">
								<input type="text" id="digit-6" name="digit_6" data-next="digit-7" data-previous="digit-5" maxlength="1" placeholder="-">
							</div>

							<div class="form-group mt-4">
								<input type="hidden" name="type" value="">
								<button href="#!" id="otp-btn" class="genBtn">Verify</button>
							</div>
							<button type = "button" href="#!" id="resend-btn" class="resendBtn">Resend Code</button>
						</form>

						<a href="javascript: history.go(-1)" class="backBtn xy-center"><i class="fa-solid fa-angle-left"></i></a>
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
	<script src="{{asset('assets/js/custom.js')}}"></script> 
	<script src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('assets/js/datatable1.js')}}"></script>
	<script src="{{asset('assets/js/jquery.growl.js')}}"></script>
	<script src="{{asset('assets/js/notifIt.js')}}"></script>
	<script src="{{asset('assets/js/rainbow.js')}}"></script>
	<script src="{{asset('assets/js/sample.js')}}"></script>


	<script>
		$(document).ready(function() {
			$("#otp-btn").click(function(event) {
				event.preventDefault();

				var otp_form = $('#otp-from').serializeArray();
				for (i = 1; i <= 6; i++) {

					if (otp_form[i].value == '') {
						not("OTP Field Can not be Empty", 'error')
						return;
					}
				}
				otp_form.push({
					name: "email",
					value: localStorage.getItem('email')
				});
				otp_form.push({
					name: "type",
					value: localStorage.getItem('type')
				});
				$.ajax({

					url: "{{url('admin/venue/otp-verify')}}",
					type: "POST",
					data: otp_form,
					success: function(data) {

						if (data.status == 1) {

							localStorage.setItem('reference_code', data.data.reference_code)
							// return;
							// not(data.message, 'success');
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

			$("#resend-btn").click(function(event) {
				event.preventDefault();
				email = localStorage.getItem('email')
				type = localStorage.getItem('type')
				url = "";
				if (type == "PASSWORD_RESET"){
					url = "{{url('admin/venue/forgot-password')}}";
				}else{
					url = "{{url('admin/venue/signup/resend-otp')}}";
				}
				// console.log(email,type)
				// return;
				
				$.ajax({

					url: url,
					type: "POST",
					data: {
						email,
						"_token":"{{csrf_token()}}"
					},
					success: function(data) {

						if (data.status == 1) {
							console.log(data)
							not(data.message, 'success');
							
						} else if (data.status == 0) {
							not(data.message, 'error');
						}
					},
					error: function(error) {
						console.log(error, 'dfasf');
					}
				});
			});
			// alert(localStorage.getItem('email'))
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