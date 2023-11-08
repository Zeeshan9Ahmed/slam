@extends('layout.master')

@section('content')
<div class="tableWrap overFlow">

    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event Title</th>
                <th>Event Details</th>
                <th>Location</th>
                <th>No of Reports</th>
                <th>Date & Time</th>
                <th>Reported User's Details</th>
                <th class="text-center">Actions</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($reported_events as $key =>$event)
            <tr>
                @php
                $index = $key;
                @endphp
                <td class="text-center">{{++$key}}</td>
                <td>{{$event->events?->title}}</td>
                <td><p class="eventDetail111">{{$event->events?->detail}}</p></td>
                <td>{{$event->events?->location}}</td>
                <td>{{count($event->events?->reported_users)}}</td>
                <td>
                    <p class="eveDate">
                        <span>{{$event->events?->date}}</span>
                        <span>{{$event->events?->start_time}} - {{$event->events?->end_time}}</span>
                    </p>
                </td>
                <td>
                    <div class="btnWrap xy-center">
                        <a href="#userDetailModal" class="view trashIcon xy-center" data-id="{{$index}}" data-bs-toggle="modal">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                </td>
                <td class="text-center approve" data-id="{{$event->event_id}}"><button>Approve</button></td>
				<td class="text-center reject" data-id="{{$event->event_id}}"><button>Reject</button></td>

            </tr>
            @endforeach


        </tbody>
    </table>
</div>

<!-- DELETE MODAL ALERT START-->
<div id="userDetailModal" class="modal fade">
    <div class="modal-dialog modal-confirm modal-dialog-centered">
        <div class="modal-content relClass">
            <p class="closeBtn xy-center" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></p>
            <div class="modal-header flex-column">
                <h4 class="modal-title w-100 mt-0 mb-2 text-dark">Reported Users</h4>
            </div>
            <div class="modal-body p-0" id="users_list">

                
               
            </div>
        </div>
    </div>
</div>
<!-- DELETE MODAL ALERT END-->





@endsection
@section('additional_scripts')

<script>
    $(document).ready(function() {
        var data = <?php echo json_encode($reported_events); ?>;
        image = "{{asset('assets/images/avatar.png')}}"
        $(document).on('click','.view', function(){
            event_index = $(this).attr('data-id')
            var users = data[event_index].events.reported_users
            html = '';

            $(users).each(function(index, user){
                html += `<ul class="list-unstyled text-start userList1">
                    <li class="mb-2">
                        Name: <span>${user.full_name}</span>
                    </li>
                    <li class="mb-2">
                        Email: <span>${user.email}</span>
                    </li>
                    <li class="mb-2 d-flex flex-column">
                        Image: <span><img src="${user.avatar??image}" alt="img"></span>
                    </li>
                </ul>`;
            })
            
            $('#users_list').html(html)
        });


        $('.approve').click(function() {
			event_id = $(this).attr("data-id")
			
			$.ajax({
				url: "{{url('admin/approve-reported/event')}}",
				data: {
					"_token": "{{ csrf_token() }}",
					event_id,
					
				},
				method: "POST",
				dataType: 'json',
				success: function(response, textStatus, jqXHR) {
					

					if (response.success == 1) {
					
						not('Approved Successfully', 'success')
						window.location.reload()

					} else {
						// toastr.error(response.message,'error');
					}

				}
			});
		})

        $('.reject').click(function() {
			event_id = $(this).attr("data-id")
			type = "reject"
			$.ajax({
				url: "{{url('admin/reject-reported/event')}}",
				data: {
					"_token": "{{ csrf_token() }}",
					event_id,
					type
				},
				method: "POST",
				dataType: 'json',
				success: function(response, textStatus, jqXHR) {
				
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