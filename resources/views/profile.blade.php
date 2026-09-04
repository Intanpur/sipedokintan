@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')

<div class="row justify-content-center">

    <div class="col-md-8">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <div class="text-center">

                    <div class="mb-3">

                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center"
                             style="width:100px;height:100px;font-size:35px;font-weight:bold;">

                            {{ strtoupper(substr(Auth::user()->name,0,1)) }}

                        </div>

                    </div>

                    <h3 class="fw-bold">
                        {{ Auth::user()->name }}
                    </h3>

                    <p class="text-muted">
                        {{ ucfirst(Auth::user()->role) }}
                    </p>

                </div>

                <hr>

                <div class="row mb-3">

                    <div class="col-md-4 fw-bold">
                        Nama
                    </div>

                    <div class="col-md-8">
                        {{ Auth::user()->name }}
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-4 fw-bold">
                        Email
                    </div>

                    <div class="col-md-8">
                        {{ Auth::user()->email }}
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-4 fw-bold">
                        Role
                    </div>

                    <div class="col-md-8">
                        {{ ucfirst(Auth::user()->role) }}
                    </div>

                </div>

                <div class="row mb-3">

                    <div class="col-md-4 fw-bold">
                        Bergabung Sejak
                    </div>

                    <div class="col-md-8">
                        {{ Auth::user()->created_at->format('d F Y') }}
                    </div>

                </div>

                <div class="text-end">

                    <a href="{{ url()->previous() }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection