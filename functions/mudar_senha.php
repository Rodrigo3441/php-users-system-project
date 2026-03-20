<?php
/*
arquivo: mudar_senha.php
função: realizar a atualização de senha caso o usuário tenha esquecido sua senha
data de modificação: 19/03/2026
*/

//inclui arquivo de conexão com servidor e funções para encontrar os dados do usuário
require_once "config.php";
require_once "funcoes.php";

//se o método de requisição dessa página for POST, o código será executado
if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    //recebe variáveis do formulário de esqueci a senha
    $cpf = isset($_POST["cpf"]) ? trim($_POST["cpf"]) : "";
    $senha_nova = isset($_POST["senha"]) ? trim($_POST["senha"]) : "";

    //valida se os campos não foram enviados vazioz
    if (empty($cpf) || empty($senha_nova))
    {
        header("Location: ../pagina_esqueci_senha.php?erro=campos_vazios");
        exit;
    }

       //verifica se a senha desejada possui entre 4 e 50 caracteres
       if (strlen($senha) < 4 || strlen($senha) > 50) {
        header("Location: ../pagina_cadastro.php?erro=senha_invalida");
        exit;
    }

    //chama a função para fazer a busca do usuário e armazenar os dados dele na variável
    $usuario = encontrar_usuario($conn, $cpf);

    //se tiver havido retorno para usuário (usuário foi encontrado no sistema), executará o bloco de código
    if ($usuario)
    {
        //se a senha informada for igual a senha cadastrada, não permite a mudança
        if (password_verify($senha_nova, $usuario['usuario_senhahash']))
        {
            header("Location: ../pagina_esqueci_senha.php?erro=senha_ja_usada");
            exit;
        } 
        //se a senha informada for diferente da cadastrada, permite a mudança
        else 
        {
            //cria o hash da nova senha
            $senha_nova_hash = password_hash($senha_nova, PASSWORD_DEFAULT);

            //define a query para execução da atualização da senha no registro do usuário
            $sql_atualizar_senha = "UPDATE tbl_usuario SET usuario_senhahash = ? WHERE usuario_cpf = ?";

            //prepara a query para sua execução
            $ponteiro = $conn->prepare($sql_atualizar_senha);

            //vincula a nova senha hash e o cpf para a query
            $ponteiro->bind_param("ss", $senha_nova_hash, $cpf);

            //executa a query e já verifica via desvio condicional se houve êxito ou não
            if ($ponteiro->execute())
            {
                //em caso de êxito, redireciona para a página de login exibindo mensagem de sucesso ao usuário
                header("Location: ../pagina_login.php?aviso=senha_alterada");
                exit;
            }
            else
            {
                //se não houver êxito, retorna a página "esqueci minha senha" e apresenta erro ao usuário
                header("Location: ../pagina_esqueci_senha.php?erro=falha_ao_alterar_senha");
                exit;
            }
        }
    } 
    //caso o usuário não tenha tido retorno (cpf informado não está cadastrado), redireciona e retorna o erro
    else 
    {
        header("Location: ../pagina_esqueci_senha.php?erro=falha_ao_alterar_senha");
        exit;
    }

//redireciona para a página principal se o acesso for de fora do formulário
} 
else 
{
    header("Location: ../pagina_esqueci_senha.php?erro=acesso_invalido");
    exit;
}

//ao fim da execução de todo o script, se houver alguma conexão aberta, a mesma é fechada
if(isset($ponteiro)) $ponteiro->close();
if(isset($conn)) $conn->close();
?>