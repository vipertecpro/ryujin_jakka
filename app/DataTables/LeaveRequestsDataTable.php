<?php

namespace App\DataTables;

use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LeaveRequestsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (LeaveRequest $LeaveRequest) {
                $pageData = [
                    'row' => $LeaveRequest,
                ];
                return view('pages.apps.leaveRequests.columns._actions', $pageData);
            })
            ->editColumn('created_at', function (LeaveRequest $leaveRequest) {
                return $leaveRequest->created_at->format('d M Y, h:i a');
            })
            ->editColumn('start_date', function (LeaveRequest $leaveRequest) {
                return $leaveRequest->start_date->format('d M Y');
            })
            ->editColumn('end_date', function (LeaveRequest $leaveRequest) {
                return $leaveRequest->end_date->format('d M Y');
            })
            ->editColumn('status', function (LeaveRequest $leaveRequest) {
                $status = $leaveRequest->status;
                $statusClass = 'badge-light-secondary';
                if ($status === 'pending') {
                    $statusClass = 'badge-light-warning';
                } elseif ($status === 'approved') {
                    $statusClass = 'badge-light-success';
                } elseif ($status === 'rejected') {
                    $statusClass = 'badge-light-danger';
                }
                return '<span class=" text-center mx-auto badge badge-light ' . $statusClass . '">' . ucfirst($status) . '</span>';
            })
            ->addColumn('total_days', function (LeaveRequest $leaveRequest) {
                return $leaveRequest->start_date->diffInDays($leaveRequest->end_date);
            })
            ->rawColumns(['action','status'])
            ->setRowId('id');
    }
    /**
     * Get the query source of dataTable.
     */
    public function query(LeaveRequest $model): QueryBuilder
    {
        return $model->with(['employee','leaveType','approvedBy','rejectedBy'])->newQuery();
    }
    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $canExport = Auth::user()->hasPermissionTo('export leave requests management');
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
                                'columns' => [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                                'filename' => $this->filename()
                            ]
                        ],
                        [
                            'extend' => 'excelHtml5',
                            'text' => __('Excel'),
                            'filename' => $this->filename(),
                            'title' => '',
                            'exportOptions' => [
                                'columns' => [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                                'filename' => $this->filename()
                            ]
                        ],
                    ]
                ]
            ];
        }
        return $this->builder()
            ->setTableId('leaveRequests-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'
                            <'col-sm-12 col-md-12 d-flex justify-content-between gap-2 py-2 align-items-end' B <'#import.import-container'> >
                            <'col-sm-12 col-md-12 gap-2 py-2 ' <'table-responsive ' rt > >
                            <'col-sm-12 col-md-6 d-flex justify-content-start gap-2 py-2 'li>
                            <'col-sm-12 col-md-6 d-flex justify-content-end 'p>
                        >")
            ->addTableClass('table align-middle fs-6 gy-2 dataTable no-footer table-hover fw-semibold table-sm w-100 border gx-1 gy-2 w-100 display nowrap')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase bg-light-secondary')
            ->orderBy(0)
            ->parameters([
                'buttons' =>  $export,
            ])
            ->autoWidth()
            ->lengthMenu([[10, 25, 50, 100, 250, 500], [10, 25, 50, 100, 250, 'All']])
            ->drawCallback("function() { " .
                file_get_contents(public_path('assets/js/custom/configurations/leaveRequests/listCallbacks.js'))
                . " }");
    }
    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'wLeaveRequests_' . date('YmdHis');
    }
    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('updated_at')
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
            Column::make('employee.user.name')->title('Applied By')->orderable(false)->addClass('border'),
            Column::make('leave_type.name')->title('Leave Type')->orderable(false)->addClass('border'),
            Column::make('start_date')->name('start_date')->title('Start Date')->addClass('text-end w-100px border'),
            Column::make('end_date')->name('end_date')->title('End Date')->addClass('text-end w-100px border'),
            Column::make('total_days')->name('total_days')->title('Total Days')->orderable(false)->addClass('text-end w-100px border'),
            Column::make('status')->name('status')->title('Status')->addClass('border text-center w-100px border'),
            Column::make('approved_by.user.name')->title('Approved by')->orderable(false)->addClass('border'),
            Column::make('approved_at')->title('Approved At')->visible(false)->addClass('border'),
            Column::make('rejected_by.user.name')->title('Rejected by')->orderable(false)->addClass('border'),
            Column::make('rejected_at')->title('Rejected At')->visible(false)->addClass('border'),
            Column::make('created_at')->title('Created Date')->addClass('text-start w-100px border'),
        ];
    }
}
