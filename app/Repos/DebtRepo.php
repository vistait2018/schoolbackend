<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/25/2021
 * Time: 1:49 PM
 */

namespace App\Repos;


use App\iRepo\IDebt;
use App\Models\Debt;
use App\Models\GeneralBill;
use App\Models\Payment;
use App\Models\SchoolClass;

class DebtRepo implements  IDebt
{

    public function create($data)
    {
        $debts = Debt::create([
            'general_bill_id'=>$data['general_bill_id'],
            'student_id'=>$data['student_id'] ,
            'school_session_id'=>$data['school_session_id'],
            'term_id'=>$data['term_id'],
            'general_bill_name'=>$data['general_bill_name'],
            'general_bill_amount'=>$data['general_bill_amount'],
            'school_class_id'=>$data['school_class_id'],
            'collected'=>$data['collected'],

        ]);
      if($debts){
          return $debts;
      }

      return null;
    }

    public function all($class_id=null, $session_id=null,$term_id=null)
    {
        $debt = null;
        if(is_null($class_id) and is_null($session_id) and is_null($term_id)){
            $debt = Debt::paginate(50);

        }

        if(is_null($class_id) and (!is_null($session_id))and (!is_null($term_id))){
            $debt = Debt::where('school_session_id','=',$session_id)
                ->where('term_id','=',$term_id)
                ->paginate(50);

        }

        if(!is_null($class_id) and (!is_null($session_id))and (!is_null($term_id))){
            $debt = Debt::where('school_session_id','=', $session_id)
                ->where('school_class_id','=', $class_id)
                ->where('term_id','=', $term_id)
                ->paginate(50);

        }

        if(!is_null($class_id) and (is_null($session_id))and (!is_null($term_id))){
            $debt = Debt::where('school_class_id','=', $class_id)
                ->where('term_id','=', $term_id)
                ->paginate(50);

        }

        if(!is_null($class_id) and (!is_null($session_id))and (is_null($term_id))){
            $debt = Debt::where('term_id','=', $term_id)
                          ->paginate(50);

        }


     return $debt;
    }

    public function findClassId($id)
    {
        $debt = null;
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();
        if($id){
            $debt = Debt::where('school_session_id','=', $result['school_session_id'])
                ->where('school_class_id','=', $id)
                ->where('term_id','=', $result['term_id'])
               ->paginate(50);
            }
       }


    public function findStudentId($id)
    {
        $debt = null;
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();
        if($id){
            $debt = Debt::where('school_session_id','=', $result['school_session_id'])
                ->where('student_id','=', $id)
                ->where('term_id','=', $result['term_id'])
                ->get();
            return $debt;
        }
    }

    public function update($id, $data)
    {
        $debt_to_update = null;
        if($id){
            $debt_to_update = Debt::find($id);
            $debt_to_update->general_bill_id = $data['general_bill_id'];
            $debt_to_update->student_id = $data['student_id'];
            $debt_to_update->session_id = $data['school_session_id'];
            $debt_to_update->term_id = $data['term_id'];
            $debt_to_update->collected = $data['collected'];
            $debt_to_update->school_class_id = $data['school_class_id'];
            $debt_to_update->general_bill_name = $data['general_bill_name'];
            $debt_to_update->general_bill_amount = $data['general_bill_amount'];
            $result = $debt_to_update->save();
           if($result) return $debt_to_update;
        }
        return null;
    }

    public function delete($id)
    {
        $debt_to_delete = null;
        if($id){
            $debt_to_delete = Debt::find($id);
            $result =$debt_to_delete->delete();
            if($result) return $result;
        }
        return null;
    }

    public function getUpaidAndUnbalanceItems($class_id)
    {
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();
        if(!is_null($class_id)){
            $debt = Debt::where('school_session_id','=', $result['school_session_id'])
                ->where('school_class_id','=', $class_id)
                ->where('term_id','=', $result['term_id'])
                ->where('collected','=', false)
                ->get(50);
        }


    }

    public function getUpaidItems($student_id)
    {
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();
        if(!is_null($student_id)){
            $debt = Debt::where('school_session_id','=', $result['school_session_id'])
                ->where('student_id','=', $student_id)
                ->where('term_id','=', $result['term_id'])
                ->where('collected','=', false)
                ->get(50);
        }

    }

    public function getbalanceItems($student_id)
    {
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();
        if(!is_null($student_id)){
            $debt = Debt::where('school_session_id','=', $result['school_session_id'])
                ->where('student_id','=', $student_id)
                ->where('term_id','=', $result['term_id'])
                ->where('collected','=', true)
                ->paginate(50);
        }
    }


    public function getTotalDebts($student_id)
    {
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();

        if(!is_null($student_id)){
            $debt = Debt::where('school_session_id','=', $result['school_session_id'])
                ->where('student_id','=', $student_id)
                ->where('term_id','=', $result['term_id'])
                ->sum('general_bill_amount');

        }
    }


    public function getBalanceOfEachBillItem($student_id, $bill_ids){
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();
        $data= [];
        $debt = null;
        $payments = [];
        foreach ($bill_ids as $id) {
            $bill =Payment::where('school_session_id','=', $result['school_session_id'])
                ->where('term_id','=', $result['term_id'])
                ->where('student_id','=',$student_id)
                ->gets();
            array_push($payments,$bill);
        }
         ;
        if(!is_null($student_id)){
            $debt = Debt::where('school_session_id','=', $result['school_session_id'])
                ->where('student_id','=', $student_id)
                ->where('term_id','=', $result['term_id'])
                ->select('debts.*')
                ->get();

        }

         $data = [
             'paymente'=>$payments,
             'debts'=>$debt
         ];
        if(count($debt > 0)){
            return $data;
        }
        return null;


    }
}