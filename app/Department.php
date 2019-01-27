<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Department extends Model
{
    use SoftDeletes;

    public $table = 'departments';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

   public $fillable = [
        'department_code',
        'department_name'
    ];

    public function courses(){
        return $this->hasMany('App\Course');
    }
}
