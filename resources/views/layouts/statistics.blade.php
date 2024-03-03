<!-- BEGIN col-3 -->
<div class="col-xl-3 col-lg-6">
    <!-- BEGIN card -->
    <div class="card mb-3">
        <!-- BEGIN card-body -->
        <div class="card-body">
            <!-- BEGIN title -->
            <div class="d-flex fw-bold small mb-3">
                <span class="flex-grow-1">SUCCESS TOPUPS</span>
                <a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
            </div>
            <!-- END title -->
            <!-- BEGIN stat-lg -->
            <div class="row align-items-center mb-2">
                <div class="col-7">
                    <h3 class="mb-0">{{ $topupCounters["success"] ?? 0 }}</h3>
                </div>
                <div class="col-5">
                    <div class="mt-n3 mb-n2" data-render="apexchart" data-type="pie" data-title="Visitors" data-height="45"></div>
                </div>
            </div>
        </div>
        <!-- END card-body -->

        <!-- BEGIN card-arrow -->
        <div class="card-arrow">
            <div class="card-arrow-top-left"></div>
            <div class="card-arrow-top-right"></div>
            <div class="card-arrow-bottom-left"></div>
            <div class="card-arrow-bottom-right"></div>
        </div>
        <!-- END card-arrow -->
    </div>
    <!-- END card -->
</div>
<!-- END col-3 -->

<!-- BEGIN col-3 -->
<div class="col-xl-3 col-lg-6">
    <!-- BEGIN card -->
    <div class="card mb-3">
        <!-- BEGIN card-body -->
        <div class="card-body">
            <!-- BEGIN title -->
            <div class="d-flex fw-bold small mb-3">
                <span class="flex-grow-1">FAILED TOPUPS</span>
                <a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
            </div>
            <!-- END title -->
            <!-- BEGIN stat-lg -->
            <div class="row align-items-center mb-2">
                <div class="col-7">
                    <h3 class="mb-0">{{ $topupCounters["failed"] ?? 0 }}</h3>
                </div>
                <div class="col-5">
                    <div class="mt-n3 mb-n2" data-render="apexchart" data-type="donut" data-title="Visitors" data-height="45"></div>
                </div>
            </div>
        </div>
        <!-- END card-body -->

        <!-- BEGIN card-arrow -->
        <div class="card-arrow">
            <div class="card-arrow-top-left"></div>
            <div class="card-arrow-top-right"></div>
            <div class="card-arrow-bottom-left"></div>
            <div class="card-arrow-bottom-right"></div>
        </div>
        <!-- END card-arrow -->
    </div>
    <!-- END card -->
</div>
<!-- END col-3 -->

<!-- BEGIN col-3 -->
<div class="col-xl-3 col-lg-6">
    <!-- BEGIN card -->
    <div class="card mb-3">
        <!-- BEGIN card-body -->
        <div class="card-body">
            <!-- BEGIN title -->
            <div class="d-flex fw-bold small mb-3">
                <span class="flex-grow-1">TOTAL CUSTOMERS</span>
                <a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
            </div>
            <!-- END title -->
            <!-- BEGIN stat-lg -->
            <div class="row align-items-center mb-2">
                <div class="col-7">
                    <h3 class="mb-0">{{ $userCounters["customer"] ?? 0 }}</h3>
                </div>
                <div class="col-5">
                    <div class="mt-n2" data-render="apexchart" data-type="bar" data-title="Visitors" data-height="30"></div>
                </div>
            </div>
        </div>
        <!-- END card-body -->

        <!-- BEGIN card-arrow -->
        <div class="card-arrow">
            <div class="card-arrow-top-left"></div>
            <div class="card-arrow-top-right"></div>
            <div class="card-arrow-bottom-left"></div>
            <div class="card-arrow-bottom-right"></div>
        </div>
        <!-- END card-arrow -->
    </div>
    <!-- END card -->
</div>
<!-- END col-3 -->

@if(Auth::user()->user_role == 'admin')
<!-- BEGIN col-3 -->
<div class="col-xl-3 col-lg-6">
    <!-- BEGIN card -->
    <div class="card mb-3">
        <!-- BEGIN card-body -->
        <div class="card-body">
            <!-- BEGIN title -->
            <div class="d-flex fw-bold small mb-3">
                <span class="flex-grow-1">TOTAL RESELLERS</span>
                <a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
            </div>
            <!-- END title -->
            <!-- BEGIN stat-lg -->
            <div class="row align-items-center mb-2">
                <div class="col-7">
                    <h3 class="mb-0">{{ @$userCounters["reseller"] }}</h3>
                </div>
                <div class="col-5">
                    <div class="mt-n2" data-render="apexchart" data-type="line" data-title="Visitors" data-height="30"></div>
                </div>
            </div>
        </div>
        <!-- END card-body -->

        <!-- BEGIN card-arrow -->
        <div class="card-arrow">
            <div class="card-arrow-top-left"></div>
            <div class="card-arrow-top-right"></div>
            <div class="card-arrow-bottom-left"></div>
            <div class="card-arrow-bottom-right"></div>
        </div>
        <!-- END card-arrow -->
    </div>
    <!-- END card -->
</div>
<!-- END col-3 -->

<!-- BEGIN col-6 ------------------TRAFFIC ANALYTICS----------------------->
<div class="col-xl-6">
    <!-- BEGIN card -->
    <div class="card mb-3">
        <!-- BEGIN card-body -->
        <div class="card-body">
            <!-- BEGIN title -->
            <div class="d-flex fw-bold small mb-3">
                <span class="flex-grow-1">TRAFFIC ANALYTICS</span>
                <a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
            </div>
            <!-- END title -->
            <!-- BEGIN map -->
            <div class="ratio ratio-21x9 mb-3">
                <div id="world-map" class="jvectormap-without-padding"></div>
            </div>
            <!-- END map -->
            <!-- BEGIN row -->
            <div class="row gx-4">
                <!-- BEGIN col-6 -->
                <div class="col-lg-12 mb-3 mb-lg-0">
                    <table class="w-100 small mb-0 text-truncate text-inverse text-opacity-60">
                        <thead>
                            <tr class="text-inverse text-opacity-75">
                                <th class="w-50 bg-transparent text-inverse">COUNTRY</th>
                                <th class="w-25 bg-transparent text-inverse">VISITS</th>
                                <th class="w-25 bg-transparent text-inverse">PCT%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($countries_visits->count() > 0)
                                @foreach ($countries_visits as $visit )
                                     <tr>
                                        <td>{{ $visit->country ? $visit->country: 'Not Specified' }}</td>
                                        <td>{{ $visit->topup_count }}</td>
                                        <td>{{ $visit->percentage}}%</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END card-body -->

        <!-- BEGIN card-arrow -->
        <div class="card-arrow">
            <div class="card-arrow-top-left"></div>
            <div class="card-arrow-top-right"></div>
            <div class="card-arrow-bottom-left"></div>
            <div class="card-arrow-bottom-right"></div>
        </div>
        <!-- END card-arrow -->
    </div>
    <!-- END card -->
</div>
<!-- BEGIN col-6 ------------------TRAFFIC ANALYTICS----------------------->

<!-- BEGIN col-6 ------------------PACKAGES LIST----------------------->
<div class="col-xl-6">
    <!-- BEGIN card -->
    <div class="card mb-3">
        <!-- BEGIN card-body -->
        <div class="card-body">
            <!-- BEGIN title -->
            <div class="d-flex fw-bold small mb-4">
                <span style="margin-bottom: 0.8rem;" class="flex-grow-1">PACKAGES LIST</span>
                <a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
            </div>
            <!-- END title -->
            <!-- BEGIN table -->
            <div class="table-responsive">
                <table class="w-100 mb-0 small align-middle text-nowrap">
                    <tbody>
                        @php $count = 0; @endphp
                        @foreach ($packages as $package)
                            <tr class="{{ $count < 4 ? '' : 'hidden' }}">
                                <td>
                                    <div class="d-flex mb-3 align-items-center">
                                        <div class="position-relative">
                                            @if ($package->network && $package->network->ntw_logo)
                                                <div class="bg-position-center bg-size-cover bg-repeat-no-repeat w-80px h-60px"
                                                    style="background-image: url({{ asset('/storage/uploads/' . $package->network->ntw_logo) }});">
                                                </div>
                                            @else
                                                <div class="bg-position-center bg-size-cover bg-repeat-no-repeat w-80px h-60px"
                                                    style="background-image: url({{ asset('assets/img/user/place.png') }});">
                                                </div>
                                            @endif
                                            <div class="position-absolute top-0 start-0 " style="margin-left: -24px;">
                                                <span class="babadge bg-theme text-theme-900 rounded-0 d-flex align-items-center justify-content-center w-20px h-20px"
                                                    Title="Commissions">{{ intval($package->general_comm) }}</span>
                                            </div>
                                        </div>
                                        <div class="flex-1 ps-3">
                                            <div class="mb-1"><small class="fs-9px fw-500 lh-1 d-inline-block rounded-0 badge bg-secondary bg-opacity-25 text-inverse text-opacity-75 pt-5px">Package Type</small></div>
                                            <div class="text-inverse fw-500">{{ $package->pck_type }}</div>
                                            {{ $package->pck_price }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <table class="mb-2">
                                        <tr>
                                            <td class="text-inverse">Country Fee: </td>
                                            <td class="text-inverse text-opacity-75 fw-500"> {{ $package->pck_country }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-inverse">Internal Fee: </td>
                                            <td class="text-inverse text-opacity-75 fw-500"> {{ $package->interior_charges }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-inverse">External: Fee</td>
                                            <td class="text-inverse text-opacity-75 fw-500"> {{ $package->outdoor_charges }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @php $count++; @endphp
                        @endforeach
                        @if ($count > 4)
                            <tr id="see-more-row">
                                <td colspan="3">
                                    <a href="#" id="see-more" >See More</a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!-- END table -->
        </div>
        <!-- END card-body -->

        <!-- BEGIN card-arrow -->
        <div class="card-arrow">
            <div class="card-arrow-top-left"></div>
            <div class="card-arrow-top-right"></div>
            <div class="card-arrow-bottom-left"></div>
            <div class="card-arrow-bottom-right"></div>
        </div>
        <!-- END card-arrow -->
    </div>
    <!-- END card -->
</div>
<!-- BEGIN col-6 ------------------PACKAGES LIST----------------------->

@endif

<script>
    // passing dynamic markers for the visited countries to the js file (don't remove this)
     var dynamicMarkers = @json($dynamicMarkers); 
</script>

<script>
    //See more option in package lists
    document.getElementById("see-more").addEventListener("click", function(e) {
        e.preventDefault(); // Prevent the link from following the href
        var hiddenRows = document.querySelectorAll('.hidden');
        for (var i = 0; i < hiddenRows.length; i++) {
            hiddenRows[i].classList.remove('hidden');
        }
        document.getElementById("see-more-row").style.display = 'none';
    });
</script>