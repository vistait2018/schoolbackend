<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/28/2021
 * Time: 12:59 PM
 */

namespace App\Repos;


use App\iRepo\IPayment;
use App\Models\Debt;
use App\Models\GeneralBill;
use App\Models\Payment;

class PaymentRepo implements IPayment
{

    public function pay($data)
    {
        $pay = $this->payment($data);
        if($pay){
           $clear_debt = $this->clearDebts($data['general_bills_id']);
        }

        if($clear_debt){
            return $pay;
        }
        return null;
   }

private function payment($data){
    $school_session_term_ids = new SchoolSessionRepo();
    $result= $school_session_term_ids->presentSessionTermDetails();
    return data;

}

private function clearDebts($bill_ids){

    $school_session_term_ids = new SchoolSessionRepo();
    $result= $school_session_term_ids->presentSessionTermDetails();
    $clear_debt= null;
    foreach ($bill_ids as $bill_id){
        $bill = GeneralBill::find($bill_id);

        $clear_debt = Debt::where('general_bills_id',$bill_id)
            ->where('school_session_id',$result['school_session_id'] )
            ->where('amount_paid','=',$bill->amount )
            ->where('term_id','=',$result['term_id'])
            ->delete();
    }
    if($clear_debt) return true;
    return null;

}




}