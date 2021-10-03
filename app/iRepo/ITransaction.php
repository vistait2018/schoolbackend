<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/24/2021
 * Time: 3:15 PM
 */

namespace App\iRepo;


interface ITransaction
{
    public function getPaymentHistoryByStudentId($student_id);

    public function getDebtorByClassId($class_id);

    public function getAllDebtorsInSchool();







}