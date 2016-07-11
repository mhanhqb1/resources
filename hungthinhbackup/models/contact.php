<?php
class CONTACT extends DATABASE{
	protected $_email;
	protected $_phone;
	protected $_address;
	protected $_isActived;
	protected $_name;
	protected $_facebook;
	protected $_twitter;
	protected $_intagram;
	protected $_yahoo;
	protected $_skype;

	public function __construct(){
		$this->connect();	
	}

	public function setIsActived($s){
		$this->_isActived = $s;
	}
	public function getIsActived(){
		return $this->_isActived;
	}

	public function setEmail($s){
		$this->_email = $s;
	}
	public function getEmail(){
		return $this->_email;
	}

	public function setName($s){
		$this->_name = $s;
	}
	public function getName(){
		return $this->_name;
	}

	public function setFacebook($s){
		$this->_facebook = $s;
	}
	public function getFacebook(){
		return $this->_facebook;
	}

	public function setTwitter($s){
		$this->_twitter = $s;
	}
	public function getTwitter(){
		return $this->_twitter;
	}

	public function setIntagram($s){
		$this->_intagram = $s;
	}
	public function getIntagram(){
		return $this->_intagram;
	}

	public function setPhone($s){
		$this->_phone = $s;
	}
	public function getPhone(){
		return $this->_phone;
	}

	public function setAddress($s){
		$this->_address = $s;
	}
	public function getAddress(){
		return $this->_address;
	}

	public function setYahoo($s){
		$this->_yahoo = $s;
	}
	public function getYahoo(){
		return $this->_yahoo;
	}

	public function setSkype($s){
		$this->_skype = $s;
	}
	public function getSkype(){
		return $this->_skype;
	}
	/*--------------------------FUNCITONS--------------------------*/

	public function listOne($id){
		$sql = "SELECT * FROM contact WHERE id=$id";
		$this->query($sql);
		$data = '';
		if($this->num_rows() != 0){
			$data = $this->fetch();
		}
		return $data;
	}

	public function listAll(){
		$sql = "SELECT * FROM contact WHERE is_actived = '1' ORDER BY id DESC LIMIT 1";
		$this->query($sql);
		$data = '';
		if($this->num_rows() != 0){
			$data = $this->fetch();
		}
		return $data;
	}

	public function insert(){
		$sql = "INSERT INTO contact(email, phone, address, is_actived, name, facebook, twitter, intagram, yahoo, skype) values('".$this->getEmail()."', '".$this->getPhone()."', '".$this->getAddress()."', '".$this->getIsActived()."', '".$this->getName()."', '".$this->getFacebook()."', '".$this->getTwitter()."', '".$this->getIntagram()."', '".$this->getYahoo()."', '".$this->getSkype()."')";
		$this->query($sql);
	}

	public function update($id){
		$sql = "UPDATE contact SET email='".$this->getEmail()."', phone='".$this->getPhone()."', address='".$this->getAddress()."', is_actived='".$this->getIsActived()."', name='".$this->getName()."', facebook='".$this->getFacebook()."', twitter='".$this->getTwitter()."', intagram='".$this->getIntagram()."', yahoo='".$this->getYahoo()."', skype='".$this->getSkype()."' WHERE id='".$id."'";
		$this->query($sql);
	}

	public function delete($id){
		$sql = "DELETE FROM contact WHERE id=$id";
		$this->query($sql);
	}

}
?>