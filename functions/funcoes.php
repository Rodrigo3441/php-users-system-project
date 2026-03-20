<?php
/*
arquivo: funcoes.php
função: centralizar funções de consulta de cpf no banco de dados

explicação de cada função

cpf_existe($conn, $cpf):
local de uso: página de cadastro
explicação: faz uma consulta no banco e retorna se houve resultado na pesquisa
do CPF informado no sistema, dizendo se o CPF já foi usado ou não

encontrar_usuario($conn, $cpf):
local de uso: página de login
explicação: Diferente da função anterior, essa faz a consulta e também seleciona
atributos na pesquisa, atributos esses que serão armazenados em um array associativo
e posteriormente retornados para serem usados na inicialização da sessão do usuário

data de modificação: 19/03/2026
*/

//CADASTRO - função para verificar se um cpf já está cadastrado no sistema
function cpf_existe($conn, $cpf)
{
    
//Faz uma consulta com o CPF inserido para saber se ele já foi utilizado
$sql_busca = "SELECT usuario_cpf FROM tbl_usuario WHERE usuario_cpf = ?";
$ponteiro = $conn->prepare($sql_busca);     //prepara a busca

//verifica se não houve falhas no preparo
if (!$ponteiro)
{
    error_log("Erro na preparação da query: " . $conn->error);
    return false;
}

$ponteiro->bind_param("s", $cpf);           //passa o CPF para a query de busca
$ponteiro->execute();                       //executa a busca

// verifica se a query foi executada corretamente
if (!$ponteiro->execute())
{
    error_log("Erro ao executar query: " . $conn->error);
    $ponteiro->close(); 
    return false;
}

$resultado_busca = $ponteiro->get_result(); //obtem os resultados da busca e armazena-os na variável

$ponteiro->close();                         //fecha a conexão para liberar recursos

//se houver pelo menos uma linha no resultado, o CPF já se encontra em uso
return $resultado_busca->num_rows > 0;
}



//LOGIN - função para retornar o usuario com base no cpf digitado
function encontrar_usuario($conn, $cpf)
{
    
//Faz uma consulta com o CPF inserido para saber se ele já foi utilizado
$sql_busca = "SELECT usuario_cpf, usuario_nome, usuario_senhahash, usuario_sexo, usuario_datanasc FROM tbl_usuario WHERE usuario_cpf = ?";
$ponteiro = $conn->prepare($sql_busca);     //prepara a busca

//verifica se não houve falhas no preparo
if (!$ponteiro)
{
    error_log("Erro na preparação da query: " . $conn->error);
    return false;
}

$ponteiro->bind_param("s", $cpf);           //passa o CPF para a query de busca
$ponteiro->execute();                       //executa a busca

// verifica se a query foi executada corretamente
if (!$ponteiro->execute())
{
    error_log("Erro ao executar query: " . $conn->error);
    $ponteiro->close(); 
    return null;
}

$resultado_busca = $ponteiro->get_result(); //obtem os resultados da busca e armazena-os na variável

$usuario = $resultado_busca->fetch_assoc();     //pega os dados do usuário e coloca eles em um array associativo
$ponteiro->close();                         //fecha a conexão para liberar recursos

//retorna uma espécie de 'struct' do usuario, com todos os seus dados cadastrados
return $usuario;
}

?>