@extends('layout.master')

@section('content')
<div class="tableWrap overFlow">
	<div class="xy-end">
		<a href="#genModal3" data-bs-toggle="modal" class="genBtn mb-3 eventBtn">Create Event</a>


	</div>
	<table id="table_id" class="display">
		<thead>
			<tr>
				<th>ID</th>
				<th>Artist Name</th>
				<th>Event Title</th>
				<th>Location</th>
				<th>Event Details</th>
				<th>Date & Time</th>
				<th>Status</th>
				<th class="text-center">Actions</th>
			</tr>
		</thead>

		<tbody>

			@foreach ($events as $key => $event)
			<tr>
				<td class="text-center">{{++$key}}</td>
				<td>{{$event->artist_status?->user->full_name??"-----"}}</td>
				<td>{{$event->title}}</td>
				<td>{{$event->location}}</td>
				<td>
					<p class="eventDesc">{{$event->detail}}</p>
				</td>
				<td>
					<p class="eveDate">
						<span>{{$event->date}}</span>
						<span>{{$event->start_time}}- {{$event->end_time}}</span>
					</p>
				</td>
				<td>{{($event->artist_status == null ? "Rejected" : $event->artist_status->user == null) ? "Rejected" : ($event->artist_status->interested == 0 ? "Pending" : "Accepted")}}</td>
				<td>
					<div class="btnWrap xy-between">
						<a href="#genModal2" class="editIcon xy-center" data-id="{{$event->id}}" data-bs-toggle="modal">
							<i class="fa-solid fa-pen-to-square"></i>
						</a>
						<a href="#dltModal" class="deleteIcon trashIcon xy-center" data-id="{{$event->id}}" data-bs-toggle="modal">
							<i class="fa-solid fa-trash-can"></i>
						</a>
					</div>
				</td>
			</tr>

			@endforeach

		</tbody>
	</table>
</div>


<!-- ADD EVENT MODAL START -->
<div class="modal fade genModal" id="genModal3" tabindex="-1" aria-labelledby="genModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<p class="heading pb-3">Create Event</p>

				<form class="row eventForm" id="create_event" enctype="multipart/form-data" method="POST" action="{{route('create_event')}}">
					<div class="col-12">
						<div class="form-group mb-3">
							<label class="label1">Event Title</label>
							<input type="text" class="eventInput" name="title" id="title1" placeholder="Enter Event Title">
						</div>
					</div>
					@csrf
					<div class="col-12">
						<div class="form-group mb-3">
							<div class="row m-0" id="image_span">

								<label class="label1" for="files">Event Images</label>
								{{--<input type="file" class="eventInput" id="image-upload" name="images[]" placeholder="Image" accept=".png, .jpg, .jpeg"  multiple>--}}
								<input type="file" class="eventInput" id="files" name="files[]" accept=".png, .jpg, .jpeg" multiple />

							</div>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group mb-3">
							<label class="label1">Event Capacity</label>
							<input type="number" class="eventInput" name="event_capacity" id="event_capacity1" onchange="handleChange(this);" onKeyPress="if(this.value.length==6) return false;" placeholder="Enter Event Capacity">
						</div>
					</div>
					<div class="col-12">
						<div class="form-group mb-3">
							<label class="label1">Event Details</label>
							<textarea class="eventInput textArea" name="detail" id="detail1" onKeyPress="if(this.value.length==250) return false;" placeholder="Enter Event Detail"></textarea>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group mb-3">
							<label class="label1">Date</label>
							<input type="date" class="eventInput" min="<?php echo date("Y-m-d"); ?>" name="date" id="date1" placeholder="Date">
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="form-group mb-3">
							<label class="label1">Start Time</label>
							<input type="time" class="eventInput" name="start_time" id="start_time1" placeholder="Event Start Time">
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="form-group mb-3">
							<label class="label1">End Time</label>
							<input type="time" class="eventInput" name="end_time" id="end_time1" placeholder="Event End Time">
						</div>
					</div>

					<div class="col-12">
						<div class="form-group mb-3">
							<label class="label1">Select Artist</label>
							<select name="user_id" id="user_id1" class="form-control eventInput">
								<option value="">Select Artist</option>
								@foreach($artists as $artist)
								<option value="{{$artist->id}}">{{$artist->full_name}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="col-12">
						<div class="form-group mt-3">
							<!-- <a href="#!" class="genBtn" id="create_event" type="submit">Create Event</a>	 -->
							<button href="#!" class="genBtn" id="create_event" type="submit">Create Event</button>
						</div>
					</div>
				</form>
				<p class="closeBtn xy-center" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></p>
			</div>
		</div>
	</div>
</div>
<!-- ADD EVENT MODAL END -->

<!-- EDIT EVENT MODAL START -->
<div class="modal fade genModal" id="genModal2" tabindex="-1" aria-labelledby="genModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<p class="heading pb-3">Edit Event</p>

				<form class="row eventForm" enctype="multipart/form-data" method="POST" id="update_event" action="{{url('admin/event-update')}}">
					<div class="col-12">
						<div class="form-group mb-3">
							<label class="label1">Event Title</label>
							<input type="text" name="title" id="title" class="eventInput edit" placeholder=" Event Title" value="">
							<input type="hidden" name="id" id="id" class="eventInput" placeholder="Awesome Event" value="">
							<input type="hidden" name="images_count" id="images_count" class="eventInput" placeholder="Awesome Event" value="">
						</div>
					</div>
					@csrf
					{{--
						<div class="col-12">
						<div class="form-group mb-3">
							<label class="label1">Conventional Hall</label>
							<input type="text" class="eventInput" name="location" id="location" placeholder="Conventional Hall">
						</div>
					</div>
						--}}
					<div class="col-12">
						<div class="form-group mb-3">
							<div class="row m-0" id="edit_image_span">
								<label class="label1">Event Images</label>
								<input type="file" class="eventInput edit" name="images[]" id="editfiles" placeholder="Image" accept=".png, .jpg, .jpeg" multiple>
							</div>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group mb-3">
							<label class="label1">Event Capacity</label>
							<input type="number" class="eventInput edit" name="event_capacity" id="event_capacity" onKeyPress="if(this.value.length==6) return false;" placeholder="Enter Event Capacity">
						</div>
					</div>
					<div class="col-12">
						<div class="form-group mb-3">
							<label class="label1">Event Details</label>
							<textarea class="eventInput textArea edit" name="detail" id="detail" onKeyPress="if(this.value.length==250) return false;"></textarea>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group mb-3">
							<label class="label1">Date</label>
							<input type="date" class="eventInput edit" min="<?php echo date("Y-m-d"); ?>" name="date" id="date" placeholder="Date">
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="form-group mb-3">
							<label class="label1">Start Time</label>
							<input type="time" class="eventInput edit" name="start_time" id="start_time" placeholder="Start Time">
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="form-group mb-3">
							<label class="label1">End Time</label>
							<input type="time" class="eventInput edit" name="end_time" id="end_time" placeholder="End Time">
						</div>
					</div>

					<div class="col-12">
						<div class="form-group mb-3" id="user_id">
							<label class="label1">Select Artist</label>
							<select name="user_id" id="user_id" class="form-control eventInput select" >
								<option value="">Select Artist</option>
								@foreach($artists as $artist)
								<option value="{{$artist->id}}">{{$artist->full_name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-12">
						<label class="label1 pb-2">Images</label>
						<div class="row uploadedImgs" id="images">


						</div>
					</div>
					<div class="col-12">
						<div class="form-group mt-3">
							<button href="#!" class="genBtn update_event_button" id="update_event" type="submit">Update</button>
						</div>
					</div>
				</form>
				<p class="closeBtn xy-center" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></p>
			</div>
		</div>
	</div>
</div>
<!-- EDIT EVENT MODAL END -->

<!-- DELETE MODAL ALERT START-->
<div id="dltModal" class="modal fade">
	<div class="modal-dialog modal-confirm modal-dialog-centered">
		<div class="modal-content relClass">
			<p class="closeBtn xy-center" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></p>
			<div class="modal-header flex-column">
				<div class="icon-box">
					<i class="fa-solid fa-xmark"></i>
				</div>
				<h4 class="modal-title w-100">Are you sure?</h4>
			</div>
			<div class="modal-body p-0">
				<p>Do you really want to delete this event? This process cannot be undone.</p>
			</div>
			<input type="hidden" name="" id="event_id" value="" />
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger delete_event">Delete</button>
			</div>
		</div>
	</div>
</div>
<!-- DELETE MODAL ALERT END-->



@endsection
@section('additional_scripts')

<script>
	$(document).ready(() => {


		startTime = "{{$venue->start_time}}"
		endTime = "{{$venue->end_time}}"
		capacity = "{{$venue->capacity}}"




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
		converted_start_time = convertTime12to24(startTime);
		converted_end_time = convertTime12to24(endTime);
		$("#start_time1").on("change", function() {
			this_refrence = $(this);
			var st_time = this_refrence.val();
			if (st_time < converted_start_time) {
				not(`Start Time should be greater than ${startTime}`, 'error')
				this_refrence.val('')
				return;
			}
			if (st_time > converted_end_time) {

				not(`Start Time should be less than ${endTime}`, 'error')
				this_refrence.val('')
				return;
			}
		});

		$("#end_time1").on("change", function() {
			this_refrence = $(this);
			var end_time = this_refrence.val();
			if (end_time < converted_start_time) {
				not(`End Time should be greater than ${startTime}`, 'error')
				this_refrence.val('')
				return;
			}
			if (end_time > converted_end_time) {
				not(`End Time should be less than ${endTime}`, 'error')
				this_refrence.val('')
				return;
			}


		});
		$(document).on('focusin', '#start_time', function() {
				$(this).data('val', $(this).val());
			})
			.on("change", "#start_time", function() {
				var prev = $(this).data('val');
				this_refrence = $(this);
				var st_time = this_refrence.val();
				if (st_time < converted_start_time) {
					not(`Start Time should be greater than ${startTime}`, 'error')
					this_refrence.val(prev)
					return;
				}
				if (st_time > converted_end_time) {

					not(`Start Time should be less than ${endTime}`, 'error')
					this_refrence.val(prev)
					return;
				}
			});





		$(document).on('focusin', '#end_time', function() {
				$(this).data('val', $(this).val());
			})
			.on("change", "#end_time", function() {
				var prev = $(this).data('val');

				this_refrence = $(this);
				var end_time = this_refrence.val();
				if (end_time < converted_start_time) {
					not(`End Time should be greater than ${startTime}`, 'error')
					this_refrence.val(prev)
					return;
				}
				if (end_time > converted_end_time) {
					not(`End Time should be less than ${endTime}`, 'error')
					this_refrence.val(prev)
					return;
				}


			});

		$('#create_event').on('submit', function(e) {
			e.preventDefault();

			var title = $('#title1').val()
			var event_capacity = $('#event_capacity1').val()
			var detail = $('#detail1').val()
			var date = $('#date1').val()
			var start_time = $('#start_time1').val()
			var end_time = $('#end_time1').val()
			var author = $('#user_id1').val();

			if (!title) {
				not('Event Title Field is required', 'error')
				return;
			} else if (!event_capacity) {
				not('Event Capacity Field is required', 'error')
				return;

			} else if (parseInt(event_capacity) > parseInt(capacity)) {
				not(`Event capacity can not be greater than ${capacity}`, 'error')
				return;

			} else if (!detail) {
				not('Event Detail Field is required', 'error')
				return;

			} else if (detail.length > 250) {
				not('Event Detail can not be greater than 250 characters', 'error')
				return;

			} else if (!date) {
				not('Date Field is required', 'error')
				return;
			} else if (!start_time) {
				not('Start Time Field is required', 'error')
				return;
			} else if (!end_time) {
				not('End Time Field is required', 'error')
				return;
			}
			// else if (  end_time < start_time) {
			// 	not('End Time Should be greater than end time', 'error')
			// 	return;
			// }
			else if (!author) {
				not('Please select Artist', 'error')
				return;
			}
			e.currentTarget.submit();



		});

		$('#update_event').on('submit', function(e) {
			e.preventDefault();
			var title = $('#title').val()
			var event_capacity = $('#event_capacity').val()
			var detail = $('#detail').val()
			var date = $('#date').val()
			var start_time = $('#start_time').val()
			var end_time = $('#end_time').val()
			var author = $('#user_id').find(":selected").val();
		
			
			if (!title) {
				not('Event Title Field is required', 'error')
				return;
			} else if (!event_capacity) {
				not('Event Capacity Field is required', 'error')
				return;

			} else if (parseInt(event_capacity) > parseInt(capacity)) {
				not(`Event capacity can not be greater than ${capacity}`, 'error')
				return;

			} else if (!detail) {
				not('Event Detail Field is required', 'error')
				return;

			} else if (detail.length > 250) {
				not('Event Detail can not be greater than 250 characters', 'error')
				return;

			} else if (!date) {
				not('Date Field is required', 'error')
				return;
			} else if (!start_time) {
				not('Start Time Field is required', 'error')
				return;
			} else if (!end_time) {
				not('End Time Field is required', 'error')
				return;
			}
			
			else if ( !author) {
				not('Please Select Author', 'error')
				return;
			}
			e.currentTarget.submit();



		});


		$('.editIcon').click(function() {
			event_id = $(this).attr("data-id")

			$.ajax({
				url: "{{url('admin/event-detail')}}",
				data: {
					event_id
				},
				dataType: 'json',
				success: function(response, textStatus, jqXHR) {
					if (response.success == 1) {
						data = response.data
						// console.log(data,'data')
						$(".edit").attr("disabled", false);
						$('.update_event_button').show();

						start = data.start_time
						end = data.end_time

						date = new Date(data.date)
						current_date = new Date();
						// console.log(date, 'date', current_date, 'current_date')

						if (start.includes("AM")) {
							start_time = start.replace("AM", '').trim()
						} else {
							start_time = start.replace("PM", '').trim()
						}

						if (end.includes("AM")) {
							end_time = end.replace("AM", '').trim()
						} else {
							end_time = end.replace("PM", '').trim()
						}


						$('#title').val(data.title)
						$('#event_capacity').val(data.event_capacity)
						$('#location').val(data.location)
						$('#detail').val(data.detail)
						$('#date').val(data.date)
						$('#start_time').val(start_time)
						$('#end_time').val(end_time)
						$('#id').val(data.id)
						let images = data.images;
						images_count = images.length;
						// console.log(images.length)
						if (images_count >= 5) {
							$('#editfiles').attr('disabled', 'disabled');
						}
						$('#images_count').val(images_count)

						$('#images').html('')
						if (current_date > date) {
							$(".edit").attr("disabled", true);
							$('.update_event_button').hide();
						}
						images.map(function(image) {
							let image2 =
								`<div class="col-lg-3 col-md-4 col-sm-6 col-6" class="y">
								<div class="upImge">
									<img src="${image.image_url}" alt="img" class="w-100">
									<a  class="removeImg xy-center" >
										<i class="fa-solid fa-xmark delete_image" data-id="${image.id}"></i>
									</a>
								</div>
							</div>`;

							$('#images').append(image2)
						})

						console.log(data)
						var artist_id = data.artist_status?.user?.id;
						
						$("div#user_id select.select option").each(function() {
							if ($(this).val() == artist_id) { // EDITED THIS LINE
								$(this).attr("selected", "selected");
							}
							if (data.created_by_artist || data.artist_status?.interested || current_date > date) {

								$(this).attr("disabled", true);
							}
						});


					} else {
						// toastr.error(response.message, 'error');
					}

				}
			});
		})
		$(document).on("click", ".delete_event", function() {
			event_id = $('#event_id').val()
			// $(document).


			$.ajax({
				url: "{{url('admin/delete-event')}}",
				data: {
					event_id
				},
				dataType: 'json',
				success: function(response, textStatus, jqXHR) {
					if (response.success == 1) {
						$('#dltModal').modal('hide');
						data = response.data
						window.location.reload()
						not("Deleted Successfully", 'success');
					} else {
						// toastr.error(response.message, 'error');
					}

				}
			});


		});
		$('.deleteIcon').click(function() {
			event_id = $(this).attr("data-id")
			$('#event_id').val(event_id)
		})
		$(document).on('click', '.delete_image', function() {

			image_id = $(this).attr('data-id')
			if (!confirm("Do you really want to delete this Image?")){
				return;
			}
			that = $(this);
			$.ajax({
				url: "{{url('admin/delete-image')}}",
				data: {
					image_id
				},
				dataType: 'json',
				success: function(response, textStatus, jqXHR) {
					if (response.status == 1) {
						 $(that).parent().parent().parent().remove()
						not("Image Removed ", 'success')
						$('#images_count').val(parseInt($("#images_count").val()) - 1)
						$('#editfiles').attr('disabled', false);



					} else {}

				}
			});
		});
		



	});
</script>
@endsection