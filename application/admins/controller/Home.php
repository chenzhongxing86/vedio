<?php
  namespace app\admins\controller;
  use think\Controller;

  /**
   * 
   */
  class Home extends BaseAdmin{
    public function index(){
        return $this->fetch();
    }
    public function welcome(){
      return $this->fetch();
    }
  }
?>