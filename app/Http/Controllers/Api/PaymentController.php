<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Repos\PaymentRepo;
use App\Repos\SchoolSessionRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use App\Traits\ApiResponser;
use \App\Models\Payment;

class PaymentController extends Controller
{

    use ApiResponser;
    protected $paymentRepo;



    public function __construct(PaymentRepo  $paymentRepo)
    {
        $this->paymentRepo = $paymentRepo;


    }
    public function pay(Request $request, $student_id){

        $data = $request->data;
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();

        try{

           foreach ($data as $d){
               $payment = Payment::where('payments.student_id','=', $student_id)
                   ->where('school_session_id','=',$result['school_session_id'])
                   ->where('term_id','=',$result['term_id'])
                   ->where('general_bills_id','=',$d['general_bill_id'])
                   ->first();

               if($payment){
                      $payment->amount_paid = floatval($payment->amount_paid) + floatval($d['amount_paid']);
                      $payment->transaction_id = $request->transaction_id;
                      $payment->save();
               } else {
                   $paymentData = [
                       'student_id' => $student_id,
                       'school_session_id' => $result['school_session_id'],
                       'term_id' => $result['term_id'],
                       'general_bills_id' => $d['general_bill_id'],
                       'amount_paid' => floatval($d['amount_paid']),
                       'transaction_id' => $request->transaction_id,
                   ];
                   Payment::Create($paymentData);
               }
           }


        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }
    }
}
