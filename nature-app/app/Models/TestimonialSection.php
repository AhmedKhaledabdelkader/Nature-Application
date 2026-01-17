<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TestimonialSection extends Model
{


    
    public $incrementing = false;
    protected $keyType = 'string';



    protected $fillable = [
        'client_name_en',
        'client_name_ar',
        'job_title_en',
        'job_title_ar',
        'testimonial_en',
        'testimonial_ar',
        'status'
    ];


       protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }







}
