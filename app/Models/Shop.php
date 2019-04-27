<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use SoftDeletes;
    protected $table = 'shop';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'logo', 'website', 'status', 'created_by', 'last_modified_by','created_date','last_modified_date'
    ];
}
