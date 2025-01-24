<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Employee extends Model
{
    use AsSource, Filterable;

    protected $fillable = [
        'name',
        'lastname',
        'phone_number',
        'email',
        'company_id',
        'job'
    ];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
