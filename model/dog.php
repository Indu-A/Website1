<?php
	class dog{		

		private $id;
		private $name;
		private $DOB;
		private $age;
		private $img;
				
		function __construct($id, $name, $DOB, $age, $img){
			$this->setId($id);
			$this->setName($name);
			$this->setDOB($DOB);
			$this->setAge($age);
			$this->setimg($img);
			}		
		
		public function getName(){
			return $this->name;
		}
		
		public function setName($name){
			$this->name = $name;
		}
		
		public function getDOB(){
			return $this->DOB;
		}
		
		public function setDOB($DOB){
			$this->DOB = $DOB;
		}
		
		public function getAge(){
			return $this->age;
		}
		
		public function setAge($age){
			$this->age = $age;
		}

		public function getImg(){
			return $this->img;
		}

		public function setImg($img){
			$this->img = $img;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

	}
?>