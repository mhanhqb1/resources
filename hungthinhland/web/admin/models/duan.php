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
		protected $_thongtin;
		protected $_vitri;
		protected $_tienich;
		protected $_matbang;
		protected $_tintuc;
		protected $_hinhanh;
		protected $_vitrihienthi;
		protected $_price;

		
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

		public function setThongtin($s){
			$this->_thongtin = $s;
		}
		public function getThongtin(){
			return $this->_thongtin;
		}

		public function setVitri($s){
			$this->_vitri = $s;
		}
		public function getVitri(){
			return $this->_vitri;
		}

		public function setTienich($s){
			$this->_tienich = $s;
		}
		public function getTienich(){
			return $this->_tienich;
		}

		public function setMatbang($s){
			$this->_matbang = $s;
		}
		public function getMatbang(){
			return $this->_matbang;
		}

		public function setTintuc($s){
			$this->_tintuc = $s;
		}
		public function getTintuc(){
			return $this->_tintuc;
		}

		public function setHinhanh($s){
			$this->_hinhanh = $s;
		}
		public function getHinhanh(){
			return $this->_hinhanh;
		}

		public function setVitrihienthi($s){
			$this->_vitrihienthi = $s;
		}
		public function getVitrihienthi(){
			return $this->_vitrihienthi;
		}

		public function setPrice($s){
			$this->_price = $s;
		}
		public function getPrice(){
			return $this->_price;
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
			$sql = "INSERT INTO duan(title, image, description, detail, is_featured, is_dautu, is_giatot, is_duanmoi, thongtin, vitri, tienich, matbang, tintuc, hinhanh, vitrihienthi, price) values('".$this->getTitle()."', '".$this->getImage()."', '".$this->getDescription()."','".$this->getDetail()."', '".$this->getIsFeatured()."', '".$this->getIsDautu()."', '".$this->getIsGiatot()."', '".$this->getIsMoi()."', '".$this->getThongtin()."', '".$this->getVitri()."', '".$this->getTienich()."', '".$this->getMatbang()."', '".$this->getTintuc()."', '".$this->getHinhanh()."', '".$this->getVitrihienthi()."', '".$this->getPrice()."')";
			$this->query($sql);
		}

		public function update($id, $image=''){
			if($image != ''){
				$sql = "UPDATE duan SET image='".$this->getImage()."', description='".$this->getDescription()."', is_featured='".$this->getIsFeatured()."', title='".$this->getTitle()."', detail='".$this->getDetail()."', is_dautu='".$this->getIsDautu()."', is_giatot='".$this->getIsGiatot()."', is_duanmoi='".$this->getIsMoi()."', thongtin='".$this->getThongtin()."', vitri='".$this->getVitri()."', tienich='".$this->getTienich()."', matbang='".$this->getMatbang()."', tintuc='".$this->getTintuc()."', hinhanh='".$this->getHinhanh()."', vitrihienthi='".$this->getVitrihienthi()."', price='".$this->getPrice()."' WHERE duan_id='".$id."'";
			}else{
				$sql = "UPDATE duan SET description='".$this->getDescription()."', is_featured='".$this->getIsFeatured()."', title='".$this->getTitle()."', detail='".$this->getDetail()."', is_dautu='".$this->getIsDautu()."', is_giatot='".$this->getIsGiatot()."', is_duanmoi='".$this->getIsMoi()."', thongtin='".$this->getThongtin()."', vitri='".$this->getVitri()."', tienich='".$this->getTienich()."', matbang='".$this->getMatbang()."', tintuc='".$this->getTintuc()."', hinhanh='".$this->getHinhanh()."', vitrihienthi='".$this->getVitrihienthi()."', price='".$this->getPrice()."' WHERE duan_id='".$id."'";
			}
			$this->query($sql);
		}

		public function delete($id){
			$sql = "DELETE FROM duan WHERE duan_id=$id";
			$this->query($sql);
		}

	}
?>