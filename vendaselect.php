<?php
session_start();
include('verificalogin.php');
include('connect.php');

// Query SQL padrão para listar todos campos da tabela venda
$sql = "select v.id, p.nome produto, ve.nome vendedor, cli.nome cliente,
        v.precocusto, v.preco, v.quantidade, v.datavenda, v.valortotal
        from venda v
        inner join produto p
        on p.id = v.idproduto
        inner join vendedor ve
        on ve.id = v.idvendedor
        inner join cliente cli
        on cli.id = v.idcliente";


// Variáveis que serão usadas para as pesquisas
$pesqvend = '';
$pesqcliente = '';
$pesqproduto = '';
$pesqdata = '';
// Algoritmo que identifica a ação do botão submit, declara as variáveis anteriores ao valor que usuário.
if (isset($_POST['submit'])) {
    $pesqvend = mysqli_real_escape_string($con, $_POST['pesqvend']);
    $pesqcliente = mysqli_real_escape_string($con, $_POST['pesqcliente']);
    $pesqproduto = mysqli_real_escape_string($con, $_POST['pesqproduto']);
    $pesqdata = mysqli_real_escape_string($con, $_POST['pesqdata']);
    // Aqui é para trocar as / na data para - e trocar as posições dos números, ficando 0000-00-00 (padrão MYSQL)
    $pesqdata = implode("-",array_reverse(explode("/",$pesqdata)));
    // Depois de todos os valores declarados, será feito outro SQL porém com o filtro de pesquisa.
    $sql = $sql . " where ve.nome like '%$pesqvend%' and p.nome like '%$pesqproduto%' and 
    cli.nome like '%$pesqcliente%' and v.datavenda like '%$pesqdata%'";
}
// Aqui transfirá o resultado do $sql para a variável result
$result = mysqli_query($con, $sql);
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Superar</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <?php include('cabecalhoCRUD.html')?>
</head>

<body>
    <!-- Page Header Start -->
    <!-- <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s"> -->
        <!-- <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s"> -->
    <div class="container">
        <div class="container" style="margin-right:1000px;margin-top: 10px; width:2000px">
            <div class="row">
                <!-- Aqui é o Nome da Empresa e abaixo os botões Menu e Sair para voltar ou sair do sistema -->
                <div class="col-2">
                    <h1>Superar</h1>
                    <div>
                        <a href="menu.php"><strong style="font-size: 20px;">Menu</strong></a><br><br>
                        <a href="logout.php"><strong style="font-size: 20px;">Sair</strong></a><br><br>
                    </div>
                </div>
                <!-- Aqui é o formulário de pesquisa usando o form com método post -->
                <form method="post" action="" style="width: 1050px; padding: 5px; display: flex; align-items: flex-start; gap: 15px; 
                    background-color: #556152; border-radius: 10px;">
                    <div style="flex: 1;">

                        <!-- Aqui são todos os campos que o cliente irá preencher para fazer a pesquisa e filtrar os resultados -->
                        <div class="form-row">
                            <h5 style="margin-top:5px">Vendedor parcial:</h5>
                            <input type="text" name="pesqvend" placeholder="Nome..." style="height:30px; margin-top:5px"
                                value="<?php echo $pesqvend; ?>">
                        </div>

                        <div class="form-row">
                            <h5>Cliente parcial:</h5>
                            <input type="text" name="pesqcliente" placeholder="Nome..." style="height:30px"
                                value="<?php echo $pesqcliente; ?>">
                        </div>

                        <div class="form-row">
                            <h5>Produto parcial:</h5>
                            <input type="text" name="pesqproduto" placeholder="Nome..." style="height:30px"
                                value="<?php echo $pesqproduto; ?>">
                        </div>

                        <div class="form-row">
                            <h5>Data parcial:</h5>
                            <input class="data-input" type="date" name="pesqdata" style="height:30px"
                                value="<?php echo $pesqdata; ?>">
                        </div>
                    </div>
            <!-- Aqui fica os 3 botões principais: Pesquisar (de acordo com os valores nos campos), Limpar os valores inseridos e 
            entrar na área de incluir nova venda -->
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <button class="btn btn-secondary rounded-pill py-2 px-3" type="submit"
                            name="submit">Pesquisar</button>
                        <a href="vendaselect.php" class="btn btn-secondary rounded-pill py-2 px-3">Limpar</a>
                        <a href="vendainsert.php" class="btn btn-secondary rounded-pill py-2 px-3">Incluir</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabela de Resultados -->
    <div class="table-container">
        <table class="table table-hover text-center">
            <thead class="thead-dark">
                <tr>
                    <!-- Aqui é uma lista de todos os campos que irão aparecer na tabela -->
                    <?php
                        $listcolumn = ['ID','Vendedor','Cliente','Produto','Quantd.','Preço Custo','Preço Venda','Total','Data','Operações'];
                /** Aqui é uma estrutura de repetição utilizando o vetor $listcolumn e a variável $lc, tem objetivo de
                 * simplifica na hora de colocar cada coluna e seu nome, sendo $lc o índice do vetor $listcomun (agora não tem ctrl+C e V)
                */
                        for ($lc=0; $lc < count($listcolumn); $lc++) { 
                            echo "<th scope='col' style='background-color: #404A3D; color: white; width:20px'>" . $listcolumn[$lc] . "</th>";
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                // Esta parte é para formatar a variável $datavenda do padrão mysql para o padrão brasileiro 00/00/2000
                        $datavenda = date('d/m/Y', strtotime($row['datavenda']));
                // Aqui está atribuindo os valores puxadas no banco de dados para as colunas feitas anteriormente 
                // (a estrutura de repetição)
                            echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['vendedor'] . "</td>
                            <td>" . $row['cliente'] . "</td>                
                            <td>" . $row['produto'] . "</td>
                            <td>" . $row['quantidade'] . "</td>
                            <td>" . $row['precocusto'] . "</td>
                            <td>" . $row['preco'] . "</td>
                            <td>" . $row['valortotal'] . "</td>
                            <td>" . date('d/m/Y', strtotime($row['datavenda'])) . "</td>
                            <td>
                              <a href='vendaupdate.php?updateid={$row['id']}' class='btn btn-sm btn-primary'>
                                <i class='bi bi-pencil-square'></i> Alterar
                              </a>
                              <a href='vendadelete.php?deleteid={$row['id']}' class='btn btn-sm btn-danger'>
                                <i class='bi bi-trash'></i> Excluir
                              </a>
                            </td>
                          </tr>";
                    //   Depois do date('d/m/Y')... estão os botões vendaupdate e vendadelete para trocar a área de ver as vendas
                    //   para as áreas de alterar alguma venda ou excluir alguma venda.
                        }
                    } else {
                        echo "<tr><td colspan='11'>Nenhuma venda registrada.</td></tr>";
                    }
                    ?>
            </tbody>
        </table>
    </div>
    <?php include('templateJSfinal.html')?>
</body>

</html>