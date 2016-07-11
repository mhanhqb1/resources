<?php
	define('PAGE_LIMIT', 9);
	class DATABASE{
		protected $_hostname = "mysql4.000webhost.com";
		protected $_hostuser = "a1905214_ht";
		protected $_hostpass = "1Hoanganh";
		protected $_dbname = "a1905214_hthinh";
		protected $_connect;
		protected $_result;
		
		public function connect(){
			$this->_connect = mysql_connect($this->_hostname, $this->_hostuser, $this->_hostpass);
			mysql_select_db($this->_dbname, $this->_connect);
			mysql_set_charset('utf8',$this->_connect);
		}
		
		public function disconnect(){
			if($this->_connect){
				mysql_close($this->_connect);
			}
		}
		
		public function query($sql){
			$this->_result = mysql_query($sql);	
		}
		
		public function num_rows(){
			if($this->_result){
				$rows = mysql_num_rows($this->_result);	
			}else{
				$rows = 0;	
			}
			return $rows;
		}
		
		public function fetch(){
			if($this->_result){
				$rows = mysql_fetch_assoc($this->_result);	
			}else{
				$rows = 0;	
			}
			return $rows;
		}
	}

	function __autoload($class){
		require "models/".strtolower($class).".php";	
	}

	function convertURL($str)
	{
		$str = preg_replace("/(\,|-|\.)/", '', $str);
		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);
		$str = preg_replace('/\s+/', ' ', $str);
                $str = str_replace("/", "-", $str);
		$str = str_replace(" ", "-", $str);
		return strtolower($str);
	}

	function pagination($start,$limit,$data){
		$result = '';
		$count = 0;
		foreach ($data as $key => $value) {
			if($key >= $start && $count < $limit){
				$count++;
				$result[] = $value;
			}
		}
		return $result;
	}
?>