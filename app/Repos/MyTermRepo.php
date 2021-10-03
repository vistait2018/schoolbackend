<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/9/2021
 * Time: 11:32 AM
 */

namespace App\Repos;


use App\iRepo\iTerm;
use App\Models\SchoolSessionTerm;
use App\Models\Term;


class MyTermRepo implements iTerm
{

    /**
     * Get's a Users by it's ID
     *
     * @param int
     */


    public function get($term_id)
    {
        $term = Term::find($term_id);
        if($term) return $term;
        else return null;

    }

    /**
     * Get's all Users
     *
     * @return mixed
     */
    public function all()
    {
        $term = Term::all();
        if($term) return $term;
        else return null;
    }

    /**
     * Deletes a Users.
     *
     * @param int
     */
    public function delete($term_id)
    {
       $term = Term::find($term_id);
       if($term){
           $result = $term->delete();
           return $result;
       }
       return null;
    }

    /**
     * Updates a Users.
     *
     * @param int
     * @param array
     */
    public function update($iterm_id , $data)
    {
        $term = Term::find($iterm_id);
        $result = null;
        if($term){
            $term->name = $data['name'];
            $term->level = $data['level'];
            $result = $term->save();
            return $result;
        }
        return null;
    }

    public function endTerm()
    {
        /*$term = Term::where('status','=',true)->first();
        if($term) {
            $term->status = false;
            $term->save();
            return $term;
        }*/
        return null;
    }

    public function isMaxTerm($term)
    {
      $max_term = Term::max('level');
      $min_term = Term::min('level');


      if($term->level >= $max_term){

       return true;
      }

      return false;
    }


    public function presentTerm()
    {
        $present_term = Term::where('status',true)->first();
        if($present_term)return $present_term;
        else return null;
    }

    public function create($data)
    {
        if(is_null($data)) return null;

        $term = Term::create([
            'name' => $data['name'],
            'level' => $data['level'],
            'status' => false
        ]);
        if($term) return $term;
        return null;

    }

    public function maxTerm()
    {
       $max_term_level = Term::max('level');

        return $max_term_level;
       if($max_term_level){
           return $max_term_level;

       }

       return null;
    }

    public function minTerm()
    {
        $min_term_level = Term::min('level');
        if($min_term_level){
            return $min_term_level;

        }

        return null;
    }

    public function newTerm()
    {
        $present_session = SchoolSessionTerm::where('status',true)->first();
      // define('present_session_id',$present_session->school_session_id )  ;
       if($present_session){
           $last_term = Term::find($present_session->term_id);
           $is_max_term = $this->isMaxTerm($last_term);
           $result = null;
           $data =[];
           If($is_max_term){
               $data=[
                   'status' =>false,
                   'message'=>'You need to end This session first.'
               ];
               return $data;
           }

           $last_level = $last_term->level;
           $new_term = Term::where('level',$last_level+1)->first();
           if($new_term){

               //Sesion status update to false
               SchoolSessionTerm::where('id','>',0)->update(['status'=>false]);

               $result =  SchoolSessionTerm::create([
                   'term_id' => $new_term->id,
                   'school_session_id'=>  $present_session->school_session_id,
                   'status'=>true
               ]);

               //Term status update to false
               Term::where('id','>',0)->update(['status'=>false]);

               //Term Upadte new term term status to true
               Term::where('id',$new_term->id)->update(['status'=>true]);


               return $result;

           }

       }else{
           $data=[
               'status' =>false,
               'message'=>'No Active Session.You Need To start a session'
           ];
           return $data;
       }

    }

    public function minTermID()
    {
        $min_term = $this->minTerm();
        $min_term_Id = Term::where('level',$min_term)->first();
        return $min_term_Id->id;
    }

    public function maxTermID()
    {
        $max_term = $this->maxTerm();
        $max_term_Id = Term::where('level',$max_term)->first();
        return $max_term_Id->id;
    }
}