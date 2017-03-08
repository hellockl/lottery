<?php
namespace Admin\Controller;

class LotteryController extends CommonController{

    protected   $prize_model;
    protected   $winning_list_model;

    public function __construct(){
        parent::__construct();
        $prize_model = D('Prize');

        $this->prize_model = $prize_model;

    }

    /**
     * @description:大转盘-奖品列表
     * @author ckl
     */
    public function index(){

        $prize_list = $this->prize_model->selectAllPrize(10);
        $this->assign('prize_list',$prize_list['list']);
        $this->assign('page',$prize_list['page']);
        $this->display();
    }


    /**
     * @description  大转盘-添加奖品
     * @author ckl
     *
     */
    public function addPrize(){
        if(IS_POST){
            $data = I('post.');
            if($this->prize_model->addPrize($data)){
                $this->ajaxSuccess("奖品添加成功");
            }else{
                $this->ajaxError("奖品添加失败");
            }
        }else{
            $this->display();
        }

    }

    public function editPrize(){
        if(IS_POST){
            $data = I('post.');
            $data_info = array(
                'id'=>$data['id'],
                'pname' => $data['pname'],
                'pimg' => $data['pimg'],
                'level' => $data['level'],
                'chance' => $data['chance'],
            );
            if($this->prize_model->editPrize($data_info) !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $id = I('get.id',0,'intval');
            $prize_info = $this->prize_model->findPriceById($id);
            $this->assign("prize_info",$prize_info);
            $this->display();
        }
    }


    public function upload(){
        if(IS_POST){
            $img = $_FILES['file'];

            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   = 3145728 ;// 设置附件上传大小
            $upload->exts      = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  = './Public/'; // 设置附件上传根目录
            $upload->savePath  = 'upload/'; // 设置附件上传（子）目录
            // 上传文件
            $info   =   $upload->uploadOne($img);


            if(!$info) {// 上传错误提示错误信息
                echo json_encode(array('status' => 'error','msg' => $upload->getError()));
                exit;
            }else{// 上传成功

                $imgpath = $info['savepath'].$info['savename'];
                echo json_encode(array('status' => 'success','url'=>'/Public/'.$imgpath));
                exit;
            }

        }else{
            $this->display();
        }
    }

    /**
     * @description  大转盘-中奖列表
     * @author ckl
     * 
     */
    public function winningList(){
        $winning_list  = $this->prize_model->getAllWinningList();
        $this->assign('winning_list',$winning_list['list']);
        $this->assign('page',$winning_list['page']);
        $this->display();
    }


}