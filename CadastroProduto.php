<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$nome =   $cpf_err = $cnpj_err = "";
$nome_err = $cpf_err = $cnpj_err =  "";
$valor =  $cpf_err = $cnpj_err = "";
$valor_err = $cpf_err = $cnpj_err = "";
$descricao = $cpf_err = $cnpj_err = "";
$descricao_err =  $cpf_err = $cnpj_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
      

    $input_nome = trim($_POST["nome"]);
    if(empty($input_nome)){
        $nome_err = "Por favor entre com um nome válido.";
    } elseif(!filter_var($input_nome, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nome_err = "Por favor entre com um nome válido.";
    } else{
        $nome = $input_nome;
    }

    $input_valor = trim($_POST["valor"]);
    if(empty($input_valor)){
        $valor_err = "Por favor entre com um valor válido.";
    }  else {
        $valor = $input_valor;
    }
    
    // Validate descricao
    $input_descricao = trim($_POST["descricao"]);
    if(empty($input_descricao)){
        $descricao_err = "Por favor entre com uma descricao válido.";     
    } else {
        $descricao = $input_descricao;
    }

 

    // Check input errors before inserting in database
    if(empty($nome_err) && empty($descricao_err) && empty($valor_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO Produtos (nome, valor, descricao) VALUES (?, ?, ?)";
   
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_nome, $param_valor, $param_descricao);
 
            // Set parameters
            $param_nome = $nome;
            $param_valor = $valor;
            $param_descricao = $descricao;
  
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.html");
                exit();
            } else{
                echo "Ocorreu um erro, por favor tente novamente mais tarde";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Cadastro de Produtos / Itens </h2>
                    <p>Por favor entre com os dados para gravar no banco de dados</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                       
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control <?php echo (!empty($nome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nome; ?>">
                            <span class="invalid-feedback"><?php echo $nome_err;?></span>
                        </div>
                
                        <div class="form-group">
                            <label>Valor</label>
                            <input type="number" name="valor" class="form-control <?php echo (!empty($valor_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $valor; ?>">
                            <span class="invalid-feedback"><?php echo $valor_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Descrição</label>
                            <input type="text" name="descricao" class="form-control <?php echo (!empty($descricao_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $descricao; ?>">
                            <span class="invalid-feedback"><?php echo $descricao_err;?></span>
                        </div>
 
                        <input type="submit" class="btn btn-primary" value="Gravar">
                        <a href="index.html" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>