<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repos\DepartmentRepo;
use App\Repos\SchoolClassRepo;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;

class DepartmentController extends Controller
{
    use ApiResponser;
    protected $departmentRepo;
    protected $schoolClassRepo;


    public function __construct(DepartmentRepo  $departmentRepo, SchoolClassRepo $schoolClassRepo)
    {
        $this->departmentRepo = $departmentRepo;
       $this->schoolClassRepo = $schoolClassRepo;

    }
    public function index(){
        try{
            $department =  $this->departmentRepo->all();
            if($department)  return $this->success($department,'All Departments ',200);
            else  return $this->error('Error Retrieving  Department Records  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }

    }

    public function getDepartment($id){
        try{
            $department =  $this->departmentRepo->findDepartmentById($id);
            if($department)  return $this->success($department,'Department ',200);
            else  return $this->error('Error Retrieving  Department Record  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }

    }

    public function store(Request $request){

        $data = [

            'name' => $request->input('name'),

        ];
        try{
            $department =  $this->departmentRepo->create($data);
            if($department)  return $this->success($department,'Department ',200);
            else  return $this->error('Error Retrieving  Department Record  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }

    }

    public function update(Request $request,$id){

        $data = [

            'name' => $request->input('name'),

        ];
        try{
            $department =  $this->departmentRepo->update($id,$data);
            if($department)  return $this->success($department,'Department Updated Successful ',200);
            else  return $this->error('Error Updating  Department Record  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function delete($id){
        try{
            $department =  $this->departmentRepo->delete($id);
            if($department)  return $this->success($department,'Department Deleted Successful ',200);
            else  return $this->error('Error Deleting Department Record  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function addSchoolClass(Request $request, $id){
        try{
            $school_classes = $request->input('school_classes');
            // return $school_classes;
            $result =  $this->schoolClassRepo->addToDepartment($id,$school_classes);
            if($result)  return $this->success($result,'School Classes have been Successfully added to this Department ',200);
            else  return $this->error('Error adding School Classes  to this Department  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }


    public function updateDepartmentSchoolClasses(Request $request, $id){
        try{
            $school_classes = $request->input('school_classes');
             //return $school_classes;
            $result =   $this->schoolClassRepo->updateSchoolClassesInDepartment($id,$school_classes);

            if($result)  return $this->success($result,'School Classes  have been Successfully updated to this Department ',200);
            else  return $this->error('Error updating School Classes  to this Department  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }


   public function getSchoolClassesFromDepartments($department_id){
       try{


           $result =  $this->schoolClassRepo->getDepartmentsSchoolClasses($department_id);
           if($result)  return $this->success($result,'School Classes in this department are as follows: ',200);
           else  return $this->error('Error fetching School CLasses  in this department  ',404);
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }
   }

   public function removeAllSchoolClassesFromDepartment(Request $request,$id){
       try{
           $school_classes = $request->input('school_classes');
           //return $school_classes;
           $result =  $this->schoolClassRepo->removeSchoolClassesFromDepartments($id,$school_classes);
           if($result)  return $this->success($result,'School Classes have been Successfully removed from this Department ',200);
           else  return $this->error('Error removing School Classes  from this Department  ',404);
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }
   }


   public function removeSchoolClassesFromDepartments($id){
       try{

           // return $department_ids;
           $result =  $this->schoolClassRepo->removeFromDepartment($id);
           if($result)  return $this->success($result,'All School Classes have been Successfully removed from this Department ',200);
           else  return $this->error('Error removing School Classes  from this Department  ',404);
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }

   }
}
