<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/19/2021
 * Time: 4:47 PM
 */

namespace App\iRepo;


interface ISchoolClass
{
    public function create($data);

    public function all();

    public function findSchoolClassById($id);

    public function update($id,$data);

    public function delete($id);

    public function createManyClasses($school_classes);


    public function addToDepartment($department_ids,$shoo1_classes_id);

    public function removeFromDepartment($department_ids);

    public function removeSchoolClassesFromDepartments($department_ids,$shoo1_classes_id);

    public function updateSchoolClassesInDepartment($department_ids,$shoo1_classes_id);

    public function getDepartmentsSchoolClasses($category_id);
}