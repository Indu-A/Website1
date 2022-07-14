<?php
// Include dogDAO file
require_once('./dao/dogDAO.php');

 
// Define variables and initialize with empty values
$name = $DOB = $age = $img = "";
$name_err = $DOB_err = $age_err = $img_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate DOB
    $input_DOB = trim($_POST["DOB"]);
    if(empty($input_DOB)){
        $DOB_err = "Please enter an DOB.";     
    } else{
        $DOB = $input_DOB;
    }
	
	// Validate age
    $input_age = trim($_POST["age"]);
    if(empty($input_age)){
        $age_err = "Please enter age.";
    } elseif(!filter_var($input_age, FILTER_VALIDATE_INT, array("options"=>array('min_range' => 1,
        'max_range' => 50)))){
        $age_err = "Please enter a valid number.";
    } else{
        $age = $input_age;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($DOB_err) && empty($img_err)){
        $dogDAO = new dogDAO();    
        $dog = new Dog(0, $name, $DOB, $img);
        $addResult = $dogDAO->addDog($dog);
        echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';   
        header( "refresh:2; url=index.php" ); 
        // Close connection
        $dogDAO->getMysqli()->close();
        }
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add dog record to the database.</p>
					
					<!--the following form action, will send the submitted form data to the page itself ($_SERVER["PHP_SELF"]), instead of jumping to a different page.-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>DOB</label>
                            <textarea name="DOB" class="form-control <?php echo (!empty($DOB_err)) ? 'is-invalid' : ''; ?>"><?php echo $DOB; ?></textarea>
                            <span class="invalid-feedback"><?php echo $DOB_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Age</label>
                            <input type="number" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>"><?php echo $age; ?></textarea>
                            <span class="invalid-feedback"><?php echo $age_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="text" name="img" class="form-control <?php echo (!empty($img_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $img; ?>">
                            <span class="invalid-feedback"><?php echo $img_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
        <?include 'footer.php';?>
    </div>
</body>
</html>