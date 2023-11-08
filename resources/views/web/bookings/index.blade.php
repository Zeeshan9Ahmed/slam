@extends('layout.master')
@section('content')
<div class="tableWrap overFlow">
	<table id="table_id" class="display">
		<thead>
			<tr>
				<th>ID</th>
				<th>Artist Name</th>
				<th>Date</th>
				<th>Time</th>
				<th class="text-center" scope="col">Actions</th>
				<th class="text-center" scope="col">Actions</th>
				<th class="text-center" scope="col">Detail</th>
			</tr>
		</thead>
		<tbody>
			@foreach($events as $key => $event)
			<tr>
				<td class="text-center">{{++$key}}</td>
				<td>{{$event->artist->full_name??"---"}}</td>
				<td>{{\Carbon\Carbon::parse($event->date)->isoFormat('Do MMMM , YYYY')}}</td>
				<td>
					<span>{{$event->start_time}}</span>
					to
					<span>{{$event->end_time}}</span>
				</td>
				<td class="text-center approve" data-id="{{$event->id}}"><button>Approve</button></td>
				<td class="text-center reject" data-id="{{$event->id}}"><button>Reject</button></td>
				<td class="text-center editIcon" data-id="{{$event->id}}" ><button  data-bs-toggle="modal"  data-bs-target="#artistDetail">View Detail</button></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

<div class="modal fade genModal" id="artistDetail" tabindex="-1" aria-labelledby="genModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<p class="heading pb-3">EVENT DETAILS</p>

				<form class="row eventForm">
					<div class="col-12">
						<div class="form-group mb-3">
							<label class="label1">Title</label>
							<input type="text" class="eventInput" id="title" value="" disabled>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group mb-3">
							<label class="label1">Detail</label>
							<textarea class="eventInput textArea" id="detail" value="" disabled></textarea>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group mb-3">
							<label class="label1">Event Capacity</label>
							<input type="text" class="eventInput" id="event_capacity" value="" disabled>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group mb-3">
							<label class="label1">Location</label>
							<textarea class="eventInput textArea" id="location" value="" disabled></textarea>
						</div>
					</div>

					<div class="col-12">
						<div class="form-group mb-3">
							<label class="label1">Date</label>
							<input type="text" class="eventInput" id="date" value="" disabled>
						</div>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="form-group mb-3">
							<label class="label1">Start Time</label>
							<input type="text" class="eventInput" id="start_time" value="" disabled>
						</div>
					</div>

					<div class="col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="form-group mb-3">
							<label class="label1">End Time</label>
							<input type="text" class="eventInput" id="end_time" value="" disabled>
						</div>
					</div>

				</form>
				<p class="closeBtn xy-center" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></p>
			</div>
		</div>
	</div>
</div>
@endsection

@section('additional_scripts')

<script>
	$(document).ready(() => {
		$('.approve').click(function() {
			event_id = $(this).attr("data-id")
			type = "approve"
			$.ajax({
				url: "{{url('admin/approve-reject/event')}}",
				data: {
					"_token": "{{ csrf_token() }}",
					event_id,
					type
				},
				method: "POST",
				dataType: 'json',
				success: function(response, textStatus, jqXHR) {
					console.log(response, 'response')

					if (response.success == 1) {
						// alert("Approved Successfully")
						not('Approved Successfully', 'success')
						window.location.reload()

					} else {
						// toastr.error(response.message,'error');
					}

				}
			});
		})



		$('.editIcon').click(function() {
			event_id = $(this).attr("data-id")
			// alert(event_id)
			$.ajax({
				url: "{{url('admin/event-detail')}}",
				data: {
					event_id
				},
				dataType: 'json',
				success: function(response, textStatus, jqXHR) {
					if (response.success == 1) {
						data = response.data
						
						start = data.start_time
						end = data.end_time
						// console.log(data, 'daaaaaaaaaaata')
						


						$('#title').val(data.title)
						$('#event_capacity').val(data.event_capacity)
						$('#location').val(data.location)
						$('#detail').val(data.detail)
						$('#date').val(data.date)
						$('#start_time').val(start)
						$('#end_time').val(end)
						// $('#id').val(data.id)
						// let images = data.images;

						// images.map(function(image) {
						// 	// console.log(image,'image')	
						// 	let image2 =
						// 		`<div class="col-lg-3 col-md-4 col-sm-6 col-6" class="y">
						// 		<div class="upImge">
						// 			<img src="${image.image_url}" alt="img" class="w-100">
						// 			<a href="#!" class="removeImg xy-center">
						// 				<i class="fa-solid fa-xmark delete_image" data-id="${image.id}"></i>
						// 			</a>
						// 		</div>
						// 	</div>`;

						// 	$('#images').append(image2)
						// })


						// var artist_id = data.event_artist[0]?.user_id;
						// $("div#user_id select.select option").each(function() {
						// 	if ($(this).val() == artist_id) { // EDITED THIS LINE
						// 		$(this).attr("selected", "selected");
						// 	}
						// 	if (data.created_by_artist) {

						// 		$(this).attr("disabled", true);
						// 	}
						// });


					} else {
						// toastr.error(response.message, 'error');
					}

				}
			});
		})

		$('.reject').click(function() {
			event_id = $(this).attr("data-id")
			type = "reject"
			$.ajax({
				url: "{{url('admin/approve-reject/event')}}",
				data: {
					"_token": "{{ csrf_token() }}",
					event_id,
					type
				},
				method: "POST",
				dataType: 'json',
				success: function(response, textStatus, jqXHR) {
					console.log(response, 'response')

					if (response.success == 1) {
						not('Rejected Successfully', 'success')
						window.location.reload()

					} else {
						// toastr.error(response.message,'error');
					}

				}
			});
		})




	});
</script>
@endsection
