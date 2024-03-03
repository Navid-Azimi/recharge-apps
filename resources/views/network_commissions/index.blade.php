@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="d-flex align-items-center mb-3">
            <h1 class="page-header">Registered commissions</h1>
            <div class="ms-auto">
                <a href="{{ route('commissions.create') }}" class="btn btn-primary btn-sm form-control"><i class="fa fa-plus-circle fa-fw me-1"></i> Add commission</a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-md-12">
            <x-messages />
        </div>
    </div>   
    
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Network Name</th>
            <th>User Name</th>
            <th>Commission Rrate</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($commissions as $commission)
        <tr>
            <td>{{ ($commissions->currentPage() - 1) * $commissions->perPage() + $loop->iteration }}</td>
            <!-- <td>{{ $commission->com_ntw_id }}</td> -->
            <td>{{ @$commission->network->ntw_name }}</td>
            <td>{{ $commission->user->name }}</td>
            <td>{{ $commission->com_custom_rate }}</td>
            <td>
                <form action="{{ route('commissions.destroy', $commission->id) }}" method="POST">
                    <a class="btn btn-success btn-sm" href="{{ route('commissions.show',$commission->id) }}">Show</a>
                    <a class="btn btn-primary btn-sm" href="{{ route('commissions.edit',$commission->id) }}">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $commissions->links() !!}
      
@endsection