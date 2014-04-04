<?php
		header("Content-type:text/html;charset=utf8");


		class log {
			
			protected $root = '';		//日志根目录
			protected $path = '';		//每天的日志目录
			protected $size = 0.3;		//单位MB
			protected $abpath = '';		//日志文件
			protected $log = '/tmp.log';	//临时存放文件
			protected $error = array(
						'1' => '目录出现问题'
			);
			
			/**
			 *		log类的构造函数，初始化
			 *		@Param	string 	$Froot		log文件根目录
			 */
			public function __construct($Froot = './'){
				$this -> save_root($Froot);		//设置日志根目录
				$this -> tmplog_path();			//设置日志临时文件
				$dirname = $this -> rand_dname();	//产生当天的日志目录
				if($this -> make_dir($this -> root.'/'.$dirname)){		//尝试创建当天的日志目录
					echo $this -> path,'成功';
				} else {
					echo $this -> path,'失败';
				}

			}

			/**
			 *	把日志写入文件中
			 *	@Param	string	$Fcont	要写入的内容
			 */
			public function write_data($Fcont){
				$aFcont = $Fcont."\r\n";				//添加换行
				if($rs = fopen($this -> log,'ab')){		//打开文件
					if($this -> check_file_size($this -> log)){			//检查文件大小
						if(fwrite( $rs, $aFcont)){			//符合规定大小则写入
							fclose($rs);
							echo '写入数据成功';
						} else{
							echo '写入数据失败';
						}
					} else{								//不符合则将临时文件放到指定位置，重新创建临时文件
						fclose($rs);
						$this ->abpath = $this -> make_file();
						$this -> rename();
					}
				} else {
					echo '打开文件失败';		
				}
			}

			/**
			 *		生成临时日志文件	
			 */
			public function tmplog_path(){
				$this -> log = $this -> root . '/'.'tmp.log';
			}

			/**
			 *		将临时文件放到指定位置
			 *		return bool 成功true 失败false
			 */
			public function rename(){
				//var_dump($this -> log);
				//var_dump($this ->abpath);
				return rename($this -> log,$this -> abpath)?true:false;
			}
			
			/**
			 *	生成文件名称
			 */
			public function  make_file(){
				$name = $this -> rand_fname();
				return $this -> abpath = $this -> path.'/'.$name.'.txt';				
			}

			/**
			 *	@Pram $Ffile	文件路径
			 */
			public function check_file_size($Ffile){
				return filesize($Ffile) <= $this -> size * 1024 * 1024 ? true:false;

			}
			
			/**
			 *	生成文件名称 141234 时分秒
			 */
			public function rand_fname(){
				return date('His');
			}

			/**
			 *	检查文件是否存在
			 *	return 2存在	$Fdir不存在
			 */
			public function check_dir ($Fdir) {
					clearstatcache();
					return is_dir($Fdir)?2:$Fdir;						
			}

			/**
			 *	创建日志文件存放目录
			 *	@Param string $Fwdir 文件存放目录	
			 */
			public function make_dir ($Fwdir) {
					$Ftdir = $Fwdir;
					$unc = $this ->check_dir($Fwdir);
					if($Ftdir == $unc ){		//如果目录不存在，则创建
						if($var = mkdir($Fwdir)){
							$this -> path = $Fwdir;
							return $Fwdir;
						} else {
							return false;
						}							//如果文件存在，则直接返回文件目录
					} else if($unc == 2) {													
						return $this -> path = $Ftdir;						
					}
			}
			/**
			 *	生成目录名称
			 */
			public function rand_dname () {
					return date(Ymd);
			}

			/**
			 *	@Param string $Froot
			 *	将根目录存放到类内
			 */
			public function save_root($Froot){
					$this -> root = $Froot;
			}

		}

		$a = new log('D:\wmp\www\file_os\log');
		$i = 0;
		
		while($i<9999){
		$a -> write_data('123');
		$i++;
		echo $i;
		}
		
		//$a -> write_data('qwe');
		//echo $a -> make_file();



?>