<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryAddDepartments;
use App\Repos\CategoryRepo;
use App\Repos\SchoolRepo;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Mockery\Exception;

class CategoryController extends Controller
{

    use ApiResponser;
    protected $categoryRepo;
    protected $schoolRepo;

    public function __construct(CategoryRepo  $categoryRepo, SchoolRepo $schoolRepo)
    {
        $this->categoryRepo = $categoryRepo;
        $this->schoolRepo = $schoolRepo;

    }
   public function index(){
       try{
           $category =  $this->categoryRepo->all();
           if($category)  return $this->success($category,'All Categories ',200);
           else  return $this->error('Error Retrieving  Category Records  ',404);
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }

   }

   public function getCategory($id){
       try{
           $category =  $this->categoryRepo->findCategoryById($id);
           if($category)  return $this->success($category,'Category ',200);
           else  return $this->error('Error Retrieving  Category Record  ',404);
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }

   }

   public function store(Request $request){
        $myschool = $this->schoolRepo->mySchool();
       //return $myschool;
        $data = [
         'school_id' => $myschool->id,
            'name' => $request->input('name'),
            'level' =>$request->input('level')
        ];
       try{
           $category =  $this->categoryRepo->create($data);
           if($category)  return $this->success($category,'Category ',200);
           else  return $this->error('Error Retrieving  Category Record  ',404);
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }

   }

   public function update(Request $request,$id){

       $myschool = $this->schoolRepo->mySchool();
       $data = [
           'school_id' => $myschool->id,
           'name' => $request->input('name'),
           'level' =>$request->input('level')
       ];
       //return $data;
       try{
           $category =  $this->categoryRepo->update($id,$data);
           if($category)  return $this->success($category,'Category Updated Successful ',200);
           else  return $this->error('Error Updating  Category Record  ',404);
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }
   }

   public function delete($id){
       try{
           $category =  $this->categoryRepo->delete($id);
           if($category)  return $this->success($category,'Category Deleted Successful ',200);
           else  return $this->error('Error Deleting Category Record  ',404);
       }catch(Exeption $ex){
           return $this->error('Internal Server Error',500);
       }
   }

    public function addDepartments(CategoryAddDepartments $request, $id){
        try{
            $department_ids = $request->input('department_ids');
           // return $id;
            $result =  $this->categoryRepo->addDepartmentsToCategory($id,$department_ids);
            if($result)  return $this->success($result,'Departments have been Successfully added to this Category ',200);
            else  return $this->error('Error adding Departments  to this Category  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function getCategoryDepartments($category_id){
        try{


            $result =  $this->categoryRepo->getCategoryDepartments($category_id);
            if($result)  return $this->success($result,'Department in this categories are as follows: ',200);
            else  return $this->error('Error fetching departments  in this Category  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function updateCategoryDepartments(CategoryAddDepartments $request, $id){

        try{
            $department_ids = $request->input('department_ids');
           // return $department_ids;
            $result =  $this->categoryRepo->updateDepartmentsInCategory($id,$department_ids);
            if($result)  return $this->success($result,'Departments have been Successfully added to this Category ',200);
            else  return $this->error('Error updating Departments  to this Category  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function removeDepartmentsFromCategory(Request $request,$id)
    {
        try{
            $department_ids = $request->input('department_ids');
             //return $department_ids;
            $result =  $this->categoryRepo->removeDepartmentsFromCategory($department_ids,$id);
            if($result)  return $this->success($result,'Departments have been Successfully removed from this Category ',200);
            else  return $this->error('Error removing Departments  from this Category  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function removeAllDepartmentFromCategory($id)
    {
        try{

            // return $department_ids;
            $result =  $this->categoryRepo->removeAllDepartmentFromCategory($id);
            if($result)  return $this->success($result,'All Departments have been Successfully removed from this Category ',200);
            else  return $this->error('Error removing Departments  from this Category  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }

    }

}
