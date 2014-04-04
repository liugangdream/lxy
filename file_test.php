<?php
	//echo __FILE__;
	//echo __dir__;

	//$handle = opendir(__dir__);
	/*
	$dir = 'hello';
	if(mkdir(__dir__.'/'.$dir)){
		echo "创建目录成功","<br />";
	} else {
		if(rmdir($dir)){
			echo "删除",$dir,"目录成功","<br />";
		} else
		echo "创建目录失败","<br />";
	}
	*/
	
	$mulu = __dir__;
	eachdir($mulu,1);

	/*
		遍历目录
	*/

	function eachdir ($hl,$lev){
		$handle = opendir($hl);
		echo $lev,"<br />";
		while(($dir = readdir($handle)) !== false){;
			if($dir == '.' || $dir == '..'){
				continue;
			}
			echo '├'.str_repeat('─',$lev);
			if(is_dir($hl.'\\'.$dir) !== false){
				//echo $dir,'<br / >';				
				echo $dir,'目录','<br / >';
				eachdir($hl.'\\'.$dir,$lev + 1);
			} else{
				echo $dir,'文件','<br />';
			}
		}
	}
/*
	$mulu = __dir__;
	//$handle = opendir($mulu);
	 function myscandir($pathname){
        foreach( glob($pathname) as $filename ){
            if(is_dir($filename)){
                myscandir($filename.'/*');
            }else{
                echo $filename.'<br/>';
            }
        }
    }
	myscandir($mulu);
*/
?>