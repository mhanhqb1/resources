<?php
	class PHONENUMBER extends DATABASE{
		protected $_name;
		protected $_vitri;
		protected $_phone;
		protected $_isActived;
		
		public function __construct(){
			$this->connect();	
		}

		public function setPhone($i){
			$this->_phone = $i;
		}
		public function getPhone(){
			return $this->_phone;
		}

		public function setName($p){
			$this->_name = $p;
		}
		public function getName(){
			return $this->_name;
		}

		public function setVitri($p){
			$this->_vitri = $p;
		}
		public function getVitri(){
			return $this->_vitri;
		}

		public function setIsActived($s){
			$this->_isActived = $s;
		}
		public function getIsActived(){
			return $this->_isActived;
		}

		/*--------------------------FUNCITONS--------------------------*/

		public function listOne($id){
			$sql = "SELECT * FROM phonenumber WHERE id=$id";
			$this->query($sql);
			$data = '';
			if($this->num_rows() != 0){
				$data = $this->fetch();
			}
			return $data;
		}

		public function listAll(){
			$sql = "SELECT * FROM phonenumber where is_actived = 1 ORDER BY vitri";
			$this->query($sql);
			$phonenumber = '';
			if($this->num_rows() != 0){
				while ($data = $this->fetch()) {
					$phonenumber[] = $data; 
				}
			}
			return $phonenumber;
		}

		public function insert(){
			$sql = "INSERT INTO phonenumber(name, phone, vitri, is_actived) values('".$this->getName()."', '".$this->getPhone()."', '".$this->getVitri()."', '".$this->getIsActived()."')";
			$this->query($sql);
		}

		public function update($id){
			$sql = "UPDATE phonenumber SET phone='".$this->getPhone()."', is_actived='".$this->getIsActived()."', name='".$this->getName()."', vitri='".$this->getVitri()."' WHERE id='".$id."'";
			
			$this->query($sql);
		}

		public function delete($id){
			$sql = "DELETE FROM phonenumber WHERE id=$id";
			$this->query($sql);
		}

	}
?>