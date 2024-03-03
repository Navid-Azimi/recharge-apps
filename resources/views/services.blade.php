@extends('layouts.app')
@section('content')
@inject('user', 'App\Models\User')
@php $users = $user::latest()->paginate(10); @endphp
    <div class="card-body">
        <table class="table table-bordered mb-0">
            <thead>
                <tr class="text-center">
                    <th>NO</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Gmail</th>
                </tr>
            </thead>
            @foreach ($users as $user)
            <tbody>
                <tr>
                    <td class="text-center">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                        <a href="https://api.whatsapp.com/send?phone={{ $user->mobile_no }}" target="_blank" onclick="return false;">{{ $user->mobile_no }}</a>
                    </td>
                    <td>
                        <a href="https://mail.google.com/mail/u/0/?view=cm&fs=1&tf=1&to={{ $user->email }}" target="_blank">{{ $user->email }}</a>
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
@endsection



