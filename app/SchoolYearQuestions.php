<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolYearQuestions extends Model
{
    protected $table = 'school_year_questions';
    protected $fillable = ['category_id','year_id','question_id'];
}
