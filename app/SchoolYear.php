<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    protected $table = 'school_year';
    protected $fillable = ['year', 'isOpen','inFinish','isAnswerRecord','isExam'];
}
