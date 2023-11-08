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
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.min.css" rel="stylesheet" />
	<meta name="X-CSRF-TOKEN" content="{{ csrf_token() }}">

	@yield('additional_styles')
	<!-- STYLE SHEETS -->
</head>

<body>

	<section class="initial-sec login-sec xy-center pt-5 pb-5">

		<div class="tableWrap settingsTabs">
			<ul class="nav nav-pills xy-between" id="pills-tab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="pills-setting1-tab" data-bs-toggle="pill" data-bs-target="#pills-setting1" type="button" role="tab" aria-controls="pills-setting1" aria-selected="true">Complete Profile</button>
				</li>

			</ul>
			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-setting1" role="tabpanel" aria-labelledby="pills-setting1-tab">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-12">
							<form class="profileEdit" id="update_profile_form" enctype="multipart/form-data">
								<div class="topInfo1 mb-5">
									@csrf
									<!-- file-uploader-start -->
									<div class="avatar-upload">
										<div class="avatar-edit">
											<input type='file' id="imageUpload" name="avatar" class="test1" accept=".png, .jpg, .jpeg" />
											<label for="imageUpload">
												<i class="fa-solid fa-camera"></i>
											</label>
										</div>
										<div class="avatar-preview">
											<div id="imagePreview" style="background-image: asset('assets/images/profile-img-2.png')">
											</div>
										</div>
									</div>
									<!-- file-uploader-end -->


									<p class="title101">Personal Profile</p>
								</div>

								<div class="form-group mb-3">
									<input type="text" placeholder="Full Name" class="profileInput" name="full_name" id="full_name" value="{{auth()->user()->full_name??''}}">
								</div>

								<div class="form-group mb-3">
									<input type="tel" placeholder="Phone Number" value="+1 " name="phone_number" id="phone_number" maxlength="17" class="profileInput">
								</div>

								<div class="form-group">
									<input type="email" placeholder="Email Address" class="profileInput" value="{{auth()->user()->email??''}}" disabled>
								</div>

						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-12">
							<!-- <form class="profileEdit"> -->
							<div class="topInfo1 mb-5">
								<!-- file-uploader-start -->
								<div class="avatar-upload">
									<div class="avatar-edit">
										<input type='file' id="imageUpload2" name="venue_image" class="test2" accept=".png, .jpg, .jpeg" />
										<label for="imageUpload2">
											<i class="fa-solid fa-camera"></i>
										</label>
									</div>
									<div class="avatar-preview">
										<div id="imagePreview2" style="background-image: url(assets/images/.png)">
										</div>
									</div>
								</div>
								<!-- file-uploader-end -->
								<p class="title101">Venue Profile</p>
							</div>

							<div class="form-group mb-3">
								<input type="text" placeholder="Venue Name" name="venue_name" id="venue_name" class="profileInput">
							</div>

							<div class="form-group mb-3 eventForm">
								<div class="relClass">
									<textarea type="text" name="address" id="autocomplete" class="profileInput textArea d-block" placeholder=" Location"></textarea>
									<input type="hidden" name="latitude" id="latitude">
									<input type="hidden" name="longitude" id="longitude">
								</div>
							</div>

							<div class="form-group mb-3">
								<input type="number" placeholder="Seating Capacity" name="capacity" id="capacity" onKeyPress="if(this.value.length==6) return false;" class="profileInput">
							</div>

							<div class="form-group mb-3 eventForm">
								<textarea type="text" placeholder="Description" name="detail" id="detail" onKeyPress="if(this.value.length==250) return false;" class="profileInput textArea d-block"></textarea>
							</div>

							<div class="form-group mb-3">
								<input type="tel" placeholder="Venue Phone Number" value="+1 " name="venue_number" id="venue_number" maxlength="17" class="profileInput">
							</div>

							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12 col-12">
									<div class="form-group mb-3">
										<label for="" class="label101">Select Time After 7 am</label>
										<input type="text" class="profileInput" onfocus="(this.type='time')" name="start_time" id="start_time" placeholder="Start Time">
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-12">
									<div class="form-group mb-3">
										<label for="" class="label101">Select Time Before 11 pm</label>
										<input type="text" class="profileInput" onfocus="(this.type='time')" name="end_time" id="end_time" placeholder="End Time">
									</div>
								</div>
							</div>



							<!-- </form> -->
						</div>
						<div class="col-12">
							<button type="submit" id="update_profile-btn" class="genBtn updateBtn">Complete Profile</button>
						</div>
						</form>
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
	<script src="https://maps.google.com/maps/api/js?key=AIzaSyBmaS0B0qwokES4a_CiFNVkVJGkimXkNsk&libraries=places&callback=initAutocomplete" type="text/javascript"></script>

	<script>
		const imageUpload = document.getElementById('image-upload');
		const imageContainer = document.getElementById('image-container');
		imageUpload.addEventListener('change', function() {
			// alert(1)

			const file = this.files[0];
			const reader = new FileReader();
			reader.addEventListener('load', function() {
				const imagePreview = document.createElement('div');
				imagePreview.classList.add('image-preview');
				const image = document.createElement('img');
				image.setAttribute('src', this.result);
				imagePreview.appendChild(image);
				const removeButton = document.createElement('button');
				removeButton.classList.add('remove-image');
				removeButton.innerHTML = '&times;';
				removeButton.addEventListener('click', function() {


					imagePreview.remove();
				});
				imagePreview.appendChild(removeButton);
				imageContainer.innerHTML = '';
				imageContainer.appendChild(imagePreview);
			});
			reader.readAsDataURL(file);
		});
	</script>

	<script>
		google.maps.event.addDomListener(window, 'load', initialize);

		function initialize() {
			var input = document.getElementById('autocomplete');
			var autocomplete = new google.maps.places.Autocomplete(input);
			autocomplete.addListener('place_changed', function() {
				var place = autocomplete.getPlace();
				$('#latitude').val(place.geometry['location'].lat());
				$('#longitude').val(place.geometry['location'].lng());
			});
		}
	</script>

	<script>
		$(document).ready(function() {

			const convertTime12to24 = (time12h) => {
				const [time, modifier] = time12h.split(' ');

				let [hours, minutes] = time.split(':');

				if (hours === '12') {
					hours = '00';
				}

				if (modifier === 'PM') {
					hours = parseInt(hours, 10) + 12;
				}

				return `${hours}:${minutes}`;
			}
			$(document).on('focusin', '#start_time', function() {
					$(this).data('val', $(this).val());
				})
				.on("focusout", "#start_time", function() {
					
					var prev = $(this).data('val');
					this_refrence = $(this);
					var st_time = this_refrence.val();
					if (convertTime12to24(st_time) < '07:00') {
						not(`Start Time should be greater than 07:00 AM`, 'error')
						this_refrence.val(prev)
						return;
					}
				});

			$(document).on('focusin', '#end_time', function() {
					$(this).data('val', $(this).val());
				})
				.on("focusout", "#end_time", function() {
					var prev = $(this).data('val');
					this_refrence = $(this);
					var end_time = this_refrence.val();
					if (convertTime12to24(end_time) > '23:00') {
						not(`End Time should be less than 11:00 PM`, 'error')
						this_refrence.val(prev)
						return;
					}
				});


			$(document).on('keydown', function(e) {
				if (e.keyCode == 8 && $('#phone_number').is(":focus") && $('#phone_number').val().length < 4) {
					e.preventDefault();
				}
			});
			$(document).on('keydown', function(e) {
				if (e.keyCode == 8 && $('#venue_number').is(":focus") && $('#venue_number').val().length < 4) {
					e.preventDefault();
				}
			});

			$("#venue_number").keypress(function(e) {

				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
					return false;
				}

				var curchr = this.value.length;
				var curval = $(this).val();
				if (curchr == 6 && curval.indexOf("(") <= -1) {
					$(this).val("+1 (" + curval.replace("+1 ", "") + ")" + "-");
				} else if (curchr == 6 && curval.indexOf("(") > -1) {
					$(this).val(curval + ")-");
				} else if (curchr == 12 && curval.indexOf(")") > -1) {
					$(this).val(curval + "-");
				} else if (curchr == 9) {
					$(this).val(curval + "-");
					$(this).attr('maxlength', '14');
				}


			});
			$("#phone_number").keypress(function(e) {

				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
					return false;
				}

				var curchr = this.value.length;
				var curval = $(this).val();
				if (curchr == 6 && curval.indexOf("(") <= -1) {
					$(this).val("+1 (" + curval.replace("+1 ", "") + ")" + "-");
				} else if (curchr == 6 && curval.indexOf("(") > -1) {
					$(this).val(curval + ")-");
				} else if (curchr == 12 && curval.indexOf(")") > -1) {
					$(this).val(curval + "-");
				} else if (curchr == 9) {
					$(this).val(curval + "-");
					$(this).attr('maxlength', '14');
				}


			});
			$('#update_profile_form').on('submit', function(event) {
				event.preventDefault();

				// var admin_image = $("#imageUpload")[0]?.files;
				// if (admin_image.length == 0 ) {
				// 	not('Profile Image is required', 'error')
				// 	return;

				// }
				var full_name = $('#full_name').val()
				var phone_number = $('#phone_number').val()
				var venue_name = $('#venue_name').val()
				var autocomplete = $('#autocomplete').val()
				var latitude = $('#latitude').val()
				var capacity = $('#capacity').val()
				var detail = $('#detail').val()
				var start_time = $('#start_time').val()
				var end_time = $('#end_time').val()

				let files = $("#imageUpload2")[0]?.files;


				var venue_number = $('#venue_number').val()

				if (!full_name) {
					not('Full Name Field is required', 'error')
					return;
				} else if (!phone_number) {
					not('Phone Number Field is required', 'error')
					return;

				} else if (phone_number.length < 17) {
					not('Phone Number is not a valid', 'error')
					return;

				} else if (files.length == 0) {
					not('Venue Image is required', 'error')
					return;

				} else if (!venue_name) {
					not('Venue Name Field is required', 'error')
					return;

				} else if (!autocomplete) {
					not('Location Field is required', 'error')
					return;

				} else if (!latitude) {
					not('Please Select A valid Location', 'error')
					return;

				} else if (!capacity) {
					not(' Capacity Field is required', 'error')
					return;

				} else if (!detail) {
					not('Description Filed is required', 'error')
					return;

				} else if (detail.length > 250) {
					not('Description Filed must be less than 250 characters', 'error')
					return;

				} else if (!venue_number) {
					not('Venue Phone Number Field is required', 'error')
					return;

				} else if (venue_number.length < 17) {
					not('Venue Phone Number is not Valid', 'error')
					return;

				} else if (!start_time) {
					not('Start Time Field is required', 'error')
					return;

				} else if (!end_time) {
					not('End Time Field is required', 'error')
					return;

				} else if (end_time < start_time) {
					not('End Time Should be greater than end time', 'error')
					return;
				}


				// return;
				$.ajax({
					url: "{{ url('admin/venue/update-profile') }}",
					method: "POST",
					data: new FormData(this),
					dataType: 'JSON',
					contentType: false,
					cache: false,
					processData: false,
					success: function(data) {
						console.log(data)
						if (data.status == 1) {

							not(data.message, 'success');
							window.location.href = data.redirect_url;
						} else if (data.status == 0) {
							not(data.message, 'error');
						}

					}
				})
			});


			var msg = $('#mSg').val();
			var color = $('#mSg').attr('color');


			if (msg) {
				not(msg, color);
			}
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