<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/1/2021
 * Time: 10:26 AM
 */


namespace App\iRepo;

interface IUser
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

    /**
     * Create a Users.
     *
     * @param int
     * @param array
     */
    public function create($data);

    public function roleUpdate($data);

    public function userRoleUpdate($data);

    public function userRole($user_id);
}