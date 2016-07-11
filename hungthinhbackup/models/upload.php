<?php
class UPLOAD extends DATABASE{
	protected $_filename;
	protected $_filetype;
	protected $_filetmp;
	protected $_filesize;
	/*
	public function __construct($data){
		$this->setName($data['name']);
		$this->setType($data['type']);
		$this->setTmp($data['tmp']);
		$this->setSize($data['size']);
	}*/
	
	public function __construct($name, $type, $tmp, $size){
		$this->setName($name);
		$this->setType($type);
		$this->setTmp($tmp);
		$this->setSize($size);
	}
	
	public function setName($name){
		$this->_filename = $name;	
	}
	public function getName(){
		return $this->_filename;	
	}
	
	
	public function setType($type){
		$this->_filetype = $type;	
	}
	public function getType(){
		return $this->_filetype;	
	}
	
	
	public function setTmp($tmp){
		$this->_filetmp = $tmp;	
	}
	public function getTmp(){
		return $this->_filetmp;	
	}
	
	
	public function setSize($size){
		$this->_filesize = $size;	
	}
	public function getSize(){
		return $this->_filesize;	
	}
	
	//upload/
	public function process($name, $dir){
		move_uploaded_file($this->getTmp(), $dir . $name);
	}
}