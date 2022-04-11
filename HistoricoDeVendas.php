<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 680px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
        <?php echo $pesquisarNome = $_GET['pesquisarNome']; ?>
        <?php echo $pesquisarCNPJ = $_GET['pesquisarCNPJ']; ?>
        <?php echo $pesquisarProduto = $_GET['pesquisarProduto']; ?>
        <?php echo $QntProduto = $_GET['Quantidade']; ?>
        <?php echo $Valor = $_GET['Valor']; ?>
        <?php echo $ValorUnit = $_GET['ValorUnit']; ?>
        <?php echo $Descricao = $_GET['Descricao']; ?>
        <?php echo $ProdutoID = $_GET['ProdutoID']; ?>
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5 mb-3 clearfix">
                    <h2 class="pull-left">Cadastro de Vendas</h2><br><br><br>  
                    
                    <div class="form-group" class="container">
                    <form method="POST" action="ProcurarComprador.php">
                    Cliente CNPJ                      
                        <input type="text"  name="pesquisarCNPJ"  placeholder="CNPJ Comprador" value= <?php echo $pesquisarCNPJ ?>  >  <br> <br> 
                    Nome Cliente <input type="text" name="pesquisarNome" placeholder="Nome do Comprador" value= <?php echo $pesquisarNome ?> >
                    <br> <br>   <input type="submit" value="Procurar">
                    </form>
 
                    </div>
                    <hr size="50">
                    <br><br>
                      
                
                <tr>
                <form method="POST" action="ProcurarProduto.php?pesquisarNome=<?php echo $pesquisarNome ?>&pesquisarCNPJ=<?php echo $pesquisarCNPJ ?>& ">
                    Produto
                    <input type="text" name="pesquisarProduto" placeholder="Nome do Produto" value= <?php echo $pesquisarProduto ?> ><td></td><input type="submit" value="Procurar"> 
                     &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Descrição
                        <input type="text" id="txtBuscaProduto" placeholder="Descrição do produto"value= <?php echo $Descricao ?>  > </td>
                </form>
                      <br>  
                      Quantidade
                      <input type="text" id="txtBuscaProduto" placeholder="Quantidade" value= <?php echo $QntProduto ?>></td>
                      &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      Valor
                      <input type="text" id="txtBuscaProduto" placeholder="Valor do produto" value= <?php echo $Valor ?> > <td></td><br><br>
                      Desconto em %
                      <input type="text" id="txtBuscaProduto" placeholder="Desconto em %"value= <?php echo ($Valor-$ValorUnit)/100 ?> > </td></td>
                      &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; R$ Desconto
                        <input type="text" id="txtBuscaProduto" placeholder="Desconto em R$" value= <?php echo $Valor-$ValorUnit ?>    > </td>
                </tr>
                <tr> 
                     
                    </div>
                    <a href="AdicionarProduto.php?pesquisarNome=<?php echo $pesquisarNome ?>&pesquisarCNPJ=<?php echo $pesquisarCNPJ ?>&nome=<?php echo $pesquisarProduto ?>&Quantidade=<?php echo $QntProduto ?>&DescontoPercent=<?php echo ($Valor-$ValorUnit)/100 ?>&DescontoValor=<?php echo $Valor-$ValorUnit ?>&Valor=<?php echo $Valor ?>&ProdutoID=<?php echo $ProdutoID ?>  " class="btn btn-warning pull-right"><i class="fa fa-plus"></i> Adicionar Produto</a> <td></td>                     
                   </a>
                    
                    <br><br> 
                    </td>
                    <a href="Vender.php" class="btn btn-warning pull-right"><i class="fa fa-plus"></i> Vender</a> <td></td>
                    </br>
                    <a href="index.html" class="right">  </i> Voltar ao menu principal</a> <td></td>
                 
                    <hr size="50">
                    <br><br>
            </div>
            

            </div>
                <?php
                // Inclui arquivo config
                require_once "config.php";

                // Executa a query clientes
                $sql = "SELECT * FROM Vendas V INNER JOIN Produtos P ON V.ProdutoID=P.ProdutoID";
                if($result = mysqli_query($link, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Item</th>";
                        echo "<th>Produto</th>";
                        echo "<th>Quantidade</th>";
                        echo "<th>Valor Unitario</th>";
                        echo "<th>Desconto %</th>";
                        echo "<th>Desconto R$</th>";
                        echo "<th>Valor Total R$</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while($row = mysqli_fetch_array($result)){
                            echo "<tr>";
                            echo "<td>" . $row['VendaID'] . "</td>";
                            echo "<td>" . $row['Nome'] . "</td>";
                            echo "<td>" . $row['Quantidade'] . "</td>";
                            echo "<td>" . $row['ValorUnitario'] . "</td>";
                            echo "<td>" . $row['DescontoPercent'] . "</td>";
                            echo "<td>" . $row['DescontoValor'] . "</td>";
                            echo "<td>" . $row['Valor'] . "</td>";
                            echo "<td>";
                            echo '<a href="read.php?VendaID='. $row['VendaID'] .'" class="mr-3" title="Ver Dados" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                            echo '<a href="update.php?VendaID='. $row['VendaID'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                            echo '<a href="delete.php?VendaID='. $row['VendaID'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        // Final do resultado
                        mysqli_free_result($result);
                    } else{
                        echo '<div class="alert alert-danger"><em>Nenhum registro cadastrado.</em></div>';
                    }
                } else{
                    echo "Aconteceu algum problema tente novamente.";
                }

                // Fecha conexão
                mysqli_close($link);
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>