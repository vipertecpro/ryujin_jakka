<x-default-layout  :title="$title">
    @section('title')
        {{ $title }}
    @endsection
    @section('breadcrumbs')
        {!! $breadcrumbs !!}
    @endsection
    <div class="card">
        <div class="card-header border-0 pt-2">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-2 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-sm w-300px ps-13" placeholder="Search branch" id="dt-search" />
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end gap-2" data-kt-user-table-toolbar="base">
                    @if(Auth::user()->hasPermissionTo('import branch management'))
                        <input type="file" id="import-sheet" data-kt-action="import-file" data-kt-import-url="{{ route('branches.import') }}" accept=".csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel" style="left: -100%; top: -100%; position: absolute;"/>
                        <a href="#" class="btn btn-light-secondary border border-dark btn-sm" data-kt-action="import">
                            {!! getIcon('file', 'fs-4', '', 'i') !!}
                            Import
                        </a>
                    @endif
                    @if(Auth::user()->hasPermissionTo('delete branch management'))
                        <a href="#" class="btn btn-light-danger btn-sm border border-danger" data-kt-action="remove-all" data-kt-remove-all-url="{{ route('branches.removeAll') }}" >
                            {!! getIcon('trash', 'fs-4', '', 'i') !!}
                            Remove All
                        </a>
                    @endif
                    @if(Auth::user()->hasPermissionTo('create branch management'))
                        <a href="{{ route('branches.create') }}" type="button" class="btn btn-light-primary border border-primary btn-sm">
                            {!! getIcon('plus', 'fs-4', '', 'i') !!}
                            Add New
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body py-2">
            {{ $dataTable->table() }}
        </div>
    </div>
    @push('scripts')
        {{ $dataTable->scripts() }}
    @endpush
</x-default-layout>
