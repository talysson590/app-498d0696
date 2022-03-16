# app-498d0696

Projeto em Laravel.
- Referência: https://github.com/laravel/laravel

## Instalação
```docker
1º- O projeto necessita que sejam instalados o "docker", "docker-compose" em seu ambiente.  

2º- copie o arquivo env: cp .env.example .env

3º- Em seguida, execute o comando: "docker-compose up --build -d".

4º- Execute "docker-compose exec app php artisan key:generate" para gerar a chave

5º- Após, execute "docker exec product-app php artisan migrate:fresh --seed" para rodar as migrations

6º- http://localhost:8000
```

## Teste
```docker
docker exec product-app php artisan test
```

## versão
```docker
• versão php: 7.4
• versão laravel: 7.0
```

## Docker
```docker
Comandos:
    Rotas: docker exec product-app php artisan route:list
    Containers em execução: docker-compose ps
    Instalar pacotes: docker-compose exec app composer install
    Rodar todas as migrations com as seedrs: docker exec product-app php artisan migrate:fresh --seed
```

## Rotas da API
```docker
Rotas:
    GET api/historico-produto
    GET api/produto
    POST api/produto
    GET api/produto/{produto}
    PUT api/produto/{produto}
    DELETE api/produto/{produto}
```

## Exemplos de busca
```docker
Exemplos de consultas:
    GET: api/produto?search={"sku":"98","quantidade":"","status":"","criado":""}&sort={"field":"ds_sku","direction":"asc"}
    GET: api/historico-produto?search={"sku":"98","quantidade":"","observacao":"","criado":""}&sort={"field":"ts_criado","direction":"desc"}
```