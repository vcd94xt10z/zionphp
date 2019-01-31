# zionphp
Framework PHP

Requisitos minimos
- PHP >= 5.3.0 que começou o suporte a namespace

 Como usar
 1) Incluir o arquivo autoload.php no seu projeto
 2) Linkar o diretório raiz do framework no seu projeto para que a IDE reconheça as classes
 
 Como linkar o framework
 - Eclipse: Propriedades do Projeto > PHP > Source Paths > Build Path > Link Source.
 - NetBeans: Em Breve
 
 Configuração para utilização de módulos
  - No arquivo .htaccess da raiz do projeto que redireciona todo o fluxo de requisições para o index.php, 
  insira a linha abaixo para não tentar encontrar as imagens diretamente dentro do projeto pois esse caminho 
  não existe fisicamente:
  
  RewriteCond %{REQUEST_URI} !^zion/
	