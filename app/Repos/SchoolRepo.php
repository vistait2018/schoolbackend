<?php
/**
 * Created by PhpStorm.
 * Role: jyde
 * Date: 6/2/2021
 * Time: 1:25 PM
 */

namespace App\Repos;


use App\iRepo\ISchool;
use App\Models\School;
use Storage;
use Illuminate\Http\Request;

class SchoolRepo implements ISchool
{


    public function create($data){
        $school = School::create($data);

        if($school) return $school;
        return null;

    }
    public function get($school_id){
        $school = School::find($school_id);
        if($school){
            return $school;
        }else {
            return null;
        }
    }

    /**
     * Get's all Roles
     *
     * @return mixed
     */
    public function all(){
        $school =  School::first();
        //$school->school_logo = secure_asset('/images/82afbfaa2a64cebfd0077f73abe15659.png');
        if($school) return $school;
        return null;
    }

    /**
     * Deletes a Roles.
     *
     * @param int
     */
    public function delete($zchool_id){
        $zchool_id = School::find($zchool_id);
        if($zchool_id){
            $deleted = $zchool_id->delete();
            if($deleted){
                return  $deleted ;
            }
        }
        return null;
    }

    /**
     * Updates a Roles.
     *
     * @param int
     * @param array
     */
    public function update($school_id ,$data){
        $school = School::find($school_id);
        if($school){
            $school->school_name = $data['school_name'];
            $school->address =      $data['address'];
            $school->phone_no2 = $data['phone_no2'];
            $school->phone_no1 = $data['phone_no1'];
            $school->established_at = $data['established_at'];
            $school->address = $data['school_owner'];
            $school->email = $data['email'];
            $school->save();
           return  $school;
        }

        return null;

    }

    public function upload($user_id ,$data){
        return $data;
        if(empty($data)) return null;
        $result = null;

        $destinationPath = "uploadedImages";

        $newNameComplete = $data['newName'].$user_id.'.'.$data['guessFileExtension'];
        $file = $photo->move($destinationPath, $newNameComplete);

        if($file){
            $school = School::find($user_id);
            $school->school_logo = $newNameComplete;
            $result = $school->save();

        }

        if($result !=  null){
            return true;
        }else{
            return null;
        }
      return null;
    }

    public function mySchool(){
        $school = School::first();
        if($school) return $school;
        return null;
    }
}