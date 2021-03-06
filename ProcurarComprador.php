<?php
     require_once "config.php";
     $pesquisarNome = $_POST['pesquisarNome'];
     $pesquisarCNPJ = $_POST['pesquisarCNPJ'];
     $result_cursos = "SELECT * FROM Compradores WHERE Nome LIKE '%$pesquisarNome%' AND  Cnpj LIKE '%$pesquisarCNPJ%'  LIMIT 5";
     $resultado_cursos = mysqli_query($link, $result_cursos);
 
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
     
    if($stmt = mysqli_prepare($link, $result_cursos)){
 
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $pesquisarNome = $row["Nome"];
                $pesquisarCNPJ = $row["Cnpj"];
              
            } else{
              
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: errorCNPJ.php");
                exit();
            }
            
        } else{
          
            echo "Tente novamente mais tarde.";
        }
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
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">Comprador Cadastrado</h1>
                    <div class="form-group">
                        <label>Nome</label>
                        <p><b><?php echo $row["Nome"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Cpf</label>
                        <p><b><?php echo $row["Cpf"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Cnpj</label>
                        <p><b><?php echo $row["Cnpj"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Cnpj</label>
                        <p><b><?php echo $row["Cnpj"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Endereco Empresa</label>
                        <p><b><?php echo $row["NomeEmpresa"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Data Cadastro</label>
                        <p><b><?php echo $row["DataCadastro"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Situa????o</label>
                        <p><b><?php echo $row["Situa????o"]; ?></b></p>
                    </div>
                    <p><a href="HistoricoDeVendas.php?pesquisarNome=<?php echo $pesquisarNome; ?>&pesquisarCNPJ=<?php echo $pesquisarCNPJ; ?>" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
