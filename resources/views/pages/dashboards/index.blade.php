<x-default-layout :title="$title" >

    @section('title')
        {{ $title }}
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('dashboard') }}
    @endsection
    <div class="row gx-5 gx-xl-10">
{{--        <div class="col-xxl-6 mb-5 mb-xl-10">--}}
{{--            @include('partials/widgets/charts/_widget-8')--}}
{{--        </div>--}}
        <div class="col-xxl-12 mb-5 mb-xl-12">
            @include('partials/widgets/tables/_widget-16')
        </div>
{{--        <div class="col-xxl-6 mb-5 mb-xl-10">--}}
{{--            @include('partials/widgets/tables/_widget-14')--}}
{{--        </div>--}}
    </div>
</x-default-layout>
