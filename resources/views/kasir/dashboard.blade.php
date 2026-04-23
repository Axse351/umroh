@extends('layouts.app')

@section('title', 'Dashboard Kasir')
@section('page-title', 'Dashboard Kasir')

@section('breadcrumb')
    <div class="breadcrumb-item active">Dashboard</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Selamat Datang, Kasir!</h4>
                </div>
                <div class="card-body">
                    <p>Anda login sebagai <strong>Kasir</strong>.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
