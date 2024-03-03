@extends('layouts.app')
@section('content')
    <div id="basicUsage" class="mb-5">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-6 -->
            <div class="col-xl-12">
                <div id="bootstrapTable" class="mb-5">
                    <h5 class="flex-grow-1 d-inline-block mb-3">Reseller Reports</h5>
                    <x-topup-list route="reseller_reports" :resellers="$resellers" :topups="$topups" :operators="$operators" :countries="$countries"/>
                </div>
            </div>
            <!-- END col-6 -->
        </div>
        <!-- END row -->
    </div>
@endsection
