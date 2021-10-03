<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/17/2021
 * Time: 2:10 PM
 */

namespace App\Repos;


use App\iRepo\IDepartment;
use App\Models\Department;

class DepartmentRepo implements IDepartment
{

    public function create($data)
    {

        $department = null;
        if($data){
            $department = Department::create([
                'name'=> $data['name'],
            ]);

        }
        if($department) return $department;

        return null;
    }

    public function all()
    {
        $department = Department::all();
        if($department) return $department;
        return null;
    }

    public function findDepartmentById($id)
    {
        $department = Department::find($id);
        if($department) return $department;
        return null;
    }

    public function update($id, $data)
    {
        $result = null;
        if($data){
            $department_to_update = Department::find($id);
            if($department_to_update){
                $department_to_update->name = $data['name'];

                $result = $department_to_update->save();
            }

            return $result;
        }
    }

    public function delete($id)
    {
        $result = null;

        $department_to_delete = Department::find($id);
        if($department_to_delete){
            $result = $department_to_delete->delete();
        }

        return $result;
    }
}