<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/1/2021
 * Time: 10:30 AM
 */

namespace App\Repos;


use App\iRepo\IUser;
use App\Models\Role_User;
use App\Models\User;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class UserRepo implements IUser
{
    /**
     * Get's a Users by it's ID
     *
     * @param int
     */
    public function get($user_id){
        $user = User::find($user_id);
        $roles = [];
        $data = [];
        if($user->has('roles')){
            foreach($user->roles as $role){
                array_push($roles,'name',$role->name );
                array_push($roles,'slug',$role->slug );
                array_push($roles,'created_at',$role->name );
                array_push($roles,'updated_at',$role->name );
            }
            $data = ['user' => $user, 'roles' =>$roles];
            return $data;
        }

        $data = ['user' => $user, 'roles' =>null];

        if($data != null){
            $data = ['user' => $user, 'roles' =>null];
        }
       return null;
    }

    /**
     * Get's all Users
     *
     * @return mixed
     */
    public function all(){
      return User::get();

    }

    /**
     * Deletes a Users.
     *
     * @param int
     */
    public function delete($user_id){
       $user = User::find($user_id);
        $deleted =null;
       if($user){
          $role = $user->roles()->delete();
          if($role) $deleted = $user->delete();
            if($deleted){

                return  $deleted ;
            }
       }
        return null;
    }

    /**
     * Updates a Users.
     *
     * @param int
     * @param array
     */
    public function update($user_id , $data){

        $user = User::find($user_id);
        $result = null;

        if($user){
            $user->name = $data['name'];
            if( $user->email != $data['email'] ){
                $user->email = $data['email'];
            }
            $result =  $user->save();
            if($result){
                return $user;
            }
          return null;

        }
        return null;


    }

    public function create($data){

        if(is_null($data)) return null;

        $user = User::create([
            'name' => $data['name'],
            'password' => bcrypt($data['password']),
            'email' => $data['email']
        ]);
        if($user) return $user;
        return null;


    }


    public function roleUpdate($data)
    {
     $user = User::find($data['user_id']);
     if($user){
         $roles =$user->roles()->sync($data['roles']);
         return $roles;
     }
      return null;
    }

    public function userRoleUpdate($data)
    {
       $user_update = $this->update($data['user_id'], $data);
       If($user_update != null){
           $role_update =  $this->roleUpdate($data);
           if($role_update != null) {
               return true;
           }

       }
       return null;


    }

    public function userRole($user_id){
        $user = User::find($user_id);
        if($user){
            return $user->roles;
        }
        return false;
    }

}