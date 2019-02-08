# zionphp
Framework PHP - Um framework MVC de propósito geral, visando atender todas as demandas de um sistema ou site

## Pré-Requisitos
- PHP >= 5.3.0 Versão que iniciou o suporte a namespace
- Apache >= 2.2 com módulo mod_rewrite instalado
- MySQL >= 5.6
- Arquivo .htaccess redirecionando todo o fluxo da aplicação para o index.php, exceto arquivos estaticos como 
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

## Linkar o diretório raiz do framework no seu projeto para que a IDE reconheça as classes
 
- Eclipse: Propriedades do Projeto > PHP > Source Paths > Build Path > Link Source.
![Eclipse](https://raw.githubusercontent.com/vcd94xt10z/zionphp/master/frontend/zion/github/eclipse.png)
 
- NetBeans: Em breve

## Disclaimer

Este projeto utiliza frameworks e bibliotecas de terceiros como: jquery, bootstrap, etc. 
Verifique os termos e condições das licenças individualmente e verifique se você pode utiliza-los.

Ao usar este projeto, não há nenhum garantia ou suporte oficial