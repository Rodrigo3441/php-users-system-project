<?php
session_start();

if (!isset($_SESSION['usuario_cpf'])){
    header("Location: pagina_login.php?erro=acesso_invalido");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link href="styles/cadastro.css" rel="stylesheet">
<link href="styles/cor_mensagens.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Atualizar informações</title>
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
            case 'erro_generico':
                echo '<p class="vermelho">Ocorreu um erro ao cadastrar. Tente novamente.</p>';
                break;
            case 'nome_invalido':
                echo '<p class="vermelho">Utilize somente letras para o nome de usuário.</p>';
                break;
            case 'nome_muito_grande':
                echo '<p class="vermelho">O nome de usuário deve conter até 20 caracteres.</p>';
                break;
            case 'senha_invalida':
                echo '<p class="vermelho">Utilize entre 4 e 50 caracteres para a senha.</p>';
                break;
            case 'falha_ao_atualizar':
                echo '<p class="vermelho">Ocorreu um erro ao tentar atualizar a conta.</p>';
                break;
        }
    }
     //mesma explicação do anterior, porém esse é para mensagens de aviso
    if (isset($_GET['aviso']))
    {
        switch ($_GET['aviso'])
        {
            case 'conta_atualizada':
                echo '<p class="verde">Conta atualizada com sucesso.</p>';
                break;
        }
    }
    ?>
    <h3>Atualizar informações</h3>
    <p id="msg">Atualize as informações que você desejar e insira sua senha para confirmar a atualização de perfil.</p>

    <form action="functions/editar_perfil.php" method="POST">
        <p>
            <label for="usuario">Nome de usuário:</label><br>
            <input type="text" id="usuario" name="usuario" placeholder="use somente letras" minlength="3" maxlength="20" value="<?php  echo htmlspecialchars($_SESSION['usuario_nome'], ENT_QUOTES, 'UTF-8'); ?>" required>
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
                            <option disabled value="">...</option>
                            <option value="M" <?php if ($_SESSION['usuario_sexo'] === 'M') echo 'selected' ?>>Masculino</option>
                            <option value="F" <?php if ($_SESSION['usuario_sexo'] === 'F') echo 'selected' ?>>Feminino</option>
                            <option value="O" <?php if ($_SESSION['usuario_sexo'] === 'O') echo 'selected' ?>>Outros</option>
                        </select>
                    </p>
                </td>
                <td>
                    <p>
                    <label for="datanasc">Data de nascimento</label><br>
                    <input type="date" id="datanasc" name="datanasc" value="<?php echo htmlspecialchars($_SESSION['usuario_datanasc'], ENT_QUOTES, 'UTF-8'); ?>" required>
                   </p>
                </td>
            </tr>
        </table>

        <input type="submit" value="Registrar alterações">
    </form>     
    <br><br>
    <a href="pagina_principal.php">Cancelar</a> |    <a href="pagina_encerrar_conta.php" class="vermelho">Encerrar conta</a>
</div>
</body>
</html>
