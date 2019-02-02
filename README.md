# zionphp
Framework PHP - Este projeto utiliza frameworks e bibliotecas de terceiros, exemplo: jquery, bootstrap, etc. 
Verifique os termos e condições das licenças de cada um individualmente.

Requisitos minimos
- PHP >= 5.3.0 Versão que iniciou o suporte a namespace

 Como usar
 1) Incluir o arquivo autoload.php no seu projeto, exemplo abaixo: 
 
 ```php
  require(dirname(dirname(dirname(__FILE__)))."/zionphp/autoload.php");
 ```
 
 2) Linkar o diretório raiz do framework no seu projeto para que a IDE reconheça as classes
 
 Como linkar o framework
 - Eclipse: Propriedades do Projeto > PHP > Source Paths > Build Path > Link Source.
  ![Eclipse](https://raw.githubusercontent.com/vcd94xt10z/zionphp/master/frontend/zion/github/eclipse.png)
 
 - NetBeans: Em Breve
 
 Configuração para utilização de módulos
  - No arquivo .htaccess da raiz do projeto que redireciona todo o fluxo de requisições para o index.php, 
  insira a linha abaixo para não tentar encontrar as imagens diretamente dentro do projeto pois esse caminho 
  não existe fisicamente:
 
 ```php 
 RewriteCond %{REQUEST_URI} !^zion/
 ```