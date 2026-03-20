# Funções PHP do projeto

Aqui você pode conferir alguns detalhes quanto ao uso e funcionalidade de cada um dos arquivos de funções do projeto




| Nome do Arquivo | Ação | Descrição | Fluxo |
|-----------------|------|-----------|-------|
| config.php | Conectar com Banco de Dados | Esse arquivo recebe as credenciais de acesso do banco de dados e estabelece uma conexão criando um objeto Mysqli | recebe nome do servidor, nome do usuario, senha e nome do banco de dados -> cria um objeto mysqli -> estabelece a conexão
| fazer_cadastro.php | Cadastro de Usuário | Esse arquivo recebe as informações do usuário, valida elas e o registra no sistema | Verifica se o método de requisição da página é válido -> recebe as informações do usuário e trata elas -> faz validações referentes aos dados -> cria um hash da senha -> define a query -> prepara a query -> executa a query para registrar o usuário
| fazer_login.php | Iniciar sessão do usuário | Esse arquivo recebe CPF e senha do usuário para iniciar sessão no sistema | Verifica se o método de requisição da página é válido -> Recebe CPF e senha do usuário -> Valida os dados -> Busca se o usuário está cadastrado no sistema -> Verifica se a senha está correta -> Inicia sessão do usuário|
| mudar_senha.php | Atualizar senha do usuário | Esse arquivo é responsável por atualizar a senha do usuário caso ele tenha esquecido ela | Verifica se o método de requisição da página é válido -> Recebe o CPF e a nova senha do usuário -> Valida as informações -> Verifica se o usuário está cadastrado no sistema -> Verifica se a senha não é igual a anterior -> Executa a operação e altera a senha |
| sair.php | Encerrar sessão | Esse arquivo é responsável por encerrar a sessão do usuário | Redefine todas as variáveis de sessão -> encerra a sessão do usuário |
| editar_perfil.php | Atualizar informações | Esse arquivo é responsável por atualizar informações do usuário, como nome, sexo e data de nascimento | Verifica se o método de requisição é válido -> Recebe as novas informações do usuário -> Valida as informações -> Cria um novo hash da senha -> Define a query para atualização das informações -> Prepara a query -> Vincula os dados à query -> Executa a operação e atualiza as informações do usuário
| encerrar_conta.php | Apaga a conta do usuário | Essa página é responsável por apagar permanentemente a conta de um usuário do sistema | Verifica se o método de requisição é válido -> Recebe a senha do usuário para confirmação da deleção -> Busca se o usuário está cadastrado no sistema -> Verifica se a senha informada está correta -> Define a query para deleção -> Prepara a query -> Vincula os valores à query -> Executa a operação e deleta a conta do usuário do sistema


## Arquivo busca.php

Esse arquivo será detalhado separadamente pois ele possui duas funções diferentes em sua programação que merecem um destaque e uma explicação melhor, ambas sendo relacionadas à consulta no banco de dados

| Função | Tipo | Entrada | Saída | Descrição | Fluxo |
|--------|------|---------|-------|-----------|-------|
|cpf_existe| Consulta | $conn, $cpf | Boolean | Essa função realiza uma consulta para saber se um CPF já está cadastrado no sistema, impedindo duplicidade das informações | Define a query de consulta -> Prepara a query -> Verifica se não houve falhas no preparo -> Vincula os valores à query -> Executa a query -> Obtem os resultados -> Libera recursos da query -> Verifica número de linhas -> Retorna true/false | 
|encontrar_usuario| Consulta e retorno de dados | $conn, $cpf | Associative Array | Essa função realiza a busca e retorno de informações. O arquivo irá consultar o CPF do usuário e retornar um array associativo com todas as informações necessárias para uso ao longo da sessão | Define a query de consulta -> Prepara a query -> Verifica se não houve falhas no preparo -> Vincula os valores à query -> Executa a query -> Obtem os resultados -> Converte para um array associativo -> Libera recursos da query -> Retorna as informações do usuário |
