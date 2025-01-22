<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Type extends Model
{
    use AsSource;

    protected $fillable = [
        'name'
    ];
}
