<?php
class INTRODUCTION extends DATABASE{
	protected $_content;
	protected $_isActived;

	public function __construct(){
		$this->connect();	
	}

	public function setIsActived($s){
		$this->_isActived = $s;
	}
	public function getIsActived(){
		return $this->_isActived;
	}

	public function setContent($s){
		$this->_content = $s;
	}
	public function getContent(){
		return $this->_content;
	}
	/*--------------------------FUNCITONS--------------------------*/

	public function listOne($id){
		$sql = "SELECT * FROM introduction WHERE id=$id";
		$this->query($sql);
		$data = '';
		if($this->num_rows() != 0){
			$data = $this->fetch();
		}
		return $data;
	}

	public function listAll(){
			$sql = "SELECT * FROM introduction ORDER BY id DESC";
			$this->query($sql);
			$introduction = '';
			if($this->num_rows() != 0){
				while ($data = $this->fetch()) {
					$introduction[] = $data; 
				}
			}
			return $introduction;
		}

	public function insert(){
		$sql = "INSERT INTO introduction(content, is_actived) values('".$this->getContent()."', '".$this->getIsActived()."')";
		$this->query($sql);
	}

	public function update($id){
		$sql = "UPDATE introduction SET content='".$this->getContent()."', is_actived='".$this->getIsActived()."' WHERE id='".$id."'";
		$this->query($sql);
	}

	public function delete($id){
		$sql = "DELETE FROM introduction WHERE id=$id";
		$this->query($sql);
	}

}
?>