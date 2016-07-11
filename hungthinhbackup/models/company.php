<?php
	class COMPANY extends DATABASE{
		protected $_name;
		protected $_website;
		protected $_image;
		protected $_isActived;
		
		public function __construct(){
			$this->connect();	
		}

		public function setImage($i){
			$this->_image = $i;
		}
		public function getImage(){
			return $this->_image;
		}

		public function setName($p){
			$this->_name = $p;
		}
		public function getName(){
			return $this->_name;
		}

		public function setWebsite($p){
			$this->_website = $p;
		}
		public function getWebsite(){
			return $this->_website;
		}

		public function setIsActived($s){
			$this->_isActived = $s;
		}
		public function getIsActived(){
			return $this->_isActived;
		}

		/*--------------------------FUNCITONS--------------------------*/

		public function listOne($id){
			$sql = "SELECT * FROM company WHERE id=$id";
			$this->query($sql);
			$data = '';
			if($this->num_rows() != 0){
				$data = $this->fetch();
			}
			return $data;
		}

		public function listAll(){
			$sql = "SELECT * FROM company WHERE is_actived = '1' ORDER BY id DESC";
			$this->query($sql);
			$company = '';
			if($this->num_rows() != 0){
				while ($data = $this->fetch()) {
					$company[] = $data; 
				}
			}
			return $company;
		}

		public function checkImageExist($id = ''){
			$sql = "SELECT * FROM company WHERE image='".$this->getImage()."' AND id != '$id'";
			$this->query($sql);
			if($this->num_rows() != 0){
				return FALSE; // iamge name đã tồn tại
			}else{
				return TRUE; // image name chua co
			}
		}

		public function insert(){
			$sql = "INSERT INTO company(name, image, website, is_actived) values('".$this->getName()."', '".$this->getImage()."', '".$this->getWebsite()."', '".$this->getIsActived()."')";
			$this->query($sql);
		}

		public function update($id, $image=''){
			if($image != ''){
				$sql = "UPDATE company SET image='".$this->getImage()."', is_actived='".$this->getIsActived()."', name='".$this->getName()."', website='".$this->getWebsite()."' WHERE id='".$id."'";
			}else{
				$sql = "UPDATE company SET is_actived='".$this->getIsActived()."', name='".$this->getName()."', website='".$this->getWebsite()."' WHERE id='".$id."'";
			}
			$this->query($sql);
		}

		public function delete($id){
			$sql = "DELETE FROM company WHERE id=$id";
			$this->query($sql);
		}

	}
?>