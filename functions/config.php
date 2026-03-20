<?php
/*
arquivo: config.php
função: estabelecer uma conexão com o banco de dados para fazer a manipulação de informações
data de modificação: 19/03/2026
*/

//inicializa as quatro variáveis necessárias para estabelecer a conexão
$nomeservidor = "localhost";
$nomeusuario = "root";
$senha = "root";
$nomedb = "db_usuarios";

//cria a conexão com um novo objeto mysqli, passando ao final, o número da porta
$conn = new mysqli($nomeservidor, $nomeusuario, $senha, $nomedb, 3306);

//se a conexão resultar em algum erro, retorna para a página principal e apresenta erro de conexão

if ($conn->connect_errno)
{
    error_log("Erro de conexão: " . $conn->connect_error);
    header("Location: ../pagina_principal.php?erro=falha_servidor");
    exit;
} 

//define o banco de dados com padrão utf8, para poder garantir compatibilidade com acentos nos conteúdos
$conn->set_charset("utf8mb4");
?>