<?php

namespace App\DataTables;

use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class BranchDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function (Branch $branch) {
                return $branch->created_at->format('d M Y, h:i a');
            })
            ->addColumn('action', function (Branch $branch) {
                $pageData = [
                    'row' => $branch,
                ];
                return view('pages.apps.branches.columns._actions', $pageData);
            })
            ->setRowId('id');
    }


    /**
     * Get the query source of dataTable.
     */
    public function query(Branch $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        $canExport = Auth::user()->hasPermissionTo('export branch management');
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
                                'columns' => [2, 3, 4, 5, 6, 7, 8],
                                'filename' => $this->filename()
                            ]
                        ],
                        [
                            'extend' => 'excelHtml5',
                            'text' => __('Excel'),
                            'filename' => $this->filename(),
                            'title' => '',
                            'exportOptions' => [
                                'columns' => [2, 3, 4, 5, 6, 7, 8],
                                'filename' => $this->filename()
                            ]
                        ],
                    ]
                ]
            ];
        }
        return $this->builder()
            ->setTableId('branches-table')
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
            ->drawCallback("function() { " . file_get_contents(public_path('assets/js/custom/configurations/branches/listCallbacks.js')) . " }");
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
            Column::make('name')->name('name')->title('Name')->addClass('border'),
            Column::make('email')->name('email')->title('Email')->addClass('border'),
            Column::make('code')->name('code')->title('Branch Code')->addClass('border'),
            Column::make('country')->name('country')->title('Country')->addClass('border'),
            Column::make('state')->name('state')->title('State')->addClass('border'),
            Column::make('postal_code')->name('postal_code')->title('Postal Code')->addClass('text-start border'),
            Column::make('created_at')->name('created_at')->title('Created Date')->addClass('text-start w-200px border'),
        ];
    }
    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'WBranch_' . date('YmdHis');
    }
}
