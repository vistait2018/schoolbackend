<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/17/2021
 * Time: 2:09 PM
 */

namespace App\iRepo;


interface IDepartment
{
    public function create($data);

    public function all();

    public function findDepartmentById($id);

    public function update($id,$data);

    public function delete($id);

}