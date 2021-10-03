<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/24/2021
 * Time: 3:27 PM
 */

namespace App\Repos;


use App\Enums\BillType;
use App\iRepo\IGeneralBill;
use App\iRepo\ISchoolTypeEnum;
use App\Models\GeneralBill;

class GeneralBillRepo implements IGeneralBill
{




    public function create($data)
    {

        $type = $this->billType($data['type']);
       $new_bill = GeneralBill::create([
         'name'=>$data['name'],
           'amount'=>$data['amount'],
           'description'=>$data['description'],
           'type'=> $type,
           'school_class_id'=>$data['school_class_id']
       ]);
       if($new_bill) {
           return $new_bill;
       }

       //return null;
    }

    public function all()
    {
        $data = [];
        $specific_bill= GeneralBill::join('school_classes', 'general_bills.school_class_id', '=', 'school_classes.id')
                       ->get(['general_bills.*', 'school_classes.name as class_name' ]);
        $general_bill = GeneralBill::where('type','=',BillType::GeneralBill)
            ->get();

        $store_bill = GeneralBill::where('type','=',BillType::StoreBill)
            ->get();
        $data=[
            'compulsory'=>$specific_bill,
            'general'=>$general_bill,
            'store'=>$store_bill
        ];
            return $data;



    }



    public function findBillByClassId($id)
    {
        $data = [];

        if($id){
           $specific_bill = GeneralBill::where('school_class_id','=',$id)
               ->where('type','=',BillType::SpecificBill)
               ->orWhere('type', '=', BillType::SpecificCompulsory)
               ->get();
            $general_bill = GeneralBill::where('type','=',BillType::GeneralBill)
                ->get();

            $store_bill = GeneralBill::where('type','=',BillType::StoreBill)
                ->get();

            $data=[
                'compulsory'=>$specific_bill,
                'general'=>$general_bill,
                'store'=>$store_bill
            ];

            return $data;

        }
        return null;

    }

    public function update($bill_id,$data)
    {
    $result = null;
        $bill = GeneralBill::find($bill_id);
        if($bill){



            $bill->name = $data['name'];
            $bill->amount = $data['amount'];
            $bill->description = $data['description'];
            $bill->type = $this->billType($data['type']);
            if($data['school_class_id']){
               $bill->school_class_id =  $data['school_class_id'];
            }
            $bill->updated_at = date("Y-m-d H:i:s");
            $result = $bill->save();
            if($result)return $result;

        }
        return null;
    }

    public function delete($id)
    {
        $result = null;
        if($id){

            $bill = GeneralBill::find($id);
            $result = $bill->delete();
            if($result) return true;

        }
        return null;
    }


    private function billType($type){

         //return ISchoolTypeEnum::General;
        $result = null;
        if($type == BillType::GeneralBill){
            $result = BillType::GeneralBill;
        }
        if($type == BillType::SpecificBill){
            $result = BillType::SpecificBill;
        }
        if($type == BillType::StoreBill){
            $result = BillType::StoreBill;
        }

        return $result;
    }

    public function generalBill()
    {
        $data = [];

        $data = GeneralBill::where('type','=',BillType::GeneralBill)
            ->get();

        return $data;
    }

    public function compulsoryBill()
    {
        $data = [];
        $data= GeneralBill::join('school_classes', 'general_bills.school_class_id', '=', 'school_classes.id')
            ->get(['general_bills.*', 'school_classes.name as class_name' ]);

        return $data;
    }

    public function storeBill()
    {
        $data = [];
        $data = GeneralBill::where('type','=',BillType::StoreBill)->get();
        return $data;

    }

    public function specificCompulsoryBill()
    {
        $data = [];
        $data = GeneralBill::where('type','=',BillType::SpecificCompulsory)->get();
        return $data;

    }
    public function myBillByClassId($class_id)
    {

        if($class_id){
            $specific_bills = GeneralBill::where('school_class_id','=',$class_id)
                ->where('type', '=', BillType::SpecificBill)
                  ->get();

            $general_bills = GeneralBill::where('type','=',BillType::GeneralBill)
                ->get();
            $compulsory_bills = GeneralBill::where('type','=',BillType::SpecificCompulsory)
                ->get();

            $store_bills = GeneralBill::where('type','=',BillType::StoreBill)
                ->get();
            $merged = [];
            foreach ($specific_bills as $bill) array_push($merged, $bill);
            foreach ($general_bills as $bill) array_push($merged, $bill);
            foreach ($store_bills as $bill) array_push($merged, $bill);
            foreach ($compulsory_bills as $bill) array_push($merged, $bill);
            return $merged;
        }
        return [];
    }
}