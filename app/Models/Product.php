<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // pakai koneksi SQL Server
    protected $connection = 'sqlsrv_easyadmin';

    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $fillable = [
        'code',
        'name',
        'description',
        'price'
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
                style='margin:1px;'
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
                style='margin:1px;'
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
                style='margin:1px;'
                onclick='setShowPreview(" . json_encode($this->id) . ")'>
                <i class='ti ti-eye'></i>
                </button>";
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value
            ? date("Y-m-d H:i:s", strtotime($value))
            : "-";
    }

    public function getCreatedAtAttribute($value)
    {
        return $value
            ? date("Y-m-d H:i:s", strtotime($value))
            : "-";
    }
}
