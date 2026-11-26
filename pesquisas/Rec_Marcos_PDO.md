## O que é PDO?

A extensão PHP Data Objects (PDO) define uma interface leve e consistente para acessar bancos de dados no PHP. Cada driver de banco de dados que implementa a interface PDO
pode expor recursos específicos do banco de dados como funções de extensão comuns. Observe que não é possível executar nenhuma função de banco de dados usando apenas a
extensão PDO; um driver PDO de banco de dados deve ser usado para acessar o servidor de banco de dados.

## Porque usar PDO?

Antes da chegada do PDO, a linguagem PHP oferecia suporte à comunicação com diferentes modelos de SGBD através de módulos específicos.
A maioria deles provia uma biblioteca de funções e utilizava um resource para representar a conexão e outro para representar um resultset (o resultado de uma consulta). As operações eram feitas sobre as variáveis de resource.
Cada driver implementava suas operações conforme imaginavam ser mais adequados. Embora alguns deles tivessem um funcionamento semelhante, a ordem dos parâmetros nem sempre era a mesma e podia causar uma certa confusão entre programadores.

























## Fontes: https://www.php.net/manual/pt_BR/book.pdo.php