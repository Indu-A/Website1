<?php
require_once('abstractDAO.php');
require_once('./model/dog.php');

class dogDAO extends abstractDAO {
        
    function __construct() {
        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }  
    
    public function getDog($id){
        $query = 'SELECT * FROM dogs WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $temp = $result->fetch_assoc();
            $dog = new dog($temp['id'],$temp['name'], $temp['DOB'], $temp['age'], $temp['img']);
            $result->free();
            return $dog;
        }
        $result->free();
        return false;
    }


    public function getDogs(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM dogs');
        $dogs = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new dog object, and add it to the array.
                $dog = new Dog($row['id'], $row['name'], $row['DOB'], $row['age'], $row['img']);
                $dogs[] = $dog;
            }
            $result->free();
            return $dogs;
        }
        $result->free();
        return false;
    }   
    
    public function addDog($dog){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
			$query = 'INSERT INTO dogs (name, DOB, age, img) VALUES (?,?,?,?)';
			$stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $name = $dog->getName();
			        $DOB = $dog->getDOB();
			        $age = $dog->getAge();
			        $img = $dog->getImg();
                  
			        $stmt->bind_param('ssi', 
				        $name,
				        $DOB,
				        $age,
				        $img
			        );    
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $dog->getName() . ' added successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   
    public function updateDog($dog){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = "UPDATE dogs SET name=?, DOB=?, age=?, img=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if($stmt){
                    $id = $dog->getId();
                    $name = $dog->getName();
			        $DOB = $dog->getDOB();
			        $age = $dog->getAge();
			        $img = $dog->getImg();
					
			        $stmt->bind_param('ssii',
				        $name,
				        $age,
				        $DOB,
				        $img,
                        $id
			        );   
                    //Execute the statement
                    $stmt->execute();         
                    
                    if($stmt->error){
                        return $stmt->error;
                    } else {
                        return $dog->getName() . ' updated successfully!';
                    } 
			}
             else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error; 
                return $error;
            }
       
        }else {
            return 'Could not connect to Database.';
        }
    }   

    public function deleteDog($id){
        if(!$this->mysqli->connect_errno){
            $query = 'DELETE FROM dogs WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            if($stmt->error){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>

