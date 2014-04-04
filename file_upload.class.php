<?php
		header("Content-type:text/html;charset=utf-8");
		class FileUpload {
			public $data = array();
			protected $file_type = array('jpg','jpeg','ico','icon','txt','php','bat');
			public $file_max_size = 1;		//单位MB
			public $str = 'QWERTYUIOPASDFGHJKZXCVBNMqwertyuiopasdfghjkzxcvbnm23456789';
			protected $rootdir = NULL;
			protected $errinfo = NULL;
			protected $error = array(
										'0' => '文件上传成功',
										'1' => '上传的文件超过了 php.ini ',
										'2' => '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值',
										'3' => '文件只有部分被上传',
										'4' => '没有文件被上传',
										'5' => '文件写入失败',
										'6' => '不合法的文件后缀',
										'7' => '超过系统规定文件大小'
			);

			/*
				构造函数，
				@$file 前台获取到的文件信息数据，$_FILES	
				功能:把超级全局$_FILES数据传递到类内
			*/
			public function __construct($file){
				//var_dump($file);
				if(isset($file)){
					$this -> data['name']		= $file['name'];
					$this -> data['tmp_name']   = $file['tmp_name'];
					$this -> data['error']		= $file['error'];
					$this -> data['size']		= $file['size'];
				} else {
					echo $this ->file_error(4);
					return false;
				}
			}
			
			/*
					文件上传类总流程
			*/
			public function upload_file(){
				if(!$this->check_file_ext($this -> data['name'])){
					return false;
				}

				if(!$this->check_file_size($this -> data['size'])){
					return false;
				}

				if($this -> move_file()){
					return true;
				} else {
					return false;
				}
			}
			
			/*
				创建文件所在目录
				*/
			public function make_file_dir($str){

				$randstr = date('Ymd').substr(str_shuffle($str),0,6);
				$root = $this -> rootdir.'\\'.$randstr;
				if(!file_exists($root)){
					if(mkdir($root)){
						return $root.'\\'.$this -> data['name'];
					}
				}
				return false;
			}
			
			/*
						设置文件上传的根目录
			*/
			public function set_file_rootdir($rootdir){
				return $this -> rootdir = $rootdir;
			}
			
			/*
					移动文件到指定目录
			*/
			public function move_file(){
				if($file = $this -> make_file_dir($this -> str)){
					if(move_uploaded_file($this -> data['tmp_name'],$file)){
						echo $this ->file_error(0);
						return true;
					} else {
						echo $this ->file_error(5);
						return false;
					}
				}

			}

			/*
					检查文件大小是否符合规定大小
					$filesize 文件实际大小	单位：Byte
					return bool
			*/
			public function check_file_size($filesize){				
				if($filesize <= ($this -> file_max_size * 1024 *1024)){
					return true;
				} else {
					echo $this ->file_error(7);
					return false;
				}
			}

			/*
					检查文件后缀是否符合系统规定
			*/
			public function check_file_ext ($filename) {
				$ext = $this -> get_file_ext($filename);
				if($ext){
					foreach($this -> file_type as $val){
						if($ext == $val){
							return true;
						} else {
							continue;
						}
					}
					echo $this ->file_error(6);
					return false;
				}

			}

			/*
				获取文件后缀
				@$filename 文件全名		格式：文件名.后缀名	
				返回后缀或false
			*/
			public function get_file_ext($filename){
				if($tmp = pathinfo($filename)){
					$ext = $tmp['extension'];
					return $ext;
				}	else {
					echo $this ->file_error(6);
					return false;
				}				
			}

			public function file_error($errcode){
				return $this -> errinfo = $this -> error[$errcode];
			}


		}


		$file = new FileUpload($_FILES['abc']);
		$file -> set_file_rootdir('D:\wmp\www\file_os\save');
		$file -> upload_file();

?>