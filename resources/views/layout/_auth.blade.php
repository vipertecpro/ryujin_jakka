@extends('layout.master')

@section('content')
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-5 order-2 order-lg-1">
                <div class="fade-overlay"></div>
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-100 w-md-75 p-5">
                        {{ $slot }}
                    </div>
                </div>
            </div>
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-position-center order-1 order-lg-2 gradient-background1" >
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                    <a href="{{ route('dashboard') }}" class="mb-12">
                        <img alt="Logo" src="{{ getGlobalSetting('logo') ?? image('logos/custom-1.png') }}" class="h-60px h-lg-75px"/>
                    </a>
                    <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20 rounded-xl" src="{{ getGlobalSetting('login_banner') ?? image('misc/auth-screens.png') }}" alt=""/>
                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
                        Fast, Efficient and Productive
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection
