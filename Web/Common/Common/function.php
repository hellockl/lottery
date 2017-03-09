<?php
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
        //var_dump($proArr);
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur['v']) {
                $result = $proCur['id'];
                $k = $key;
                break;
            } else {
                $proSum -= $proCur['v'];
            }
        }

        if($proArr[$k]['n']==0){
            return get_rand($proArr);
        }else{
            unset ($proArr);
            return $result;
        }

    }

    function noWin($arr){
        $res['win']['pname'] = $arr[0]['pname']; //中奖奖品名
        $res['win']['id'] = $arr[0]['id']; //中奖奖品ID
        $arr = array('errorCode'=>1,'errorMsg'=>'未中奖','data'=>$res);
        return $arr;
    }


