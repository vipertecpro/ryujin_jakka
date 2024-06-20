<x-system-layout>
    <div class="card card-flush w-lg-650px py-5">
        <div class="card-body py-15 py-lg-20">
            <style>
                body {
                    background-image: url('{{ image('auth/bg7.jpg') }}');
                }

                [data-bs-theme="dark"] body {
                    background-image: url('{{ image('auth/bg7-dark.jpg') }}');
                }
            </style>
            <h1 class="fw-bolder fs-2qx text-gray-900 mb-4">
                Unauthorized Access
            </h1>
            <div class="mb-11">
                <img src="{{ image('auth/403-error.png') }}" class="mw-100 mh-300px theme-light-show" alt=""/>
            </div>
            <div class="mb-0">
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary">Return Home</a>
            </div>
        </div>
    </div>
</x-system-layout>
