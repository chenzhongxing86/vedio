<?php
  namespace app\admins\controller;
  use think\Controller;
  use Util\data\Sysdb;

  /**
   * 角色管理
   */
  class Roles extends BaseAdmin{
	  
	  // 角色列表
	 public function index(){
		 $data['roles'] = $this->db->table('admin_groups')->lists();
		 $this->assign('data',$data);
		 return $this->fetch();
		}
	}
?>