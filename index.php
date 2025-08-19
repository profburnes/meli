<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - MeLi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

</head>
<body>
    <?php
         if ($_POST) {
            $nome = trim($_POST["nome"] ?? NULL);
            $valor = trim($_POST["valor"] ?? NULL);
            $qtde = trim($_POST["qtde"] ?? NULL);
            $id = trim($_POST["id"] ?? NULL);

            $_SESSION["carrinho"][$id] = array("id" => $id,
                "nome" => $nome,
                "qtde" => $qtde,
                "valor" => $valor,
                "imagem" => "teste" );
        }
    ?>
    <div class="container">
        <h1 class="text-center">
            <a href="index.php" title="MeLi">
                <img src="images/mercado-pago-logo.png" alt="Mercado Pago" width="300px">
            </a>
        </h1>
        <hr>
        <div class="card">
            <div class="card-body">
                <h2>Adicione um Produto:</h2>
                <form name="formProdutos" method="post">
                    <label for="id">ID do Produto</label>
                    <input type="number" name="id" id="id" class="form-control" required>
                    <label for="nome">Nome do Produto</label>
                    <input type="text" name="nome" id="nome" class="form-control" required>
                    <label for="qtde">Qtde do Produto</label>
                    <input type="number" name="qtde" id="qtde" class="form-control" required>
                    <label for="valor">Valor do Produto</label>
                    <input type="text" name="valor" id="valor" class="form-control" required placeholder="Exemplo 1500.90">
                    <br>
                    <button type="submit" class="btn btn-success">
                        Adicionar Produto
                    </button>
                </form>
            </div>
        </div>
        <hr>
        <div class="card">
            <div class="card-body">
                <h2>Produtos do Carrinho:</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Nome do Produto</td>
                            <td>Qtde</td>
                            <td>Valor</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (isset($_SESSION["carrinho"])) {
                                foreach ($_SESSION["carrinho"] as $dados) {
                                    ?>
                                    <tr>
                                        <td><?=$dados["nome"]?></td>
                                        <td><?=$dados["qtde"]?></td>
                                        <td><?=$dados["valor"]?></td>
                                        <td><?=$dados["valor"] * $dados["qtde"]?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
                <p>
                    <a href="limpar.php" class="btn btn-danger">Limpar Carrinho</a>
                </p>
            </div>
        </div>
        <hr>
        <div class="card">
            <div class="card-body">
                <h2>Cliente:</h2>
                <form name="formCliente" method="post" action="finalizar.php">
                    <label for="nome">Nome do Cliente</label>
                    <input type="text" name="nome" id="nome" class="form-control" required>
                    <label for="email">E-mail do cliente</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <br>
                    <button type="submit" class="btn btn-success">
                        Finalizar Compra
                    </button>
                </form>
            </div>
        </div>
        <br>
    </div>
    
</body>
</html>