<?php

namespace App\Core;

class Model {

   private static $conexao;

   public static function getConn(){

      if(!isset(self::$conexao)){
         self::$conexao = new \PDO("mysql:host=db;port=3306;dbname=contato_mysql;", "user", "password");
         self::$conexao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); 
      }

      return self::$conexao;
   }

}
