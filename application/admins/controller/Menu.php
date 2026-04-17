<?php
  namespace app\admins\controller;
  use think\Controller;
  use Util\data\Sysdb;

  /**
   * 管理员管理
   */
  class Menu extends BaseAdmin{
	 public function index(){
		return $this->fetch();
	 }
  }
?>