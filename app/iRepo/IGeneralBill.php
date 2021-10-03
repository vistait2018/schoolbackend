<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/24/2021
 * Time: 3:24 PM
 */

namespace App\iRepo;


interface IGeneralBill
{
    public function create($data);

    public function all();

    public function findBillByClassId($id);


    public function update($bill_id,$data);

    public function delete($id);

    public function generalBill();
    public function compulsoryBill();
    public function storeBill();

    public function myBillByClassId($class_id);




}