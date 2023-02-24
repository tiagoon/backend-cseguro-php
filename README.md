# Backend Contato Seguro PHP

Aplicação desenvolvida em PHP 7.4 (compatível com v8.2) com CRUD de **usuários** e **empresas** relacionando-se de __n para n__.

#
## Como utilizar

Use o Docker para tal. Os arquivos da aplicação ficam dentro do diretório www/

Suba os containers do projeto
```sh
docker-compose up -d
```

Acesse o container
```sh
docker-compose exec www bash
```

Instale as dependências do projeto
```sh
composer install
```
 

Acesse o projeto
[http://localhost:8001](http://localhost:8001)


#
## Utlizando o phpMyAdmin

Não é necessário executar ação alguma para configurar o banco de dados. Um dump do mesmo será feito de forma automática ao subir o docker pela primeira vez.

Um modelo do sql utilizado está disponível no diretório *dump/*.


Para utilizar o phpMyAdmin, acesse o link [http://localhost:8000](http://localhost:8000)

Login: usuário `test` e senha `password`

#
## Utilizando a API

Acesse a documentação em [README-API.md](README-API.md)