<?php
    //inicia a sessao
    session_start();

    //limpa a sessao produtos
    unset($_SESSION["carrinho"]);

    //redireciona para o index.php
    header("Location: index.php");