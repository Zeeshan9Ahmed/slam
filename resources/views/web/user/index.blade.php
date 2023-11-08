@extends('layout.master')
@section('content')
<div class="tableWrap overFlow">
    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event Title</th>
                <th>Date</th>
                <th>Total Artists</th>
                <th>Total Guests</th>
                
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($events as $key=>$event)
            <tr>
                <td class="text-center">{{++$key}}</td>
                <td>{{$event->title}}</td>
                <td>{{$event->date}}</td>
                <td>{{$event->artists_count  }} </td>
                <td>{{  $event->attendess_count}}</td>
                <td class="text-center"><a href="{{url('admin/event', $event->id)}}">View Users</a></td>
            </tr>
            @endforeach

            

        </tbody>
    </table>
</div>
@endsection