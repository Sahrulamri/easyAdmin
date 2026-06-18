<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Idev\EasyAdmin\app\Http\Controllers\DefaultController;

class TransactionController extends DefaultController
{
    protected $modelClass = Transaction::class;
    protected $title;
    protected $generalUri;
    protected $tableHeaders;
    protected $actionButtons;
    protected $importExcelConfig;

    public function __construct()
    {
        $this->title = 'Transaction';
        $this->generalUri = 'transaction';

        $this->actionButtons = [
            'btn_edit',
            'btn_show',
            'btn_delete'
        ];

        $this->tableHeaders = [
            ['name' => 'No', 'column' => '#', 'order' => true],
            ['name' => 'Transaction Code', 'column' => 'transaction_code', 'order' => true],
            ['name' => 'Product Code', 'column' => 'product_code', 'order' => true],
            ['name' => 'Product Name', 'column' => 'product_name', 'order' => true],
            ['name' => 'Unit Price', 'column' => 'unit_price', 'order' => true],
            ['name' => 'Quantity', 'column' => 'quantity', 'order' => true],
            ['name' => 'Total Price', 'column' => 'total_price', 'order' => true],
            ['name' => 'Created At', 'column' => 'created_at', 'order' => true],
        ];

        $this->importExcelConfig = [
            'primaryKeys' => ['transaction_code'],
            'headers' => []
        ];
    }

    protected function fields($mode = "create", $id = '-')
    {
        $edit = null;

        if ($id != '-') {
            $edit = Transaction::where('id', $id)->first();
        }

        $products = Product::all();

        $productOptions = [];

        foreach ($products as $product) {
            $productOptions[] = [
                'value' => $product->code,
                'text'  => $product->name
            ];
        }

        return [

            [
                'label' => 'Product',
                'name' => 'product_id',
                'type' => 'select',
                'options' => $productOptions,
                'value' => $edit?->product_code
            ],

            [
                'label' => 'Quantity',
                'name' => 'quantity',
                'type' => 'number',
                'placeholder' => 'Input quantity',
                'value' => $edit?->quantity
            ],

        ];
    }

    protected function rules($id = null)
    {
        return [
            'product_id' => 'required',
            'quantity' => 'required|numeric|min:1',
        ];
    }

    protected function store(Request $request)
    {
        $product = Product::where(
            'code',
            $request->product_id
        )->first();

        $last = Transaction::count() + 1;

        $trxCode = 'TRX' . str_pad($last, 4, '0', STR_PAD_LEFT);

        Transaction::create([
            'transaction_code' => $trxCode,
            'product_code' => $product->code,
            'product_name' => $product->name,
            'unit_price' => $product->price,
            'quantity' => $request->quantity,
            'total_price' => $product->price * $request->quantity,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Transaction created successfully'
        ]);
    }

    protected function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $product = Product::where(
            'code',
            $request->product_id
        )->first();

        $transaction->update([
            'product_code' => $product->code,
            'product_name' => $product->name,
            'unit_price' => $product->price,
            'quantity' => $request->quantity,
            'total_price' => $product->price * $request->quantity,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Transaction updated successfully'
        ]);
    }
}
