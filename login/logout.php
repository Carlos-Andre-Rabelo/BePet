<?php
// Inicia a sessão
session_start();

// Remove todas as variáveis da sessão
$_SESSION = array();

// Destrói a sessão
session_destroy();

// Redireciona para a página de login
header("Location: ../Landingpage/index.php");
// Garante que o script pare de ser executado após o redirecionamento
exit();