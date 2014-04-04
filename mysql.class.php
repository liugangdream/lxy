<?php
		header("Content-type:text/html;charset=utf8");


/*
			未完成，待SQL拼接类完成再写
*/
		class mysql {
				protected $host = '';
				protected $root = '';
				protected $password = '';
				protected $conn = '';
				protected $error = array(
									'0' => '成功';
									'1' => '链接服务器失败';
									'2' => '选择数据库失败';
									'3' => '执行SQL语句失败'
				);

				public function __construct ($host,$root,$password){
					$this -> host = $host;
					$this -> root = $root;
					$this -> password = $password;
				}
		
				public function connect() {
					if($conn = mysql_connect($this -> host, $this -> root, $this -> password)){
						return $conn;
					} else {
						return false;
					}
				}

				public function query($sql) {
					if($rs = mysql_query($sql,$this -> conn)){
						return $rs;	
					} else {
						return false;
					}
				}

				public function close() {
					mysql_close($this -> conn);
				}
		
		}




?>