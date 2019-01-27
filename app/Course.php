<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    public $table = 'courses';

    public $fillable = [
        'course_id',
        'course_name',
        'department_id'
    ];

    public function course(){
        return $this->belongsTo('App\Department');
    }
}
