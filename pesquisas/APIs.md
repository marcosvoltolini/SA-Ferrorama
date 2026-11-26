# Pesquisa: APIs (Application Programming Interface)

## 1. O que é uma API?

API (Application Programming Interface), ou Interface de Programação de Aplicações, é uma ferramenta que permite a comunicação entre diferentes sistemas, aplicativos e serviços.

Sua função é facilitar a troca de informações entre programas, mesmo que tenham sido desenvolvidos de maneiras diferentes.

**Exemplo:** Integração entre Discord e PlayStation 5: permite que jogadores utilizem chamadas de voz do Discord diretamente no console, demonstrando como diferentes plataformas podem se conectar por meio de integrações e APIs.

## 2. Como funciona uma API?

O funcionamento de uma API acontece por meio de uma solicitação e uma resposta.

O processo funciona da seguinte maneira:

1. Um sistema solicita uma informação.
2. A API recebe e processa o pedido.
3. O servidor envia uma resposta.
4. O sistema recebe e utiliza os dados.

Integração entre Discord e PlayStation 5: permite que jogadores utilizem chamadas de voz do Discord diretamente no console, demonstrando como diferentes plataformas podem se conectar por meio de integrações e APIs.
## 3. O que são APIs REST?

REST é um modelo utilizado para organizar a comunicação entre sistemas por meio de APIs.

As APIs REST utilizam principalmente o protocolo HTTP para enviar e receber informações. Normalmente, os dados são transmitidos no formato JSON.

Esse modelo é bastante utilizado em sites, aplicativos e sistemas empresariais.

## 4. Métodos HTTP

Os métodos HTTP indicam o que o sistema deseja fazer com as informações de uma API.

Os principais são:

| Método | Função | Exemplo |
|---|---|---|
| GET | Consultar dados | `/clientes/1` |
| POST | Criar dados | `/clientes` |
| PUT | Atualizar todos os dados | `/clientes/1` |
| PATCH | Atualizar parte dos dados | `/clientes/1` |
| DELETE | Excluir dados | `/clientes/1` |

**Exemplo:** em uma loja virtual, o GET pode consultar os produtos, enquanto o POST pode cadastrar um novo produto.

## 5. Endpoints

Endpoints são os endereços utilizados para acessar as informações de uma API.

Exemplos:

```text
/api/clientes
/api/produtos
/api/pedidos
```

Cada endereço representa uma parte do sistema e permite acessar informações específicas.

## 6. JSON

JSON é um formato utilizado para organizar e transmitir informações entre diferentes sistemas.

Ele é bastante utilizado em APIs porque é simples e fácil de entender.

**Exemplo:**

```json
{
    "produto": "Notebook",
    "preco": 3500,
    "estoque": 15
}
```

Nesse exemplo, temos o nome do produto, seu preço e a quantidade disponível no estoque.

## 7. Códigos de resposta HTTP

Quando uma API recebe uma solicitação, ela envia um código informando se a operação deu certo ou se ocorreu algum problema.

Alguns exemplos são:

- **200:** solicitação realizada com sucesso.
- **201:** informação criada com sucesso.
- **400:** solicitação incorreta.
- **401:** usuário não autenticado.
- **403:** acesso não permitido.
- **404:** informação não encontrada.
- **500:** erro interno do servidor.

Esses códigos ajudam a identificar problemas durante a comunicação entre os sistemas.

## 8. API x Sistema Web

Um sistema web apresenta páginas e informações para os usuários, enquanto uma API permite que diferentes sistemas troquem informações.

**Exemplo:** em uma loja virtual, o site mostra os produtos na tela, enquanto a API fornece os dados desses produtos.

## 9. PHP e APIs

O PHP permite utilizar APIs para buscar informações de outros sistemas ou disponibilizar dados para outras aplicações.

Uma ferramenta bastante utilizada é o cURL, que permite fazer solicitações para servidores externos.

O PHP também possui a função `json_decode()`, utilizada para interpretar informações recebidas no formato JSON.

**Exemplo:**

```php
<?php

$url = "https://api.exemplo.com/produtos";

$resposta = file_get_contents($url);

$dados = json_decode($resposta, true);

echo $dados["produto"];

?>
```

Nesse exemplo, o PHP acessa uma API, recebe os dados e utiliza as informações retornadas.

## 10. Segurança em APIs

A segurança é importante para proteger as informações e evitar acessos indevidos.

Algumas formas de proteção são:

- **Autenticação:** identifica quem está acessando o sistema.
- **Autorização:** controla o que cada usuário pode fazer.
- **HTTPS:** protege a comunicação entre os sistemas.
- **Tokens:** ajudam a verificar se uma solicitação está autorizada.
- **Validação de dados:** verifica se as informações recebidas estão corretas.

## 11. Vantagens e desvantagens das APIs

### Vantagens

- Facilitam a comunicação entre sistemas.
- Permitem compartilhar informações.
- Ajudam a automatizar tarefas.
- Economizam tempo de desenvolvimento.
- Permitem integrar diferentes aplicativos.

### Desvantagens

- Podem depender de serviços externos.
- Podem apresentar falhas de conexão.
- Precisam de cuidados com segurança.
- Algumas possuem limites de utilização.

## 12. Exemplos de utilização

As APIs são utilizadas em diversas situações do cotidiano, como:

- Aplicativos de previsão do tempo.
- Sistemas de pagamento, como Pix e PayPal.
- Aplicativos de mapas e localização.
- Sistemas de rastreamento de entregas.
- Redes sociais.
- Sistemas de empresas e lojas virtuais.

## 13. Conclusão

As APIs são importantes para o funcionamento de muitos sistemas e aplicativos que utilizamos diariamente.

Elas permitem que diferentes programas troquem informações de maneira rápida e organizada, facilitando a criação de novas funcionalidades e a integração entre serviços.

Por isso, conhecer o funcionamento das APIs é importante para quem estuda programação e desenvolvimento de sistemas.

## 14. Fontes consultadas

- **MDN Web Docs:** https://developer.mozilla.org/pt-BR/docs/Web/HTTP
- **REST API Tutorial:** https://restfulapi.net/
- **JSON:** https://www.json.org/json-pt.html
- **RFC 9110 - HTTP:** https://www.rfc-editor.org/rfc/rfc9110
- **Documentação PHP:** https://www.php.net/docs.php
- **OWASP API Security:** https://owasp.org/www-project-api-security/