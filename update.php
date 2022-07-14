<?php
// Include dogDAO file
require_once('./dao/dogDAO.php');
 
// Define variables and initialize with empty values
$name = $age = $img = "";
$DOB = '';
$name_err = $age_err = $DOB_err = $img_err = "";
$dogDAO = new dogDAO(); 

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
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
	
	//validate date
	//Retrieved from https://www.codexworld.com/how-to/validate-date-input-string-in-php/
	function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
	}
	
    $input_DOB = trim($_POST["DOB"]);
	if(empty($input_DOB)){
		$DOB_err = "Please enter age.";
    }elseif(var_dump(validateDate($input_DOB))){
        $DOB_err = "Please enter a Valid Date";     
    } else{
        $DOB = $input_DOB;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($DOB_err) && empty($age_err)){   
        $dog = new Dog($id, $name, $DOB, $age, $img);
        $result = $dogDAO->updateDog($dog);
        echo '<br><h6 style="text-align:center">' . $result . '</h6>';   
        header( "refresh:2; url=index.php" ); 
        // Close connection
        $dogDAO->getMysqli()->close();
    }

} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        $dog = $dogDAO->getDog($id);
                
        if($dog){
            // Retrieve individual field value
            $name = $dog->getName();
            $DOB = $dog->getDOB();
            $age = $dog->getAge();
            $img = $dog->getImg();
        } else{
            // URL doesn't contain valid id. Redirect to error page
            header("location: error.php");
            exit();
        }
    } else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
    // Close connection
    $dogDAO->getMysqli()->close();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="js/script.js"></script>
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
                    <p>Please edit the input values and submit to update the dog record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Age</label>
                            <input type="number" id="age" name="age" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>"><?php echo $age; ?>
                            <span class="invalid-feedback"><?php echo $age_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="date" id="DOB" name="DOB" class="form-control <?php echo (!empty($DOB_err)) ? 'is-invalid' : ''; ?>"><?php echo $DOB; ?>
                            <span class="invalid-feedback"><?php echo $DOB_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <!--<input type="file" name="img" id="img" class="form-control ">-->
							<div class="modal-body">
								<input type="file" name="imageFile" accept="image/*" id="imageFile">
								<button type="button" class="btn btn-primary" onclick="uploadFile()">Upload</button>
								<span id="uploadError"></span>
							</div>
                            <span class="invalid-feedback"><?php echo $img_err;?></span>
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