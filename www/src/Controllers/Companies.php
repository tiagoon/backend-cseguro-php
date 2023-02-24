<?php 

namespace App\Controllers;

use App\Core\Controller;

class Companies extends Controller {

   //ALL
   public function index()
   {
      $companyModel = $this->model('Company');
      $companies = $companyModel->all();
      
      echo json_encode($companies, JSON_UNESCAPED_UNICODE);
   }

   //FIND BY ID
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

      $companyModel               = $this->model('Company');
      $companyModel->companyName  = $data->company_name;
      $companyModel->document     = $data->document;
      $companyModel->address      = $data->address;
      $companyModel->createdAt    = date('Y-m-d H:i:s');

      $companyModel->create();

      if ($companyModel) {
         http_response_code(201);
         echo json_encode($companyModel);
      } else {
         http_response_code(500);
         echo json_encode(['message' => 'Erro ao cadastrar empresa']);
      }

   }

   //UPDATE
   public function update($id)
   {
      $data = $this->getRequestBody();

      $companyModel               = $this->model('Company');
      $companyModel->companyName  = $data->company_name;
      $companyModel->document     = $data->document;
      $companyModel->address      = $data->address;

      $companyModel->update($id);

      if ($companyModel) {
         http_response_code(200);
         echo json_encode(['message' => 'Atualizado com sucesso']);
      } else {
         http_response_code(500);
         echo json_encode(['message' => 'Erro ao atualizar empresa']);
      }
   }

   //DELETE
   public function destroy($id)
   {
      $companyModel = $this->model('Company');
      $company = $companyModel->destroy($id);

      if (!$company) {
         http_response_code(404);
         echo json_encode(['message' => 'Empresa não localizada'], JSON_UNESCAPED_UNICODE);
      } else {
         echo json_encode(['message' => 'Empresa excluída com sucesso.'], JSON_UNESCAPED_UNICODE);
      }

   }
}