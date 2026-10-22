## O que é uma API?

    API (Application Programming Interface) é uma interface que permite a comunicação entre diferentes sistemas, aplicativos ou serviços. Sua função é facilitar a troca de informações de forma padronizada.

## Como funciona?

    Um sistema envia uma requisição para a API, que processa o pedido e retorna uma resposta com os dados solicitados.

## O que são APIs REST?

    São APIs que utilizam o protocolo HTTP para comunicação e normalmente trocam dados no formato JSON.

## Métodos HTTP
    # GET: consultar dados;
        GET /clientes/1

    # POST: criar dados;
        POST /clientes

    # PUT: atualizar dados completamente;
        PUT /clientes/1

    # PATCH: atualizar parcialmente;
        PATCH /clientes/1

    # DELETE: excluir dados.
        DELETE /clientes/1


## Endpoints

    São os endereços (URLs) onde os recursos da API podem ser acessados.
        /api/clientes
        /api/produtos
        /api/pedidos

## JSON

    É um formato leve e organizado para troca de dados entre sistemas.
        {
        "produto": "Notebook",
        "preco": 3500,
        "estoque": 15
        }

## API x Sistema Web

    Um sistema web exibe páginas para usuários, enquanto uma API fornece dados para outras aplicações.

## PHP e APIs

    Aplicações PHP podem consumir APIs usando ferramentas como cURL ou bibliotecas específicas para enviar requisições e receber dados.

## Segurança

   A segurança é fundamental para proteger informações e controlar acessos. Os principais mecanismos são:

        - Autenticação (identificação do usuário);
        - Autorização (controle de permissões);
        - Uso de HTTPS para criptografar a comunicação;
        - Tokens de acesso, como JWT.

## Exemplos de Uso
    - Sistemas de pagamento (Pix, PayPal);
    - ERPs;
    - CRMs;
    - Sistemas de logística e rastreamento;
    - Aplicativos de integração empresarial.

## Fontes Consultadas
    - Mozilla Developer Network (MDN): https://developer.mozilla.org/
    - REST API Tutorial: https://restfulapi.net/
    - Documentação oficial JSON: https://www.json.org/json-pt.html
    - Documentação HTTP - RFC 9110: https://www.rfc-editor.org/rfc/rfc9110
    - PHP Documentation: https://www.php.net/docs.php