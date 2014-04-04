<?php
		/*class Human {
			static public $head = 1;
			function hu (){
				Human::$head = 2;
			}
			static public function cry(){
				echo '555';
			}
		}

		echo Human::hu();
		echo Human::cry();
	*/
	class danli {
		public $hash = 1;
		static protected $ins = NULL;					//只存在一个，不能只能本身修改或者继承者修改
		final protected function __construct(){			//final，防止继承过去开辟新实例
			$this->hash = mt_rand(0,10000);
		}
		static public function  newClass(){					//通过该方法来实例化一个类
			if(self::$ins instanceof self){
				return self::$ins;
			}
			return self::$ins = new self();
		}
	}
	
	class dlson extends danli {
	
	}
	//$a = new danli();

	$shili = danli::newClass();
	$shili1 = danli::newClass();
	print_r($shili);
	print_r($shili1);
	$shili2 = dlson::newClass();
	print_r($shili2);
?>