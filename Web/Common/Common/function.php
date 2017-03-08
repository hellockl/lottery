<?php
/**
 * description: 递归菜单
 * @author: wuyanwen(2016年8月7日)
 * @param unknown $array
 * @param number $fid
 * @param number $level
 * @param number $type 1:顺序菜单 2树状菜单
 * @return multitype:number
 */
function get_column($array,$type=1,$fid=0,$level=0)
{
    $column = [];
    if($type == 2)
        foreach($array as $key => $vo){
        if($vo['pid'] == $fid){
            $vo['level'] = $level;
            $column[$key] = $vo;
            $column [$key][$vo['id']] = get_column($array,$type=2,$vo['id'],$level+1);
        }
    }else{
        foreach($array as $key => $vo){
            if($vo['pid'] == $fid){
                $vo['level'] = $level;
                $column[] = $vo;
                $column = array_merge($column, get_column($array,$type=1,$vo['id'],$level+1));
            }
        }
    }
    
    return $column;
}


/**
 * 经典的概率算法， 
 * $proArr是一个预先设置的数组， 
 * 假设数组为：array(100,200,300，400)， 
 * 开始是从1,1000 这个概率范围内筛选第一个数是否在他的出现概率范围之内，  
 * 如果不在，则将概率空间，也就是k的值减去刚刚的那个数字的概率空间， 
 * 在本例当中就是减去100，也就是说第二个数是在1，900这个范围内筛选的。 
 * 这样 筛选到最终，总会有一个数满足要求。 
 * 就相当于去一个箱子里摸东西， 
 * 第一个不是，第二个不是，第三个还不是，那最后一个一定是。 
 * 这个算法简单，而且效率非常 高， 
 * 关键是这个算法已在我们以前的项目中有应用，尤其是大数据量的项目中效率非常棒。 
 */  
function get_rand($proArr) {   
	
    $result = '';    
    //概率数组的总概率精度
	$proSum = 0;
	foreach($proArr as $k=>$v){
		$proSum +=$v['v'];
		
	}
    //$proSum = array_sum($proArr);  
	
    //概率数组循环   
    foreach ($proArr as $key => $proCur) {   
	
        $randNum = mt_rand(1, $proSum);   
        if ($randNum <= $proCur['v']) {   
            $result = $key;   
            break;   
        } else {   
            $proSum -= $proCur['v'];   
        }         
    }
	
	if($proArr[$result]['n']==0){
		return get_rand($proArr);
	}else{
		unset ($proArr);    
		return $result; 
	}
      
}   