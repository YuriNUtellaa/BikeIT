<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stocks'; // Specify the table name if it's different from the model name
    protected $primaryKey = 'stock_id'; // Specify the primary key if it's different from 'id'
    protected $fillable = [
        'product_id',
        'quantity',
    ];
}
