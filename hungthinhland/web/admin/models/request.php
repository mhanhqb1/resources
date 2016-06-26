<?php
class REQUEST extends DATABASE{
	protected $_email;
	protected $_phone;
	protected $_company;
	protected $_name;
	protected $_subject;
	protected $_message;
	protected $_postTime;

	public function __construct(){
		$this->connect();	
	}

	public function setEmail($s){
		$this->_email = $s;
	}
	public function getEmail(){
		return $this->_email;
	}

	public function setPhone($s){
		$this->_phone = $s;
	}
	public function getPhone(){
		return $this->_phone;
	}

	public function setCompany($s){
		$this->_company = $s;
	}
	public function getCompany(){
		return $this->_company;
	}

	public function setName($s){
		$this->_name = $s;
	}
	public function getName(){
		return $this->_name;
	}

	public function setSubject($s){
		$this->_subject = $s;
	}
	public function getSubject(){
		return $this->_subject;
	}

	public function setMessage($s){
		$this->_message = $s;
	}
	public function getMessage(){
		return $this->_message;
	}

	public function setPostTime($s){
		$this->_postTime = $s;
	}
	public function getPostTime(){
		return $this->_postTime;
	}
	/*--------------------------FUNCITONS--------------------------*/

	public function listOne($id){
		$sql = "SELECT * FROM request WHERE id=$id";
		$this->query($sql);
		$data = '';
		if($this->num_rows() != 0){
			$data = $this->fetch();
		}
		return $data;
	}

	public function listAll(){
		$sql = "SELECT * FROM request ORDER BY id DESC";
		$this->query($sql);
		$request = '';
		if($this->num_rows() != 0){
			while ($data = $this->fetch()) {
				$request[] = $data; 
			}
		}
		return $request;
	}

	public function insert(){
		$sql = "INSERT INTO request(phone, post_time, name, message) values('".$this->getPhone()."''".$this->getPostTime()."', '".$this->getName()."', '".$this->getMessage()."')";
		$this->query($sql);
	}

	public function update($id){
		$sql = "UPDATE request SET phone='".$this->getPhone()."', post_time='".$this->getPostTime()."', name='".$this->getName()."', message='".$this->getMessage()."' WHERE id='".$id."'";
		$this->query($sql);
	}

	public function delete($id){
		$sql = "DELETE FROM request WHERE id=$id";
		$this->query($sql);
	}

}
?>