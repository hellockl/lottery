<?php
namespace Home\Model;
use Think\Model;

class PrizeModel extends Model
{
    protected $tableName = 'prize';

    
    /**
     * @description:每页显示数目
     * @author
     * @return multitype:unknown string
     */
    public function selectAllPrize(){

        $where = array(
            'status' => 0,
        );

        $list = $this->field('id,pname,pimg,num,chance,level,pre_win')->where($where)->select();
    
        return $list;
    
    }

    /**
     * 用户中奖
     * */
    public function getWinPrize($phone,$openid,$prize_id){
        $num = $this->where('id='.$prize_id)->getField('num');
        if($num<=0){
            return false;
        }

        $this->startTrans();
        $res_a = $this->prizeNumDec($prize_id);
        $data = array(
          'phone'=>$phone,
          'prize_id'=>$prize_id,
          'openid'=>$openid,
          'create_time'=>time()
        );
        $res_b = $this->addWinningList($data);

        if($res_a&&$res_b){
            $this->commit();
            return true;
        }else{
            $this->rollback();
            return false;
        }
    }


    /**
     *奖品数量减一
     *
     *
     */
    public function prizeNumDec($id){
        $where['id']= $id;
        return $this->where($where)->setDec('num');
    }


    /**
     * 添加中奖信息
     *
     */
    public function addWinningList($data){

        return M("WinningList")->add($data);
    }

    public function findWinByPhone($phone){
        $where['phone'] = $phone;
        $where['status'] = 0;
        return M('WinningList')->where($where)->find()?true:false;
    }
    

    

}