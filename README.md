# zionphp
Um framework MVC de propósito geral, visando atender grande parte das demandas de qualquer sistema

## Funcionalidades

A idéia é ser simples, modificando apenas 1 linha do seu código já é possivel utilizar a maioria das funcionalidades, 
exceto as que precisem da instalação de dependências por exemplo.

As principais funcionalidades são:
- Plataforma para aplicações MVC com segurança e facilidade de integração
- Persistência de dados: diversos bancos como MySQL, SQLServer entre outros que serão incluidos futuramente
- Gerenciamento de E-mails: e-mails, cotas, logs
- Gerenciamento de Erros: Exceções, erros de código, erros de banco
- Segurança: WAF, suporte a SSL e criptografia
- Gerador de Módulos: Gere CRUD para módulos totalmente funcionais com as melhores práticas, flexivel e extensível
- Internacionalização: Use textos em seu sistema em qualquer idioma
- Bibliotecas backend: Ferramentas diversas
- Bibliotecas frontend: Ferramentas diversas

## Pré-Requisitos

- PHP >= 5.3.0 Versão que iniciou o suporte a namespace
- Apache >= 2.2 com módulo mod_rewrite instalado
- MySQL >= 5.6
- Arquivo .htaccess redirecionando todo o fluxo da aplicação para o index.php, exceto arquivos estáticos como 
imagens, estilos CSS, JavaScripts
- Composer instalado

## Como usar

1) Configurações mínimas do PHP (php.ini)

```php 
short_open_tag = On
```

2) Instale as extensões do PHP (varia de acordo com a versão do Linux e PHP utilizadas, segue o exemplo do Linux Fedora). Caso seu sistema não seja compatível, verifique na internet quais os comandos e módulos equivalentes para
o seu ambiente

```php 
yum install php-mbstring php-pdo php-mysqlnd php-json php-xml php-soap php-zip php-xdebug php-process php-posix
```

3) Clone ou baixe o zip do projeto e extraia em um diretório de sua preferência. Recomendamos que fique no diretório de projetos junto com os projetos que utilizaram o framework.

4) Entre no diretório raiz do framework e baixe as bibliotecas

```php 
composer update
```

5) Inclua o arquivo autoload.php no seu projeto 
 
```php
require(dirname(dirname(dirname(__FILE__)))."/zionphp/autoload.php");
```
 
6) Acesse a url do seu projeto no navegador com a uri "/zion/" e siga as instruções

```php 
http://seusite.com.br/zion/
```

7) Pronto! Você já pode começar a utilizar o framework, você pode simplesmente utilizar as classes do framework (backend) ou utilizar também os módulos já embutidos, disponíveis com o prefixo de URI /zion/. 

## Configure sua IDE

Para funcionar o auto complete e reconhecer as classes, métodos etc, é necessário configurar sua IDE, siga as instruções abaixo:
- Eclipse: Propriedades do Projeto > PHP > Source Paths > Include Path > Aba "Libraries" > Add Library.
- NetBeans: Em breve

## Melhoria continua

Este framework esta em constante atualização, portanto, pode ser que uma classe que existe hoje, não exista amanhã. 
Porém, isso só sera feito se realmente necessário para não prejudicar os utilizadores do framework

## Aviso Legal

Este projeto utiliza frameworks e bibliotecas de terceiros como jquery, bootstrap, etc. 
Verifique os termos e condições das licenças individualmente e descubra se você pode utilizá-los.

Ao usar este projeto, não há nenhuma garantia ou suporte oficial