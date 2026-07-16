<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalysisArticle extends Model
{
protected $fillable = [
    'title',
    'country',
    'country_code',
    'category',
    'summary',
    'content',
    'risk_level',
    'recommendation',
    'status',
    'image'
];
}