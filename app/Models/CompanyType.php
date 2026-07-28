<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyType extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'slug'];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
