# Aplicação de Pequeno Mercado - Frontend em React com TypeScript e Backend em PHP puro com Banco PostgreSQL

Esta é uma aplicação de exemplo de um pequeno mercado, desenvolvida como parte de um processo seletivo da empresa Workana. O objetivo da aplicação é simular um sistema de gerenciamento de estoque, vendas e tipos de produtos. O frontend é desenvolvido em React com TypeScript e criado usando o Vite, enquanto o backend é desenvolvido em PHP puro. O banco de dados utilizado é o PostgreSQL. A aplicação é configurada para ser executada usando o Docker Compose, o que permite executar o frontend, o backend e o banco de dados simultaneamente.

## Pré-requisitos

- Docker
- Docker Compose

Certifique-se de ter o Docker e o Docker Compose instalados em sua máquina antes de prosseguir com as etapas de instalação.

## Instalação

Siga as etapas abaixo para configurar e executar a aplicação:

1. Clone este repositório para o seu ambiente local.

2. Acesse a pasta raiz do projeto.

3. Abra o arquivo `docker-compose.yml` e verifique as configurações do serviço do banco de dados PostgreSQL. Certifique-se de que as credenciais (usuário, senha e nome do banco de dados) estejam corretas. Você pode alterar essas configurações conforme necessário.

4. Abra o terminal e execute o comando `docker-compose up` para iniciar os serviços do frontend, backend e banco de dados.

5. Aguarde até que todos os contêineres sejam inicializados corretamente. Você verá os logs do Docker no terminal.

6. Após a inicialização bem-sucedida, acesse o aplicativo frontend em `http://localhost:3000` em seu navegador.

## Estrutura do Projeto

O projeto está organizado da seguinte maneira:

- `frontend/` - Pasta contendo o código-fonte do aplicativo frontend em React com TypeScript.
- `backend/` - Pasta contendo o código-fonte do aplicativo backend em PHP.
- `docker-compose.yml` - Arquivo de configuração do Docker Compose para executar os serviços do frontend, backend e banco de dados.

## Desenvolvimento

Durante o desenvolvimento, você pode editar o código-fonte tanto do frontend quanto do backend.

- O código-fonte do frontend está localizado na pasta `frontend/src`.
- O código-fonte do backend está localizado na pasta `backend`.

## Testes Unitários

Foram criados testes unitários tanto para o frontend quanto para o backend da aplicação. Os testes garantem a qualidade e a integridade do código.

- Os testes unitários do frontend estão localizados na pasta `frontend/tests`.
- Os testes unitários do backend estão localizados na pasta `backend/tests`.

Você pode executar os testes unitários usando as ferramentas de teste específicas do frontend e do backend (PHPUNIT/JEST).

## Configuração do Banco de Dados

O banco de dados PostgreSQL é configurado automaticamente pelo Docker Compose com as credenciais fornecidas no arquivo `docker-compose.yml`. O banco de dados é acessível dentro do contêiner usando o host `db` e a porta `5432`.

No código do backend PHP, você pode configurar a conexão com o banco de dados usando as credenciais fornecidas no arquivo `docker-compose.yml`.

## Personalização

Você pode personalizar o aplicativo frontend e o aplicativo backend de acordo com suas necessidades. Edite o código-fonte nas respectivas pastas (`frontend/src` e `backend`) para adicionar suas funcionalidades, componentes e lógica de negócios.

## Considerações Finais

Esta é apenas uma aplicação de exemplo de um pequeno mercado desenvolvida para participar de um processo seletivo. Sinta-se à vontade para explorar e expandir este projeto de acordo com suas necessidades específicas.

Lembre-se de consultar a documentação oficial do React, TypeScript, Vite, PHP e PostgreSQL para obter informações detalhadas sobre como desenvolver e configurar cada um desses componentes.

Divirta-se codificando e boa sorte em seu processo seletivo!
