<?php
	class DUAN extends DATABASE{
		protected $_title;
		protected $_description;
		protected $_detail;
		protected $_image;
		protected $_isFeatured;
		protected $_isDautu;
		protected $_isGiatot;
		protected $_isMoi;
		
		public function __construct(){
			$this->connect();	
		}

		public function setImage($i){
			$this->_image = $i;
		}
		public function getImage(){
			return $this->_image;
		}

		public function setTitle($p){
			$this->_title = $p;
		}
		public function getTitle(){
			return $this->_title;
		}

		public function setDescription($p){
			$this->_description = $p;
		}
		public function getDescription(){
			return $this->_description;
		}

		public function setDetail($p){
			$this->_detail = $p;
		}
		public function getDetail(){
			return $this->_detail;
		}

		public function setIsFeatured($s){
			$this->_isFeatured = $s;
		}
		public function getIsFeatured(){
			return $this->_isFeatured;
		}

		public function setIsDautu($s){
			$this->_isDautu = $s;
		}
		public function getIsDautu(){
			return $this->_isDautu;
		}

		public function setIsGiatot($s){
			$this->_isGiatot = $s;
		}
		public function getIsGiatot(){
			return $this->_isGiatot;
		}

		public function setIsMoi($s){
			$this->_isMoi = $s;
		}
		public function getIsMoi(){
			return $this->_isMoi;
		}
		/*--------------------------FUNCITONS--------------------------*/

		public function listOne($id){
			$sql = "SELECT * FROM duan WHERE duan_id=$id";
			$this->query($sql);
			$data = '';
			if($this->num_rows() != 0){
				$data = $this->fetch();
			}
			return $data;
		}

		public function listAll(){
			$sql = "SELECT * FROM duan ORDER BY duan_id DESC";
			$this->query($sql);
			$new = '';
			if($this->num_rows() != 0){
				while ($data = $this->fetch()) {
					$new[] = $data; 
				}
			}
			return $new;
		}

		public function getDuanNoiThanh($a = false){
			if ($a) {
				$sql = "SELECT * FROM duan WHERE is_featured = '1' ORDER BY vitrihienthi ASC LIMIT $a";
			} else {
				$sql = "SELECT * FROM duan WHERE is_featured = '1' ORDER BY vitrihienthi ASC";
			}
			$this->query($sql);
			$new = '';
			if($this->num_rows() != 0){
				while ($data = $this->fetch()) {
					$new[] = $data; 
				}
			}
			return $new;
		}

		public function getDuanNgoaiThanh($a = false){
			if ($a) {
				$sql = "SELECT * FROM duan WHERE is_featured != '1' ORDER BY vitrihienthi ASC LIMIT $a";
			} else {
				$sql = "SELECT * FROM duan WHERE is_featured != '1' ORDER BY vitrihienthi ASC";
			}
			$this->query($sql);
			$new = '';
			if($this->num_rows() != 0){
				while ($data = $this->fetch()) {
					$new[] = $data; 
				}
			}
			return $new;
		}

		public function getDuandautu(){
			$sql = "SELECT * FROM duan WHERE is_dautu = '1' ORDER BY vitrihienthi ASC LIMIT 9";
			$this->query($sql);
			$new = '';
			if($this->num_rows() != 0){
				while ($data = $this->fetch()) {
					$new[] = $data; 
				}
			}
			return $new;
		}

		public function getDuangiatot(){
			$sql = "SELECT * FROM duan WHERE is_giatot = '1' ORDER BY vitrihienthi ASC LIMIT 9";
			$this->query($sql);
			$new = '';
			if($this->num_rows() != 0){
				while ($data = $this->fetch()) {
					$new[] = $data; 
				}
			}
			return $new;
		}

		public function getDuanmoi(){
			$sql = "SELECT * FROM duan WHERE is_duanmoi = '1' ORDER BY vitrihienthi ASC LIMIT 9";
			$this->query($sql);
			$new = '';
			if($this->num_rows() != 0){
				while ($data = $this->fetch()) {
					$new[] = $data; 
				}
			}
			return $new;
		}

		public function checkImageExist($id = ''){
			$sql = "SELECT * FROM duan WHERE image='".$this->getImage()."' AND duan_id != '$id'";
			$this->query($sql);
			if($this->num_rows() != 0){
				return FALSE; // iamge title đã tồn tại
			}else{
				return TRUE; // image title chua co
			}
		}

		public function insert(){
			$sql = "INSERT INTO duan(title, image, description, detail, is_featured) values('".$this->getTitle()."', '".$this->getImage()."', '".$this->getDescription()."','".$this->getDetail()."', '".$this->getIsFeatured()."')";
			$this->query($sql);
		}

		public function update($id, $image=''){
			if($image != ''){
				$sql = "UPDATE duan SET image='".$this->getImage()."', description='".$this->getDescription()."', is_featured='".$this->getIsFeatured()."', title='".$this->getTitle()."', detail='".$this->getDetail()."' WHERE duan_id='".$id."'";
			}else{
				$sql = "UPDATE duan SET description='".$this->getDescription()."', is_featured='".$this->getIsFeatured()."', title='".$this->getTitle()."', detail='".$this->getDetail()."' WHERE duan_id='".$id."'";
			}
			$this->query($sql);
		}

		public function delete($id){
			$sql = "DELETE FROM duan WHERE duan_id=$id";
			$this->query($sql);
		}

	}
?>