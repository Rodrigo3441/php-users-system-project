<?php
//Inicia uma sessão recebendo dados de outras páginas
session_start();
$_SESSION['tentativas_login'] = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="styles/cor_mensagens.css" rel="stylesheet">
    <link href="styles/main.css" rel="stylesheet">
    <title>NewStar Systems</title>
</head>
<body>

<header class="header">
    <nav class="navbar">
        <a href="#">Cadastro</a>
        <a href="#quem-somos">Quem somos?</a>
        <a href="#contato">Contato</a>
    </nav>

    <form action="https://google.com/search" class="search-bar" method="GET">
        <input type="text" name="q" placeholder="Pesquisar..">
        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>

    <div class="perfil" style="display: flex; width: 25%">
        <div style="flex-basis: 40%">
        <?php
        //se sessão estiver iniciada, exibe informações do usuário
        if (isset($_SESSION['usuario_cpf']))
        {
            echo 'Olá <span style="color: #ffff00;">' . htmlspecialchars($_SESSION['usuario_nome'], ENT_QUOTES, 'UTF-8') . '</span> !<br>';
        } 
        //caso contrário, exibe opção para fazer cadastro
        else 
        {
            echo '<a href="pagina_cadastro.php">Fazer cadastro</a>';
        }
        ?>
        </div>
        <div style="flex-basis: 60%">
        <?php
        //se sessão estiver iniciada, exibe opções para usuário editar perfil e sair
        if (isset($_SESSION['usuario_cpf']))
        {
            echo '<a href="pagina_editar_perfil.php">Editar Perfil</a> | <a href="functions/sair.php">Sair</a>';
        }
        //se não houver sessão, exibe a opção para iniciar a sessão
        else
        {
            echo '<a href="pagina_login.php">Iniciar sessão</a>';
        }
        ?> 
        </div>
    </div>
    
</header>

<!-- Área de cadastro/login -->
<div class="cadastro">
            
    <div class="quadrado">
            <?php
            //desvio condicional que verifica se houve passagem de parâmetro pela URL (método get)
            //se houve, o switch-case exibe a mensagem referente ao parâmetro (erro ou aviso) que foi passado.
            if (isset($_GET['aviso']))
            {
                switch ($_GET['aviso'])
                {
                    case 'cadastro_realizado':
                        echo '<p class="verde">Sucesso ao cadastrar! acesse sua conta agora.</p>';
                        break;
                    case 'logoff_sucesso':
                        echo '<p class="verde">Você saiu da sua conta com sucesso.</p>';
                        break;
                    case 'conta_deletada':
                        echo '<p class="verde">Conta encerrada com sucesso.</p>';
                        break;
                }
            }
            //mesma explicação do anterior, porém esse é para mensagens de erro
            if (isset($_GET['erro']))
            {
                switch ($_GET['erro'])
                {
                    case 'acesso_invalido':
                        echo '<p class="vermelho">Erro ao acessar a página.</p>';
                        break;
                }
            }
            ?>
        <h2 class="logo"><i class="fa-solid fa-star-half-stroke"></i> NewStar Systens</h2>
        <div class="intro">
            <h2>Bem vindo(a)!<br> Seu universo tecnológico começa aqui.</h2> 
            <p>Conectando você ao futuro!</p>
            <div class="social-icons">
                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-github"></i></a> 
            </div>
        </div>
    </div>

</div>

<!-- Seções extras -->
<div id="quem-somos" class="secao-preta"><br><br> 
    <h2>Quem Somos?</h2>
    <p>A NewStar Systens nasceu da paixão por inovação e tecnologia. Fundada por um grupo de entusiastas que acreditam que 
        produtos tecnológicos de qualidade podem transformar a vida das pessoas, nossa missão é levar soluções modernas, 
        eficientes e acessíveis para todos. Desde gadgets do dia a dia até equipamentos de ponta, queremos que cada cliente sinta a experiência de estar à frente do futuro.</p>
<div id="contato" class="secao-preta">
    <h2>Contato</h2>
    <form>
      <input type="text" placeholder="Seu nome" required>
      <input type="email" placeholder="Seu e-mail" required>
      <textarea rows="5" placeholder="Sua mensagem"></textarea>
      <button type="submit">Enviar</button><br> 
    </form>
</div>

<footer class="rodape">
<hr>
© 2026 NewStar Systens LTDA. Todos os direitos reservados
</footer>
</body>
</html>
