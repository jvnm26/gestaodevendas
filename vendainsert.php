<?php
session_start();
include('verificalogin.php');
include('connect.php');
if (isset($_POST['submit'])) {
    $idproduto = $_POST['idproduto'];
    $idvendedor = $_POST['idvendedor'];
    $idcliente = $_POST['idcliente'];
    $quantidade = $_POST['quantidade'];
    $datavenda = $_POST['datavenda'];
    $precocusto = $_POST['precocusto'];
    $preco = $_POST['preco'];

    $sql = "INSERT INTO `venda`(`idproduto`, `idvendedor`, `idcliente`, `quantidade`, `datavenda`, `preco`, `precocusto`) VALUES ('$idproduto','$idvendedor','$idcliente','$quantidade','$datavenda','$preco','$precocusto')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        header('location: vendaselect.php');
    } else {
        die('' . mysqli_error($con));
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Superar</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Open+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

    <!-- Aqui é o Nome da Empresa e abaixo os botões Menu e Sair para voltar ou sair do sistema -->
                <div class="col" style="margin-left: 200px; margin-top: 40px">
                    <h1>Superar</h1>
                    <div>
                        <a href="menu.php"><strong style="font-size: 20px;">Menu</strong></a><br><br>
                        <a href="logout.php"><strong style="font-size: 20px;">Sair</strong></a><br><br>
                    </div>
                </div>

    <!-- Page Header Start -->
    <div class="container-form-post">
        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s">
            <div class="container p-3">
                <div class="container text-center py-2">
                    <h1>Incluir Venda</h1>
                </div>

                <form action="" method="post" class="mt-3">
                    <h4>Dados da Venda:</h4>

                    <!-- Produto -->
                    <div class="mb-3">
                        <label for="idproduto" class="form-label">Nome do Produto:</label>
                        <?php
                        $sqll = 'SELECT * FROM produto ORDER BY id';
                        $result = mysqli_query($con, $sqll);
                        if ($result) {
                            echo '<select name="idproduto" class="form-control">';
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['id'] . '">' . $row['nome'] . '</option>';
                            }
                            echo '</select>';
                        }
                        ?>
                    </div>

                    <!-- Vendedor -->
                    <div class="mb-3">
                        <label for="idvendedor" class="form-label">Nome do Vendedor:</label>
                        <?php
                        $sqll = 'SELECT * FROM vendedor ORDER BY id';
                        $result = mysqli_query($con, $sqll);
                        if ($result) {
                            echo '<select name="idvendedor" class="form-control">';
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['id'] . '">' . $row['nome'] . '</option>';
                            }
                            echo '</select>';
                        }
                        ?>
                    </div>

                    <!-- Cliente -->
                    <div class="mb-3">
                        <label for="idcliente" class="form-label">Nome do Cliente:</label>
                        <?php
                        $sqll = 'SELECT * FROM cliente ORDER BY id';
                        $result = mysqli_query($con, $sqll);
                        if ($result) {
                            echo '<select name="idcliente" class="form-control">';
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['id'] . '">' . $row['nome'] . '</option>';
                            }
                            echo '</select>';
                        }
                        ?>
                    </div>
                    <!-- Quantidade -->
                    <div class="mb-3">
                        <label for="quantidade" class="form-label">Quantidade vendida:</label>
                        <input type="text" name="quantidade" class="form-control" required>
                    </div>
                    <!-- Data da venda -->
                    <div class="col form-group">
                            <label for="datavenda">Data da Venda:</label>
                            <input type="date" name="datavenda" class="form-control" required>
                        </div>

                    <!-- Preço Custo -->
                    <div class="mb-3">
                        <label for="precocusto" class="form-label">Preço Custo:</label>
                        <input type="number" name="precocusto" class="form-control" step="0.01" required>
                    </div>

                    <!-- Preço Venda -->
                    <div class="mb-3">
                        <label for="preco" class="form-label">Preço Venda:</label>
                        <input type="number" name="preco" class="form-control" step="0.01" required>
                    </div>
                    
                    <!-- Botões -->
                    <div class="text-center mt-4">
                        <a href="vendaselect.php" class="btn btn-voltar">Voltar</a>
                        <button type="submit" name="submit" class="btn btn-adicionar">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Page Header End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/parallax/parallax.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>