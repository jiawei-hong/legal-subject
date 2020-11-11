<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scores extends Model
{
    protected $table = 'score';
    protected $fillable = ['category_id', 'user_id', 'year_id', 'score'];
}
