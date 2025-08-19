<?php
    session_start();

    if (!isset($_SESSION["carrinho"])) {
        echo "<script>alert('Carrinho vazio!');history.back();</script>";
    }

    $token = "seu token do Mercado Pago"; // Seu access token
    // onde conseguir o token: https://www.mercadopago.com.br/developers/panel/app/4614854370059387/credentials/production

    $nome = $_POST["nome"] ?? NULL;
    $email = $_POST["email"] ?? NULL;

    if (empty($nome)) {
        echo "<script>alert('Preencha o nome!');history.back();</script>";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Digite um e-mail válido!');history.back();</script>";
    }

    require 'vendor/autoload.php'; // caminho do autoload do Composer

    MercadoPago\SDK::setAccessToken($token); 

    
    // Crie um objeto de preferência
    $preference = new MercadoPago\Preference();
    use MercadoPago\Payer;

    $itens = [];

    foreach ($_SESSION["carrinho"] as $produto) {
        
        $itens[] = array(
            "title"       => $produto["nome"],
            "quantity"    => (int)$produto["qtde"],
            "currency_id" => "BRL",
            "unit_price"  => (float)$produto["valor"]
        );

    }

    $preference->items = $itens;

    $payer = new Payer();
    $payer->name = $nome;
    $payer->email = $email;

    $preference->payer = $payer;

    // URL de retorno após o pagamento
    $preference->back_urls = array(
        "success" => "https://www.seusite.com.br/meli/sucesso.php",
        "failure" => "https://www.seusite.com.br/meli/falha.php",
        "pending" => "https://www.seusite.com.br/meli/pendente.php"
    );

    $preference->notification_url = "https://www.seusite.com.br/meli/notificacao.php";

    $preference->auto_return = "approved"; // Retorno automático quando aprovado

    $preference->save();

  

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
    <div class="container">
        <h1 class="text-center">
            <a href="index.php" title="MeLi">
                <img src="images/mercado-pago-logo.png" alt="Mercado Pago" width="300px">
            </a>
        </h1>
        <hr>
        <div class="card">
            <div class="card-body">
                <h2>Produtos do Carrinho:</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Produto</td>
                            <td>Qtde</td>
                            <td>Valor</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $total = 0;
                            if (isset($_SESSION["carrinho"])) {
                                foreach ($_SESSION["carrinho"] as $dados) {
                                    $total = $total + ($dados["valor"] * $dados["qtde"]);
                                    ?>
                                    <tr>
                                        <td><?=$dados["id"]?></td>
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
                    <strong>Total da Compra: <?=$total?></strong>
                </p>
                <br>
                <p class="text-center">
                    <!-- Botão de pagamento -->
                    <script src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js"
                            data-preference-id="<?php echo $preference->id; ?>"
                            data-button-label="Pagar com Mercado Pago (Boleto, Cartão de Crédito ou Débito)">
                    </script>
                </p>
            </div>
        </div>
    </div>
</body>
</html>