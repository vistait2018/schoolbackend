<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/9/2021
 * Time: 2:32 PM
 */

namespace App\Repos;


use App\iRepo\ISchoolSession;
use App\Models\School;
use App\Models\SchoolSession;
use App\Models\SchoolSessionTerm;
use App\Models\Term;

class SchoolSessionRepo implements ISchoolSession
{

    public function get($school_session_id)
    {
       $school_sessions = SchoolSession::first($school_session_id);
       if($school_sessions) return $school_sessions;
       return null;
    }

    public function all()
    {
        $school_sessions = SchoolSession::all();
        if($school_sessions) return $school_sessions;
        return null;
    }

    public function update($school_session_id, $data)
    {
        $school_sessions = SchoolSession::first($school_session_id);
        if($school_sessions){
            $school_sessions->start = $data['start'];
            $school_sessions->end = $data['end'];

            $school_sessions->term_id = $data['term_id'];
          $result =  $school_sessions->save();

          if($result) return $school_sessions;
        }
        return null;
    }

    public function delete($school_session_id)
    {
       $session_to_delete = SchoolSession::find($school_session_id);
       if($session_to_delete) {
           $result = $session_to_delete->delete();
           return $session_to_delete;
       }
       return null;
    }

    public function present_session()
    {
        $present_school_session = SchoolSession::where('status',true)->first();
        if($present_school_session) return $present_school_session;
        return null;

    }

    public function check_start_session()
    {
        $check_start_session = SchoolSessionTerm::where('status',true)->first();
        $data= [];
        if($check_start_session){

            return false;
        }
        return true;
    }

    public function end_session()
    {
        // TODO: Implement end_session() method.
    }

    public function create_session($data){

        if(is_null($data)) return null;
        $rdata=[];
        $max = Term::max('level');
        $join_table = SchoolSessionTerm::latest('id')->first();
        $term = Term::find($join_table->term_id);
       // return $join_table;
        if($term->level > $max){
            $rdata = [
                'message' => 'we need to be in the final term before we can end session'
            ]  ;

            return $rdata;
        }

        if(($join_table->status == true) && ($term->level == $max) ){
            $rdata = [
                'message' => 'You are in the final term but you must end the term first'
            ]  ;

            return $rdata;
        }

        if(($join_table->status == false) && ($term->level == $max) ){

            $session = SchoolSession::create([
                'start' => $data['start'],
                'end' => $data['end'],
                'status' => true,
            ]);
            $data['school_session_id'] = $session->id;
            //  return $data;

            // first term


            if($session){
                $myterm = new MyTermRepo();
                $newTerm = Term::where('level',$myterm->minTerm())->first();
                // return $newTerm;
                $session_to_term =SchoolSession::find( $data['school_session_id']);


                $session_to_term->terms()->attach($newTerm->id , ['status' => true]);
                $this->beginTerm();

                return true;
            }
        }



        return null;

    }

    public function changeSessionTerm()
    {
        // TODO: Implement changeSessionTerm() method.
    }

    public function endSessionTerm()
    {

    }

    public function endSchoolSession()
    {
        $join_table = SchoolSessionTerm::latest('id')->first();
        if($join_table){
            $school_session = SchoolSession::find($join_table->school_session_id);

            $result = $school_session->terms()->updateExistingPivot($join_table->term_id, [
                'status' => false,
            ]);
            if($result){
                $school_session->status =false;
                $school_session->save();
                Term::where('id','>',0)->update(['status'=>false]);
                return true;
            }
        }
        return null;
    }

    public function endTerm()
    {
        $active_terms = \App\Models\Term::where('status',true)->get();
        $active_result = null;


        foreach($active_terms as $term){
            $term->status = false;
            $active_result =  $term->save();
        }


    }

    public function beginTerm()
    {
         $this->endTerm();

        $minimun_active =Term::min('level');

        $minimun_active = Term::where('level',$minimun_active)->first();

        $minimun_active->status = true;
        $minimun_active_result= $minimun_active->save();
        //return $minimun_active_result;
    }

    public function presentSessionTermDetails()
    {
        $term_details = \App\Models\Term::select('id','name','level')->where('status',true)->get();
        $session_details = \App\Models\SchoolSession::select('id','start','end')->where('status',true)->get();
        $data= null;
        If($term_details )
        $data =[
            'term_id' => $term_details[0]['id'],
            'term_name'=> $term_details[0]['name'],
            'school_session_id' => $session_details[0]['id'],
            'school_session_name' => $session_details[0]['start'] . "/" . $session_details[0]['end'] ,

        ];
        return $data;

    }
}