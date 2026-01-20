<?php

namespace App\Repositories\Eloquents;

use App\Models\ClientSection;

use App\Repositories\Contracts\ClientSectionRepositoryInterface;

class ClientSectionRepository implements ClientSectionRepositoryInterface
{


    public function create(array $data)
    {
        return ClientSection::create($data) ;
    }

    public function find(string $id)
    {
        return ClientSection::find($id);
    }

 
    public function getAll($page, $size)
{
    return ClientSection::query()
        ->where('status', true)->latest()
        ->paginate($size, ['*'], 'page', $page);
}


public function search(string $keyword, int $page, int $size)
{
    $locale = app()->getLocale();
    $column = $locale === 'ar' ? 'name_ar' : 'name_en';

    return ClientSection::query()
        ->where($column, 'LIKE', "{$keyword}%")->latest()
        ->paginate($size, ['*'], 'page', $page);
}



    public function delete(string $id): bool
{
    $client = ClientSection::find($id);
    
    if ($client) {
        return $client->delete();
    }
    
    return false;
}





}
