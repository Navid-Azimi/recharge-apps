@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div id="bootstrapTable" class="mb-5">
                    @include('layouts.topup_list')
                </div>
            </div>
        </div>
    </div>
                
	<!-- table filter links  -->
	<script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-table/dist/bootstrap-table.min.js') }}"></script>
    <!-- table filter links  -->
@endsection

