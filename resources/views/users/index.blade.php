@extends('layouts.app')
@section('content')
<x-messages />
<div class="d-flex align-items-center mb-2">
    <h1 class="page-header"> Users List</h1>
    <div class="ms-auto">
        <a href="{{ route('users.create') }}" class="submtting_pack btn btn-primary btn-sm form-control"><i class="submtting_pack fa fa-plus-circle fa-fw me-1"></i> Add User</a>
    </div>
</div>
<div class="table-responsive mb-3">
    <table class="table table-bordered">
        <tr class="text-center">
            <th data-sortable="true">No</th>
            <th data-sortable="true">User Avatar</th>
            <th data-sortable="true">User Name</th>
            <th data-sortable="true">User Email</th>
            <th data-sortable="true">User Business</th>
            <th data-sortable="true">User Role</th>
            <th data-sortable="true">Active</th>
            <th data-sortable="true">Actions</th>
        </tr>
        @foreach ($users as $user)
            <tr class="text-center">
                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                <td>
                        @if ($user->avatar && $user->avatar != 'avatar.png')
                        <img src="{{ asset('/storage/uploads/' . $user->avatar) }}" width="50" class="rounded-circle" height="50" alt="{{$user->name}} avatar">
                    @else
                            <img src="{{ asset('assets/img/user/avatar.png') }}" width="50" height="50"
                            alt="user avatar">
                    @endif
                </td>                                        
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->business_type ? $user->business_type : 'Not Set' }}</td>
                <td>{{ $user->user_role }}</td>
                <td>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="status_{{ $user->id }}" name="status" value="1" {{ $user->status == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_{{ $user->id }}">{{ $user->status == 1 ? 'On' : 'Off' }}</label>
                    </div>
                </td>
                <td>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" id="user-delete-form-{{ $user->id }}">
                        <button type="button" class="btn btn-primary btn-sm">
                            <a href="{{ route('users.edit', $user->id) }}" class="submtting_pack dropdown-item d-flex align-items-center">{{ __('Modify User') }}</a>
                        </button>
                        @csrf
                        @method('DELETE')
                        <!-- <button type="button" class="btn btn-danger btn-sm delete-user" data-user-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button> -->
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {!! $users->links() !!}
</div>
@endsection
