<?php

namespace Webkul\SizeChart\Datagrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;
use Webkul\SizeChart\Models\SizeChart;

class TemplateDataGrid extends DataGrid
{
    protected $primaryColumn = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('size_charts')
            ->select(
                'id',
                'template_name',
                'template_code',
                'template_type',
                'image_path',
                'created_at',
                'updated_at'
            );
            
        // Debug the query
        // \Log::debug('SizeChart Query:', ['sql' => $queryBuilder->toSql(), 'bindings' => $queryBuilder->getBindings()]);
        
        return $queryBuilder;
    }

    public function prepareColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('sizechart::app.sizechart.template.id'),
            'type'       => 'integer',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'template_name',
            'label'      => trans('sizechart::app.sizechart.template.template-name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'template_code',
            'label'      => trans('sizechart::app.sizechart.template.template-code'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'template_type',
            'label'      => trans('sizechart::app.sizechart.template.template-type'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure' => function ($row) {
                return $row->template_type == 'configurable' 
                    ? trans('sizechart::app.sizechart.template.configurable-type')
                    : trans('sizechart::app.sizechart.template.simple-type');
            }
        ]);
        
        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('admin::app.datagrid.created_at'),
            'type'       => 'datetime',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);
    }

    public function prepareActions()
    {
        // $this->addAction([
        //     'title' => trans('sizechart::app.edit'),
        //     'type' => 'Edit',
        //     'method' => 'GET',
        //     'route' => 'sizechart.admin.index.edit',
        //     'icon' => 'icon pencil-lg-icon'
        // ]);
        $this->addAction([
            'title' => trans('sizechart::app.edit'),
            'method' => 'GET',
            'url' => function ($row) {
                return route('sizechart.admin.index.edit', $row->id);
            },
            'icon' => 'icon pencil-lg-icon',
        ]);

        // $this->addAction([
        //     'title'        => trans('sizechart::app.delete'),
        //     'method'       => 'POST',
        //     'route'        => 'sizechart.admin.index.delete',
        //     'confirm_text' => trans('ui::app.datagrid.massaction.delete'),
        //     'icon'         => 'icon trash-icon',
        // ]);

        $this->addAction([
            'title' => trans('sizechart::app.delete'),
            'method' => 'POST',
            'url' => function ($row) {
                return route('sizechart.admin.index.delete', $row->id);
            },
            'confirm_text' => trans('ui::app.datagrid.massaction.delete'),
            'icon' => 'icon trash-icon',
        ]);
    }

    public function prepareMassActions()
    {
        // $this->addMassAction([
        //     'type' => 'delete',
        //     'label' => trans('sizechart::app.sizechart.template.delete'),
        //     'action' => route('sizechart.admin.index.massdelete'),
        //     'method' => 'POST'
        // ]);

        $this->addMassAction([
            'title' => trans('sizechart::app.sizechart.template.delete'),
            'url' => route('sizechart.admin.index.massdelete'),
            'method' => 'POST',
        ]);
    }
}
