<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/1/2021
 * Time: 10:26 AM
 */


namespace App\iRepo;

interface iTerm
{
    /**
     * Get's a Users by it's ID
     *
     * @param int
     */
    public function get($term_id);

    /**
     * Get's all Users
     *
     * @return mixed
     */
    public function all();

    /**
     * Deletes a Users.
     *
     * @param int
     */
    public function delete($term_id);

    /**
     * Updates a Users.
     *
     * @param int
     * @param array
     */
    public function update($iterm_id,$data);

     public  function create($data);

    public function endTerm();

    public function isMaxTerm($term);


    public function presentTerm();

    public function maxTerm();

    public function minTermID();
    public function maxTermID();

    public function minTerm();

    public function newTerm();

}