<?php
	class SLIDER extends DATABASE{
		protected $_image;
		protected $_position;
		protected $_active;
		
		
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

		public function setActive($s){
			$this->_active = $s;
		}
		public function getActive(){
			return $this->_active;
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
			$sql = "SELECT * FROM slider WHERE is_actived = '1' ORDER BY position ASC";
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
			$sql = "SELECT * FROM slider WHERE image='".$this->getImage()."' AND id != '$id'";
			$this->query($sql);
			if($this->num_rows() != 0){
				return FALSE; // iamge name đã tồn tại
			}else{
				return TRUE; // image name chua co
			}
		}

		public function register(){
			$sql = "INSERT INTO slider(image, first_text, second_text, position, active) values('".$this->getImage()."', '".$this->getFirstText()."', '".$this->getSecondText()."', '".$this->getPosition()."', '".$this->getActive()."')";
			$this->query($sql);
		}

		public function update($id, $image=''){
			if($image != ''){
				$sql = "UPDATE slider SET image='".$this->getImage()."', first_text='".$this->getFirstText()."', second_text='".$this->getSecondText()."', position='".$this->getPosition()."', active='".$this->getActive()."' WHERE id='".$id."'";
			}else{
				$sql = "UPDATE slider SET first_text='".$this->getFirstText()."', second_text='".$this->getSecondText()."', position='".$this->getPosition()."', active='".$this->getActive()."' WHERE id='".$id."'";
			}
			$this->query($sql);
		}

		public function delete($id){
			$sql = "DELETE FROM slider WHERE id=$id";
			$this->query($sql);
		}

	}
?>