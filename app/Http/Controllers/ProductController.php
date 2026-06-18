<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class ProductController extends DefaultController
{
    protected $modelClass = Product::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    protected $actionButtons;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Product';
        $this->generalUri = 'product';

        $this->actionButtons = [
            'btn_edit',
            'btn_show',
            'btn_delete'
        ];

        $this->tableHeaders = [
            ['name' => 'No', 'column' => '#', 'order' => true],
            ['name' => 'Code', 'column' => 'code', 'order' => true],
            ['name' => 'Name', 'column' => 'name', 'order' => true],
            ['name' => 'Description', 'column' => 'description', 'order' => false],
            ['name' => 'Price', 'column' => 'price', 'order' => true],
            ['name' => 'Created At', 'column' => 'created_at', 'order' => true],
            ['name' => 'Updated At', 'column' => 'updated_at', 'order' => true],
        ];

        $this->importExcelConfig = [
            'primaryKeys' => ['code'],
            'headers' => [
                'code',
                'name',
                'description',
                'price'
            ]
        ];
    }

    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;

        if ($id != '-') {
            $edit = $this->modelClass::where('id', $id)->first();
        }

        return [

            [
                'label' => 'Code',
                'name' => 'code',
                'type' => 'text',
                'placeholder' => 'Input product code',
                'value' => $edit?->code,
            ],

            [
                'label' => 'Name',
                'name' => 'name',
                'type' => 'text',
                'placeholder' => 'Input product name',
                'value' => $edit?->name,
            ],

            [
                'label' => 'Description',
                'name' => 'description',
                'type' => 'textarea',
                'placeholder' => 'Input description',
                'value' => $edit?->description,
            ],

            [
                'label' => 'Price',
                'name' => 'price',
                'type' => 'number',
                'placeholder' => 'Input price',
                'value' => $edit?->price,
            ],
        ];
    }

    protected function rules($id = null)
    {
        return [
            'code' => 'required',
            'name' => 'required',
            'price' => 'required|numeric|min:0',
        ];
    }
}
