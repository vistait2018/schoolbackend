<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Repos\SchoolSessionRepo;
use App\Repos\StudentRepo;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use PHPUnit\Exception;


class StudentController extends Controller
{

    use ApiResponser;
    protected $studentRepo;
    protected $schoolSessionRepo;


    public function __construct(StudentRepo  $studentRepo, SchoolSessionRepo $schoolSessionRepo)
    {
        $this->studentRepo = $studentRepo;
        $this->schoolSessionRepo = $schoolSessionRepo;

    }
   public function index(Request $request){
      try{
        $student = $this->studentRepo->all();

       if($student) return $this->success($student,'All Students ',200);
            return $this->error('Error Retrieving  School Records  ',404);


       }catch(Exception $ex){
           return $this->error('Internal Server Error',500);
       }
   }


   public function findStudentById($id){
       try{
           $student =  $this->studentRepo->findStudentById($id);
           if($student) return $this->success($student,'Student Record retrieved ',200);
           return $this->error('Error Retrieving  School Record  ',404);


       }catch(Exception $ex){
           return $this->error('Internal Server Error',500);
       }
   }

   public function findStudentByParams(Request $request){
       //return $request;
       try{
           $student =  $this->studentRepo->findStudentByLastnameFirstNameAndClass($request->get('first_name'), $request->get('last_name'), intval($request->get('class_id')));
           if($student) return $this->success($student,'Student Record retrieved ',200);
           return $this->error('Error Retrieving  School Record  ',404);


       }catch(Exception $ex){
           return $this->error('Internal Server Error',500);
       }
   }
    public function myBill($student_id){
        try{
            $student_bill =  $this->studentRepo->myBill($student_id);
            if($student_bill>= 0)return $this->success($student_bill,'Student Bill Record retrieved ',200);
            return $this->error('Error Retrieving  School Bill Record  ',404);


        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }
    }

   public function deleteStudent($student_id){
       try{
           $student =  $this->studentRepo->delete($student_id);
           if($student) return $this->success($student,'Student Record deleted ',200);
           return $this->error('Error Deleting  School Record |Perhaps Student doess   ',404);


       }catch(Exception $ex){
           return $this->error('Internal Server Error',500);
       }
   }

   public function createStudent(Request $request){
       // return $request;
      try{
          $data =[
              'first_name'=> $request->input('first_name'),
              'middle_name'=> $request->input('middle_name'),
              'last_name'=> $request->input('last_name'),
              'address'=> $request->input('address'),
              'dob'=> $request->input('dob'),
              'phone_no'=> $request->input('phone_no'),
              'email'=> $request->input('email'),
              'gender'=> $request->input('gender'),

          ];
          $student =  $this->studentRepo->create($data);
          $new_student_id = $this->studentRepo->lastInsertedStudentId();

          If(is_null($new_student_id)){
              return $this->error('Internal Server Error',500);
          }


              if($new_student_id){
                  $this->studentRepo->addStudentToAClass($request->class_id, $new_student_id);
                  return $this->success($student,'Student Record Created ',200);
              }
              return $this->error('Error Creating  School Record  ',404);



      }catch(Exception $ex ){

      }

   }
   public function updateStudent(Request $request, $student_id, $class_id){
       try{

           $data = [
              'first_name'=> $request->input('first_name'),
           'middle_name'=> $request->input('middle_name'),
           'last_name'=> $request->input('last_name'),
           'address'=> $request->input('address'),
           'dob'=> $request->input('dob'),
           'phone_no'=> $request->input('phone_no'),
               'email'=> $request->input('email'),
               'gender'=> $request->input('gender'),

           ];
           $student =  $this->studentRepo->update($student_id,$data);
           if($student){
               $this->studentRepo->addStudentToAClass($class_id, $student_id);
                   return $this->success($student,'Student Record updated ',200);
           }
           return $this->error('Error Updating  School Record  ',404);


       }catch(Exception $ex){
           return $this->error('Internal Server Error',500);
       }
   }
   public function addStudentsToClass(Request $request, $class_id){
       try{
           $class = SchoolClass::find($class_id);
           if($class) {
               $addedStudents = $this->studentRepo->addStudentsToClass($class_id, $request->input('student_id'));
               if ($addedStudents) return $this->success($addedStudents, 'Students Added to Classs ', 200);
               return $this->error('Error Retrieving  Adding Student to Class  ', 404);

           }

           return $this->error('Error: Class does not exist  ', 404);
       }catch(Exception $ex){
           return $this->error('Internal Server Error',500);
       }
   }


   public function getStudentsInClass($class_id){
       try{
          //return $class_id;

               $Students = $this->studentRepo->getStudentsInClass($class_id);
               if ($Students) return $this->success($Students, 'Students In Class are as follows: ', 200);
               return $this->error('Error Retrieving   Students In Class | Perhaps there are no student in the class ', 404);


       }catch(Exception $ex){
           return $this->error('Internal Server Error',500);
       }
   }


   public function changeStudentClass( $student_id, $present_class_id, $new_class_id){
       try{
            $present_class = SchoolClass::find($present_class_id);
           $present_class = SchoolClass::find($new_class_id);
           $studentInClass= $this->studentRepo->checkIfAStudentIsInClass($present_class_id, $student_id);
           //return $studentInClass;
          if($studentInClass){
              $Students = $this->studentRepo->changeStudentClass($present_class_id, $student_id, $new_class_id);

              if ($Students) return $this->success($Students, 'Students Class Changed from '.$present_class->name.' to '.$present_class->name, 200);
              return $this->error('Error   changing student class ', 404);

          }
           return $this->error('Student Not in the class '.$present_class->name, 404);

       }catch(Exception $ex){
           return $this->error('Internal Server Error',500);
       }
   }

    public function noOfStudents(){
        try{
            $no_of_students  = $this->studentRepo->noOfStudent();
            if($no_of_students){
                $this->success($no_of_students, 'No of Student ', 200);
            }
            return $this->error('Error getting no of students ', 404);
        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }
    }


    public function saveStoreDebts($studentId, $classId,Request $request){
        $school_session_term_ids = new SchoolSessionRepo();
        $result = $school_session_term_ids->presentSessionTermDetails();
     //
        // return $request;
        $data =[
            'general_bill_id' => intval($request->input('general_bill_id')),
            'student_id' =>$studentId,
            'school_class_id'=>$request->input('school_class_id'),
            'school_session_id'=>$result['school_session_id'],
            'term_id'=>$result['term_id'],
            'collected'=>$request->input('collected'),
            'general_bill_name'=>$request->input('general_bill_name'),
            'quantity'=> $request->input('quantity'),
            'isChecked'=>$request->input('isChecked')
        ];


        try{
            $bill_amount =$this->studentRepo->getSumofSingleExpectedPayment($data['general_bill_id']);
            $amount_paid = $this->studentRepo->getTotalPaidPerBillItem($studentId, $data['general_bill_id']);

            $leastQuantity = ceil($amount_paid / $bill_amount);

            if ((int)$data['quantity'] < $leastQuantity) {
                return $this->error('You cannot reduce once have have made part-payment',500);
            }

            $storeDebt  = $this->studentRepo->saveQuantity($studentId, $classId, $data);
            if($storeDebt != null){

              return   $this->success($storeDebt, 'Store Debts Saved ', 200);
            }
            return $this->error('Error getting no of students ', 404);
        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function addToGeneralBill($studentId, $classId,Request $request){

        $school_session_term_ids = new SchoolSessionRepo();
        $result = $school_session_term_ids->presentSessionTermDetails();

        $data =[
            'general_bill_id' => intval($request->input('id')),
            'student_id' =>$studentId,
            'school_class_id'=>$classId,
            'school_session_id'=>$result['school_session_id'],
            'term_id'=>$result['term_id'],
            'collected'=>false,
            'general_bill_name'=>$request->input('name'),
            'quantity'=> 1,
            'isChecked'=> true
        ];
    //  return $data;
        try{
            $storeDebt  = $this->studentRepo->addAndRemoveGeneralToPayment($studentId, $classId, $data);

          return [
              'status'=>'success',
              'message'=>'general bill',
              'data'=>$storeDebt
          ];
        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }
    }


    public function removeFromGeneralBill($studentId, $classId,Request $request){

        $school_session_term_ids = new SchoolSessionRepo();
        $result = $school_session_term_ids->presentSessionTermDetails();

        $amount_paid = $this->studentRepo->getTotalPaidPerBillItem($studentId, intval($request->input('id')));

        if ($amount_paid > 0) {
            return $this->error('You cannot reduce once have have made part-payment', 404);

           // return $this->error('You cannot reduce once have have made part-payment',500);
        }

        $data =[
            'general_bill_id' => intval($request->input('id')),
            'student_id' =>$studentId,
            'school_class_id'=>$classId,
            'school_session_id'=>$result['school_session_id'],
            'term_id'=>$result['term_id'],
            'collected'=>false,
            'general_bill_name'=>$request->input('name'),
            'quantity'=> 0,
            'isChecked'=> false
        ];
        //  return $data;
        try{
            $storeDebt  = $this->studentRepo->addAndRemoveGeneralToPayment($studentId, $classId, $data);

            return [
                'status'=>'success',
                'message'=>'general bill',
                'data'=>$storeDebt
            ];
        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }
    }

}
