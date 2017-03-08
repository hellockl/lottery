<?php
namespace Home\Controller;
use Think\Controller;
class ApiController extends Controller {
	
	/*大转盘抽奖*/
    public function lottery(){
        /**
		 * 奖项数组 
		 * 是一个二维数组，记录了所有本次抽奖的奖项信息， 
		 * 其中id表示中奖等级，prize表示奖品，v表示中奖概率。 
		 * 注意其中的v必须为整数，你可以将对应的 奖项的v设置成0，即意味着该奖项抽中的几率是0， 
		 * 数组中v的总和（基数），基数越大越能体现概率的准确性。 
		 * 本例中v的总和为100，那么平板电脑对应的 中奖概率就是1%， 
		 * 如果v的总和是10000，那中奖概率就是万分之一了。 
		 *  
		 */  
		$prize_arr = array(   
			'0' => array('id'=>1,'num'=>0,'prize'=>'平板电脑','v'=>50),   
			'1' => array('id'=>2,'num'=>0,'num'=>1,'prize'=>'数码相机','v'=>0),   
			'2' => array('id'=>3,'num'=>0,'prize'=>'音箱设备','v'=>0),   
			'3' => array('id'=>4,'num'=>0,'prize'=>'4G优盘','v'=>0),   
			'4' => array('id'=>5,'num'=>0,'prize'=>'10Q币','v'=>0),   
			'5' => array('id'=>6,'num'=>100,'prize'=>'下次没准就能中哦','v'=>50),   
		);   
		  
		/* 
		 * 每次前端页面的请求，PHP循环奖项设置数组， 
		 * 通过概率计算函数get_rand获取抽中的奖项id。 
		 * 将中奖奖品保存在数组$res['yes']中， 
		 * 而剩下的未中奖的信息保存在$res['no']中， 
		 * 最后输出json个数数据给前端页面。 
		 */  
		foreach ($prize_arr as $key => $val) {   
			$arr[$val['id']]['v'] = $val['v'];
			$arr[$val['id']]['n'] = $val['num'];			
		}   
		$rid = get_rand($arr); //根据概率获取奖项id   
		
		$res['yes'] = $prize_arr[$rid-1]['prize']; //中奖项   
		unset($prize_arr[$rid-1]); //将中奖项从数组中剔除，剩下未中奖项   
		shuffle($prize_arr); //打乱数组顺序   
		for($i=0;$i<count($prize_arr);$i++){   
			$pr[] = $prize_arr[$i]['prize'];   
		}   
		$res['no'] = $pr;   
		print_r($res);  
    }
}