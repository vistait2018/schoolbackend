<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSession;
use App\Repos\MyTermRepo;
use App\Repos\SchoolSessionRepo;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Mockery\Exception;

class SchoolSessionController extends Controller
{

    use ApiResponser;
    protected $schoolSessionRepo;
    protected $termRepo;

    public function __construct(SchoolSessionRepo  $schoolSessionRepo, MyTermRepo $termRepo)
    {
        $this->schoolSessionRepo = $schoolSessionRepo;
        $this->termRepo = $termRepo;
    }
    public function createSession(CreateSession $request){

        try{
             $in_session = $this->schoolSessionRepo->check_start_session();
             If($in_session){
                 $max_term_id =  $this->termRepo->maxTermID();

                 $data = [
                     'start'=>$request->input('start'),
                     'end' =>$request->input('end'),
                     'term_id'=>$max_term_id


                 ];

                 $school_session = $this->schoolSessionRepo->create_session($data);
                 if($school_session){
                     return $this->success($school_session,'School Session Created',200);

                 }else{
                     return $this->error('Error Creating  New Session  ',404);
                 }
             }else{
                 return $this->error('Error Creating  New Session| There is an active Session  ',404);
             }

        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }


    }

    public function endSchoolSession(){
        try{

            $present_term = $this->termRepo->presentTerm();
            $max_term = $this->termRepo->maxTerm();
            if($present_term == null){
                return $this->error('Error Ending Session|There is no active term  ',404);
            }
            if($present_term->level != $max_term){
                return $this->error('Error Ending Session|We are not in the final term  ',404);

            }



            $end_school_session =  $this->schoolSessionRepo->endSchoolSession();

            if($end_school_session){
                return $this->success($end_school_session,'School Session Ended',200);

            }else{
                return $this->error('Error Ending Session  ',404);
            }
        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }


    }

    public function newTerm(){
        try{
            $result = $this->termRepo->newTerm();
            if ($result['status'] == false) {
                return $this->error($result['message'],404);
            }
            return $this->success($result,'New Term Created',200);
        }catch (Exception $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function schoolSessionAndTermInfo(){
        try{
            $result = $this->schoolSessionRepo->presentSessionTermDetails();

            return $this->success($result,'Session and Term Info',200);
        }catch (Exception $ex){
            return $this->error('Internal Server Error',500);
        }
    }
}
