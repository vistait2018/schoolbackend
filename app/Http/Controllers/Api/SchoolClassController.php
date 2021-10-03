<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repos\SchoolClassRepo;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;


class SchoolClassController extends Controller
{
    use ApiResponser;
    protected $schoolClassRepo;


    public function __construct(SchoolClassRepo  $schoolClassRepo)
    {
        $this->schoolClassRepo = $schoolClassRepo;


    }

    public function index(){
        try{
            $schoolClass =  $this->schoolClassRepo->all();
            if($schoolClass)  return $this->success($schoolClass,'All Classes ',200);
            else  return $this->error('Error Retrieving  Class Records  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }

    }

    public function getSchoolClass($id){
        try{
            $schoolClass =  $this->schoolClassRepo->findSchoolClassById($id);
            if($schoolClass)  return $this->success($schoolClass,'School Class Record Retrieved ',200);
            else  return $this->error('Error Retrieving  School Class Record  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }

    }

    public function store(Request $request){

        $data = [
           'name' => $request->input('name'),

        ];
        try{
            $schoolClass =  $this->schoolClassRepo->create($data);
            if($schoolClass)  return $this->success($schoolClass,'New Class Record Saved ',200);
            else  return $this->error('Error Saving School Class Record  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }

    }


    public function update(Request $request,$id){

        $data = [
            'name' => $request->input('name'),
        ];
        //return $request->input('name');
        try{
            $schoolClass =  $this->schoolClassRepo->update($id,$data);
            if($schoolClass)  return $this->success($schoolClass,'School Class Updated Successful ',200);
            else  return $this->error('Error Updating  School Class Record  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function delete($id){
        try{
            $schoolClass =  $this->schoolClassRepo->delete($id);
            if($schoolClass)  return $this->success($schoolClass,'School Class Deleted Successful ',200);
            else  return $this->error('Error Deleting School CLass Record  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function addManyClasses(Request $request){
        try{
            $data = $request->input('school_classes');
            if(empty($data))  return $this->error('Error Creating School CLasses Record-No School Class given  ',404);
            $schoolClass =  $this->schoolClassRepo->createManyClasses($data);
            if($schoolClass)  return $this->success($schoolClass,'School Class Deleted Successful ',200);
            else  return $this->error('Error Deleting School CLass Record  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }

}
