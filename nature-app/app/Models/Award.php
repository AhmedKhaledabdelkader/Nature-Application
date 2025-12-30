<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Award extends Model
{


    use HasTranslations ;

    
     public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'description',
        'image',
        'organization_name',
        'organization_logo',
        'year',
      
    ];

    public $translatable = [
        'title',
        'description',
        'organization_name',
    ];

 
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


// this a real important part to delete related sponsors' logos when an award is deleted
/*
    protected static function booted()
{
    static::deleting(function ($award) {

        foreach ($award->sponsors as $sponsor) {
       
            Storage::delete($sponsor->logo);
        }
    });
}
*/

    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class, 'award_sponsor');
    }

    
}
