<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/19/2021
 * Time: 4:51 PM
 */

namespace App\Repos;

use App\iRepo\ISchoolClass;
use App\Models\Department;
use App\Models\DepartmentSchoolClass;
use App\Models\SchoolClass;
use Carbon\Carbon;

class SchoolClassRepo implements ISchoolClass
{

    public function create($data)
    {
            $schoolclass = null;
            if($data){
                $schoolclass = SchoolClass::create([
                    'name'=> $data['name'],

               ]);

            }
            if($schoolclass) return $schoolclass;

            return null;
    }

    public function all()
    {
        $schoolclass = SchoolClass::all();
        if($schoolclass) return $schoolclass;
        return null;
    }

    public function findSchoolClassById($id)
    {
        //return $id;
        $schoolclass = SchoolClass::find($id);
        if($schoolclass) return $schoolclass;
        return null;
    }

    public function update($id, $data)
    {
        $result = null;
        if($data){
            $school_class_to_update = SchoolClass::find($id);
            if($school_class_to_update){
                $school_class_to_update->name = $data['name'];
                $result = $school_class_to_update->save();
            }

            return $result;
        }
    }

    public function delete($id)
    {
        $result = null;

        $school_class_to_dalete = SchoolClass::find($id);
        if($school_class_to_dalete){
            $result = $school_class_to_dalete->delete();
        }

        return $result;
    }


    public function createManyClasses($school_classes)
    {
        $classes = $school_classes;

        // Book records to be saved
        $all_classes = [];

        // Add needed information to book records
        foreach($classes as $class)
        {
            if(! empty($classes))
            {
                // Get the current time
                $now = Carbon::now();

                // Formulate record that will be saved
                $all_classes[] = [
                    'name' => $class,

                    'updated_at' => $now,  // remove if not using timestamps
                    'created_at' => $now   // remove if not using timestamps
                ];
            }
        }

        // Insert book records
        $inserted_classes = SchoolClass::insert($all_classes);

        if($inserted_classes)return true;
        return null;
    }

    public function addToDepartment($department_id,$shoo1_classes_id)
    {
        $department = Department::find($department_id);
        //return $shoo1_classes_id;
        $result = null;
        $class_id = [];


        If($department){
            foreach($shoo1_classes_id as $id){

                if(! empty($shoo1_classes_id))
                {
                    // Get the current time
                    $now = Carbon::now();

                    // Formulate record that will be saved
                    $class_id[] = [
                        'school_class_id' => $id,
                        'department_id'=>$department_id,
                        'updated_at' => $now,  // remove if not using timestamps
                        'created_at' => $now   // remove if not using timestamps
                    ];
                }
            }
            // Insert School CLasses records
            $inserted_classes = DepartmentSchoolClass::insert($class_id);

            if($inserted_classes)return true;
            return null;

        }

        return null;
    }

    public function removeFromDepartment($department_ids)
    {
        $department = Department::find($department_ids);
        If($department){
            $result = $department->schoolClasses()->detach();
            return true;
        }

        return null;
    }

    public function removeSchoolClassesFromDepartments($department_ids, $shoo1_classes_id)
    {
        $department = Department::find($department_ids);
        //return $department_ids;
        If($department){

            $result = $department->schoolClasses()->detach($shoo1_classes_id);
            return true;
        }

        return null;
    }

    public function updateSchoolClassesInDepartment($department_ids, $shoo1_classes_id)
    {
        $department = Department::find($department_ids);
         //return $shoo1_classes_id;
        $result = null;
        If($department){
            $result = $department->schoolClasses()->sync($shoo1_classes_id);
            return true;
        }

        return null;
    }


    public function getDepartmentsSchoolClasses($category_id)
    {
        $department = Department::find($category_id);



        If($department) {
            return $department->schoolClasses;
        }
        return null;
    }
}