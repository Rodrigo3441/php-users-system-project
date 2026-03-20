<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link href="styles/cadastro.css" rel="stylesheet">
<link href="styles/cor_mensagens.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar sessão</title>
</head>

<body>
<div class="container">
            <!--Parte para imprimir mensagem em situações de caso de erro-->
            <?php
            //desvio condicional que verifica se houve passagem de parâmetro pela URL (método get)
            //se houve, o switch-case exibe a mensagem referente ao parâmetro (erro ou aviso) que foi passado.
            if (isset($_GET['erro'])){
                switch ($_GET['erro']){
                    case 'credenciais_invalidas':
                        echo '<p class="vermelho">Usuário ou senha incorretos.</p>';
                        break;

                    case 'acesso_invalido':
                        echo '<p class="vermelho">Faça login para acessar essa página.</p>';
                        break;
                    case 'muitas_tentativas':
                        echo '<p class="vermelho">Número de tentativas excedidas, tente novamente mais tarde.</p>';
                }
            }
            //mesma explicação do anterior, porém esse é para mensagens de aviso
            if (isset($_GET['aviso'])){
                switch ($_GET['aviso']){
                    case 'senha_alterada':
                        echo '<p class="verde">Sua senha foi alterada com sucesso.</p>';
                        break;
                }
            }
            ?>
    <h3>Iniciar sessão</h3>
    <p id="msg">Insira seus dados para poder acessar a sua conta</p>

    <form action="functions/fazer_login.php" method="POST">
                    <p>
                        <label for="cpf">CPF:</label><br>
                        <input type="text" id="cpf" name="cpf" placeholder="Use somente números" maxlength="11" pattern="[0-9]{11}" required>
                    </p>
                    
                    <p>
                        <label for="senha">Senha:</label><br>
                        <input type="password" id="senha" name="senha" placeholder="use letras, números e símbolos" required>
                    </p>
            
                    <p>
                        <a href="pagina_esqueci_senha.php">Esqueceu sua senha?</a><br><br>
                        <a href="pagina_cadastro.php">Não tem cadastro?</a>
                    </p><br>
            
                    <input type="submit" value="Login">
            
            </form> 
            <br><br>
            <a href="pagina_principal.php">Voltar à página principal</a>
</div>
</body>
</html>
