<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$nome = $telefone = $cpf = $cpf = "";
$nome_err = $telefonen_err = $cpf_err = $cpf_err = "";
$sobrenome = $telefone = $cpf = $cpf = "";
$sobrenome_err = $telefonen_err = $cpf_err = $cpf_err = "";
$cpf = $telefone = $cpf = $cpf = "";
$cpf_err = $telefonen_err = $cpf_err = $cpf_err = "";
$cargo = $telefonen_err = $cpf_err = $cpf_err = "";
$cargo_err = $telefonen_err = $cpf_err = $cpf_err = "";


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

    $input_sobrenome = trim($_POST["sobrenome"]);
    if(empty($input_sobrenome)){
        $sobrenome_err = "Por favor entre com um sobre nome válido.";
    } elseif(!filter_var($input_sobrenome, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $sobrenome_err = "Por favor entre com um sobre nome válido.";
    } else{
        $sobrenome = $input_sobrenome;
    }
    
    // Validate cpf
    $input_cpf = trim($_POST["cpf"]);
    if(empty($input_cpf)){
        $cpf_err = "Por favor entre com um cpf válido.";     
    } elseif(!ctype_digit($input_cpf)){
        $cpf_err = "Por favor entre com um cpf válido";
    } else{
        $cpf = $input_cpf;
    }

    // Validate empresa
    $input_cargo = trim($_POST["cargo"]);
    if(empty($input_cargo)){
       $cargo_err = "Entre com um cargo válido";     
    } else{
            $cargo = $input_cargo;
    }
    
    // Check input errors before inserting in database
    if(empty($nome_err) && empty($cnpj_err) && empty($cpf_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO funcionarios (Nome, Sobrenome, Cpf, Cargo) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_nome, $param_sobrenome, $param_cpf, $param_cargo);
         
            // Set parameters
            $param_nome = $nome;
            $param_sobrenome = $sobrenome;
            $param_cpf = $cpf;
            $param_cargo = $cargo;
            
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
                    <h2 class="mt-5">Cadastro de Funcionários </h2>
                    <p>Por favor entre com os dados para gravar no banco de dados</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                       
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control <?php echo (!empty($nome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nome; ?>">
                            <span class="invalid-feedback"><?php echo $nome_err;?></span>
                        </div>
                
                        <div class="form-group">
                            <label>Sobre Nome</label>
                            <input type="text" name="sobrenome" class="form-control <?php echo (!empty($sobrenome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $sobrenome; ?>">
                            <span class="invalid-feedback"><?php echo $sobrenome_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Cpf</label>
                            <input type="text" name="cpf" class="form-control <?php echo (!empty($cpf_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cpf; ?>">
                            <span class="invalid-feedback"><?php echo $cpf_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Nome Empresa</label>
                            <input type="text" name="cargo" class="form-control <?php echo (!empty($cargo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cargo; ?>">
                            <span class="invalid-feedback"><?php echo $cargo_err;?></span>
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