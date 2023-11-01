## Projeto de API REST de pastelaria 

### Como iniciar o projeto
O primeiro passo para iniciar esse projeto é iniciar o container docker

```
docker-compose up
```

Assim que o container estiver o rodando, é necessário executar alguns comandos para preparar o ambiente

### Copia as imagens dos produtos já cadastrados no banco para a pasta do projeto
```
mv -v produtos_iniciais/* ./pastelaria/storage/app/produtos/
```

### Copia o .env para o projeto 
O .env normalmente não seria versionado, mas é necessário para o projeto
```
mv -v conf/.env ./pastelaria/
```

### Cria mysqlite para testes
```
docker-compose exec myapp touch database/database.sqlite
```

### Cria as tabelas do banco de dados
```
docker-compose exec myapp php artisan migrate
```
### Popula a tabela de produtos
```
docker-compose exec myapp php artisan db:seed
```
### Cria o link para que as imagens dos produtos possam ser acessadas
```
docker-compose exec myapp php artisan storage:link
```

## Postman collection
Na pasta conf também foi adicionado um postmanCollection, com as rotas já preparadas para serem utilizadas

## Falha do framework
O laravel possui um bug já antigo relacionado a requests PATCH que utilizam form-data.
Nesses casos, ele não identifica as informações passadas. 
Isso normalmente não é um problema, porém nessa API, foi necessário enviar dados como form-data no PATCH de produto, devido a imagem.
Nesse caso, o _workaround_ recomendado é realizar a requisição como POST, mas adicionar um novo parâmetro chamado _method e passar o valor dele como PATCH. 

https://laravel.io/forum/02-13-2014-i-can-not-get-inputs-from-a-putpatch-request