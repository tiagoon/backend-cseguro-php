<?php 

namespace App\Controllers;

use App\Core\Controller;

class Companies extends Controller {

   public function index()
   {
      $companyModel = $this->model('Company');
      $companies = $companyModel->all();
      
      echo json_encode($companies, JSON_UNESCAPED_UNICODE);
   }

   public function find($id)
   {
      $companyModel = $this->model('Company');

      $company = $companyModel->find($id);

      if (!$company) {
         http_response_code(404);
         echo json_encode(['message' => 'Empresa não localizada'], JSON_UNESCAPED_UNICODE);
         exit;
      }

      echo json_encode($company, JSON_UNESCAPED_UNICODE);
   }

   //CREATE
   public function store()
   {
      $data = $this->getRequestBody();

      $userModel            = $this->model('User');
      $userModel->name      = $data->name;
      $userModel->email     = $data->email;
      $userModel->phone     = $data->phone;
      $userModel->birthday  = $data->birthday;
      $userModel->cityName  = $data->city_name;
      $userModel->createdAt = date('Y-m-d H:i:s');

      $userModel->create();

      if ($userModel) {
         http_response_code(201);
         echo json_encode($userModel);
      } else {
         http_response_code(500);
         echo json_encode(['message' => 'Erro ao cadastrar usuário']);
      }

   }
}