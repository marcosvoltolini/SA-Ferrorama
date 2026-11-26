Textos e formatação
strlen()
 Conta quantos bytes tem um texto. Aparece 3 vezes, sempre para validar o tamanho da senha: strlen($senha) < 6 recusa senhas com menos de 6 caracteres (em cadastrar_usuario.php, cadastrar_admin.php e atualizar_clientes.php). Em atualizar_clientes.php, só valida se a senha foi preenchida ($senha !== "").
mb_strlen()
 Primo do strlen(), mas conta caracteres de verdade, e não bytes. É a versão certa para textos com acento, já que "ã" ocupa 2 bytes mas é 1 caractere. Aparece 16 vezes, quase sempre para limitar nome, e-mail, origem e destino a 100 caracteres, que é o tamanho das colunas do banco.
trim()
 Tira espaços do começo e do fim do texto. É usada nos campos dos formulários, como trim($_POST["email"]), para que um espaço sem querer não estrrague a validação.
htmlspecialchars()
 Troca caracteres como < e > por versões seguras antes de mostrar na tela. Evita ataques XSS, em que alguém cadastra um nome com código <script> malicioso.
str_replace()
 Substitui um trecho de texto por outro. Em adicionar_rota.php, troca vírgula por ponto na distância (12,5 vira 12.5), porque o banco só aceita ponto decimal.
ucfirst()
 Deixa a primeira letra maiúscula. Nos selects de tipo de sensor, mostra "Localização" mesmo que no banco esteja "localização".
rawurlencode()
 Prepara um texto para ir dentro de uma URL, trocando espaços e caracteres especiais. Serve para imagens com nome estranho, como venice rota.png, que ficaria quebrada sem isso.
preg_match()
 Confere se um texto segue um padrão (regex). Em adicionar_rota.php, garante que o horário de partida está no formato HH:MM, entre 00:00 e 23:59.
Validação
isset()
 Verifica se uma variável existe e não é null. Usada, por exemplo, para saber se há alguém logado: isset($_SESSION["id_usuario"]).
in_array()
 Verifica se um valor está dentro de uma lista. Em verifica_acesso.php, confere se o perfil está em ["administrador", "funcionario"]. O true no final deixa a comparação estrita, sem conversão de tipo.
array_key_exists()
 Verifica se uma chave existe no array. Em cadastrar_admin.php, confere se o perfil escolhido existe em $perfis.
filter_var()
 Valida ou filtra um valor. Com FILTER_VALIDATE_EMAIL, confirma que o e-mail tem formato válido (algo@dominio.com).
is_numeric()
 Retorna verdadeiro se o valor é um número. Valida a distância da rota antes de gravar.
Arrays e arquivos
scandir()
 Lista o que há dentro de uma pasta. Aqui lê assets/imag para montar o select de imagens de trens e mapas.
array_diff()
 Remove de um array os itens que aparecem em outro. Tira . e .. da lista do scandir(), que são entradas da pasta e não imagens.
file_get_contents()
 Lê o conteúdo de um arquivo ou de uma URL. No painel do cliente, chama a API Open-Meteo para buscar o clima.
json_decode()
 Converte um texto JSON em array PHP. Transforma a resposta da API de clima em dados que o código consegue usar.
