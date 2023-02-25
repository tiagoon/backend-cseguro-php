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

      $response = $userModel->create();

      if ($response->id) {
         http_response_code(201);
         echo json_encode($userModel);

      } else {
         http_response_code(500);
         echo json_encode([
            'message' => 'Não foi possível cadastrar o usuário',
            'error'  => $response['error'],
            'code' => $response['code']
         ]);
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

      $response = $userModel->update($id);

      if ($response) {
         http_response_code(200);
         echo json_encode(['message' => 'Atualizado com sucesso']);

      } else {
         http_response_code(500);
         echo json_encode([
            'message' => 'Não foi possível atualizar este usuário',
            'error'  => $response['error'],
            'code' => $response['code']
         ]);
      }
   }

   public function delete($id)
   {
      $userModel = $this->model('User');
      $response = $userModel->destroy($id);

      if ($response == NULL) {
         http_response_code(404);
         echo json_encode(['message' => 'Não localizamos este usuário']);

      } elseif ($response['error']) {
         http_response_code(500);
         echo json_encode($response);
         
      } else {
         echo json_encode(['message' => 'Usuário excluído com sucesso.']);
      }

   }
}