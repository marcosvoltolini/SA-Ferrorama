                                Red Rush - SA Ferrorama

    Sistema web para gerenciar e acompanhar uma operação ferroviária inspirada no Ferrorama, o clássico ferromodelo brasileiro da Estrela. O projeto reúne trens, rotas, horários, sensores e as pessoas envolvidas (administradores, funcionários/maquinistas e clientes). Foi desenvolvido como Situação de Aprendizagem (SA) do curso técnico em Desenvolvimento de Sistemas.


-   Problema que o sistema resolve

    Sem um sistema central, as informações de uma operação ferroviária ficam espalhadas: quais trens existem, quem conduz cada um, quais rotas e horários cumprem e quais sensores monitoram cada trem. Isso dificulta o controle, gera inconsistências e deixa o cliente sem uma fonte confiável de horários e mapas.

    O Red Rush concentra esses dados em um banco único, com acesso controlado por perfil: quem opera cadastra e atualiza, e quem usa o serviço apenas consulta.


-   Objetivos e principais funcionalidades

    Objetivos: centralizar o cadastro da operação, controlar quem pode ver e alterar cada informação e disponibilizar horários e mapas de forma clara para o cliente.


-   Funcionalidades:

    - Login com três perfis (administrador, funcionário e cliente), cada um com o seu painel.
    - CRUD completo de trens, rotas, sensores e usuários.
    - Associação de um maquinista (funcionário) a cada trem.
    - Consulta de horários e mapas das rotas, lidos do banco (a chegada é calculada: partida + duração).
    - Integração com API de clima na tela inicial (temperatura, condição, localização e horário da consulta).
    - Validação de CEP via API, com tratamento de CEP inválido, sem resultado e falha de comunicação.
    - Tecnologias utilizadas
    - PHP (mysqli)
    - MySQL/MariaDB
    - HTML
    - CSS (assets/style/style.css)
    - XAMPP
    - Git/GitHub


-   Requisitos para executar

    - XAMPP com Apache e MySQL/MariaDB
    - Navegador atualizado (Chrome, Edge ou Firefox)
    - Acesso à internet, apenas para as integrações com APIs externas
    - Git
    - Instalação e configuração
    - Instale o XAMPP e ligue Apache e MySQL no painel de controle.


-   Baixe o projeto:

    - git clone https://github.com/marcosvoltolini/SA-Ferrorama.git
    - Copie a pasta para C:\xampp\htdocs\, de modo que fique htdocs\SA-Ferrorama.
    - Se o seu MySQL tiver usuário ou senha diferentes de root / (vazia), edite infra/conexao.php.
        - Configuração e importação do banco de dados
        - Abra http://localhost/phpmyadmin.
        - Vá na aba Importar, escolha o arquivo Db/Database.sql e clique em Importar.

        * Atenção: o Database.sql apaga e recria o banco SA_Ferrorama. Se já existir um banco com esse nome, os dados dele serão perdidos.

    - O banco começa sem trens, rotas ou sensores: cadastre pelo sistema. As imagens dos trens e dos mapas são escolhidas entre os arquivos da pasta assets/imag.


-   Acesso do administrador inicial

    - O Database.sql cria o administrador Marcos_Voltolini@gmail.com. Para definir uma senha nova, gere o hash e atualize no banco:

    - C:\xampp\php\php.exe -r "echo password_hash('SuaNovaSenha', PASSWORD_DEFAULT);"
    - sql
    - UPDATE usuarios SET senha_usuario = 'COLE_O_HASH_AQUI' WHERE email_usuario =          'Marcos_Voltolini@gmail.com';

    - Logado como administrador, use Usuários > Cadastrar usuário para criar funcionários (que podem ser maquinistas) e outros administradores.


-  Regras do banco

    - trens.maquinista_id é único: um maquinista conduz no máximo um trem. Se o usuário for excluído, o trem fica sem maquinista.
    - Um trem que ainda tem rotas ou sensores não pode ser excluído.
    - O e-mail do usuário e o nome do trem são únicos.
    - Como iniciar a aplicação
        - Confirme que Apache e MySQL estão ligados no XAMPP.
        - Acesse http://localhost/SA-Ferrorama/.
        - Entre pela página de login com um usuário cadastrado.
    - Perfis de acesso e permissões
    
    - Ação	
        - Cliente	
            - Ver trens, rotas, horários e mapas
        - Funcionário
            - Ver trens, rotas, horários, mapas e clientes
        - Administrador
            - Ver lista de clientes e cadastrar clientes
            - Excluir trens, rotas e sensores
            - Editar / excluir usuários e mudar perfis

    - A checagem é feita no servidor, no começo de cada página, pelos arquivos verifica_login.php, verifica_acesso.php (administrador e funcionário) e verifica_admin.php (só administrador).


-   Estrutura geral do projeto

SA-Ferrorama/
├── index.php                    página inicial
├── dashboard_admin.php          painel do administrador
├── dashboard_funcionario.php    painel do funcionário (mostra o trem que ele conduz)
├── dashboard_comum.php          painel do cliente
├── assets/                      imagens e style.css
├── Db/Database.sql              banco completo
├── infra/conexao.php            conexão com o banco
├── pesquisas/                   APIs, PDO, CRUD, Scrum, XAMPP e Kanban
└── public/
    ├── login.php, logout.php
    ├── cabecalho.php                    cabeçalho e menu
    ├── verifica_login.php, verifica_acesso.php, verifica_admin.php
    ├── Listar_trens.php, cadastro_trem.php, editar_trens.php, atualizar_trem.php, excluir_trens.php
    ├── Listar_rotas.php, adicionar_rota.php, editar_rotas.php, atualizar_rota.php, excluir_rotas.php
    ├── Listar_sensor.php, cadastro-sensor.php, editar_sensor.php, atualizar_sensor.php, excluir_sensor.php
    ├── Listar_clientes.php, cadastrar_usuario.php, cadastrar_admin.php,
    │   editar_clientes.php, atualizar_clientes.php, excluir_clientes.php
    └── Horario_trem.php, Rota_trem.php


-  Padrão de cada CRUD:

    - Listar_ mostra a tabela
    - cadastro_ / adicionar_ cria
    - editar_ mostra o formulário preenchido
    - atualizar_ grava a edição
    - excluir_ apaga
    - Segurança aplicada
    - Senhas com password_hash; nenhuma tela lê ou mostra a coluna de senha.
    - Consultas com prepared statements (sem SQL Injection).
    - Textos vindos do banco são escapados com htmlspecialchars.
    - Exclusões só aceitam POST e só para administrador.
    - Todas as páginas, menos index.php e login.php, exigem login.


-   Integrantes e contribuições

    - Marcos Voltolini (@marcosvoltolini)
        - Tela de login, página inicial, banco de dados, CRUD de trens, organização do projeto no GitHub
    - Ramon (@ramontsantos-trindade)
        - Mockup, dashboard, visualização dos sensores em PHP, correção da exposição de senhas
    - Davi Rosa (@davigura)
        - README, CRUD de trens
    - Rebeca (@rebeca-sarrea)
        - CRUD, integração com a API de CEP


-   Limitações conhecidas

    - Os sensores são cadastrados, mas o sistema não recebe leituras em tempo real (velocidade, localização).
    - O sistema é web e roda localmente no XAMPP; não há versão mobile nem hospedagem online.
    - As integrações com APIs externas dependem de internet e podem falhar se o serviço estiver fora do ar.
    - Não há recuperação de senha por e-mail; a troca de senha do administrador inicial é manual, pelo banco.
    - Não há testes automatizados.


-   Documentação da equipe

    - pesquisas/Kanban.md: quadro Kanban e backlog
    - pesquisas/: APIs, PDO, CRUD, Scrum e XAMPP