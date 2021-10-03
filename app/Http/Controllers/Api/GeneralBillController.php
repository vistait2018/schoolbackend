<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repos\GeneralBillRepo;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;

class GeneralBillController extends Controller
{
    use ApiResponser;
    protected $generalBillRepo;


    public function __construct(GeneralBillRepo  $generalBillRepo)
    {
        $this->generalBillRepo = $generalBillRepo;


    }

    public function index(){
        try{
            $generalBill =  $this->generalBillRepo->all();
            if($generalBill)  return $this->success($generalBill,'School Bills ',200);
            else  return $this->error('Error Retrieving - School Bills Not Available!!!  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }

    }

    public function generalBill(){
        try{
            $generalBill =  $this->generalBillRepo->generalBill();
            if($generalBill)  return $this->success($generalBill,'General Bill ',200);
            else  return $this->error('Error Retrieving - School Bills Not Available!!!  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function storeBill(){
        try{
            $generalBill =  $this->generalBillRepo->storeBill();
            if($generalBill)  return $this->success($generalBill,'Store Bills ',200);
            else  return $this->error('Error Retrieving - School Bills Not Available!!!  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }


    public function compulsoryBill(){
        try{
            $generalBill =  $this->generalBillRepo->compulsoryBill();
            if($generalBill)  return $this->success($generalBill,'Compulsory Bills ',200);
            else  return $this->error('Error Retrieving - School Bills Not Available!!!  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function spaecifcCompulsoryBill(){
        try{
            $generalBill =  $this->generalBillRepo->specificCompulsoryBill();
            if($generalBill)  return $this->success($generalBill,'Compulsory Bills ',200);
            else  return $this->error('Error Retrieving - School Bills Not Available!!!  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }
    public function indexByClassId($class_id){
        try{
            $generalBill =  $this->generalBillRepo->findBillByClassId($class_id);
            if($generalBill)  return $this->success($generalBill,'School Bills ',200);
            else  return $this->error('Error Retrieving - School Bills Not Available!!!  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }


    }





    public function makeBill(Request $request){

        $data = [
            'name' =>$request->input('name'),
             'amount' =>$request->input('amount'),
         'description' =>$request->input('description'),
         'type' => $request->input('type'),
         'school_class_id' => intval($request->input('school_class_id')),
        ];
        //xreturn $data['type'];
        try{
            $generalBill =  $this->generalBillRepo->create($data);
            return $generalBill;
            if($generalBill)  return $this->success($generalBill,'School Bill Created',200);
            else  return $this->error('Error Creating- School Bills .  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }

    public function updateBill(Request $request, $bill_id){
        try{
            //return $bill_id;
            if($bill_id){
                $data = [
                    'name' =>$request->input('name'),
                    'amount' =>$request->input('amount'),
                    'description' =>$request->input('description'),
                    'type' =>$request->input('type'),
                    'school_class_id' =>$request->input('school_class_id'),
                ];
                $generalBill =  $this->generalBillRepo->update($bill_id,$data);
                if($generalBill)  return $this->success($generalBill,'School Bills Updated ',200);
                else  return $this->error('Error Updating School Bills!!!  ',404);
            }

            return $this->error('Error Updateing School Bill - Bill does not exits!!!  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }


    public function deleteBill($bill_id){
        try{
            $generalBill =  $this->generalBillRepo->delete($bill_id);
            if($generalBill)  return $this->success($generalBill,'School Bill Deleted ',200);
            else  return $this->error('Error Retrieving - Deleting School Bill!!!  ',404);
        }catch(Exeption $ex){
            return $this->error('Internal Server Error',500);
        }
    }
}
