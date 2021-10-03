<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/1/2021
 * Time: 10:26 AM
 */


namespace App\iRepo;

interface ISchool
{
    /**
     * Get's a Users by it's ID
     *
     * @param int
     */
    public function get($user_id);

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
    public function delete($user_id);

    /**
     * Updates a Users.
     *
     * @param int
     * @param array
     */
    public function update($user_id, $data);

    public function upload($photo,$data);

 public function mySchool();


}