<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table = 'score_record';
    protected $fillable = ['s_id','question_id','correct'];
}
