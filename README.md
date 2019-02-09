# zionphp
Framework PHP - Um framework MVC de propósito geral, visando atender todas as demandas de qualquer tipo de sistema

## Pré-Requisitos
- PHP >= 5.3.0 Versão que iniciou o suporte a namespace
- Apache >= 2.2 com módulo mod_rewrite instalado
- MySQL >= 5.6
- Arquivo .htaccess redirecionando todo o fluxo da aplicação para o index.php, exceto arquivos estáticos como 
imagens, estilos CSS, JavaScripts

## Como usar
 
1) Baixe o zip do projeto e extraia em um diretório de sua preferência. Recomendamos que fique no diretório de projetos 
junto com os projetos que utilizaram o framework.

2) Inclua o arquivo autoload.php no seu projeto 
 
```php
require(dirname(dirname(dirname(__FILE__)))."/zionphp/autoload.php");
```
 
3) Inclua uma exceção no arquivo .htaccess da raiz do seu diretório publico para que as regras de rewrite para módulos
funcione
 
```php 
RewriteCond %{REQUEST_URI} !^zion/
```
 
4) Acesse a url do seu projeto no navegador com a uri "/zion/" e siga as instruções

```php 
http://seusite.com.br/zion/
```

5) Pronto! Você já pode começar a utilizar o framework, você pode simplesmente utilizar as classes do framework (backend) 
ou utilizar também os módulos já embutidos, disponíveis com o prefixo de URI /zion/. 

## Minha IDE não reconhece as classes

Para que sua IDE "enxergue" as classes e seus métodos utilizando o recurso de auto complete, siga as instruções abaixo:
 
- Eclipse: Propriedades do Projeto > PHP > Source Paths > Build Path > Link Source.
![Eclipse](https://raw.githubusercontent.com/vcd94xt10z/zionphp/master/frontend/zion/github/eclipse.png)
 
- NetBeans: Em breve

## Disclaimer

Este projeto utiliza frameworks e bibliotecas de terceiros como jquery, bootstrap, etc. 
Verifique os termos e condições das licenças individualmente e descubra se você pode utilizá-los.

Ao usar este projeto, não há nenhuma garantia ou suporte oficial