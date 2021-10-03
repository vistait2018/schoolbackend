<?php
/**
 * Created by PhpStorm.
 * User: jyde
 * Date: 5/29/2021
 * Time: 4:45 PM
 */

namespace App\Mail;


class MailInfo
{
   private $title;
   private $message;

    public function __construct($title, $message)
    {
        $this->title = $title;
        $this->message = $message;
    }

   public function getTitle(){
       return $this->title;
   }

    public function getMsessage(){
        return $this->message;
    }
}