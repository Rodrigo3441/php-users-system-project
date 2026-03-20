<?php
/*
arquivo: editar_perfil.php
função: fazer atualização das informações do usuário
data de modificação: 07/11/2025
*/

//inicia a sessão com as informações do usuário
session_start();

//inclui arquivo de conexão com servidor
require_once "config.php";

//se houver uma sessão iniciada o código é executado
if (isset($_SESSION['usuario_cpf']))
{
    //recebe as novas informações do usuário
    $novo_nome = isset($_POST['usuario']) ? trim($_POST['usuario']) : "";
    $nova_senha = isset($_POST['senha']) ? trim($_POST['senha']) : "";
    $novo_sexo = isset($_POST['sexo']) ? trim($_POST['sexo']) : "";
    $nova_datanasc = isset($_POST['datanasc']) ? trim($_POST['datanasc']) : "";

    //se alguns dos dados forem enviados vazios, envia via get o erro de campos vazios
    if (empty($novo_nome) || empty($nova_senha) || empty($novo_sexo) || empty($nova_datanasc))
    {
        header("Location: ../pagina_editar_perfil.php?erro=campos_vazios");
        exit;
    }

    //verifica se o nome de usuário possui algum caractere diferente de Letras Maiúsculas, Minúsculas e acentuadas.
    if (!preg_match("/^[a-zA-ZÀ-ÿ ]+$/", $novo_nome))
    {
        header("Location: ../pagina_editar_perfil.php?erro=nome_invalido");
        exit;
    }

    //verifica se a senha desejada possui entre 4 e 50 caracteres
    if (strlen($nova_senha) < 4 || strlen($nova_senha) > 50) {
        header("Location: ../pagina_editar_perfil.php?erro=senha_invalida");
        exit;
    }
    
    //Verifica se o nome de usuário tem mais de 20 caracteres
    if (strlen($novo_nome) > 20)
    {
        header("Location: ../pagina_editar_perfil.php?erro=nome_muito_grande");
        exit;
    }

    //cria um hash da nova senha (mesmo que tenha sido mantida a mesma senha)
    $hash_nova_senha = password_hash($nova_senha, PASSWORD_DEFAULT);

    //define a instrução de atualização do usuário, recebendo as novas informações posteriormente
    $sql_atualizar_conta = "UPDATE tbl_usuario SET usuario_nome = ?, usuario_senhahash = ?, usuario_sexo = ?, usuario_datanasc = ? WHERE usuario_cpf = ?";

    //instrução é preparada
    $ponteiro = $conn->prepare($sql_atualizar_conta);

    //vinculação dos valores via bind_param para evitar sql injection
    $ponteiro->bind_param("sssss", $novo_nome, $hash_nova_senha, $novo_sexo, $nova_datanasc, $_SESSION['usuario_cpf']);

    //se a execução da query terminar em êxito, atualiza as informações de sessão do usuário e redireciona com um aviso de sucesso
    if ($ponteiro->execute())
    {
        $_SESSION['usuario_nome'] = $novo_nome;
        $_SESSION['usuario_sexo'] = $novo_sexo;
        $_SESSION['usuario_datanasc'] = $nova_datanasc;
        header("Location: ../pagina_editar_perfil.php?aviso=conta_atualizada");
        exit;
    //caso a query não seja executada, redireciona e apresenta erro
    } 
    else
    {
        header("Location: ../pagina_editar_perfil.php?erro=falha_ao_atualizar");
        exit;
    }
//redireciona para a página de login caso não haja uma sessão iniciada
}
else
{
    header("Location: ../pagina_login.php?erro=acesso_invalido");
    exit;
}

//ao fim da execução de todo o script, se houver alguma conexão aberta, a mesma é fechada
if(isset($ponteiro)) $ponteiro->close();
if(isset($conn)) $conn->close();
?>
