@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="d-flex align-items-center mb-3">
            <h1 class="page-header"> User Configurations</h1>
        </div>
    </div>
   
    @include('layouts.messages')
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th> Name</th>
            <th> Value </th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($configurations as $configuration)
        <tr>
            <td>{{ ($configurations->currentPage() - 1) * $configurations->perPage() + $loop->iteration }}</td>
            <td>{{ $configuration->name }}</td>
            <td>{{ $configuration->value }}</td>
            <td>
                <form action="{{ route('configurations.destroy', $configuration->id) }}" method="POST">
                    <a class="btn btn-primary btn-sm" href="{{ route('configurations.edit',$configuration->id) }}">Edit</a>
                    @csrf
                    @method('DELETE')
                    <!-- <button type="submit" class="btn btn-danger btn-sm">Delete</button> -->
                </form>
            </td>
        </tr>

        @endforeach

    </table>
@endsection