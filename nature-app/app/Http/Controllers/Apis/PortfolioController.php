<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Services\PortfolioService;
use Illuminate\Http\Request;



class PortfolioController extends Controller
{
    public $portfolioService ;

    public function __construct(PortfolioService $portfolioService) {
        $this->portfolioService = $portfolioService;
    }


    public function store(Request $request){


    $portfolio_file=$this->portfolioService->addPortfolioFile($request->all()) ;

    
    return response()->json([


         'status' => 'success',
        'message' => 'portfolio file added successfully',
        'result'=>$portfolio_file


    ]);


    }


    public function show(){


    $file=$this->portfolioService->getPortfolioFile() ;

    if (!$file) {
    
         return response()->json([
                'status' => 'error',
                'message' => 'no files found'
            ], 404);
        
    }


    return response()->json([

        'status' => 'success',
        'message' => 'retrieved file successfully',
        'result' => $file


    ]) ;


    }


    public function destroy(){


         $deleted = $this->portfolioService->deletePortfolioFile();

           if (!$deleted) {
        return response()->json([
          
             'status' => 'error',
             'message' => 'no files found'

        ], 404);
    }


      return response()->json([
        'status' => 'success',
        'message' => 'Portfolio deleted successfully'
    ]);



    }



    public function update(Request $request)
{
    

    $path =$this->portfolioService->updatePortfolioFile($request->file('portfolio_file'));

    return response()->json([

        'status' =>'success',
        'message' => 'Portfolio updated successfully',
        'result' => $path
    ]);
}




}
