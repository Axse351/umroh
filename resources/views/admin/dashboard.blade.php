@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('breadcrumb')
    <div class="breadcrumb-item active">Dashboard</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total User</h4>
                    </div>
                    <div class="card-body">0</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Selamat Datang, Admin!</h4>
                </div>
                <div class="card-body">
                    <p>Anda login sebagai <strong>Administrator</strong>.</p>
                </div>
            </div>
        </div>
    </div>
@endsection