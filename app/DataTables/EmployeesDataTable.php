<?php

namespace App\DataTables;

use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class EmployeesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function (Employee $employee) {
                return $employee->created_at->format('d M Y, h:i a');
            })
            ->editColumn('date_of_birth', function (Employee $employee) {
                return $employee->date_of_birth ? $employee->date_of_birth->format('d M Y') : '-';
            })
            ->editColumn('date_of_joining', function (Employee $employee) {
                return $employee->date_of_joining ? $employee->date_of_joining->format('d M Y, h:i a') : '-';
            })
            ->addColumn('action', function (Employee $employee) {
                $pageData = [
                    'row' => $employee,
                ];
                return view('pages.apps.employees.columns._actions', $pageData);
            })
            ->setRowId('id');
    }


    /**
     * Get the query source of dataTable.
     */
    public function query(Employee $model): QueryBuilder
    {
        return $model->with(['user','branch','designation','department']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $canExport = Auth::user()->hasPermissionTo('export employees management');
        $export = [];
        if ($canExport === true) {
            $export = [
                [
                    'extend' => 'collection',
                    'className' => 'btn btn-secondary btn-sm',
                    'text' => __('Export'),
                    'buttons'   => [
                        [
                            'extend' => 'csvHtml5',
                            'text' => __('CSV'),
                            'filename' => $this->filename(),
                            'exportOptions' => [
                                'columns' => [2, 3, 4, 5, 6, 8, 9, 10],
                                'filename' => $this->filename()
                            ]
                        ],
                        [
                            'extend' => 'excelHtml5',
                            'text' => __('Excel'),
                            'filename' => $this->filename(),
                            'title' => '',
                            'exportOptions' => [
                                'columns' => [2, 3, 4, 5, 6, 8, 9, 10],
                                'filename' => $this->filename()
                            ]
                        ],
                    ]
                ]
            ];
        }
        return $this->builder()
            ->setTableId('employees-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'
                            <'col-sm-12 col-md-12 d-flex justify-content-between gap-2 py-2 align-items-end' B <'#import.import-container'> >
                            <'col-sm-12 col-md-12 gap-2 py-2 ' <'table-responsive ' rt > >
                            <'col-sm-12 col-md-6 d-flex justify-content-start gap-2 py-2 'li>
                            <'col-sm-12 col-md-6 d-flex justify-content-end 'p>
                        >")
            ->addTableClass('table align-middle fs-6 gy-2 dataTable no-footer table-hover fw-semibold table-sm w-100 border gx-1 gy-2 w-100 display nowrap rounded-2')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase bg-light-secondary')
            ->orderBy(0)
            ->parameters([
                'buttons' =>  $export,
            ])
            ->autoWidth()
            ->lengthMenu([[10, 25, 50, 100, 250, 500], [10, 25, 50, 100, 250, 'All']])
            ->drawCallback("function() { " . file_get_contents(public_path('assets/js/custom/configurations/employees/listCallbacks.js')) . " }");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('created_at')
                ->exportable(false)
                ->printable(false)
                ->visible(false)
                ->orderable()
                ->responsivePriority(-1),
            Column::computed('action')
                ->title('')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->addClass('text-center w-40px px-2')
                ->responsivePriority(-1),
            Column::make('user.name')->name('user.name')->title('Name')->addClass('border'),
            Column::make('user.email')->name('user.email')->title('Email')->addClass('border'),
            Column::make('branch.name')->name('branch.name')->title('Branch')->addClass('border'),
            Column::make('designation.name')->name('designation.name')->title('Designation')->addClass('border'),
            Column::make('department.name')->name('department.name')->title('Department')->addClass('border'),
            Column::make('date_of_birth')->name('date_of_birth')->title('DOB')->visible(false)->exportable(false)->addClass('border'),
            Column::make('date_of_joining')->name('date_of_joining')->title('DOJ')->addClass('text-start border'),
            Column::make('employee_code')->name('employee_code')->title('Employee Code')->addClass('text-start border'),
            Column::make('user.status')->name('user.status')->title('Status')->addClass('border'),
            Column::make('created_at')->name('created_at')->title('Created Date')->addClass('text-start w-200px border'),
        ];
    }
    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'WEmployee_' . date('YmdHis');
    }
}
