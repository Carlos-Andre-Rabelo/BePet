# Projeto BePet 🐾

Este é um projeto desenvolvido para a disciplina de Programação para Web, com o objetivo de criar uma plataforma para um petshop fictício, incluindo uma vitrine de produtos, formulário de contato e um painel administrativo para gerenciar mensagens e produtos.

## ✨ Funcionalidades

- **Página Principal (Landing Page)**
  - Vitrine de serviços e depoimentos.
  - Exibição de produtos cadastrados no banco de dados em um carrossel.
  - Formulário de contato que salva as mensagens para o administrador.
  - Sistema de autenticação de usuários (Login/Logout) com saudação personalizada.

- **Painel Administrativo**
  - Acesso restrito para usuários com perfil de `admin`.
  - Visualização e exclusão de mensagens de contato.
  - Gerenciamento completo de produtos (CRUD - Criar, Ler, Atualizar, Deletar) com upload de imagens.

- **Sistema de Autenticação**
  - Página de login com verificação de credenciais.
  - Página de criação de conta com criptografia de senha.
  - Redirecionamento baseado no tipo de usuário (`user` ou `admin`) após o login.

## Estrutura dos Arquivos

O projeto está dividido nas seguintes pastas:

- **/Landingpage**: Contém os arquivos da página principal (vitrine) do site.
  - `index.php`: Estrutura principal da página, que exibe produtos e o formulário.
  - `style.css`: Folha de estilos da landing page.
  - `enviar_mensagem.php`: Script PHP que processa o formulário de contato e salva as informações no banco de dados.

- **/Administracao**: Contém os arquivos do painel de gerenciamento de mensagens.
  - `respostas.php` / `respostas.view.php`: Páginas que exibem as mensagens recebidas.
  - `excluir.php`: Script para remover uma mensagem.
  - `listar_produtos.php`: Página que exibe todos os produtos cadastrados.
  - `gerenciar_produto.php`: Formulário para cadastrar ou editar um produto.
  - `processa_produto.php`: Script que lida com a lógica de criar, editar e excluir produtos, incluindo o upload de imagens.
  - `Estilo_administração.css`: Folha de estilos do painel administrativo.

- **/login**: Contém os arquivos para o sistema de autenticação de usuários.
  - `login.php`: Página e lógica para o login de usuários.
  - `criar_conta.php`: Página e lógica para o registro de novos usuários.
  - `logout.php`: Script para encerrar a sessão do usuário.
  - `login.css`: Folha de estilos compartilhada para as páginas de login e registro.

- **/Data Base**: Contém o arquivo de script SQL para a criação da estrutura do banco de dados.
  - `bepet.sql`: Script para criar as tabelas `mensagem`, `login` e `produtos`.

## 🛠️ Tecnologias Utilizadas

O projeto foi construído utilizando as seguintes tecnologias:

  - **Backend**: PHP
  - **Frontend**: HTML5, CSS3
  - **Servidor Local**: XAMPP (Apache)
  - **Banco de Dados**: MySQL

## 🚀 Como Rodar o Projeto

Siga as instruções abaixo para configurar e executar o projeto em seu ambiente local.

### Pré-requisitos

- Git instalado.
- XAMPP instalado (ou outro ambiente com Apache, MySQL e PHP).

### 1. Clonar o Repositório

Abra o terminal ou Git Bash e clone o repositório para a pasta `htdocs` do seu XAMPP.

```bash
# Navegue até a pasta htdocs do XAMPP
cd c:/xampp/htdocs

# Clone o projeto
git clone https://github.com/Carlos-Andre-Rabelo/BePet.git ProjetoBePet
```

### 2. Configurar o Banco de Dados

1. Inicie os módulos **Apache** e **MySQL** no painel de controle do XAMPP.
2. Abra seu navegador e acesse o phpMyAdmin em `http://localhost/phpmyadmin`.
3. Crie um novo banco de dados chamado `bepet`. (Certifique-se de que a codificação seja `utf8mb4_general_ci` para melhor compatibilidade).
4. Selecione o banco `bepet` recém-criado e clique na aba **Importar**.
5. Clique em "Escolher arquivo" e selecione o arquivo `bepet.sql` localizado na pasta `/Data Base` dentro do projeto que você clonou.
6. Clique em **Executar** no final da página para criar as tabelas.

### 3. Acessar a Aplicação

- Para ver a landing page, acesse: `http://localhost/ProjetoBePet/Landingpage/index.php`
- Para acessar a página de login, acesse: `http://localhost/ProjetoBePet/login/login.php`
- Para acessar o painel de administração (após fazer login como admin), as páginas principais são:
  - `http://localhost/ProjetoBePet/Administracao/respostas.php` (Mensagens)
  - `http://localhost/ProjetoBePet/Administracao/listar_produtos.php` (Produtos)

## 🧑‍💻 Como Tornar um Usuário Administrador

Por padrão, todas as contas criadas pelo site são do tipo `user`. Para dar permissões de administrador a um usuário, você precisa alterar manualmente o tipo dele no banco de dados.

Siga estes passos:

1.  Acesse o **phpMyAdmin** em `http://localhost/phpmyadmin`.
2.  No menu à esquerda, clique no banco de dados `bepet`.
3.  Selecione a tabela `login`.
4.  Encontre o usuário que você deseja promover a administrador e clique em **Editar** na linha correspondente.
5.  Procure pela coluna `tipo_usuario`. O valor atual será `user`.
6.  Altere o valor do campo `tipo_usuario` para `admin`.
7.  Role até o final da página e clique no botão **Executar** para salvar a alteração.

Pronto! Na próxima vez que esse usuário fizer login, ele será redirecionado para o painel de administração e terá acesso às funcionalidades de administrador.
