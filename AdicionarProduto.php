<?php
     require_once "config.php";
     $pesquisarNome = $_GET['pesquisarNome'];
     $pesquisarCNPJ = $_GET['pesquisarCNPJ']; 
     $Nome = $_GET['nome'];
     $Quantidade = $_GET['Quantidade'];  
     $DescontoPercent = $_GET['DescontoPercent'];
     $DescontoValor = $_GET['DescontoValor']; 
     $Valor = $_GET['Valor'];
     $ProdutoID = $_GET['ProdutoID'];
 
    $nome_err = $telefonen_err = $cpf_err = $cnpj_err = ""; 
    
    echo "Produto Inserido!";
  
        // Check input errors before inserting in database
   
            $sql = "INSERT INTO Vendas (produtoid, quantidade, descontopercent, descontoValor, valor) VALUES (?, ?, ?, ?, ?)";

            if($stmt = mysqli_prepare($link, $sql)){
                 
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sssss", $param_produtoID, $param_quantidade, $param_descontoPercent, $param_descontoValor, $param_valor);
 
                // Set parameters
                $param_produtoID = $ProdutoID;
                $param_quantidade = $Quantidade;
                $param_descontoPercent = $DescontoPercent;
                $param_descontoValor = $DescontoValor;
                $param_valor = $Valor;
 
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Records created successfully. Redirect to landing page
                    header("location: index.html");
                    exit();
                } else{
                    echo "Ocorreu um erro, por favor tente novamente mais tarde";
                }
            // Check input errors before inserting in database
        }   

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gravado</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    
         
<p><a  href="HistoricoDeVendas.php?Nome=<?php echo $pesquisarNome; ?>&pesquisarCNPJ=<?php echo $pesquisarCNPJ; ?>" class="btn btn-primary">Retornar</a></p>
                    
              
   
</body>
</html>
