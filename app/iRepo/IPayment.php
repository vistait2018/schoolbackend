<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 6/24/2021
 * Time: 3:13 PM
 */

namespace App\iRepo;


interface IPayment
{
    public function pay($data);


}