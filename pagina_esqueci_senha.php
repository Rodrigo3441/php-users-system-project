<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="styles/cor_mensagens.css" rel="stylesheet">
<link href="styles/cadastro.css" rel="stylesheet">
<title>Redefinir senha</title>
</head>
<body>
<div class="container">
    <?php 
    //desvio condicional que verifica se houve passagem de parâmetro pela URL (método get)
    //se houve, o switch-case exibe a mensagem referente ao parâmetro (erro ou aviso) que foi passado.
    if (isset($_GET['erro']))
    {
        switch ($_GET['erro'])
        {
            case 'campos_vazios':
                echo '<p class="vermelho">Os campos não podem ser enviados vazios.</p>';
                break;
            case 'senha_ja_usada':
                echo '<p class="vermelho">A nova senha deve ser diferente da cadastrada.</p>';
                break;
            case 'falha_ao_alterar_senha':
                echo '<p class="vermelho">Ocorreu um erro inesperado.</p>';
                break;
            case 'senha_invalida':
                echo '<p class="vermelho">Utilize entre 4 e 50 caracteres para a senha.</p>';
                break;
            case 'acesso_invalido':
                echo '<p class="vermelho">Acesso inválido.</p>';
                break;
        }
    }
    ?>

    <h3>Redefinir senha</h3>

    <form action="functions/mudar_senha.php" method="POST">
        <p>Se você esqueceu sua senha, você pode redefini-lá nesta página.</p>
        <p>
            <label for="cpf">Digite seu CPF:</label><br>
            <input type="text" id="cpf" name="cpf" placeholder="CPF"  minlength="11" maxlength="11" pattern="[0-9]{11}" required>
        </p>
        
        <p>
            <label for="senha">Digite a nova senha:</label><br>
            <input type="password" id="senha" name="senha" placeholder="Use letras, números e símbolos" minlength="4" maxlength="50" required>
        </p>

        <p>
            <a href="pagina_cadastro.php">Não tem cadastro?</a><br><br>
            <a href="pagina_login.php">Já cadastrado? Faça login</a>
        </p>

        <input type="submit" value="Redefinir senha">
    </form>     
</div>
</body>
</html>
