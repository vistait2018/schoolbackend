<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/24/2021
 * Time: 3:10 PM
 */

namespace App\iRepo;


interface IDebt
{
    public function create($data);

    public function all($class_id, $session_id,$term_id);

    public function findClassId($id);

    public function findStudentId($id);

    public function update($id,$data);

    public function delete($id);

    public function getUpaidAndUnbalanceItems($class_id);

    public function getUpaidItems($student_id);

    public function getbalanceItems($student_id);

    public function getTotalDebts($student_id);

    public function getBalanceOfEachBillItem($student_id,$bill_ids);



}