<?php
namespace Admin\Model;

class PrizeModel extends BaseModel
{
    protected $tableName = 'prize';

    
    /**
     * @description:每页显示数目
     * @author wuyanwen(2016年12月1日)
     * @param unknown $num
     * @return multitype:unknown string
     */
    public function selectAllPrize($num=10){

        $where = array(
            'status' => 0,
        );
    
        $count      = $this->where($where)->count();
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $list       = $this->where($where)->limit($page->firstRow.','.$page->listRows)->select();
    
        return array('page' => $show , 'list' => $list);
    
    }
    
    /**
     * @description:添加奖品
     * @author
     * @param unknown $data
     * @return boolean
     */
    public function addPrize($data)
    {
        return $this->add($data) ? true : false;
    }
    
    /**
     * @description:更新奖品
     * @author
     * @param unknown $data
     */
    public function editPrize($data){
        $where = array(
            'id'    => $data['id'],
        );

        unset($data['id']);
        
        return $this->where($where)->save($data);
    }

    public function findPrizeById($prize_id){
        $where = array(
            'id' => $prize_id,
        );


        return $this->where($where)->find();
    }
    
    /**
     * @description:删除奖品
     * @author
     * @param unknown $prize_id
     * @return Ambigous <boolean, unknown>
     */
    public function deletePrize($prize_id){
        $where = array(
            'id' => $prize_id,
        );
        
        $data = array(
            'status' => parent::DEL_STATUS,
        );
        
        return $this->where($where)->save($data);
    }

    /**
     * @description 得到中奖列表
     * @auther
     *
     */
    public function getAllWinningList($num){
        $where = array(
            'W.status' => 0,
        );
        $count      = M("WinningList")->alias("W")->where($where)->count();
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $list       = M("WinningList")->field("W.*,P.pname")->alias('W')->join("LEFT JOIN ".C('DB_PREFIX')."prize P on(W.prize_id=P.id)")->where($where)->limit($page->firstRow.','.$page->listRows)->select();

        return array('page' => $show , 'list' => $list);
    }



}