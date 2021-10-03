<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/17/2021
 * Time: 11:41 AM
 */

namespace App\Repos;


use App\iRepo\ICategory;
use App\Models\Category;
use App\Models\Category_department;

class CategoryRepo implements  ICategory
{

    public function create($data)
    {
        $category = null;
        if($data){
            $category = Category::create([
              'name'=> $data['name'],
                'school_id' =>$data['school_id'],
                'level' =>$data['level']

            ]);

        }
        if($category) return $category;

         return null;
    }

    public function all()
    {
        $category = Category::all();
        if($category) return $category;
        return null;
    }

    public function findCategoryById($id)
    {
        $category = Category::find($id);
        if($category) return $category;
        return null;
    }

    public function update($id,$data)
    {
       $result = null;
        if($data){
           $category_to_update = Category::find($id);
           if($category_to_update){
               $category_to_update->name = $data['name'];
               $category_to_update->school_id = $data['school_id'];
               $result = $category_to_update->save();
           }

           return $result;
        }

    }

    public function delete($id)
    {
        $result = null;

            $category_to_delete = Category::find($id);
            if($category_to_delete){
                $result = $category_to_delete->delete();
            }

            return $result;

    }

    public function addDepartmentsToCategory($category_id,$department_ids)
    {
        $category = Category::find($category_id);
       // return $category;
        $result = null;
        If($category){
            $result = $category->departments()->sync($department_ids);
            return true;
        }

        return null;

    }

    public function getCategoryDepartments($category_id)
    {
        $category = Category::find($category_id);



        If($category) {
            return $category->departments;
        }
        return null;
    }

    public function updateDepartmentsInCategory($category_id,$department_ids)
    {
        $category = Category::find($category_id);
        // return $category;
        $result = null;
        If($category){
            $result = $category->departments()->sync($department_ids);
            return true;
        }

        return null;
    }

    public function removeDepartmentsFromCategory($department_ids,$category_id)
    {
        $category = Category::find($category_id);
         //return $department_ids;
        If($category){

            $result = $category->departments()->detach($department_ids);
            return true;
        }

        return null;
    }

    public function removeAllDepartmentFromCategory($category_id)
    {

        $category = Category::find($category_id);
        If($category){
            $result = $category->departments()->detach();
            return true;
        }

        return null;
    }
}