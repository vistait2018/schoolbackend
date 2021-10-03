<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repos\MyTermRepo;
use App\Traits\ApiResponser;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class TermController extends Controller
{

    use ApiResponser;
    protected $termRepo;

    public function __construct(MyTermRepo  $myTermRepo)
    {
        $this->termRepo = $myTermRepo;
    }

    public function index(){
       try{
          $term =  $this->termRepo->all();
          if($term)  return $this->success($term,'Term Records ',200);
              else  return $this->error('Error Retrieving  Term Record  ',404);;
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }
   }
   public function presentTerm(){
       try{
           $term =  $this->termRepo->presentTerm();
           if(is_null($term))return $this->success($term,'Term has not been started ',200);
           if($term)  return $this->success($term,'Term Records ',200);
           else  return $this->error('Error Retrieving  Term Record  ',404);;
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }
   }

   public function getTermById($term_id){
       try{
           $term =  $this->termRepo->get($term_id);

           if($term)  return $this->success($term,'Term Records ',200);
           else  return $this->error('Error Retrieving  Term Record  ',404);;
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }
   }

   public function deleteTerm($term_id){
       try{
           $term =  $this->termRepo->delete($term_id);

           if($term)  return $this->success($term,'Term Records Deleted ',200);
           else  return $this->error('Error Deleting  Term Record  ',404);;
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }
   }


   public function updateTerm(Request $request ,$term_id){
       try{
          // return $request;
           $data = [
               'name' => $request->input('name'),
               'level' => $request->input('level'),
           ];
           //return $data;
           $term =  $this->termRepo->update($term_id,$data);
           if($term)  return $this->success($term,'Term Records Updated ',200);
           else  return $this->error('Error Updating  Term Record  ',404);;
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }


   }

   public function createTerm(Request $request){
       try{
           // return $request;
           $data = [
               'name' => $request->input('name'),
               'level' => $request->input('level'),
           ];
           //return $data;
           $term =  $this->termRepo->create($data);
           if($term)  return $this->success($term,'New Term Records Created ',200);
           else  return $this->error('Error Creating  Term Record  ',404);;
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }
   }


   public function endTerm($term_id){
       try{
           // return $request;

           $term =  $this->termRepo->endTerm($term_id);
           if($term)  return $this->success($term,$term->name.' '.'Term has been  ended ',200);
           else  return $this->error('Error Ending Term. - Term might have been ended  ',404);
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }

   }

   public function newTerm($new_term_id){
       try{
           // return $request;

           $term =  $this->termRepo->newTerm($new_term_id);
           //return $term;
           if($term == true )  return $this->success($term,$term->name.' '.'Term has been started ',200);
           else  return $this->error('Error Ending Term. - Term might have been ended  ',404);
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }
   }



}
