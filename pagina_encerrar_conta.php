<?php
//Inicia uma sessão recebendo dados de outras páginas
session_start();

//se não houver sessão iniciada, o acesso a essa página não é liberado
if (!isset($_SESSION['usuario_cpf'])){
    header("Location: pagina_login.php?erro=acesso_invalido");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link href="styles/cadastro.css" rel="stylesheet">
<link href="styles/cor_mensagens.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Encerrar conta</title>
</head>

<body>
<div class="container">
    <!--Parte para imprimir mensagem em situações de caso de erro-->
    <?php 
    //desvio condicional que verifica se houve passagem de parâmetro pela URL (método get)
    //se houve, o switch-case exibe a mensagem referente ao parâmetro (erro ou aviso) que foi passado.
    if (isset($_GET['erro']))
    {
        switch ($_GET['erro'])
        {
            case 'senha_incorreta':
                echo '<p class="vermelho">Senha incorreta.</p>';
                break;
            case 'falha_apagar':
                echo '<p class="vermelho">Erro ao encerrar a conta.</p>';
                break;
        }
    }
    ?>
    <h3>Encerrar conta</h3>
    <p>Aqui você pode deletar a sua conta.</p><br>
    <h4>IMPORTANTE</h4>
    - O processo de exclusão da conta é <span class="vermelho">irreversível</span><br>
    - Todas as suas informações serão excluídas<br>
    - Configurações serão excluídas.<br><br><br>

    


    <form action="functions/encerrar_conta.php" method="POST">
        <p>
            <label for="senha">Insira sua senha para confirmar a exclusão:</label><br>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
        </p>

        <input type="submit" id="botaovermelho" value="Excluir conta permanentemente">
    </form>     
    <br><br>
    <a href="pagina_editar_perfil.php">Cancelar</a>
</div>
</body>
</html>
