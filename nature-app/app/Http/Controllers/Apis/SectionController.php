<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Services\SectionService;
use Illuminate\Http\Request;



class SectionController extends Controller
{


    public $sectionService ;

    public function __construct(SectionService $sectionService) {
        $this->sectionService = $sectionService;
    }




public function store(Request $request){


$section=$this->sectionService->addSectionWithSubsections($request->all()) ;


return response()->json([


    'status'=>'success',
    'message'=>'section with subsections added successfully',
    'result'=>new SectionResource($section) ,



],201);


}



public function update(Request $request,string $id){


$section=$this->sectionService->updateSectionWithSubsections($request->all(),$id) ;

if (!$section) {
    
    return response()->json([
                'status' => 'error',
                'message' =>'section not found'
            ], 404);

}

return response()->json(
    [
       'status'=>'success',
       'message'=>'update section with subsection successfully',
       'result'=>new SectionResource($section)

    ]
    );



}


public function show(string $id){

    $section=$this->sectionService->findSectionWithSubsections($id) ;

    if (!$section) {
    
    return response()->json([
                'status' => 'error',
                'message' =>'section not found'
            ], 404);

}

return response()->json(
    [
       'status'=>'success',
       'message'=>'retrieve section with subsection successfully',
       'result'=>new SectionResource($section)

    ]
    );



}






}
