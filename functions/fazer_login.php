<?php
/*
arquivo: fazer_login.php
função: receber credenciais do usuário e iniciar a sessão dele no sistema
data de modificação: 06/11/2025
*/
session_start();

//inclui arquivo de conexão com servidor e funções para encontrar os dados do usuário
require_once "config.php";
require_once "funcoes.php";

// define variável de tentativas de login
if (!isset($_SESSION['tentativas_login']))
{
    $_SESSION['tentativas_login'] = 0;
}

//bloqueia o acesso em caso de excesso
if ($_SESSION['tentativas_login'] >= 5)
{
    header("Location: ../pagina_login.php?erro=muitas_tentativas");
    exit;
}

//se o método de requisição dessa página for POST, o código será executado
if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    //recebe as credenciais de cpf e senha do usuário
    $cpf = isset($_POST["cpf"]) ? trim($_POST["cpf"]) : "";
    $senha_informada = isset($_POST["senha"]) ? trim($_POST["senha"]) : "";

    //se alguns dos dados forem enviados vazios, envia via get o erro de campos vazios
    if (empty($cpf) || empty($senha_informada))
    {
        header("Location: ../pagina_login.php?erro=campos_vazios");
        exit;
    }

    //chama a função para fazer a busca do usuário e armazenar os dados dele na variável
    $usuario = encontrar_usuario($conn, $cpf);

    //se tiver havido retorno para usuário (usuário foi encontrado no sistema), executará o bloco de código
    if ($usuario)
    {
        //se a senha informada corresponder com o hash salvo no banco, executa o bloco 
        if (password_verify($senha_informada, $usuario['usuario_senhahash']))
        {
            //gera um novo id de sessão e zera as tentativas de login
            session_regenerate_id(true); 
            $_SESSION['tentativas_login'] = 0;

            //cria duas variáveis de sessão, que ficam disponíveis na sessão iniciada do usuário
            $_SESSION['usuario_nome'] = $usuario['usuario_nome'];
            $_SESSION['usuario_cpf'] = $usuario['usuario_cpf'];
            $_SESSION['usuario_sexo'] = $usuario['usuario_sexo'];
            $_SESSION['usuario_datanasc'] = $usuario['usuario_datanasc'];

            //redireciona para a página principal
            header("Location: ../pagina_principal.php");
            exit;

        //caso a senha seja incorreta, redireciona para a página de login e informa o erro
        } 
        else 
        {
            $_SESSION['tentativas_login']++;
            header("Location: ../pagina_login.php?erro=credenciais_invalidas");
            exit;
        }
    //caso o usuário não tenha tido retorno (cpf informado não está cadastrado), redireciona e retorna o erro
    }
    else 
    {
        $_SESSION['tentativas_login']++;
        header("Location: ../pagina_login.php?erro=credenciais_invalidas");
        exit;
    }


//redireciona para a página principal se o acesso for de fora do formulário
}
else
{
    header("Location: ../pagina_login.php?erro=acesso_invalido");
    exit;
}

//ao fim da execução de todo o script fecha a conexão com o banco de dados
if(isset($conn)) $conn->close();
?>