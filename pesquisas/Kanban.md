# Kanban — Red Rush

O quadro em si (GitHub Projects, Trello etc.) não fica no repositório. Este arquivo é o modelo para organizar o quadro e o backlog atual.

## Colunas

| Coluna | Significa | Limite |
|---|---|:---:|
| Backlog | Pendências ainda não priorizadas | — |
| A fazer | Priorizado para esta semana, com responsável | — |
| Em andamento | Alguém está fazendo agora | 1 por pessoa |
| Em revisão | Pronto, esperando outra pessoa testar | 3 |
| Feito | Testado e cumprindo a definição de pronto | — |

## Regras

1. Todo cartão tem um responsável e um prazo (uma data).
2. Ninguém puxa cartão novo com outro em andamento.
3. Quem revisa não é quem fez.
4. Cartão travado ganha a etiqueta `bloqueado` e o motivo.

## Definição de pronto

- Funciona no XAMPP de outra pessoa da equipe
- Testado com os três perfis (cliente, funcionário, administrador)
- Mudança de banco feita no `Db/Database.sql`
- README atualizado se mudou algo que quem usa precisa saber

## Modelo de cartão

```
Título: verbo + objeto (ex.: "Corrigir exclusão de trens por usuário comum")
Responsável:
Prazo:
Etiqueta: bug | funcionalidade | documentação | segurança | banco
Critério de aceite: como saber que acabou
```

## Backlog atual

| # | Cartão | Estado |
|--:|---|---|
| 1 | Criar CRUD de rotas | Em revisão |
| 2 | Impedir que usuário comum exclua trens | Em revisão |
| 3 | Parar de expor a senha na lista de usuários | Em revisão |
| 4 | Melhorar a interface | Em revisão |
| 5 | Relacionar as tabelas com chaves estrangeiras | Em revisão |
| 6 | Associar um maquinista a um trem | Em revisão |
| 7 | Reorganizar o quadro Kanban | Em andamento |
| 8 | Reescrever o README | Em revisão |
| 9 | Pesquisa de API | Feito (`pesquisas/APIs.md`) |
| 10 | Corrigir login e redirecionamento por perfil | Em revisão |
| 11 | Proteger todas as páginas com sessão e perfil | Em revisão |
| 12 | Criar painel para o usuário comum | Em revisão |
| 13 | Melhorar CRUD de trens e rotas | Em revisão |
| 14 | Ligar Horários, Rotas e Sensores ao banco | Em revisão |
| 15 | Cadastrar os trens, rotas e sensores reais pelo sistema | A fazer |
| 16 | Definir a licença do projeto | A fazer |
| 17 | Testar tudo no XAMPP com os 3 perfis e mover os cartões para Feito | A fazer |
