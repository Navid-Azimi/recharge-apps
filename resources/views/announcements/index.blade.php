@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="d-flex align-items-center mb-3">
            <h1 class="page-header">All Announcements</h1>
            <div class="ms-auto">
                <a href="{{ route('announcements.create') }}" class="submtting_pack btn btn-primary btn-sm form-control"><i
                        class="fa fa-plus-circle fa-fw me-1"></i> Add Announcement</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <x-messages />
        </div>
    </div>
    <table class="table table-bordered">
        <tr class="text-center">
            <th>No</th>
            <th>Logo</th>
            <th>Country</th>
            <th>Announcement</th>
            <th>Created At</th>
            <th width="280px">Action</th>
        </tr>
        @if (count($announcements) > 0)
            @foreach ($announcements as $announcement)
                <tr class="text-center">
                    <td>{{ ($announcements->currentPage() - 1) * $announcements->perPage() + $loop->iteration }}</td>
                    <td>
                        @if ($announcement->ann_logo)
                            <img src="{{ asset('/storage/uploads/' . $announcement->ann_logo) }}" width="50"
                                height="50" alt="announcement logo">
                        @else
                            <img src="{{ asset('assets/img/user/place.png') }}" width="50" height="50"
                                alt="announcement logo">
                        @endif
                    </td>
                    <td>{{ $announcement->ann_country }}</td>
                    <td class="text-start">{!! $announcement->text !!}</td>
                    <td>{{ $announcement->created_at->format('d-m-Y') }}</td>
                    <td class="d-flex gap-2 justify-content-center">
                        <a class="submtting_pack btn btn-primary btn-sm"
                            href="{{ route('announcements.edit', $announcement->id) }}">Edit</a>
                        <form class="m-0" action="{{ route('announcements.destroy', $announcement->id) }}" method="POST"
                            id="announcement-delete-form-{{ $announcement->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="  btn btn-danger btn-sm delete-announcement" data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                                data-announcement-id="{{ $announcement->id }}">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7">No records yet!</td>
            </tr>
        @endif
    </table>
    {!! $announcements->links() !!}
    <!-- BEGIN #modal -->
    <div id="exampleModal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title">Delete Announcement</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal-body">
                            <div class="panel">
                                <div class="panel-body text-center py-2">
                                    <h3> Are you sure you want to delete this Announcement?</h3>
                                </div>
                                <div class="form-group mybody mt-2 d-flex justify-content-between mb-3">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-arrow">
                        <div class="card-arrow-top-left"></div>
                        <div class="card-arrow-top-right"></div>
                        <div class="card-arrow-bottom-left"></div>
                        <div class="card-arrow-bottom-right"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END #modal -->
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        deleteWithModalConfirmation('delete-announcement', '#exampleModal', 'announcement_deletor',
            'announcement-delete-form-', 'announcement');
    });
</script>
