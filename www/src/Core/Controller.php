<?php

namespace App\Core;

class Controller{

   public function model($model){
      $className = "\\App\\Models\\{$model}";
      return new $className;
   }

   protected function getRequestBody(){
      $json = file_get_contents("php://input");
      $obj = json_decode($json);
   
      return $obj;
   }

   protected function getQueryParams(){
      return $_GET;
   }

}