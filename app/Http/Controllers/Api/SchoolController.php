<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Repos\SchoolRepo;
use App\Http\Requests\SchoolCreateRequest;
use App\Http\Requests\ImageUpload;

class SchoolController extends Controller
{
    use ApiResponser;
    protected $schoolRepo;

    public function __construct(SchoolRepo $schoolRepo){
        $this->schoolRepo = $schoolRepo;
    }

    public function index(){
        try{
            $schools = $this->schoolRepo->all();
            if($schools)  return $this->success($schools,'School Record',200);
            return  $this->error('Error Retrieving  School Record  ',404);
        }
        catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function getSchool($school_id){
        $school = $this->schoolRepo->get($school_id);

        try{
            if($school != null){
                return $this->success($school,'School Records',200);

            }else{
                return $this->error('Error Rerieving  School Record  ',404);
            }
        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }

    }

    public function createSchool(SchoolCreateRequest $request){
        try{
            $school = [

                'school_name'=> $request->input('school_name'),
                'address'=>  $request->input('address'),
                'phone_no2'=>  $request->input('phone_no2'),
                'phone_no1'=>  $request->input('phone_no1'),
                'established_at' =>  $request->input('established_at'),
                'school_owner'=>  $request->input('school_owner'),
                'email'=>  $request->input('email')

            ];
   // return $school;
            $created = $this->schoolRepo->create($school) ;
            if($created)  return $this->success($created,'School Record Created ',200);

            return $this->error('School Record Could not be created',404);
        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function editSchool(SchoolCreateRequest $request,$school_id){
        try{
            $data = [

                'school_name'=> $request->input('school_name'),
                'address'=>  $request->input('address'),
                'phone_no2'=>  $request->input('phone_no2'),
                'phone_no1'=>  $request->input('phone_no1'),
                'established_at' =>  $request->input('established_at'),
                'school_owner'=>  $request->input('school_owner'),
                'email'=>  $request->input('email')

            ];
            // return $school;
            $created = $this->schoolRepo->update($school_id,$data) ;
            if($created)  return $this->success($created,'School Record Updated',200);

            return $this->error('School Record Could not be updated',404);
        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function deleteSchool($id){
        try{

            $result = $this->schoolRepo->delete($id);
            if($result){
                return $this->success($result,'School Record Deleted ',200);
            }
            return $this->error('Error Deleting  School Record  ',404);


        }catch(Exception  $ex){
            return $this->error('Internal Server Error',500);
        }
    }


    public function upload(ImageUpload $request,$school_id){
        try{

            $photo = $request->file('school_logo');

            $result = null;
            $file = null;

            $school = \App\Models\School::find($school_id);
            $school->school_logo = $file;
            $result = $school->save();

               @unlink($school->school_logo);
               $destinationPath = "uploadedImages";
               $newName = md5_file($photo->getRealPath());
               $guessFileExtension = $photo->guessExtension();
               $file = $request->file('school_logo')->move($destinationPath, $newName.'.'.$guessFileExtension);

               $school->school_logo = $file;
               $result = $school->save();

     //return $result;

            if($result){
                return $this->success($result,'School Logo Uploaded ',200);
            }
            return $this->error('Error Uploaded School Logo  ',404);
        }
       catch(Exception $ex){
           return $this->error('Internal Server Error',500);
       }

    }

    public function deleteImage($school_id) {
      $result = null;
      try{
          $school = \App\Models\School::find($school_id);
          if($school){
              unlink($school->school_logo);
              $result=   School::where("id", $school_id)->delete();
          }


         if($result)   return $this->success($result,'School Logo Deleted ',200);
         else  return $this->error('Error Error Deleting School Logo| School not found  ',404);


      } catch(Exeption $ex){
          return $this->error('Internal Server Error',500);
      }
    }


    public function mySchoolSize(){

    }

}
