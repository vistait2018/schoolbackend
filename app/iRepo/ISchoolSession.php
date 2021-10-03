<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/9/2021
 * Time: 1:31 PM
 */

namespace App\iRepo;


interface ISchoolSession
{
    public  function get($school_session_id);
    public function all();
    public function update($school_session_id, $data);
    public function delete($school_session_id);
    public function present_session();
    public function check_start_session();
    public function end_session();
    public function create_session($data);
    public function changeSessionTerm();
    public function endSessionTerm() ;
    public function endSchoolSession();
    public function endTerm();
    public function beginTerm();
    public function presentSessionTermDetails();



}