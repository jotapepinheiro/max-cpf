# Projeto Controle de CPFs - Versão 1.0

[![MaxMilhas}][i-MaxMilhas]][l-MaxMilhas]

---

**Bases** | **Versão** | **Acesso**
--------------- | :---: | :---:
Desenvolvimento | 1.0   | [link][l-Desenvolvimento]
Homologação     | 1.0   | [link][l-Homologacao]
Produção        | 1.0   | [link][l-Producao]

---

## O que este repositório contém OKOK

1. Controle de permissão de usuários ACL.
2. Autenticação com [JWT][l-JWT].
3. Controle de CPFs.
4. Api Resources do Lumen.
5. [Swagger][l-Swagger] API REST.
6. Testes Unitários.
7. [Docker][l-Docker], usando o novo metodo de desenvolvimento com [Sail][l-Sail].

---

## Qual o objetivo deste repositório

1. Desafio Técnico para a empresa [MaxMilhas][l-MaxMilhas].
2. Criar uma API para gerenciamento de CPFs.

---

## O que é necessário para configurar

1. PHP >= 7.3 com requisitos de extensão, conforme descrito na documentação do [Lumen][l-Lumen].
2. [Composer][l-Composer] em uma Versão estável.
3. Qualquer banco de dados de sua escolha, eu usei o MySQL.
---

## Como instalar

- Veja **[AQUI][l-Doc-Docker]** as instruções para utilizar o Docker usando o Sail

```shell script
# Instalar todos os pacotes necessários para executar o projeto
> composer install

** Caso tenha falha de memória com php local, use: **
> COMPOSER_MEMORY_LIMIT=-1 composer install
 
# Crie o arquivo .env e defina o seu APP_TIMEZONE e banco de dados.
> cp .env.example .env

# Gerar app secret
> php artisan key:generate

# Gerar jwt secret
> php artisan jwt:secret

# Caso não use o procedimento de intalação utilizando o Docker, crie as tabelas necessárias no seu banco de dados
# Nota: Lembre-se de criar o banco de dados antes de executar este comando!
> php artisan migrate

# Alimentar nosso banco de dados com dados necessários
> php artisan db:seed

# Recriar os dados de nosso banco de dados
> php artisan migrate:fresh --seed
```

---

## Qual o modelo do diagrama

![Diagrama}][i-Diagrama]

---

## Importar Endpoits da API para o [Insomia][l-Insomia]
[![Importar Insomnia}][i-Insomia-Run]][l-Insomia-Import]

![Insomia][i-Insomia]

---

## Como executar o projeto

```shell script
# Você pode executá-lo no localhost ou pode configurar um virtualhost local
# O servidor fica a sua escolha entre nginx ou apache
# Particularmente prefiro nginx com virtualhost de domínio local. 
# Exemplo: http://maxcpf.local
# Nota: Informe a URL no projeto importado do Insomia para testar os endpoits. 
> php artisan serve
```

---

## Como gerar/acessar a documentação do [Swagger][l-Swagger-Doc]

```shell script
# Nota: O comando abaixo irá gerar a documentação da API conforme as anotações no código PHP. 
> php artisan swagger-lume:generate

# Para acessar a documentação da API acesse a url abaixo. 
> /api/documentation
```

![Swagger][i-Swagger]

---

## Como posso ver as rotas da API

```shell script
# Lista todas as rotas definidas no projeto 
> php artisan route:list
```

---

## Como executo os testes unitários

```shell script 
> php vendor/bin/phpunit

ou

> composer test
```

---

### Endpoits de consultas de CPFs cadastrados

```
# Importante: O final da url deve conter os parâmetros api/v1.
# Exemplo: http://maxcpf.local/api/v1

# Exibir todos CPFs.
> GET /api/v1/cpf

# Exibir todos CPFs com usuário.
> GET /api/v1/cpf?showUser=true

# Exibir todos CPFs com usuário e paginado
> GET /api/v1/cpf?paged=true&showUser=true

# Exibir todos CPFs, paginado, com usuário, com perfil e permissoes do usuario
> GET /api/v1/cpf?paged=true&showUser=true&showRole=true&showPermission=true
```

### Endpoits de usuários do sistema

```
# Listar todos usuários cadastrados
> /api/v1/users

# Exibir dados do usuário, perfis e permissões por ID
> /api/v1/users/2

1. Perfil - Super Administrador
> Login: super@super.com 
> Senha: super

2. Perfil - Administrador
> Login: admin@admin.com
> Senha: admin

3. Perfil - Técnico
> Login: tecnico@tecnico.com
> Senha: tecnico

4. 50 usuários ficticios com o perfil técnico e vinculados a um CPF cadastrado
> Senha Padrão: 123456

```

### Endpoit de Login

```
> /api/v1/auth/login
```

---

Se o parâmetro "remember" for enviado como "true", o token JWT irá expirar em 1 semana, caso contrário 1 hora.
Este tempo pode se definido no arquivo .env:
JWT_TTL e JWT_TTL_REMEMBER_ME

```json
{
	"email": "admin@admin.com",
	"password": "admin",
	"remember": true
}

```

[i-MaxMilhas]: doc/img/logo.svg "MaxMilhas"
[i-Diagrama]: doc/img/diagrama.png "Diagrama"
[i-Insomia]: doc/img/insomia.png "Insomia"
[i-Insomia-Run]: https://insomnia.rest/images/run.svg "Importar Insomia"
[i-Swagger]: doc/img/swagger.png "Swagger"

[l-MaxMilhas]: https://www.maxmilhas.com.br
[l-Doc-Docker]: doc/docker/README.md
[l-Lumen]: https://lumen.laravel.com/docs/6.x#server-requirements
[l-Insomia]: https://insomnia.rest/download
[l-Insomia-Import]: https://insomnia.rest/run/?label=Max%20CPF&uri=https%3A%2F%2Fraw.githubusercontent.com%2FJotapePinheiroSquadra%2Fmax-cpf%2Fmaster%2Fdoc%2Farquivos%2FInsomnia_export.json
[l-Composer]: https://getcomposer.org
[l-Swagger]: https://swagger.io
[l-JWT]: https://jwt.io
[l-Docker]: https://www.docker.com
[l-Sail]: https://laravel.com/docs/8.x/sail

[l-Swagger-Doc]: http://maxcpf.local/api/documentation
[l-Desenvolvimento]: http://maxcpf.local
[l-Homologacao]: http://maxcpf.local
[l-Producao]: http://maxcpf.local
