<?php
/*
arquivo: encerrar_conta.php
função: apagar a conta do usuário em sessão, exigindo senha para confirmação
data de modificação: 19/03/2026
*/

//inicia a sessão do usuário logado, para pegar suas informações
session_start();

//inclui arquivo de conexão com servidor e funções para encontrar os dados do usuário
require_once "config.php";
require_once "busca.php";

//se houver uma sessão iniciada e essa página tiver sido acessada exclusivamente pelo método POST, executa
if (isset($_SESSION['usuario_cpf']) && $_SERVER['REQUEST_METHOD'] === "POST")
{
    //captura a senha informada para confirmar exclusão da conta
    $senha_informada = isset($_POST['senha']) ? trim($_POST['senha']) : "";

    //chama a função para encontrar o usuário logado no banco de dados e pegar suas informações em um array associativo
    $usuario = encontrar_usuario($conn, $_SESSION['usuario_cpf']);
    
    //compara a senha informada com o hash no banco, para confirmar a exclusão
    if (password_verify($senha_informada, $usuario['usuario_senhahash']))
    {

        //define a query de exclusão na qual excluirá o usuário que estiver em sessão (pelo cpf dele)
        $sql_deletar_conta = "DELETE FROM tbl_usuario WHERE usuario_cpf = ? ";

        //prepara a query
        $ponteiro = $conn->prepare($sql_deletar_conta);

        //vincula os valores na query
        $ponteiro->bind_param("s", $_SESSION['usuario_cpf']);

        //executa a query e verifica foi executada corretamente, se sim, remove variáveis de sessão e fecha a sessão, e redireciona
        if ($ponteiro->execute())
        {
            session_unset();
            session_destroy();
            header("Location: ../pagina_principal.php?aviso=conta_deletada");
            exit;
        }
        else
        {
            //caso contrário, retorna para a página de encerrar conta e apresenta erro
            header("Location: ../pagina_encerrar_conta.php?erro=falha_apagar");
            exit;
        }

    //Se a senha informada for incorreta, rediciona para a página anterior e não permite a deleção
    }
    else
    {
        header("Location: ../pagina_encerrar_conta.php?erro=senha_incorreta");
        exit;
    }

//se essa página tentar ser acessada sem houver sessão, ou por fora do form da página de deleção, não permite o acesso
}
else
{
    header("Location: ../pagina_principal.php?erro=acesso_invalido");
    exit;
}

//ao fim da execução de todo o script, se houver alguma conexão aberta, a mesma é fechada
if(isset($ponteiro)) $ponteiro->close();
if(isset($conn)) $conn->close();
?>
