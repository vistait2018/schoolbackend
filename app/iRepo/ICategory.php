<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/17/2021
 * Time: 11:39 AM
 */

namespace App\iRepo;


interface ICategory
{

    public function create($data);

    public function all();

    public function findCategoryById($id);

    public function update($id,$data);

    public function delete($id);

    public function addDepartmentsToCategory($category_id,$department_ids);

    public function getCategoryDepartments($category_id);

    public function updateDepartmentsInCategory($category_id,$department_ids);

    public function removeDepartmentsFromCategory($department_ids,$category_id);

    public function removeAllDepartmentFromCategory($category_id);

}