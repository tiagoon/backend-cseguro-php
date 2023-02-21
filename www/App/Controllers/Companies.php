<?php 

namespace App\Controllers;

use App\Core\Controller;

class Companies extends Controller {

   public function index()
   {
      $userModel = $this->model('Company');

      $users = $userModel->all();

      if ($users) {
         http_response_code(204);
         exit;
      }

      echo json_encode($users, JSON_UNESCAPED_UNICODE);
   }
}