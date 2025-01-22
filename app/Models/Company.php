<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Company extends Model
{
    use AsSource;

    protected $fillable = [
        'employee_id',
        'type_id',
        'name',
        'VAT',
        'place',
        'logo',
        'description'
    ];
}
