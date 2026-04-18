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
		
	// 角色添加
	public function add(){
		$gid = (int)input('get.gid');
		$role = $this->db->table('admin_groups')->where(array('gid'=>$gid))->item();
		$role && $role['rights'] && $role['rights'] = json_decode($role['rights']);
		$this->assign('role',$role);
		$menu_list = $this->db->table('admin_menus')->where(array('status'=>0))->cates('mid');
		$menus = $this->getTreeItems($menu_list);
		$results = array();
		foreach($menus as $value){
			$value['children'] = isset($value['children']) ? $this->formatMenus($value['children']) : false;
			$results[] = $value;
		}
		$this->assign('menus',$results);
		return $this->fetch();
	}
	// 把平铺数组 → 转成 树形结构（无限级）
	private function getTreeItems($items){
		$tree = array();
		foreach($items as $item){
			if(isset($items[$item['pid']])){
				$items[$item['pid']]['children'][] = &$items[$item['mid']];
			}else{
				$tree[] = &$items[$item['mid']];
			}
		}
		return $tree;
	}
	
	// 格式化：把 children 里的多级菜单，全部扁平化
	private function formatMenus($items,&$res = array()){
		foreach($items as $item){
			if(!isset($item['children'])){
				$res[] = $item;
			}else{
				$tem = $item['children'];
				unset($item['children']);
				$res[] = $item;
				$this->formatMenus($tem, $res);
			}
		}
		return $res;
	}
	
	public function save(){
		$gid = (int)input('post.gid');
		$data['title'] = trim(input('post.title'));
		$menus = input('post.menu/a');
		if(!$data['title']){
			exit(json_encode(array('code'=>1,'msg'=>'角色名称不能为空')));
		}
		// 如果有权限，就转成JSON存到字段里
		$menus && $data['rights'] = json_encode(array_keys($menus));
		if($gid){
			$this->db->table('admin_groups')->where(array('gid'=>$gid))->update($data);
		}else{
			$this->db->table('admin_groups')->insert($data);
		}
		
		exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
	}
	// 删除
	public function delete(){
		$gid = input('post.gid');
		$this->db->table('admin_groups')->where(array('gid'=>$gid))->delete();
		exit(json_encode(array('code'=>0,'msg'=>'删除成功')));
	}
}
?>