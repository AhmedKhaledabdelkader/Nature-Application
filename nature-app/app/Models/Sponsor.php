<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Sponsor extends Model
{

    public $incrementing = false;
    protected $keyType = 'string';


    use HasTranslations ;



    protected $fillable = ['name', 'logo','award_id'];

    public $translatable = ['name'];

        public function setLocalizedValue(string $field, string $locale, $value): void
        {
            $this->setTranslation($field, $locale, $value);
        }

     protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }





    public function award()
    {
        return $this->belongsTo(Award::class);
    }





    
}
