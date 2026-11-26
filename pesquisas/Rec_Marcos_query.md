## Resuperação sobre Query
Aluno: Marcos Paulo Voltolini Filho
Data: 26/11
Turma: TDES24M4

# Definição de Query:
Query é uma solicitação de informações a um banco de dados. Mas não se trata de qualquer pergunta. 
Ela é baseada em um código pré-definido para obter as respostas que deseja. 
Podem ser usadas linguagens mais simples ou complexas. Mas, em síntese, a mais comum é a SQL. 
 
# Como funciona:
O gerenciamento do banco de dados permite remover, acrescentar ou modificar os dados do seu projeto on-line. 
E para concretizar essas ações, é necessário fazer uma Query.

Mas para isso ocorrer, é importante que o banco de dados compreenda a solicitação. 
Portanto, quando os comandos certos são executados, a pessoa desenvolvedora obtém os resultados desejados de informações que já estão armazenadas. 
 

# Comandos mais comuns 

Where: é o primeiro comando. Ele busca informações em um arquivo ou parte da memória. 

Group by: une os dados de um determinado grupo. 

FieldByName: seleciona os dados específicos que estão em determinada coluna e tabela. 

Having: usado para que o resultado contenha os dados selecionados por um filtro em específico.

Fields: permite visualizar os campos em ordem crescente. 

Order by: ele adiciona um fator de organização a mais no banco de dados. 

While: é um comando utilizado para consultar vários dados simultaneamente. 


# Sobre "Like"
É basicamente filtrar a pesquisa.
Para busca parcial de string, o SELECT fornece o operador LIKE. Veja o exemplo abaixo:
    SELECT CODIGO, NOME FROM CLIENTES
      WHERE NOME LIKE ‘MARIA%’
Neste comando, todos os clientes cujos nomes iniciam com Maria serão retornados. 

# Sobre "Order by"
 Organiza as linhas retornadas por uma consulta com base em uma ou mais colunas.
Usa ASC para ordem crescente (padrão, de A a Z ou menor para maior) e DESC para ordem decrescente.
Exemplo: 
SELECT nome, idade FROM alunos ORDER BY idade ASC;

# Sobre "Inner Join"
Inner Join, ou Junção Interna, é um conceito fundamental em bancos de dados relacionais que permite combinar registros de duas ou mais tabelas com base em uma condição específica. Essa técnica é amplamente utilizada em SQL (Structured Query Language) para recuperar dados que estão relacionados entre si.

Como funciona:
A Junção Interna funciona através da especificação de uma condição de junção, geralmente utilizando chaves primárias e estrangeiras. Por exemplo, se você tem uma tabela de “Clientes” e outra de “Pedidos”, pode usar a coluna “ID do Cliente” em ambas as tabelas para unir os dados. A sintaxe básica para realizar um Inner Join em SQL é a seguinte: `SELECT * FROM Clientes INNER JOIN Pedidos ON Clientes.ID = Pedidos.ClienteID;`. Essa consulta retornará apenas os clientes que possuem pedidos registrados, permitindo uma análise mais focada e eficiente das informações.


## Fontes: https://coodesh.com/blog/dicionario/o-que-e-query/
https://minacriativa.com.br/glossario/o-que-e-inner-join-juncao-interna/
