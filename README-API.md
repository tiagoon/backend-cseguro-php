# Utilizando a API

#### Boas-vindas [/]
Apenas um Hello World.

```shell
curl --request GET \
  --url http://localhost:8001/
```

#
#### Empresas [/companies]

Listar empresas

```shell
curl --request GET \
  --url http://localhost:8001/companies
```

Cadastrar empresa

```shell
curl --request POST \
  --url http://localhost:8001/companies \
  --header 'Content-Type: application/json' \
  --data '{
	"company_name": "Globo SA",
	"document": "51.605.272/0001-56",
	"address": "Av 13 de Julho, 999, Centro, Rio de Janeiro/RJ"
}'
```

Mostrar empresa (id)

```shell
curl --request GET \
  --url http://localhost:8001/companies/2
```

Atualizar empresa

```shell
curl --request PUT \
  --url http://localhost:8001/companies/2 \
  --header 'Content-Type: application/json' \
  --data '{
	"company_name": "Globo SA",
	"document": "51.605.272/0001-56",
	"address": "Av 13 de Julho, 999, Centro, São Paulo/SP"
}'
```

Excluir empresa 

```shell
curl --request DELETE \
  --url http://localhost:8001/companies/4
```

#
#### Usuários [/users]

Listar usuários

```shell
curl --request GET \
  --url http://localhost:8001/users
```

Criar usuário

```shell
curl --request POST \
  --url http://localhost:8001/users \
  --header 'Content-Type: application/json' \
  --data '{
	"name": "Tiago Oliveira",
	"phone": "(79) 99999-9999",
	"email": "tiago@gmail.com",
	"birthday": "1999-09-09",
	"city_name": "Aracaju"
}'
```

Mostrar usuário (id)

```shell
curl --request GET \
  --url http://localhost:8001/users/1
```

Atualizar um usuário

```shell
curl --request PUT \
  --url http://localhost:8001/users/4 \
  --header 'Content-Type: application/json' \
  --data '{
	"name": "Joao Jesus",
	"phone": "79 998515151",
	"email": "joao.jesus@gmail.com",
	"birthday": "1999-09-10",
	"city_name": "Aracaju"
}'
```

Excluir um usuário

```shell
curl --request DELETE \
  --url http://localhost:8001/users/4
```

Vincular usuário a uma empresa

```shell
curl --request POST \
  --url http://localhost:8001/userCompanies \
  --header 'Content-Type: application/json' \
  --data '{
	"user_id": 2,
	"company_id": 1
}'
```

Listar empresas vinculadas a um usuário

```shell
curl --request GET \
  --url http://localhost:8001/userCompanies/2
```
