<?php
	header("Content-type:text/html;charset=utf8");

	
	class a {
		public $q = '1';
		public $f = '2';

		function __construct(){
			echo $this -> q;
		}

		public function w(){
			if(isset($this -> f)){
				echo 'f存在';
				unset($this -> f);
			} else {
				echo 'f变量不存在';
			}
		}
	}

	$z = new a();
	$z->w(); 

?>