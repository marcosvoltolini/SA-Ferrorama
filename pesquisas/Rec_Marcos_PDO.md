## Recuperação 
Aluno: Marcos Paulo Voltolini Filho
Data: 26/11
Turma: TDES24M4

## O que é PDO?

A extensão PHP Data Objects (PDO) define uma interface leve e consistente para acessar bancos de dados no PHP. Cada driver de banco de dados que implementa a interface PDO
pode expor recursos específicos do banco de dados como funções de extensão comuns. Observe que não é possível executar nenhuma função de banco de dados usando apenas a
extensão PDO; um driver PDO de banco de dados deve ser usado para acessar o servidor de banco de dados.

## Porque usar PDO?

Antes da chegada do PDO, a linguagem PHP oferecia suporte à comunicação com diferentes modelos de SGBD através de módulos específicos.
A maioria deles provia uma biblioteca de funções e utilizava um resource para representar a conexão e outro para representar um resultset (o resultado de uma consulta). As operações eram feitas sobre as variáveis de resource.
Cada driver implementava suas operações conforme imaginavam ser mais adequados. Embora alguns deles tivessem um funcionamento semelhante, a ordem dos parâmetros nem sempre era a mesma e podia causar uma certa confusão entre programadores.

## Como conectar a um banco MySQL usando PDO

# testando conexão

 <?php
  $banco = new PDO('mysql:host=localhost;dbname=nome_do_banco', 'username','password')or print (mysql_error());
  print "Conexão Efetuada com sucesso!";
  ?>

  # Incluir dados.

  <?php
  $banco = new PDO('mysql:host=localhost;dbname=nome_do_banco', 'username','password');
  $novo_cliente = array('nome'=>'José','departamento'=>'TI','unidade'=>'Paulista');
  $banco->prepare('INSERT INTO clientes (nome,departamento,unidade) VALUES (:nome,:departamento,:unidade)')->execute($novo_cliente);
  ?>

  # Conectar um banco SQL Server usando PDO

  <?php
try {
    $hostname = "sqlserver01.bancodedados.com";
    $dbname = "nomebanco";
    $username = "nomebanco";
    $pw = "senha";
    $pdo = new PDO ("mssql:host=$hostname;dbname=$dbname","$username","$pw");
  } catch (PDOException $e) {
    echo "Erro de Conexão " . $e->getMessage() . "\n";
    exit;
  }
      $query = $pdo->prepare("select Coluna FROM nome_tabela");
      $query->execute();
 
      for($i=0; $row = $query->fetch(); $i++){
        echo $i." - ".$row['Coluna']."<br/>";
      }
 
      unset($pdo); 
      unset($query);
?>


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

## Principais características

Entre as principais características do PDO estão:

* Interface padronizada para acesso a bancos de dados;
* Suporte a diferentes bancos através de drivers;
* Utilização de Prepared Statements;
* Tratamento de erros através de exceções;
* Possibilidade de utilizar transações;
* Diferentes formas de buscar os resultados das consultas;
* Código mais organizado para trabalhar com bancos de dados.


## Fontes: https://www.php.net/manual/pt_BR/book.pdo.php

https://www.locaweb.com.br/ajuda/wiki/tudo-sobre-o-php-data-object-pdo-hospedagem-de-sites/

Usei a ultima pesquisa como fonte também.