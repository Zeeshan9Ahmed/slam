@extends('layout.master')
@section('content')


<div class="tableWrap settingsTabs">
    <ul class="nav nav-pills xy-between" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-setting1-tab" data-bs-toggle="pill" data-bs-target="#pills-setting1" type="button" role="tab" aria-controls="pills-setting1" aria-selected="true">Profile</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-setting2-tab" data-bs-toggle="pill" data-bs-target="#pills-setting2" type="button" role="tab" aria-controls="pills-setting2" aria-selected="true">Password</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-setting3-tab" data-bs-toggle="pill" data-bs-target="#pills-setting3" type="button" role="tab" aria-controls="pills-setting3" aria-selected="false">Payment</button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-setting1" role="tabpanel" aria-labelledby="pills-setting1-tab">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <form class="profileEdit" id="update_profile" method="POST" enctype="multipart/form-data">
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
                                    <!-- <img src="" alt="img"> -->
                                    <div id="imagePreview" style="background-image: url({{ auth()->user()->avatar??asset('assets/images/avatar.png')}})">
                                    </div>
                                </div>
                            </div>
                            <!-- file-uploader-end -->


                            <p class="title101">Personal Profile</p>
                        </div>

                        <div class="form-group mb-3">
                            <input type="text" placeholder="Full Name" class="profileInput" name="full_name" id="full_name" value="{{$user->full_name??''}}">
                        </div>

                        <div id="phone_text" class="form-group mb-3">
                            <input type="tel" placeholder="Phone Number" name="phone_number" id="phone_number" maxlength="17" value="{{$user->phone_number??''}}" class="profileInput">
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
                                <div id="imagePreview2" style="background-image: url({{ $user->venue->image??asset('assets/images/venue.png')}})">
                                </div>
                            </div>
                        </div>
                        <!-- file-uploader-end -->
                        <p class="title101">Venue Profile</p>
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" placeholder="Venue Name" name="venue_name" id="venue_name" value="{{$user->venue->name??''}}" class="profileInput">
                    </div>

                    <div class="form-group mb-3">
                        <div class="relClass eventForm">
                            <textarea type="text"  id="autocomplete" class="genInput type2 textArea" value="" disabled required>{{$user->venue->address??''}}</textarea>
                            <input type="hidden"  id="latitude" value="{{$user->venue->lat??''}}">
                            <input type="hidden"  id="longitude" value="{{$user->venue->lang??''}}">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" placeholder="Seating Capacity" name="capacity" value="{{$user->venue->capacity??''}}" id="capacity" onKeyPress="if(this.value.length==6) return false;" class="profileInput">
                    </div>

                    <div class="form-group mb-3 eventForm">
                        <textarea type="text" placeholder="Description" name="detail" class="profileInput textArea" id="detail" value="" onKeyPress="if(this.value.length==250) return false;">{{$user->venue->detail??''}}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <input type="tel" placeholder="Venue Phone Number" name="venue_number" id="venue_number" maxlength="17" value="{{$user->venue->phone_number??''}}" class="profileInput">
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group mb-3">
                                <label for="" class="label101">Select Time After 7 am</label>
                                <input type="time" class="profileInput" name="start_time" id="start_time" value="" placeholder="Start Time">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group mb-3">
                                <label for="" class="label101">Select Time Before 11 pm</label>
                                <input type="time" class="profileInput" name="end_time" id="end_time" placeholder="End Time" value="{{$user->venue->end_time}}">
                            </div>
                        </div>
                    </div>
                    <!-- </form> -->
                </div>
                <div class="col-12">
                    <button href="#!" type="submit" id="update_profile" class="genBtn updateBtn">Update</button>
                </div>
                </form>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-setting2" role="tabpanel" aria-labelledby="pills-setting2-tab">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <form class="profileEdit" id="change_password">
                        <div class="form-group mb-3">
                            <input type="password" name="current_password" id="current_password" placeholder="Current Password" class="profileInput">
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" placeholder="New Password " name="password" id="new_password" class="profileInput">
                        </div>

                        <div class="form-group mb-3">
                            <input type="password" placeholder="Confirm Password" name="confirm" id="confirm_password" class="profileInput">
                        </div>

                        <div class="form-group">
                            <button type="submit" id="change_password" class="genBtn passBtn">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-setting3" role="tabpanel" aria-labelledby="pills-setting3-tab">
            <div class="row">
                <div class="col-12">
                    <div class="cardRow xy-between">
                        <label class="paymentCard" for="radio">
                            <img src="{{asset('assets/images/card-img-1.png')}}" alt="img">
                            <input class="form-check-input" type="radio" name="card" id="radio" checked>
                        </label>
                        <label class="paymentCard" for="radio1">
                            <img src="{{asset('assets/images/card-img-2.png')}}" alt="img">
                            <input class="form-check-input" type="radio" name="card" id="radio1">
                        </label>
                        <label class="paymentCard" for="radio3">
                            <img src="{{asset('assets/images/card-img-3.png')}}" alt="img">
                            <input class="form-check-input" type="radio" name="card" id="radio3">
                        </label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <form class="profileEdit">
                        <p class="title101 ps-0 pb-4">Billing Information</p>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Full Name" class="profileInput">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Billing Address" class="profileInput">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-3">
                                    <select class="profileInput">
                                        <option selected disabled>City</option>
                                        <option value="">Algeria</option>
                                        <option value="">Belize</option>
                                        <option value="">Belgium</option>
                                        <option value="">Nairobi </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Zip Code" class="profileInput">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <select class="profileInput">
                                        <option disabled selected>Country</option>
                                        <option>Brazil</option>
                                        <option>Bulgaria</option>
                                        <option>China</option>
                                        <option>Egypt</option>
                                        <option>India</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <form class="profileEdit">
                        <p class="title101 ps-0 pb-4">Card Information</p>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Card Holder's Name" class="profileInput">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Card Holder's Name" class="profileInput">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Exp. Month" class="profileInput">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Exp. Year" class="profileInput">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="CVC" class="profileInput">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12 xy-between btnCol">
                    <a href="{{url('admin/dashboard')}}" class="genBtn proceedBtn">Return to Dashboard</a>
                    <a href="#!" class="genBtn proceedBtn">Proceed</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script src="https://maps.google.com/maps/api/js?key=AIzaSyBmaS0B0qwokES4a_CiFNVkVJGkimXkNsk&libraries=places&callback=initAutocomplete" type="text/javascript"></script>
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
    $(document).ready(() => {
        start = "{{$user->venue->start_time}}";
        end = "{{$user->venue->end_time}}";
        
       
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

        
        $('#start_time').val(convertTime12to24(start))
        $('#end_time').val(convertTime12to24(end))

        function isStrongPassword(password) {
            var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
            return regex.test(password);

        }


        $('#phone_text').on('mousemove', (e) => e.preventDefault());
        var element = $("#phone_number");
        $('#phone_text').bind('dragstart', function(event) {
            console.log(event, 'event')
            event.preventDefault();
        });

        element.attr('unselectable', 'on').css('user-select', 'none').on('selectstart dragstart', false);
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
        // venue_number
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
        $('#change_password').on('submit', function(e) {
            e.preventDefault();
            let current_password = $('#current_password').val();
            let new_password = $('#new_password').val();
            let confirm_password = $('#confirm_password').val();
            if (!current_password) {
                not('Current Password Field is required', 'error')
                return;
            } else if (!new_password) {
                not('New Password Field is required', 'error')
                return;

            } else if (!isStrongPassword(new_password)) {
                not('Password should be of 8 characters long (should contain uppercase, lowercase, number and special character).', 'error');
                return;
            } else if (!confirm_password) {
                not('Confirm Password Field is required', 'error')
                return;

            } else if (new_password !== confirm_password) {
                not('Password and Confirm Password must be same.', 'error');
                return;
            }


            $.ajax({
                url: "{{url('admin/change-password')}}",
                data: {
                    new_password,
                    current_password,
                    "_token": "{{ csrf_token() }}",
                },
                method: "POST",
                dataType: 'json',
                success: function(response, textStatus, jqXHR) {
                    if (response.status == 1) {

                        not(response.message, 'success');
                        $('#current_password').val('');
                        $('#new_password').val('');
                        $('#confirm_password').val('');
                        // window.location.reload()
                    } else {

                    }

                },
                error: function(jqXHR, exception) {
                    let data = JSON.parse(jqXHR.responseText);
                    not(data.message, 'error');
                }
            });

        });

        function getTimeAsNumberOfMinutes(time) {
            var timeParts = time.split(":");

            var timeInMinutes = (timeParts[0] * 60) + timeParts[1];

            return timeInMinutes;
        }

        $('#update_profile').on('submit', function(e) {
            e.preventDefault();
            //
            var full_name = $('#full_name').val()
            var phone_number = $('#phone_number').val()
            var venue_name = $('#venue_name').val()
            // var autocomplete = $('#autocomplete').val()
            // var latitude = $('#latitude').val()
            var capacity = $('#capacity').val()
            var detail = $('#detail').val()
            var start_time = $('#start_time').val()
            var end_time = $('#end_time').val()
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

            } else if (!venue_name) {
                not('Venue Name Field is required', 'error')
                return;

            }
            else if (!capacity) {
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

            }else if (end_time < start_time ){
                not('End Time Should be greater than Start Time', 'error')
                return;
            }

            $.ajax({
                url: "{{ url('admin/venue/update-profile') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response, textStatus, jqXHR) {
                    if (response.status == 1) {

                        not("Profile updated successfully.", 'success');

                        // window.location.reload()
                    } else {

                    }

                },
                error: function(jqXHR, exception) {
                    let data = JSON.parse(jqXHR.responseText);
                    not(data.message, 'error');
                }
            });

        });

    });
</script>

@endsection