<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validando nome
    $input_nome = trim($_POST["Nome"]);
    if(empty($input_nome)){
        $nome_err = "Entre com um nome.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nome_err = "Entre com um nome válido";
    } else{
        $nome = $input_nome;
    }
    
    // Validando telefone
    $input_telefone = trim($_POST["Telefone"]);
    if(empty($input_telefone)){
        $telefone_err = "Por favor entre com um Telefone válido.";     
    } else{
        $telefone = $input_telefone;
    }
    
    // Validando cpf
    $input_cpf = trim($_POST["Cpf"]);
    if(empty($input_cpf)){
        $cpf_err = "Entre com o cpf";     
    } elseif(!ctype_digit($input_cpf)){
        $cpf_err = "Entre com um cpf válido.";
    } else{
        $cpf= $input_cpf;
    }
    
   // Validando Placa do carro
   $input_placacarro = trim($_POST["PlacaCarro"]);
   if(empty($input_cpf)){
       $placacarro_err = "Entre com a Placa do Carro";     
   } elseif(!ctype_digit($input_placacarro)){
       $placacarro_err = "Entre com uma placa válida";
   } else{
       $placacarro= $input_placacarro;
   }
   

    // Check input errors before inserting in database
    if(empty($nome_err) && empty($telefone_err) && empty($cpf_err)){
        // Prepare an update statement
        $sql = "UPDATE clientes SET nome=?, telefone=?, cpf=? WHERE clienteid=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["ClienteID"]) && !empty(trim($_GET["ClienteID"]))){
        // Get URL parameter
        $id =  trim($_GET["ClienteID"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM clientes WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $nome = $row["Nome"];
                    $telefone = $row["Telefone"];
                    $cpf = $row["Cpf"];
                    $placacarro = $row["PlacaCarro"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="nome" class="form-control <?php echo (!empty($nome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $nome_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Telefone</label>
                            <textarea name="telefone" class="form-control <?php echo (!empty($telefone_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $telefone_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Cpf</label>
                            <input type="text" name="cpf" class="form-control <?php echo (!empty($cpf_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $cpf_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Placa do Carro</label>
                            <input type="text" name="placacarro" class="form-control <?php echo (!empty($placacarro_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $placacarro_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>