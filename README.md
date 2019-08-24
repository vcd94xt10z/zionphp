![Zion Framework](https://raw.githubusercontent.com/vcd94xt10z/zionphp/master/frontend/zion/img/zion-framework.png)

Você não veio aqui para fazer uma escolha, você já fez. Você esta aqui para entender porque fez sua escolha.

A maioria dos usuários não está preparado para despertar. E muitos deles estão tão inertes, tão desesperadamente dependentes de outros frameworks, que irão lutar para protegê-los.

Eu só posso lhe mostrar a porta. Você tem que atravessá-la.

<p float="left"> 
  <img src="https://hitcounter.pythonanywhere.com/count/tag.svg?url=https%3A%2F%2Fgithub.com%2Fvcd94xt10z%2Fzionphp" />
</p>

## Antes de começar

Certifique-se de que o Apache, PHP, MySQL Client e Composer esteja instalado e funcionando. 
Após essa verificação inicial, configure seu PHP e instale as extensões obrigatórias. 

/etc/php.ini

```
short_open_tags On
```

Comandos para instalação dos programas e módulos, usando um Linux baseado em RHEL

```
$ yum install mysql mod_ssl mod_rewrite php-mbstring php-pdo php-mysqlnd php-json php-xml php-soap php-zip php-posix
```

Após executar as instalações, reinicie o Apache e PHP se utilizar FPM e faça os testes com os comandos abaixo. 
Cada comando vai imprimir informações da versão de cada programa, não pule nenhum passo porque se os pré-requisitos 
não forem respeitados, o framework pode não funcionar.

```
$ httpd -v
$ php -v
$ mysql --version
$ composer --version
```

Segue abaixo a lista de versões esperadas de cada programa:

- PHP >= 7
- Apache >= 2.2 com módulo mod_rewrite instalado
- MySQL Server >= 5.6


## Documentação

Infelizmente, é impossível dizer o que é Zion, você tem de ver por si mesmo. 

Esta é sua última chance, depois não há como voltar.

Se tomar a pílula [azul](https://www.youtube.com/watch?v=dQw4w9WgXcQ), a história acaba, e você acordará na sua cama acreditando no que quiser acreditar.

Se tomar a pílula [vermelha](https://htmlpreview.github.io/?https://github.com/vcd94xt10z/zionphp/blob/master/docs/index.html), ficará no País das Maravilhas e eu te mostrarei até onde vai a toca do coelho.

Lembre-se, tudo que ofereço é a verdade, nada mais.  

## Funcionalidades

A ideia é ser simples, inserindo apenas 1 linha no seu código já é possível utilizar a maioria das funcionalidades, 
exceto as que precisem da instalação de dependências.

As principais funcionalidades são:
- Plataforma para aplicações MVC com segurança e facilidade de integração
- Persistência de dados: diversos bancos como MySQL, SQLServer entre outros que serão incluidos futuramente
- Gerenciamento de E-mails: e-mails, cotas, logs
- Gerenciamento de Erros: Exceções, erros de código, erros de banco
- Segurança: WAF, suporte a SSL e criptografia
- Gerador de Módulos: Gere CRUD para módulos totalmente funcionais com as melhores práticas, flexível e extensível
- Internacionalização: Use textos em seu sistema em qualquer idioma
- Bibliotecas backend e frontend: Utilidades e ferramentas diversas

## Como usar

1) Clone ou baixe o zip do projeto e extraia em um diretório de sua preferência. Recomendamos que fique no diretório de projetos junto com os projetos que utilizaram o framework.

2) Entre no diretório raiz do framework e baixe as bibliotecas

```
$ composer update
```

3) Crie um arquivo .htaccess na raiz do seu diretório publico redirecionando todo o fluxo da aplicação para o index.php exceto arquivos estáticos (css, js, html, png etc) ou copie o padrão da pasta /app-template/

4) Inclua o arquivo autoload.php no seu projeto 
 
```php
require(dirname(dirname(dirname(__FILE__)))."/zionphp/autoload.php");
```

5) Pronto! Você já pode começar a utilizar o framework, você pode simplesmente utilizar as classes do framework (backend) 
ou utilizar também os módulos já embutidos, disponíveis com o prefixo de URI /zion/.

``` 
http://seusite.com.br/zion/
```

## Configure sua IDE

Para funcionar o auto complete e reconhecer as classes, métodos etc é necessário configurar sua IDE, siga as instruções abaixo:
- Eclipse: Propriedades do Projeto > PHP > Source Paths > Include Path > Aba "Libraries" > Add Library.
- NetBeans: Propriedades do Projeto > Include Path > Add Folder.

## Melhoria continua

Este framework esta em constante atualização.

Caso encontre algum bug, melhoria fique a vontade para reportar nas 
[Issues](https://github.com/vcd94xt10z/zionphp/issues)

## Aviso Legal

Este projeto utiliza internamente frameworks e bibliotecas de terceiros embutidos como jquery, bootstrap, etc. 
Verifique os termos e condições das licenças individualmente e descubra se você pode utilizá-los.

Ao usar este projeto, não há nenhuma garantia ou suporte oficial.
