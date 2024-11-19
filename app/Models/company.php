<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    use HasFactory;

    protected $fillable = [
        'companyName',
        'description',
        'services',
        'Email',
        'phone1',
        'phone2',
        'Address',
        'Lat',
        'Lang',
        'comments',
        'password',
        'facebookLink',
        'instagramLink'
    ];
}
