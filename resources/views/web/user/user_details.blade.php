@extends('layout.master')
@section('content')
<div class="tableWrap overFlow">
    <table id="table_id" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>User Role</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($users->users_list as $key=>$user)
            <tr>
                <td class="text-center">{{++$key}}</td>
                <td>{{$user->full_name??""}}</td>
                <td>{{$user->email??""}}</td>
                <td>{{$user->role == "artist"?"Artist":"Guest"}}</td>
                <td class="text-center"><a href="{{url('admin/user', $user->id)}}">View Profile</a></td>
            </tr>
            @endforeach



        </tbody>
    </table>
</div>
@endsection