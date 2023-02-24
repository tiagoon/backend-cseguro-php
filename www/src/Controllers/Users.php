<?php 

namespace App\Controllers;

use App\Core\Controller;

class Users extends Controller {

   public function index()
   {
      $userModel = $this->model('User');

      $queryParams = $this->getQueryParams();
      
      $users = $userModel->all($queryParams);

      echo json_encode($users, JSON_UNESCAPED_UNICODE);
   }

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

   public function find($id)
   {
      $userModel = $this->model('User');

      $user = $userModel->find($id);

      if (!$user) {
         http_response_code(404);
         echo json_encode(['message' => 'Usuário não localizado'], JSON_UNESCAPED_UNICODE);
         exit;
      }

      echo json_encode($user, JSON_UNESCAPED_UNICODE);
   }

   public function update($id)
   {
      $data = $this->getRequestBody();

      $userModel              = $this->model('User');
      $userModel->name        = $data->name;
      $userModel->email       = $data->email;
      $userModel->phone       = $data->phone;
      $userModel->birthday    = $data->birthday;
      $userModel->cityName    = $data->city_name;

      $userModel->update($id);

      if ($userModel) {
         http_response_code(200);
         echo json_encode(['message' => 'Atualizado com sucesso']);
      } else {
         http_response_code(500);
         echo json_encode(['message' => 'Erro ao atualizar usuário']);
      }
   }

   public function delete($id)
   {
      $userModel = $this->model('User');
      $user = $userModel->destroy($id);

      if (!$user) {
         http_response_code(404);
         echo json_encode(['message' => 'Não foi possível excluir'], JSON_UNESCAPED_UNICODE);
      } else {
         echo json_encode(['message' => 'Usuário excluído com sucesso.'], JSON_UNESCAPED_UNICODE);
      }
   }
}