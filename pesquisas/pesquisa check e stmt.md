Check
nome que indica que a consulta serve para verificar algo. intermediário entre o PHP e o banco durante toda a verificação: ele é criado, recebe o valor, executa, entrega o resultado e é fechado. 
Para que serve
Verificar duplicidade: antes de cadastrar um trem, confere se já existe outro com o mesmo nome.

STMT
abreviação de statement, nome genérico para qualquer consulta preparada. Em INSERT, UPDATE e DELETE não existe get_result(), porque essas operações não devolvem linhas. Você só usa execute() e, se quiser saber quantas linhas foram afetadas, $stmt->affected_rows. 