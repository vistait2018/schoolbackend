<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/21/2021
 * Time: 2:35 PM
 */

namespace App\iRepo;


interface IStudent
{

    public function create($data);

    public function all();

    public function findStudentById($id);

    public function  findStudentByLastnameFirstNameAndClass($first_name,$last_name,$class_id);

    public function update($id,$data);

    public function delete($id);

    public function addStudentsToClass($class_id, $data);

    public function removeStudentsFromClass($class_id, $data);

    public function changeStudentClass($present_class_id,$data,$new_class_id);

    public function getStudentsInClass($class_id);

    public function getStudentClassByStudentId($student_id);

    public function checkIfStudentIsInClass($class_id,$student_ids);

    public function checkIfAStudentIsInClass($class_id,$student_id);

    public function addStudentToAClass($class_id,$student_id);

    public function lastInsertedStudentId();

    public function getPaymentProfileByClassId($student_id);

    //new repo addition;

    public function myBill($student_id);

    public function getTotalPaidPerBillItem($student_id,$bill_id);

    public function getTotalOfAllBillPaidFor($student_id);

    public function getBalanceOfAllBillPaidFor($student_id);


    public function getBalanceOfSingleBillPaidFor($student_id,$bill_id,$amount_paid,$quantity, $rebate);

   public function  getSumofExpectedPayment($student_id);

    public function  getSumofSingleExpectedPayment($bill_id);

    public function saveQuantity($studentId, $classId,$bill);

    public function addAndRemoveGeneralToPayment($studentId, $classId,$data);
}