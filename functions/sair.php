<?php
/*
arquivo: sair.php
função: encerrar a sessão do usuário e fazer logoff
data de modificação: 06/11/2025
*/

//inicia a sessão que está aberta no momento
session_start();

//remove todas as variáveis (informações) da sessão ativa
session_unset();

//encerra a sessão do usuário
session_destroy();

//redireciona para página principal com mensagem de sucesso
header("Location: ../pagina_principal.php?aviso=logoff_sucesso");
exit;
?>