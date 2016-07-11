<?php
	class CATE extends DATABASE{
		protected $_name;
		
		public function __construct(){
			$this->connect();	
		}

		public function setName($p){
			$this->_name = $p;
		}
		public function getName(){
			return $this->_name;
		}
		/*--------------------------FUNCITONS--------------------------*/

		public function listOne($id){
			$sql = "SELECT * FROM cate WHERE cate_id=$id";
			$this->query($sql);
			$data = '';
			if($this->num_rows() != 0){
				$data = $this->fetch();
			}
			return $data;
		}

		public function listAll(){
			$sql = "SELECT * FROM cate ORDER BY cate_id DESC";
			$this->query($sql);
			$cate = '';
			if($this->num_rows() != 0){
				while ($data = $this->fetch()) {
					$cate[] = $data; 
				}
			}
			return $cate;
		}

		public function insert(){
			$sql = "INSERT INTO cate(cate_name) values('".$this->getName()."')";
			$this->query($sql);
		}

		public function update($id, $image=''){
			$sql = "UPDATE cate SET cate_name='".$this->getName()."' WHERE cate_id='".$id."'";
			$this->query($sql);
		}

		public function delete($id){
			$sql = "DELETE FROM cate WHERE cate_id=$id";
			$this->query($sql);
		}

	}
?>