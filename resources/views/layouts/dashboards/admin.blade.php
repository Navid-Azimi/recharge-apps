@extends('layouts.app')
@section('content')

<link href="css/dashboard-styles.css" rel="stylesheet">

<div id="basicUsage" class="mb-5">

    <!-- BEGIN row -->
    <div class="row">

        @include('layouts.statistics')

         <!-- BEGIN col-6 -->
        @if(Auth::user()->user_role == 'reseller')
        <div class="col-xl-12">
            <div id="bootstrapTable" class="mb-5">
                <span class="flex-grow-1">Recent Topups</span>
                @include('layouts.topup_list')
            </div>
        </div>
        @endif
        <!-- END col-6 -->

    </div>
    <!-- END row -->

</div>


@endsection
