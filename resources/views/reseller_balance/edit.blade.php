@extends('layouts.app')
@section('content')
    <div id="tableHeadOptions" class="mb-5">
        <div class="d-flex align-items-center mb-2">
            <h1 class="page-header">Revert Balance</h1>
        </div>
        <div class="card">
            <div class="card-body pb-2">
                <x-validationErrors />
                <form action="{{ route('resellers_update_balance', $reseller->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-hovered ">
                                <tbody>
                                    <tr class="border-top border-bottom">
                                        <td>Current Balance: </td>
                                        <td>{{ $reseller->balance }}</td>
                                    </tr>
                                    <tr class="border-top border-bottom">
                                        <td>Name: </td>
                                        <td>{{ $reseller->name }}</td>
                                    </tr>
                                    <tr class="border-top border-bottom">
                                        <td>Mobile: </td>
                                        <td>{{ $reseller->mobile_no }}</td>
                                    </tr>
                                    <tr class="border-top border-bottom">
                                        <td>Email: </td>
                                        <td>{{ $reseller->email }}</td>
                                    </tr>
                                    <tr class="border-top border-bottom">
                                        <td>Revert Amount</td>
                                        <td>
                                            <input type="number" name="balance_amount" class="form-control">
                                            <input type="hidden" name="id" value="{{ $reseller->id }}" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mb-4 d-flex w-100 justify-content-between">
                        <a href="{{ route('manage_resellers') }}" class="submtting_pack btn btn-danger btn-lg">Cancel</a>
                        <button type="Submit" class="submtting_pack btn btn-success btn-lg">Revert</button>
                    </div>
                </form>
            </div>
            <div class="card-arrow">
                <div class="card-arrow-top-left"></div>
                <div class="card-arrow-top-right"></div>
                <div class="card-arrow-bottom-left"></div>
                <div class="card-arrow-bottom-right"></div>
            </div>
        </div>
    </div>
@endsection
