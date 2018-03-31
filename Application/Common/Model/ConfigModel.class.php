<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
* 配置项model
*/
class ConfigModel extends BaseModel{

    // // 自动验证
    // protected $_validate=array(
    //  array('old_password','require','原密码不能为空'),
    //  array('ADMIN_PASSWORD','require','新密码不能为空'),
    //  array('re_password','require','重复密码不能为空'),
    //  array('re_password','ADMIN_PASSWORD','两次密码不一致',0,'confirm'),
    //  );

    // 修改数据
    public function editData(){
        $data=I('post.');
    /*     p($data);die;*/
        foreach ($data as $k => $v) {
            $this->where(array('name'=>$k))->setField('value',$v);
            $data[$k]=htmlspecialchars_decode($v);
        }

        $this->where(array('name'=>'WEB_STATUS'))->setField('value',$data['WEB_STATUS']);
        $this->where(array("name"=>'TEXT_WATER_WORD'))->setField("value",$data['TEXT_WATER_WORD']);

        $data['WEB_STATISTICS']=str_replace( "'",'"',$data['WEB_STATISTICS']);
        $data['CHANGYAN_COMMENT']=str_replace( "'",'"',$data['CHANGYAN_COMMENT']);
        $data['CHANGYAN_COMMENT']=str_replace( '<div id="SOHUCS"></div>','',$data['CHANGYAN_COMMENT']);
        return true;
    }

    // 获取全部数据
    public function getAllData(){
        return $this->getField('name,value');
    }

    // 修改密码
    public function changePassword(){
        $data=I('post.');
        if($data['ADMIN_PASSWORD']==$data['re_password']){
            $old_password=$this->getFieldByName('ADMIN_PASSWORD','value');
            if(md5($data['old_password'])==$old_password){
                $password=md5($data['ADMIN_PASSWORD']);
                $this->where(array('name'=>'ADMIN_PASSWORD'))->setField('value',$password);
                return true;
            }else{
                $this->error='原密码输入错误';
            }
        }else{
            $this->error='两次密码不一致';
            return false;
        }
    }
}
