<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/21/2021
 * Time: 2:44 PM
 */

namespace App\Repos;


use App\iRepo\IStudent;
use App\Models\Debt;
use App\Models\GeneralBill;
use App\Models\Payment;
use App\Models\Rebate;
use App\Models\SchoolClass;
use App\Models\SchoolClassStudent;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentRepo implements IStudent
{

    public function create($data)
    {
        $student= null;
        if($data){
            $student =  Student::create([
                'first_name'=>$data['first_name'],
                'middle_name'=>$data['middle_name'],
                'last_name'=>$data['last_name'],
                'gender'=>$data['gender'],
                'address'=>$data['address'],
                'phone_no'=>$data['phone_no'],
                'dob'=>$data['dob'],
                'email'=>$data['email']
            ]);

        }

       if($student) return true;
       return null;
    }

    public function all()
    {
        $school_session_term_ids = new SchoolSessionRepo();
        $result = $school_session_term_ids->presentSessionTermDetails();


       $students = DB::table('school_class_student')
            ->join('students', 'students.id', '=', 'school_class_student.student_id')
            ->join('school_classes', 'school_classes.id', '=', 'school_class_student.school_class_id')
            ->where('school_class_student.term_id','=', $result['term_id'])
          ->where('school_session_id','=', $result['school_session_id'])
            ->select('students.*', 'school_classes.name as class_name', 'school_classes.id as class_id')
            ->get();

        if($students) return $students;

        return null;


    }

    public function findStudentById($id)
    {
        $school_session_term_ids = new SchoolSessionRepo();
        $result = $school_session_term_ids->presentSessionTermDetails();
        $student = DB::table('school_class_student')
            ->join('students', 'students.id', '=', 'school_class_student.student_id')
            ->join('school_classes', 'school_classes.id', '=', 'school_class_student.school_class_id')
            ->where('school_class_student.term_id','=', $result['term_id'])
            ->where('school_session_id','=', $result['school_session_id'])
            ->where('students.id','=', $id)
            ->select('students.*', 'school_classes.name as class_name', 'school_classes.id as class_id')
            ->first();
        //$student = Student::find($id);
        if($student) return $student;
        return null;
    }

    public function update($id, $data)
    {
        $student = Student::find($id);
        $result = null;
        if($student){
             $student->first_name = $data['first_name'];
               $student->middle_name = $data['middle_name'];
               $student->last_name = $data['last_name'];
                $student->gender = $data['gender'];
                $student->address = $data['address'];
                $student->phone_no = $data['dob'];
                $student->dob = $data['phone_no'];
                $student->email = $data['email'];
            $result=  $student->save();
            if($result) return $result;
        }
        return null;
    }

    public function delete($id)
    {
        $student = Student::find($id);
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();
        //$result = null;
        if($student){
            $deleted = $student->delete();
            if($deleted){
                SchoolClassStudent::where('student_id','=',$id)
                    ->where('school_session_id','=',$result['school_session_id'])
                    ->where('term_id','=',$result['term_id'])
                    ->delete();
            }

            return true;
        }

        return null;
    }

    public function addStudentsToClass($class_id, $student_ids)
    {

        $claean_student_ids = $this->checkIfStudentIsInClass($class_id, $student_ids);
        //return $claean_student_ids;
          $student_class = SchoolClass::find($class_id);
          // $student   = Student::find($student_id) ;

           $school_session_term_ids = new SchoolSessionRepo();
             $result= $school_session_term_ids->presentSessionTermDetails();



        if($student_class and $student_ids ){
       // $placed_in_class = null;
         foreach ($claean_student_ids as $student_id){



                $placed_in_class  = $student_class->students()->attach(
                    $student_id , ['term_id' => $result['term_id'], 'school_session_id'=> $result['school_session_id']]

                 );

             }
            return true;
         }

         return null;



    }

    public function removeStudentsFromClass($class_id, $data)
    {
        $student_class = SchoolClass::find($class_id);
        $result = null;
        if($student_class){
            $result = $student_class->students()->detach($data['student_id']);
        }

        if($result) return true;
        return null;
    }

    public function changeStudentClass($present_class_id, $student_id, $new_class_id)
    {
        $student_class = SchoolClass::find($present_class_id);
        $result = null;
        $school_session_term_ids = new SchoolSessionRepo();
        $result = $school_session_term_ids->presentSessionTermDetails();
        if($student_class){
            $detach = $student_class->students()->detach($student_id);
            if($detach){
                $student_new_class = SchoolClass::find($new_class_id);
                $student_new_class->students()->attach(
                    $student_id , ['term_id' => $result['term_id'], 'school_session_id'=> $result['school_session_id']]

                );
            }


        }

        if($result) return true;
        return null;
    }

    public function getStudentsInClass($class_id)
    {
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();
        //return $result;
        $class = null;
       if($class_id){



           $class = DB::table('school_class_student')
               ->join('students', 'students.id', '=', 'school_class_student.student_id')
               ->join('school_classes', 'school_classes.id', '=', 'school_class_student.school_class_id')
               ->where('school_classes.id','=', $class_id)
               ->where('school_class_student.term_id','=', $result['term_id'])
               ->where('school_session_id','=', $result['school_session_id'])
               ->select('students.*', 'school_classes.name as class_name', 'school_classes.id as class_id')
               ->get();
          /* $class =  SchoolClass::find($class_id);
          // return $class;
               $class->students()
                ->where('school_class_student.term_id','=', $result['term_id'])
               // ->orWhere('school_session_id','=', $result['school_session_id'])
                ->first();*/
           if($class){
               return $class;
           }
       }
    }

    public function checkIfStudentIsInClass($class_id, $student_ids)
    {
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();

        $data = [];
        if($student_ids){
            foreach ($student_ids as $student_id){
               $check_student_in_class = SchoolClassStudent::where('school_class_id','=',$class_id)
                   ->where('student_id','=',$student_id)
                   ->where('school_session_id','=',$result['school_session_id'])
                   ->where('term_id','=',$result['term_id'])
                   ->first();

              if($check_student_in_class ){
                  continue;

              }else{
                  $student_exist =Student::find($student_id);
                  if($student_exist){
                      array_push($data,$student_id);
                  }

              }

            }

            return  $data;
        }

        return null;
    }


    public function getPaymentProfileByClassId($student_id){
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();
         $data= [];
        $payment_profile = DB::table('general_bills')
            ->join('payments', 'general_bills_id', '=', 'general_bills.id')
            ->join('debts', 'debts.general_bill_id', '=', 'general_bills.id')
            ->where('payments.student_id','=', 'debts.student_id')
            ->where('school_session_id','=',$result['school_session_id'])
            ->where('term_id','=',$result['term_id'])
            ->select('general_bills.*', 'payments.*', 'debts.*')
            ->get();
       if($payment_profile) return $payment_profile;
      return null;

    }
    public function getTotalPaidPerBillItem($student_id,$bill_id){
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();
        $data= [];
        $payment_profile = DB::table('payments')
            ->where('payments.student_id','=', $student_id)
            ->where('school_session_id','=',$result['school_session_id'])
            ->where('term_id','=',$result['term_id'])
            ->where('general_bills_id','=',$bill_id)
            ->sum('amount_paid');
        if($payment_profile) return $payment_profile;
        return null;
    }

    public function getTotalOfAllBillPaidFor($student_id){
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();
        $data= [];
        $payment_profile = DB::table('payments')
            ->where('payments.student_id','=', $student_id)
            ->where('school_session_id','=',$result['school_session_id'])
            ->where('term_id','=',$result['term_id'])
               ->sum('amount_paid');
        if($payment_profile) return $payment_profile;
        return null;
    }

    public function getBalanceOfAllBillPaidFor($student_id){
     $amount_to_pay =$this->getSumofExpectedPayment($student_id);
     $amount_paid = $this->getTotalOfAllBillPaidFor($student_id);

     if($amount_paid == null)$amount_paid = 0;

        if($amount_to_pay == null)$amount_to_pay = 0;

        return $amount_to_pay -$amount_paid;
    }

    public function getBalanceOfSingleBillPaidFor($student_id,$bill_id,$amount_paid, $quantity, $rebate){
        $balance =0;
        $amount_to_pay =$this->getSumofSingleExpectedPayment($bill_id);
        $amount_paid = $this->getTotalPaidPerBillItem($student_id,$bill_id);
      // return gettype(floatval($amount_to_pay));
        if($amount_paid == null)$amount_paid = 0;

        if($amount_to_pay == null)$amount_to_pay = 0;

        $amount_to_pay = $amount_to_pay * $quantity - $rebate;

       $balance = floatval($amount_to_pay) -  floatval($amount_paid);
        return $balance;
    }

    public function  getSumofSingleExpectedPayment($bill_id){
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();
        $data= [];
        $payment_profile = DB::table('general_bills')

            ->where('id','=',$bill_id)


            ->sum('amount');
        if($payment_profile) return $payment_profile;
        return null;
    }

    public function getSumofExpectedPayment($student_id){
        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();
        $data= [];
        $payment_profile = DB::table('general_bills')
            ->join('payments', 'payments.general_bills_id', '=', 'general_bills.id')
              ->where('school_session_id','=',$result['school_session_id'])
            ->where('term_id','=',$result['term_id'])
            ->where('student_id','=',$student_id)
             ->sum('amount');
        if($payment_profile) return $payment_profile;
        return null;
    }
    public function myBill($student_id){

        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();
        $billRepo = new GeneralBillRepo();



           $class = $this->getStudentClassByStudentId($student_id);

             $rebate = Rebate::where('school_session_id','=',$result['school_session_id'])
                 ->where('term_id','=',$result['term_id'])
                 ->where('student_id','=',$student_id)
                 ->sum('amount');

        $data= [];
        $bills = $billRepo->myBillByClassId($class->class_id);
        $debtRepo = new DebtRepo();
        $bill_trackers = $debtRepo->findStudentId($student_id);

        $debt = 0;

        foreach($bills as $i => $bill) {
            $bill->quantity = $bill->type == 1 || $bill->type == 3 ? 1 : 0;
            $bill->isChecked = $bill->type == 1 || $bill->type == 3;
            $bill->rebate = $bill->type == 1 ? $rebate : 0;
            foreach ($bill_trackers as $bill_tracker) {
                if ($bill_tracker->general_bill_id == $bill->id && $bill_tracker->quantity > 0) {
                    $bill->isChecked = true;
                    $bill->quantity = $bill_tracker->quantity;
                }
            }
            $bill->amount_paid = $this->getTotalPaidPerBillItem($student_id,$bill->id);
            $balance = $this->getBalanceOfSingleBillPaidFor($student_id,$bill->id,$bill->amount_paid, $bill->quantity, $bill->rebate);
            $bill->balance = $balance;
            array_push($data ,$bill);
        }

        foreach($data as $i => $bill) {
            if ($bill && $bill->isChecked) {
                if ($bill->quantity > 0) {
                    $debt += (floatval($bill->amount) * $bill->quantity) - $bill->amount_paid;
                } else {
                    $debt += floatval($bill->amount) - $bill->amount_paid;
                }
            }
        }

        return array(
            'debt' => $debt,
            'bills' => $data
        );
    }



    public function checkIfAStudentIsInClass($class_id, $student_id)
    {

        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();

                $check_student_in_class = SchoolClassStudent::where('school_class_id','=',$class_id)
                   ->where('student_id','=',$student_id)
                    ->where('school_session_id','=',$result['school_session_id'])
                   ->where('term_id','=',$result['term_id'])
                   ->first();
              //return $check_student_in_class;
      if($check_student_in_class) return true;

            return  null;


    }

    public function addStudentToAClass($class_id, $student_id)
    {
       // $claean_student_ids = $this->checkIfAStudentIsInClass($class_id, $student_id);
       // return $claean_student_ids;
        $student_class = SchoolClass::find($class_id);
        // $student   = Student::find($student_id) ;

        $school_session_term_ids = new SchoolSessionRepo();
        $result= $school_session_term_ids->presentSessionTermDetails();



        if($student_class  ){
            // $placed_in_class = null;
                          $placed_in_class  = $student_class->students()->attach(
                    $student_id , ['term_id' => $result['term_id'], 'school_session_id'=> $result['school_session_id']]

                );

                      return true;
        }

        return null;

    }

    public function lastInsertedStudentId()
    {
        $new_student = Student::orderBy('id', 'desc')->take(1)->first();
        if($new_student){
            return $new_student->id;
        }else{
            return null;
        }
    }

    public function noOfStudent(){
        $student = Student::all();
        if($student) return $student->count();
        return 0;
    }

    public function findStudentByLastnameFirstNameAndClass($first_name=null,$last_name =null,$class_id =null)
    {

        // todo
        

    }
    public function getStudentClassByStudentId($student_id){
        $school_session_term_ids = new SchoolSessionRepo();
        $result = $school_session_term_ids->presentSessionTermDetails();


        $students = DB::table('school_class_student')
            ->join('students', 'students.id', '=', 'school_class_student.student_id')
            ->join('school_classes', 'school_classes.id', '=', 'school_class_student.school_class_id')
            ->where('school_class_student.term_id','=', $result['term_id'])
            ->where('school_session_id','=', $result['school_session_id'])
            ->where('school_class_student.student_id','=', $student_id)
            ->select('school_classes.name as class_name', 'school_classes.id as class_id')
            ->first();

        if($students) return $students;

        return null;
    }

    public function saveQuantity($studentId, $classId, $data){
        $debts =Debt::where('student_id', $studentId)
           ->where('school_class_id', $data['school_class_id'])
            ->where('school_session_id', $data['school_session_id'])
          ->where('general_bill_id', $data['general_bill_id'])
            ->where('term_id', $data['term_id'])
            ->where('collected', $data['collected'])
           ->where('isChecked', $data['isChecked'])
            ->first();



        if ($debts !== null) {
           $debts->quantity = (int)$data['quantity'];
            if($debts->id){
                $debts->update($data);
            }

        } else {
            $debts = Debt::create($data);
        }
           if($debts) return $debts;
         return [];

    }


 public function addAndRemoveGeneralToPayment($studentId, $classId,$data){
     // return $data['isChecked'];
     $savedDebt = null;
   $status = false;
     $debt = Debt::where('student_id', $studentId)
         ->where('school_class_id', $classId)
         ->where('general_bill_id', $data['general_bill_id'])
         ->where('school_class_id', $data['school_class_id'])
         ->where('term_id', $data['term_id'])
         ->where('general_bill_name', $data['general_bill_name'])
       //  ->where('quantity', $data['quantity'])
         ->first();

//       return  $debt;
     if ($debt) {
         $debt = Debt::find($debt->id);
         $debt->quantity = $data['quantity'];
         $debt->isChecked = $data['isChecked'];
         $debt->save();
       } else {
         $savedDebt = Debt::create($data);
      //  return  $savedDebt;
       if($savedDebt)  $status = true;
              }
     return $status;

}
}