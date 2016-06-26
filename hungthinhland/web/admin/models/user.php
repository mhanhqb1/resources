<?php
	class USER extends DATABASE{
		protected $_password;
		protected $_level;
		protected $_email;
		protected $_firstname;
		protected $_lastname;
		protected $_phone;
		
		
		public function __construct(){
			$this->connect();	
		}

		public function setPassword($pass){
			$this->_password = $pass;
		}
		public function getPassword(){
			return $this->_password;
		}

		public function setLevel($level){
			$this->_level = $level;
		}
		public function getLevel(){
			return $this->_level;
		}

		public function setEmail($email){
			$this->_email = $email;
		}
		public function getEmail(){
			return $this->_email;
		}

		public function setFirstName($a){
			$this->_firstname = $a;
		}
		public function getFirstName(){
			return $this->_firstname;
		}

		public function setLastName($a){
			$this->_lastname = $a;
		}
		public function getLastName(){
			return $this->_lastname;
		}

		public function setPhone($p){
			$this->_phone = $p;
		}
		public function getPhone(){
			return $this->_phone;
		}

		/*--------------------------FUNCITONS--------------------------*/

		public function checkAdminLogin($email, $pass){
			$sql = "SELECT * FROM users WHERE email='".$email."' AND password='".$pass."' AND level=2";
			$this->query($sql);
			if($this->num_rows() != 0){
				return $this->fetch();
			}else{
				return FALSE;
			}
		}

		public function listOne($id){
			$sql = "SELECT * FROM users WHERE id=$id";
			$this->query($sql);
			$data = '';
			if($this->num_rows() != 0){
				$data = $this->fetch();
			}
			return $data;
		}

		public function listAll(){
			$sql = "SELECT * FROM users";
			$this->query($sql);
			$users = '';
			if($this->num_rows() != 0){
				while ($data = $this->fetch()) {
					$users[] = $data; 
				}
			}
			return $users;
		}

		public function checkEmailExist($id = ''){
			$sql = "SELECT * FROM users WHERE email='".$this->getEmail()."' AND id != '$id'";
			$this->query($sql);
			if($this->num_rows() != 0){
				return FALSE; // Email đã tồn tại
			}else{
				return TRUE; // Email chưa đăng ký
			}
		}

		public function register(){
			$sql = "INSERT INTO users(email, password, first_name, last_name, phone, level) values('".$this->getEmail()."', '".$this->getPassword()."', '".$this->getFirstName()."', '".$this->getLastName()."', '".$this->getPhone()."', '".$this->getLevel()."')";
			$this->query($sql);
		}

		public function update($id){
			$sql = "UPDATE users SET email='".$this->getEmail()."', first_name='".$this->getFirstName()."', last_name='".$this->getLastName()."', phone='".$this->getPhone()."', level='".$this->getLevel()."' WHERE id='".$id."'";
			$this->query($sql);
		}

		public function delete($id){
			$sql = "DELETE FROM users WHERE id=$id";
			$this->query($sql);
		}

	}
?>