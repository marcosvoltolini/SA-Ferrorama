o que é um CRUD?
basicamente as 4 (quatro) principais operações com um banco de dados(inserir, ler, atualizar, excluir). 

Insert 
<?php
try {
  $pdo = new PDO('mysql:host=localhost;dbname=meuBancoDeDados', $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare('INSERT INTO minhaTabela (nome) VALUES(:nome)');
  $stmt->execute(array(
    ':nome' => 'Ricardo Arrigoni'
  ));

  echo $stmt->rowCount();
}

read
  < tr  class = "trow" > 
                        < td > <?php  echo  $Id ; ?> </ td > 
                        < td > <?php  echo  $Name ; ?> </ td > 
                        < td > <?php  echo  $Grade ; ?> </ td > 
                        <<td> < ?   php echo $ Marks ; ? > </td> <td> <a href="updatedata.php?id=<?php echo $Id; ?> 
                         " class = " btn btn   - primary " > Editar </a> </td> <td> <a href="deletedata.php?id=<?php echo $Id; ?> "  class = " 
                         btn btn - danger " > Excluir </a> </td> </tr> < ? php   } } ? 
                    

                     > </tbody> </table> </div> </section>

Update
$sql = "update cliente set
            nome = '".$nome."', email = '".$email."',telefone = '".$tel."'
            where idcliente = ".$id;

Delete
<?php
$id = 5;

try {
  $pdo = new PDO('mysql:host=localhost;dbname=meuBancoDeDados', $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare('DELETE FROM minhaTabela WHERE id = :id');
  $stmt->bindParam(':id', $id);
  $stmt->execute();