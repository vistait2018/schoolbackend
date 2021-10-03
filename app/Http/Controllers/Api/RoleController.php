<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\RoleUpdateRequest;
use App\Repos\RoleRepo;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleCreateRequest;

class RoleController extends Controller
{
    use ApiResponser;
    protected $roleRepo;

    public function __construct(RoleRepo  $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }

    public function index()
    {

        try{
            $roles = $this->roleRepo->all();
            if($roles->count() > 0){
                return $this->success($roles,'Role Records ',200);

            }else{
                return $this->error('Error Retrieving  Role Record  ',404);
            }
        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }



    }

    public function getRole(Request $request,$role_id){
        $role = $this->roleRepo->get($role_id);

        try{
            if($role != null){
                return $this->success($role,'Role Record ',200);

            }else{
                return $this->error('Error Rerieving  Role Record  ',404);
            }
        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }




    }

    public function createRole(RoleCreateRequest $request){
        try{
            $data = [
                'name'=> $request->input('name'),
                'slug'=>$request->input('slug'),
            ];
           $created = $this->roleRepo->create($data) ;
           if($created)  return $this->success($created,'Role Record Created ',200);

             return $this->error('Role Record Could nit be created',404);
        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }
    }
    public function editRole(RoleUpdateRequest $request,$id ){

        try{
            if(!$id){
                return $this->error('Role Id Required',404);
            }

            $data = [ 'name'=> $request->input('name'), 'slug'=> $request->input('slug')];

            $updatedRole = $this->roleRepo->update($id, $data);
            If($updatedRole != null){
                return $this->success($updatedRole,'Role Record Updated ',200);
            }
            return $this->error('Error Updating  Role Record  ',404);
        }catch(Exception $ex){
            return $this->error('Internal Server Error',500);
        }


    }

    public function deleteRole($id){
        try{

            $result = $this->roleRepo->delete($id);
            if($result){
                return $this->success($result,'Role Record Deleted ',200);
            }
            return $this->error('Error Deleting  Role Record  ',404);


        }catch(Exception  $ex){
            return $this->error('Internal Server Error',500);
        }



    }
}
