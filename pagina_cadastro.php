<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link href="styles/cadastro.css" rel="stylesheet">
<link href="styles/cor_mensagens.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fazer Cadastro</title>
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
            case 'campos_vazios':
                echo '<p class="vermelho">Os campos não podem ser enviados vazios</p>';
                break;
            case 'cpf_ja_cadastrado':
                echo '<p class="vermelho">O CPF inserido já foi utilizado, tente outro.</p>';
                break;
            case 'erro_generico':
                echo '<p class="vermelho">Ocorreu um erro ao cadastrar. Tente novamente.</p>';
                break;
            case 'nome_invalido':
                echo '<p class="vermelho">Utilize somente letras para o nome de usuário.</p>';
                break;
            case 'senha_invalida':
                echo '<p class="vermelho">Utilize entre 4 e 50 caracteres para a senha.</p>';
                break;
            case 'cpf_invalido':
                echo '<p class="vermelho">Utilize somente números para o CPF e exatamente 11 digitos.</p>';
                break;
            case 'nome_muito_grande':
                echo '<p class="vermelho">O nome de usuário deve conter até 20 caracteres.</p>';
                break;
        }
    }
    ?>
    <h3>Fazer cadastro</h3>
    <p id="msg">Insira seus dados para poder criar a sua conta</p>

    <form action="functions/fazer_cadastro.php" method="POST">
        <p>
            <label for="usuario">Nome de usuário:</label><br>
            <input type="text" id="usuario" name="usuario" placeholder="use somente letras" minlength="3" maxlength="20" required>
        </p>
        
        <p>
            <label for="cpf">CPF:</label><br>
            <input type="text" id="cpf" name="cpf" placeholder="use apenas números" minlength="11" maxlength="11" pattern="[0-9]{11}" required>
        </p>

        <p>
            <label for="senha">Senha:</label><br>
            <input type="password" id="senha" name="senha" placeholder="use letras, números e símbolos" minlength="4" maxlength="50" required>
        </p>

        <table>
            <tr>
                <td>
                    <p>
                        <label for="sexo">Sexo:</label><br>
                        <select id="sexo" name="sexo" required>
                            <option disabled selected value="">...</option>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                            <option value="O">Outros</option>
                        </select>
                    </p>
                </td>
                <td>
                    <p>
                    <label for="datanasc">Data de nascimento</label><br>
                    <input type="date" id="datanasc" name="datanasc" required>
                   </p>
                </td>
            </tr>
        </table>
       

        <p>
            <a href="pagina_esqueci_senha.php">Esqueceu a senha?</a> | 
            <a href="pagina_login.php">Faça login</a>
        </p>
        

        <input type="submit" value="Criar conta">
    </form>     
    <br><br>
    <a href="pagina_principal.php">Voltar à página principal</a>
</div>
</body>
</html>
