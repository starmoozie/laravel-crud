<?php

namespace Starmoozie\CRUD\app\Http\Controllers\Traits;

/**
 * 
 */
trait GlobalColumns
{
    protected function numbering()
    {
        $this->crud->addColumn([
            'name'      => 'row_number',
            'type'      => 'row_number',
            'label'     => '#',
            'orderable' => false,
        ])->makeFirstColumn();
    }

    protected function created()
    {
        $this->crud->addColumn([
            'name'      => 'created_at',
            'type'      => 'datetime',
            'label'     => 'Created',
            'format'    => 'D MMMM YY, HH:mm:ss'
        ])->makeLastColumn();
    }
}