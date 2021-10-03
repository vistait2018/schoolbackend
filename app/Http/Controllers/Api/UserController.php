<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserUpdateRequest;
use App\Mail\MailInfo;
use App\Mail\UserRegistration;
use App\Repos\UserRepo;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;
use App\Http\Controllers\Controller;

class UserController extends Controller
{


    use ApiResponser;
    protected $userRepo;

    public function __construct(UserRepo  $userRepo)
    {
       $this->userRepo = $userRepo;
    }

    public function index()
    {

        try{
            $users = $this->userRepo->all();
            if($users->count() > 0){
                return $this->success($users,'User Record ',200);

            }else{
                return $this->error('Error Retrieving  User Record  ',404);
            }
        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }



    }

    public function getUser(Request $request,$user_id){
        $user = $this->userRepo->get($user_id);

        try{
            if($user != null){
                return $this->success($user,'User Record ',200);

            }else{
                return $this->error('Error Rerieving  User Record  ',404);
            }
        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }




    }


    public function editUser(UserUpdateRequest $request,$id ){

        try{
            if(!$id){
                return $this->error('User Id Required',404);
            }

            $data = [ 'name'=> $request->input('name'), 'email'=> $request->input('email')];

            $updatedUser = $this->userRepo->update($id, $data);
            If($updatedUser != null){
                return $this->success($updatedUser,'User Record Updated ',200);
            }
                return $this->error('Error Updating  User Record  ',404);

        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }


    }

    public function deleteUser($id){
        try{

            $result = $this->userRepo->delete($id);
            if($result){
                return $this->success($result,'User Record Deleted ',200);
            }
            return $this->error('Error Deleting  User Record  ',404);


        }catch(Exception  $ex){
            return $this->error('Internal Server Error',500);
        }



    }


    public function craeteUser(UserUpdateRequest $request){
       try{
           $data = [
               'name' =>$request->input('name'),
               'password' => $request->input('password'),
               'email' => $request->input('email')
           ];

           $createdUser = $this->userRepo->create($data);
           if($createdUser != null){
              // unset($data['password']);
               $info = new MailInfo('User Registration', '');
               Mail::to($data['email'])->send(new UserRegistration($data, $info));
               return $this->success($createdUser,'User Record ',200);
           }
           return $this->error('Error Creating  User ',404);
       }catch(Exception $ex){
           return $this->error('Internal Server Error',500);
       }
    }


    public function roleUpdate(Request $request ,$id){
        try{
             $data = ['user_id'=> $id, 'roles'=>$request->input('roles') ];
            // return $data['user_id'];
             $result = $this->userRepo->roleUpdate($data);
            if($result){
                return $this->success($result,'User Roles Updated ',200);
            }
            return $this->error('Error Updating  User Record  ',404);


        }catch(Exception  $ex){
            return $this->error('Internal Server Error',500);
        }



    }

    public function userRoleUpdate(Request $request,$id){
        try{

            $data = [
                'user_id'=> $id,
                'roles'=>$request->input('roles'),
                'email'=>$request->input('email'),
                'name'=>$request->input('name'),
                ];
            $result = $this->userRepo->userRoleUpdate($data);
            if($result){
                return $this->success($result,'User and User Roles Updated ',200);
            }
            return $this->error('Error Updating  User Record  ',404);



        }catch(Exception  $ex){
            return $this->error('Internal Server Error',500);
        }



    }

    public function getUserRoles($user_id){
        try{


            $result = $this->userRepo->userRole($user_id);
            if($result){
                return $this->success($result,'User and User Roles  ',200);
            }
            return $this->error('Error Updating  User Record  ',404);



        }catch(Exception  $ex){
            return $this->error('Internal Server Error',500);
        }
    }


}
