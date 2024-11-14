<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'CustomerFirstName',
        'CustomerLastName',
        'CustomerPhone',
        'CustomerEmail',
        'OrderDate',
        'start_time',
        'end_time',
        'EmployeeNumber',
        'Evalute',
        'OrderState',
        'Lat',
        'Lang'
    ];
}
