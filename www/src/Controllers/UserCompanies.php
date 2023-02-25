<?php 

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Validator;

class UserCompanies extends Controller {

   //FIND ALL COMPANIES TO USER
   public function find($id)
   {
      $companyModel = $this->model('UserCompany');

      $company = $companyModel->find($id);

      if (!$company) {
         http_response_code(404);
         echo json_encode(['message' => 'Não localizamos empresas para este usuário'], JSON_UNESCAPED_UNICODE);
         exit;
      }

      echo json_encode($company, JSON_UNESCAPED_UNICODE);
   }

   public function store()
   {
      $data = $this->getRequestBody();

      //VALIDATE FORM
      $validate = new Validator();
      $validate->id($data->user_id, true);
      $validate->id($data->company_id, true);
      
      if($validate->getErrors()){
         http_response_code(400);
         echo json_encode(['message' => implode(", ", $validate->getErrors())]);
         exit;
      }


      //MODEL
      $userCompanyModel            = $this->model('UserCompany');
      $userCompanyModel->userId    = $data->user_id;
      $userCompanyModel->companyId = $data->company_id;
      
      $response = $userCompanyModel->create();

      if ($userCompanyModel->id) {
         http_response_code(201);
         echo json_encode($userCompanyModel);
      } else {
         http_response_code(500);
         echo json_encode([
            'message' => 'Não foi possível vincular o usuário a esta empresa',
            'error'  => $response['error'],
            'code' => $response['code']
         ]);
      }

   }

   //DELETE
   public function delete($id)
   {
      $companyModel = $this->model('UserCompany');
      $response = $companyModel->destroy($id);

      if ($response == NULL) {
         http_response_code(404);
         echo json_encode(['message' => 'Não localizamos este vínculo']);

      } elseif ($response['error']) {
         http_response_code(500);
         echo json_encode($response);

      } else {
         echo json_encode(['message' => 'Vínculo excluído com sucesso.']);
      }

   }
}