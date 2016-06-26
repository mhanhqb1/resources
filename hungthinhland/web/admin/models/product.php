<?php
	class PRODUCT extends DATABASE{
		protected $_name;
		protected $_price;
		protected $_description;
		protected $_detail;
		protected $_image;
		protected $_isActived;
		protected $_isFeatured;
		protected $_cateId;
		
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

		public function setPrice($p){
			$this->_price = $p;
		}
		public function getPrice(){
			return $this->_price;
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

		public function setIsActived($s){
			$this->_isActived = $s;
		}
		public function getIsActived(){
			return $this->_isActived;
		}

		public function setIsFeatured($s){
			$this->_isFeatured = $s;
		}
		public function getIsFeatured(){
			return $this->_isFeatured;
		}

		public function setCateId($s){
			$this->_cateId = $s;
		}
		public function getCateId(){
			return $this->_cateId;
		}
		/*--------------------------FUNCITONS--------------------------*/

		public function listOne($id){
			$sql = "SELECT * FROM products WHERE products_id=$id";
			$this->query($sql);
			$data = '';
			if($this->num_rows() != 0){
				$data = $this->fetch();
			}
			return $data;
		}

		public function listAll(){
			$sql = "SELECT * FROM products INNER JOIN cate ON products.cate_id=cate.cate_id ORDER BY products_id DESC";
			$this->query($sql);
			$product = '';
			if($this->num_rows() != 0){
				while ($data = $this->fetch()) {
					$product[] = $data; 
				}
			}
			return $product;
		}

		public function listCate(){
			$sql = "SELECT * FROM cate ORDER BY cate_id DESC";
			$this->query($sql);
			$product = '';
			if($this->num_rows() != 0){
				while ($data = $this->fetch()) {
					$product[] = $data; 
				}
			}
			return $product;
		}

		public function checkImageExist($id = ''){
			$sql = "SELECT * FROM products WHERE image='".$this->getImage()."' AND products_id != '$id'";
			$this->query($sql);
			if($this->num_rows() != 0){
				return FALSE; // iamge name đã tồn tại
			}else{
				return TRUE; // image name chua co
			}
		}

		public function insert(){
			$sql = "INSERT INTO products(name, price, image, description, detail, is_actived, is_featured, cate_id) values('".$this->getName()."','".$this->getPrice()."','".$this->getImage()."', '".$this->getDescription()."','".$this->getDetail()."', '".$this->getIsActived()."','".$this->getIsFeatured()."','".$this->getCateId()."')";
			$this->query($sql);
		}

		public function update($id, $image=''){
			if($image != ''){
				$sql = "UPDATE products SET image='".$this->getImage()."', description='".$this->getDescription()."', is_actived='".$this->getIsActived()."', is_featured='".$this->getIsFeatured()."', name='".$this->getName()."', price='".$this->getPrice()."', detail='".$this->getDetail()."', cate_id='".$this->getCateId()."' WHERE products_id='".$id."'";
			}else{
				$sql = "UPDATE products SET description='".$this->getDescription()."', is_actived='".$this->getIsActived()."', is_featured='".$this->getIsFeatured()."', name='".$this->getName()."', price='".$this->getPrice()."', detail='".$this->getDetail()."', cate_id='".$this->getCateId()."' WHERE products_id='".$id."'";
			}
			$this->query($sql);
		}

		public function delete($id){
			$sql = "DELETE FROM products WHERE products_id=$id";
			$this->query($sql);
		}

	}
?>