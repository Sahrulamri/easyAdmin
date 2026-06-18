<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $connection = 'pgsql_easyadmin';

    protected $table = 'transactions';

    protected $fillable = [
        'transaction_code',
        'product_code',
        'product_name',
        'unit_price',
        'quantity',
        'total_price'
    ];

    protected $appends = [
        'btn_delete',
        'btn_edit',
        'btn_show'
    ];

    public function getBtnDeleteAttribute()
    {
        return "<button type='button'
                class='btn btn-outline-danger btn-sm radius-6'
                data-bs-toggle='modal'
                data-bs-target='#modalDelete'
                onclick='setDelete(" . json_encode($this->id) . ")'>
                <i class='ti ti-trash'></i>
                </button>";
    }

    public function getBtnEditAttribute()
    {
        return "<button type='button'
                class='btn btn-outline-secondary btn-sm radius-6'
                data-bs-toggle='offcanvas'
                data-bs-target='#drawerEdit'
                onclick='setEdit(" . json_encode($this->id) . ")'>
                <i class='ti ti-pencil'></i>
                </button>";
    }

    public function getBtnShowAttribute()
    {
        return "<button type='button'
                class='btn btn-outline-secondary btn-sm radius-6'
                onclick='setShowPreview(" . json_encode($this->id) . ")'>
                <i class='ti ti-eye'></i>
                </button>";
    }

    public function getUnitPriceAttribute($value)
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }

    public function getTotalPriceAttribute($value)
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }
}
