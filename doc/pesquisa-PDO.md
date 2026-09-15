# Pesquisa – PDO

## O que é o PDO?

PDO significa **PHP Data Objects**. Ele é uma extensão do PHP utilizada para acessar e trabalhar com bancos de dados. O PDO fornece uma forma padronizada de realizar operações como conectar ao banco, executar comandos SQL e buscar informações.

Uma das principais características do PDO é que ele possui uma interface que pode ser utilizada com diferentes bancos de dados, desde que exista um driver compatível.

## Para que o PDO é utilizado?

O PDO é utilizado em aplicações PHP que precisam armazenar, consultar, alterar ou excluir informações em um banco de dados.

Por exemplo, pode ser usado em sistemas de:

* Cadastro de usuários;
* Login;
* Lojas virtuais;
* Sistemas escolares;
* Blogs;
* Sites que armazenam informações de clientes ou produtos.

## Como funciona uma conexão utilizando PDO?

Para criar uma conexão, normalmente é utilizada a classe `PDO`. É necessário informar o tipo de banco, o endereço do servidor, o nome do banco, o usuário e a senha.

Depois de estabelecer a conexão, o PDO permite que o sistema execute comandos SQL e trabalhe com os dados armazenados no banco.

## Principais características

Entre as principais características do PDO estão:

* Interface padronizada para acesso a bancos de dados;
* Suporte a diferentes bancos através de drivers;
* Utilização de Prepared Statements;
* Tratamento de erros através de exceções;
* Possibilidade de utilizar transações;
* Diferentes formas de buscar os resultados das consultas;
* Código mais organizado para trabalhar com bancos de dados.

O PDO, porém, não transforma automaticamente um SQL de um banco para outro. Ele fornece uma interface comum, mas cada banco ainda pode possuir características e comandos específicos.

## Diferenças entre PDO e MySQLi

O **PDO** e o **MySQLi** são duas opções disponíveis no PHP para trabalhar com bancos de dados.

A principal diferença é que o MySQLi foi desenvolvido especificamente para trabalhar com **MySQL**, enquanto o PDO possui suporte a vários bancos por meio de drivers.


Assim, se o projeto utiliza exclusivamente MySQL, tanto PDO quanto MySQLi podem ser utilizados. Já quando existe a possibilidade de utilizar outro banco de dados no futuro, o PDO pode ser uma opção mais flexível.

## Vantagens do PDO

Algumas vantagens de utilizar PDO são:

* **Flexibilidade:** pode ser utilizado com diferentes bancos de dados.
* **Segurança:** facilita o uso de Prepared Statements, ajudando a evitar SQL Injection.
* **Organização:** possui uma estrutura padronizada para trabalhar com consultas.
* **Tratamento de erros:** pode utilizar exceções para facilitar a identificação de problemas.
* **Facilidade de manutenção:** pode facilitar alterações futuras no sistema.

## Desvantagens do PDO

Apesar das vantagens, o PDO também possui algumas desvantagens:

* É necessário conhecer a utilização da classe `PDO` e seus métodos.
* É necessário instalar ou habilitar o driver correspondente ao banco utilizado.
* Algumas funções específicas de determinado banco podem exigir conhecimento da sintaxe própria desse banco.
* Para projetos que utilizam exclusivamente MySQL, o MySQLi também pode atender muito bem às necessidades.

## O que são Prepared Statements?

**Prepared Statements**, ou instruções preparadas, são uma forma de executar comandos SQL utilizando parâmetros separados dos dados enviados pelo usuário.

Em vez de colocar diretamente uma informação dentro da consulta SQL, utiliza-se um marcador para representar o valor que será inserido posteriormente.

Os Prepared Statements são importantes principalmente por questões de **segurança**, pois ajudam a evitar ataques de **SQL Injection**. Eles também podem ser vantajosos quando a mesma consulta precisa ser executada várias vezes com valores diferentes.

É importante lembrar que os parâmetros são utilizados para valores de dados. Eles não podem ser usados diretamente para substituir nomes de tabelas, colunas ou outras partes estruturais da consulta SQL.

## Quando o PDO pode ser uma boa escolha?

O PDO pode ser uma boa escolha em projetos PHP que precisam trabalhar com bancos de dados de forma organizada e segura.

Ele é especialmente interessante quando:

* O sistema utiliza ou pode utilizar diferentes tipos de banco de dados;
* É necessário utilizar Prepared Statements;
* O projeto precisa de um tratamento de erros mais organizado;
* O sistema possui muitas consultas ao banco;
* O desenvolvedor busca uma solução padronizada para acesso aos dados.

Portanto, o PDO é uma alternativa bastante utilizada no PHP para conexão e comunicação com bancos de dados. Ele oferece uma interface consistente, suporte a diferentes drivers e recursos importantes de segurança, principalmente através dos Prepared Statements.
