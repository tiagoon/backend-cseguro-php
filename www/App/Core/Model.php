<?php

namespace App\Core;

class Model {

   private static $conexao;

   public static function getConn(){

      if(!isset(self::$conexao)){
         self::$conexao = new \PDO("mysql:host=db;port=3306;dbname=contato_mysql;", "user", "password");
      }

      return self::$conexao;
   }

}
