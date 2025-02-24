<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    // /**
    //  * Build the DataTable class.
    //  *
    //  * @param  QueryBuilder  $query  Results from query() method.
    //  */
    // public function dataTable(QueryBuilder $query): EloquentDataTable
    // {
    //     return (new EloquentDataTable($query))
    //         ->addColumn('action', function ($row) {

    //             $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="me-1 btn btn-info btn-sm showProduct">View</a>';
    //             $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';

    //             $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

    //             return $btn;
    //         })
    //         ->rawColumns(['action'])
    //         ->make(true)
    //         ->setRowId('id');
    // }

    // /**
    //  * Get the query source of dataTable.
    //  */
    // public function query(User $model): QueryBuilder
    // {
    //     return $model->newQuery();
    // }

    // /**
    //  * Optional method if you want to use the html builder.
    //  */
    // public function html(): HtmlBuilder
    // {
    //     return $this->builder()
    //         ->setTableId('users-table')
    //         ->columns($this->getColumns())
    //         ->minifiedAjax()
    //                 //->dom('Bfrtip')
    //         ->orderBy(1)
    //         ->selectStyleSingle()
    //         ->buttons([
    //             // Button::make('excel'),
    //             // Button::make('csv'),
    //             // Button::make('pdf'),
    //             Button::make('print'),
    //             Button::make('reset'),
    //             Button::make('reload'),
    //         ]);
    // }

    // /**
    //  * Get the dataTable columns definition.
    //  */
    // public function getColumns(): array
    // {
    //     return [
    //         Column::computed('action')
    //             ->exportable(false)
    //             ->printable(false)
    //             ->width(60)
    //             ->addClass('text-center'),
    //         Column::make('id'),
    //         Column::make('name'),
    //         Column::make('email'),
    //         Column::make('created_at'),
    //         Column::make('updated_at'),
    //     ];
    // }

    // /**
    //  * Get the filename for export.
    //  */
    // protected function filename(): string
    // {
    //     return 'Users_'.date('YmdHis');
    // }
}
