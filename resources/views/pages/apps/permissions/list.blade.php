<x-default-layout :title="$title">
    @section('title')
        {{ $title }}
    @endsection
    @section('breadcrumbs')
        {{ Breadcrumbs::render('permissions.index') }}
    @endsection
    <div class="card">
        <div class="card-header border-0 pt-2">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-2 position-absolute ms-5') !!}
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-sm w-300px ps-13" placeholder="Search permission" id="mySearchInput" />
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end gap-2" data-kt-user-table-toolbar="base">
                    @if(Auth::user()->hasPermissionTo('import permissions management'))
                        <input type="file" id="import-sheet" data-kt-action="import-file" data-kt-import-url="{{ route('permissions.import') }}" accept=".csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel" style="left: -100%; top: -100%; position: absolute;"/>
                        <a href="#" class="btn btn-light-dark border border-dark btn-sm" data-kt-action="import">
                            {!! getIcon('file', 'fs-4', '', 'i') !!}
                            Import
                        </a>
                    @endif
                    @if(Auth::user()->hasPermissionTo('delete permissions management'))
                        <a href="#" class="btn btn-light-danger btn-sm border border-danger" data-kt-action="remove-all" data-kt-remove-all-url="{{ route('permissions.removeAll') }}" >
                            {!! getIcon('trash', 'fs-4', '', 'i') !!}
                            Remove All Permissions
                        </a>
                    @endif
                    @if(Auth::user()->hasPermissionTo('create permissions management'))
                        <a href="{{ route('permissions.create') }}" type="button" class="btn btn-light-primary border border-primary btn-sm">
                            {!! getIcon('plus', 'fs-4', '', 'i') !!}
                            Add Permission
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
        <script>
            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['permissions-table'].search(this.value).draw();
            });
        </script>
    @endpush

</x-default-layout>
