<?php

namespace App\Repositories\Eloquents;

use App\Models\TestimonialSection;
use App\Repositories\Contracts\TestimonialSectionRepositoryInterface;

class TestimonialSectionRepository implements TestimonialSectionRepositoryInterface
{

    public function create(array $data)
    {
        return TestimonialSection::create($data);
    }

    public function find(string $id)
    {
        return TestimonialSection::find($id);
    }


     public function getAll($page, $size)
{
    return TestimonialSection::query()->where('status',true)->latest()
    ->paginate($size, ['*'], 'page', $page);
}


public function search(string $key, string $value, int $page, int $size)
{
    $allowedKeys = ['client_name', 'job_title', 'testimonial'];

    if (!in_array($key, $allowedKeys)) {
        abort(400, 'Invalid search key');
    }

    $locale = app()->getLocale();
    $column = $key . '_' . $locale;


    return TestimonialSection::query()
        ->where('status', true)
        ->where($column, 'LIKE', "{$value}%")->latest()
        ->paginate($size, ['*'], 'page', $page);
}


public function delete(string $id): bool
{
    $testimonial = TestimonialSection::find($id);
    
    if ($testimonial) {
        return $testimonial->delete();
    }
    
    return false;
}






    
}
