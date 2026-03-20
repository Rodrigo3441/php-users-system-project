<?php
/*
arquivo: fazer_cadastro.php
função: cadastrar um novo usuário no sistema, validando seus dados e fazendo hash de senha
data de modificação: 19/03/2026
*/

//inclui arquivo de conexão com servidor e funções para encontrar os dados do usuário
require_once "config.php";
require_once "busca.php";

//Valida se o arquivo foi acessado exclusivamente pelo formulário
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    //captura os dados informados pelo usuário
    $cpf = isset($_POST["cpf"]) ? trim($_POST["cpf"]) : "";
    $usuario = isset($_POST["usuario"]) ? trim($_POST["usuario"]) : "";
    $senha = isset($_POST["senha"]) ? trim($_POST["senha"]) : "";
    $sexo = isset($_POST["sexo"]) ? trim($_POST["sexo"]) : "";
    $datanasc = isset($_POST["datanasc"]) ? trim($_POST["datanasc"]) : "";

    //se alguns dos dados forem enviados vazios, envia via get o erro de campos vazios
    if (empty($cpf) || empty($usuario) || empty($senha) || empty($sexo) || empty($datanasc))
    {
        header("Location: ../pagina_cadastro.php?erro=campos_vazios");
        exit;
    }

    //verifica se o nome de usuário possui algum caractere diferente de Letras Maiúsculas, Minúsculas e acentuadas.
    if (!preg_match("/^[a-zA-ZÀ-ÿ ]+$/", $usuario))
    {
        header("Location: ../pagina_cadastro.php?erro=nome_invalido");
        exit;
    }

    //verifica se o cpf tem somente números
    if (!preg_match("/^[0-9]+$/", $cpf) || strlen($cpf) !== 11)
    {
        header("Location: ../pagina_cadastro.php?erro=cpf_invalido");
        exit;
    }

    //função pra verificar se o CPF já está cadastrado no sistema
    if (cpf_existe($conn, $cpf))
    {
        //redireciona para a página formulário.php e envia um parâmetro de erro via método GET (?erro...)
        header("Location: ../pagina_cadastro.php?erro=cpf_ja_cadastrado");
        exit;
    }

    //verifica se a senha desejada possui entre 4 e 50 caracteres
    if (strlen($senha) < 4 || strlen($senha) > 50) {
        header("Location: ../pagina_cadastro.php?erro=senha_invalida");
        exit;
    }
    
    //Verifica se o nome de usuário tem mais de 20 caracteres
    if (strlen($usuario) > 20)
    {
        header("Location: ../pagina_cadastro.php?erro=nome_muito_grande");
        exit;
    }

    //cria um hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    //define a instrução de inserção em SQL e armazena ela
    $sql_cadastrar_conta = "INSERT INTO tbl_usuario (usuario_cpf, usuario_nome, usuario_senhahash, usuario_sexo, usuario_datanasc) VALUES (?, ?, ?, ?, ?)";

    //envia um status de preparação da query/comando em SQL para o servidor
    $ponteiro = $conn->prepare($sql_cadastrar_conta);
    if (!$ponteiro) 
    {
    error_log("Erro na preparação: " . $conn->error);
    header("Location: ../pagina_cadastro.php?erro=erro_generico");
    exit;
    }

   //Vincula os valores à query para que eles sejam devidamente inseridos via Insert
   $ponteiro->bind_param("sssss", $cpf, $usuario, $senha_hash, $sexo, $datanasc);

   //executa a instrução para cadastrar o usuário e já verifica via desvio condicional se houve êxito ou não
   if ($ponteiro->execute())
   {
    header("Location: ../pagina_principal.php?aviso=cadastro_realizado");
    exit;
   }
   else
   {
    header("Location: ../pagina_cadastro.php?erro=erro_generico");
    exit;
   }

}
else
{
    //redireciona para a página principal se o acesso for de fora do formulário
    header("Location: ../pagina_principal.php?erro=acesso_invalido");
    exit;
}

//ao fim da execução de todo o script, se houver alguma conexão aberta, a mesma é fechada
if(isset($ponteiro)) $ponteiro->close();
if(isset($conn)) $conn->close();
?>