<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$nome = $telefone = $cpf = $placacarro = "";
$nome_err = $telefonen_err = $cpf_err = $placacarro_err = "";
 
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
    
    // Validate Telefone
    $input_telefone = trim($_POST["telefone"]);
    if(empty($input_telefone)){
        $telefone_err = "Please enter an telefone.";     
    } else{
        $telefone = $input_telefone;
    }
    
    // Validate Cpf
    $input_cpf = trim($_POST["cpf"]);
    if(empty($input_cpf)){
        $cpf_err = "Please enter the Cpf amount.";     
    } elseif(!ctype_digit($input_cpf)){
        $cpf_err = "Please enter a positive integer value.";
    } else{
        $cpf = $input_cpf;
    }

        // Validate PlacaCarro
        $input_placacarro = trim($_POST["placacarro"]);
        if(empty($input_placacarro)){
            $placacarro_err = "Por favor entre com uma placa válida";     
        } elseif(!ctype_digit($input_placacarro)){
            $placacarro_err = "Por favor entre com uma placa válida";
        } else{
            $placacarro = $input_placacarro;
        }
  
    // Check input errors before inserting in database
    if(empty($nome_err) && empty($telefone_err) && empty($cpf_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO clientes (nome, telefone, cpf, placacarro) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_nome, $param_telefone, $param_cpf, $param_placacarro);
            
            // Set parameters
            $param_nome = $nome;
            $param_telefone = $telefone;
            $param_cpf = $cpf;
            $param_placacarro = $placacarro;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
                    <h2 class="mt-5">Gravar</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control <?php echo (!empty($nome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nome; ?>">
                            <span class="invalid-feedback"><?php echo $nome_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Telefone</label>
                            <textarea name="telefone" class="form-control <?php echo (!empty($telefone_err)) ? 'is-invalid' : ''; ?>"><?php echo $telefone; ?></textarea>
                            <span class="invalid-feedback"><?php echo $telefone_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Cpf</label>
                            <input type="text" name="cpf" class="form-control <?php echo (!empty($cpf_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cpf; ?>">
                            <span class="invalid-feedback"><?php echo $cpf_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Placa do Carro</label>
                            <input type="text" name="cpf" class="form-control <?php echo (!empty($placacarro_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $placacarro; ?>">
                            <span class="invalid-feedback"><?php echo $cpf_err;?></span>
                        </div>
                      
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>