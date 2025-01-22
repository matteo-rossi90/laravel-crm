<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Company extends Model
{
    use AsSource;

    protected $fillable = [
        'type_id',
        'name',
        'VAT',
        'place',
        'logo',
        'description'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
