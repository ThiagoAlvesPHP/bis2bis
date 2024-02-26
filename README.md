# bis2bis

## Instalação e Execução
## Requisitos do Ambiente:
* PHP 8.2
* Apache
* MySQL 5.6

### Extensões PHP Necessárias:
#### Certifique-se de ter as seguintes extensões PHP instaladas:
* PDO
* PDO_MySQL

## Configuração do Banco de Dados:

* Crie um banco de dados no MySQL.
* Edite o arquivo settings.php e insira as informações de conexão do banco de dados.
```
$config['host']     = "localhost";
$config['dbname']   = "bis2bis";
$config['dbuser']   = "root";
$config['dbpass']   = "root";
```
* Carregue o arquivo dump.slq da raiz do projeto para o MySQL

## Configuração Extra:
* Altere o a URL do define do arquivo settings.php
```
define("BASE", "http://localhost/bis2bis/");
```

## Instalação do Projeto:

* Clone este repositório.
```
git clone https://github.com/ThiagoAlvesPHP/bis2bis
```
* Certifique-se de que o Apache está configurado corretamente para servir o projeto.

## Execução:
* Acesse o projeto através do seu navegador.

## Login Usuário Master
* E-mail: thiagoalves@ltdeveloper.com.br
* Password: admin123