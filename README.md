![Zion Framework](https://raw.githubusercontent.com/vcd94xt10z/zionphp/master/frontend/zion/img/zion-framework.png)

Um framework MVC de propósito geral, visando atender grande parte das demandas de qualquer sistema.

Você não veio aqui para fazer uma escolha, você já fez. Você esta aqui para entender porque fez sua escolha.

A maioria dos usuários não está preparado para despertar. E muitos deles estão tão inertes, tão desesperadamente dependentes de outros frameworks, que irão lutar para protegê-lo.

Eu só posso lhe mostrar a porta. Você tem que atravessá-la.

## Documentação

Veja como começar e utilizar as funcionalidades do framework, acessando a
[documentação](https://htmlpreview.github.io/?https://github.com/vcd94xt10z/zionphp/blob/master/docs/index.html)

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
- MySQL Server >= 5.6
- Composer
- MySQL Client instalado: Pode ser usado para importação / exportação de dados que a PDO não funciona
- Arquivo .htaccess redirecionando todo o fluxo da aplicação para o index.php, exceto arquivos estáticos como 
imagens, estilos CSS, JavaScripts

## Como usar

1) Clone ou baixe o zip do projeto e extraia em um diretório de sua preferência. Recomendamos que fique no diretório de projetos junto com os projetos que utilizaram o framework.

2) Entre no diretório raiz do framework e baixe as bibliotecas

```php 
composer update
```

3) Inclua o arquivo autoload.php no seu projeto 
 
```php
require(dirname(dirname(dirname(__FILE__)))."/zionphp/autoload.php");
```
 
4) Acesse a url do seu projeto no navegador com a uri "/zion/install/" e siga as instruções

``` 
http://seusite.com.br/zion/install/
```

5) Pronto! Você já pode começar a utilizar o framework, você pode simplesmente utilizar as classes do framework (backend) 
ou utilizar também os módulos já embutidos, disponíveis com o prefixo de URI /zion/.

``` 
http://seusite.com.br/zion/
```

## Configure sua IDE

Para funcionar o auto complete e reconhecer as classes, métodos etc, é necessário configurar sua IDE, siga as instruções abaixo:
- Eclipse: Propriedades do Projeto > PHP > Source Paths > Include Path > Aba "Libraries" > Add Library.
- NetBeans: Propriedades do Projeto > Include Path > Add Folder.

## Melhoria continua

Este framework esta em constante atualização.

Caso encontre algum bug, melhoria fique a vontade para reportar nas 
[Issues](https://github.com/vcd94xt10z/zionphp/issues)

## Aviso Legal

Este projeto utiliza frameworks e bibliotecas de terceiros como jquery, bootstrap, etc. 
Verifique os termos e condições das licenças individualmente e descubra se você pode utilizá-los.

Ao usar este projeto, não há nenhuma garantia ou suporte oficial
