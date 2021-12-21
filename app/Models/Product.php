<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $dates = [
	    'created_at',
	    'updated_at'
	];
    protected $filable = [
        'id',
        'image',
        'name',
        'description',
        'price',
        'color'
    ];
    protected $primaryKey = 'id';
    protected $table = 'tbl_product';
}
