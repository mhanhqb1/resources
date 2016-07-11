<?php
	class SLIDER extends DATABASE{
		protected $_image;
		protected $_position;
		protected $_link;
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

		public function setPosition($p){
			$this->_position = $p;
		}
		public function getPosition(){
			return $this->_position;
		}

		public function setIsActived($s){
			$this->_isActived = $s;
		}
		public function getIsActived(){
			return $this->_isActived;
		}

		public function setLink($s){
			$this->_link = $s;
		}
		public function getLink(){
			return $this->_link;
		}
		/*--------------------------FUNCITONS--------------------------*/

		public function listOne($id){
			$sql = "SELECT * FROM slider WHERE slider_id=$id";
			$this->query($sql);
			$data = '';
			if($this->num_rows() != 0){
				$data = $this->fetch();
			}
			return $data;
		}

		public function listAll(){
			$sql = "SELECT * FROM slider ORDER BY slider_id DESC";
			$this->query($sql);
			$slider = '';
			if($this->num_rows() != 0){
				while ($data = $this->fetch()) {
					$slider[] = $data; 
				}
			}
			return $slider;
		}

		public function checkImageExist($id = ''){
			$sql = "SELECT * FROM slider WHERE image='".$this->getImage()."' AND slider_id != '$id'";
			$this->query($sql);
			if($this->num_rows() != 0){
				return FALSE; // iamge name đã tồn tại
			}else{
				return TRUE; // image name chua co
			}
		}

		public function register(){
			$sql = "INSERT INTO slider(image, position, link, is_actived) values('".$this->getImage()."', '".$this->getPosition()."', '".$this->getLink()."', '".$this->getIsActived()."')";
			$this->query($sql);
		}

		public function update($id, $image=''){
			if($image != ''){
				$sql = "UPDATE slider SET image='".$this->getImage()."', position='".$this->getPosition()."', is_actived='".$this->getIsActived()."', link='".$this->getLink()."' WHERE slider_id='".$id."'";
			}else{
				$sql = "UPDATE slider SET position='".$this->getPosition()."', is_actived='".$this->getIsActived()."', link='".$this->getLink()."' WHERE slider_id='".$id."'";
			}
			$this->query($sql);
		}

		public function delete($id){
			$sql = "DELETE FROM slider WHERE slider_id=$id";
			$this->query($sql);
		}
	}
?>