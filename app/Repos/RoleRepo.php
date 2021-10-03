<?php
/**
 * Created by PhpStorm.
 * Role: jyde
 * Date: 6/2/2021
 * Time: 1:25 PM
 */

namespace App\Repos;


use App\iRepo\IRole;
use App\Models\Role;

class RoleRepo implements IRole
{


    public function create($data){
        $role = Role::create([
            'name' => $data['name'],
            'slug' => $data['slug'],

        ]);

        if($role) return $role;
        return null;

    }
    public function get($role_id){
        $role = Role::find($role_id);
        if($role){
            return $role;
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
        return Role::get();
    }

    /**
     * Deletes a Roles.
     *
     * @param int
     */
    public function delete($role_id){
        $role = Role::find($role_id);
        if($role){
            $deleted = $role->delete();
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
    public function update($role_id , $data){

        $role = Role::find($role_id);
        $result = null;

        if($role){
            $role->name = $data['name'];
            if( $role->name != $data['name'] ){
                $role->name = $data['name'];
            }
            if( $role->slug != $data['slug'] ){
                $role->slug = $data['slug'];
            }
            $result =  $role->save();
            if($result){
                return $role;
            }
            return null;

        }
        return null;

}
}