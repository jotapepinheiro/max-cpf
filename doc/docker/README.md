# Docker Sail
> Voltar para [instruções do projeto][l-Doc-Projeto]

---
- PHP v7.4
- Mysql v8
- Redis
- Mailhog

___ 

### *Importante* 
- Instalar [Docker >= v19][l-Docker]
- Instalar [Docker Compose >= v1.27][l-Docker-Compose]
- Adicionar [Permissões para Docker][l-Docker-Permissoes]
___ 

### Executar na raiz do projeto
> cp .env.example .env 

### Gerar app secret

> php artisan key:generate

### Gerar jwt secret

> php artisan jwt:secret

- Antes de iniciarmos a execução dos comandos Sail, adicione um alias em seu shell de preferencia.
> alias sail='bash vendor/bin/sail'

- Caso não adicione o alias, execute os comandos do sail passando o path completo abaixo
> ./vendor/bin/sail up -d

### Iniciar containers, na raiz do projeto

> sail up -d

### Desligar containers, na raiz do projeto

> sail down

### Veja mais alguns comandos que podem ser executados:

### Rebuild Todos Container

> sail down && sail up -d --build

### Rebuild Todos Container sem Cache

> sail build --no-cache

### Listar Containers

> sail ps -a

### Entrar em um Container

> sail shell 
- ou 
> sail root-shell

### Ver versão dp PHP

> sail php -v

### Ver memoria dp PHP

> sail php -i | grep memory

### Executar o Tinker

> sail tinker

### Executar as filas

> sail artisan queue:work

___

### EDITAR ARQUIVO HOSTS
> No Windows: C:\Windows\System32\drivers\etc\hosts

> No Linux/Mac: /etc/hosts

```text
127.0.0.1       maxcpf.local
127.0.0.1       mysql
127.0.0.1       mailhog
```

___

### CONFIGURAR XDEBUG NO LINUX
> https://stackoverflow.com/questions/46263043/how-to-setup-docker-phpstorm-xdebug-on-ubuntu-16-04

- Instalar o ifconfig
> sudo apt-get install net-tools

- Copiar o nome parecido com wlp4s0 e adicionar a linha de baixo
> sudo ip addr add 10.254.254.254/24 brd + dev wlp4s0 label wlp4s0:1

- Usar o ip 10.254.254.254 em sua configuração do PhpStorm/VSCode

[l-Doc-Projeto]: ../../README.md
[l-Docker]: https://docs.docker.com/engine/install/ubuntu/
[l-Docker-Compose]: https://docs.docker.com/compose/install
[l-Docker-Permissoes]: https://docs.docker.com/engine/install/linux-postinstall
