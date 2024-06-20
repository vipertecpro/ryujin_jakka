<x-auth-layout  :title="$title">
    <form class="form w-100" novalidate="novalidate" method="POST" id="kt_sign_in_form" data-kt-redirect-url="{{ route('dashboard') }}" action="{{ route('login') }}">
        @csrf
        <div class="text-center mb-11">
            <h1 class="text-gray-900 fw-bolder mb-3">
                Sign In
            </h1>
        </div>
        <div class="fv-row mb-5">
            <label class="form-label fs-6 text-active-gray-800" for="email">Email</label>
            <input type="text" placeholder="Enter email address" name="email" id="email" autocomplete="off" class="form-control form-control-sm" />
        </div>
        <div class="fv-row mb-5">
            <label class="form-label fs-6 text-active-gray-800" for="password">Password</label>
            <input type="password" placeholder="Enter the password" name="password" id="password" autocomplete="off" class="form-control form-control-sm"/>
        </div>
        <div class="d-grid mb-5">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary btn-sm">
                @include('partials/general/_button-indicator', ['label' => 'Submit'])
            </button>
        </div>
    </form>
</x-auth-layout>
