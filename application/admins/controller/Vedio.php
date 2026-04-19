<?php
/**
 * 影片管理
 */
namespace app\admins\controller;
use app\admins\controller\BaseAdmin;

class Vedio extends BaseAdmin{
	
	// 影片列表
	public function index(){
		$data['pageSize']  =15;
		$data['page'] = max(1,(int)input('get.page'));
		$where = array();
		$data['data'] = $this->db->table('vedio')->where($where)->pages($data['pageSize']);
		dump($data);
		$this->assign('data',$data);
		return $this->fetch();
	}
	// 添加影片
	public function add(){
		$data['channel'] = $this->db->table('vedio_label')->where(array('flag'=>'channel'))->lists();
		$data['charge'] = $this->db->table('vedio_label')->where(array('flag'=>'charge'))->lists();
		$data['area'] = $this->db->table('vedio_label')->where(array('flag'=>'area'))->lists();
		
		$id = (int)input('get.id');
		$data['item'] = $this->db->table('vedio')->where(array('id'=>$id))->item();
		$this->assign('data',$data);
	    return $this->fetch();
	}
	// 保存
	public function save(){
		$id = (int)input('post.id');
		$data['title'] = trim(input('post.title'));
		$data['channel_id'] = (int)input('post.channel_id');
		$data['charge_id'] = (int)input('post.charge_id');
		$data['area_id'] = (int)input('post.area_id');
		$data['img'] = trim(input('post.img'));
		$data['url'] = trim(input('post.url'));
		$data['keywords'] = trim(input('post.keywords'));
		$data['desc'] = trim(input('post.desc'));
		$data['status'] = (int)input('post.status');
		if($data['title'] == ''){
			exit(json_encode(array('code'=>0,'msg'=>'影片名称不能为空')));
		}
		if($data['url'] == ''){
			exit(json_encode(array('code'=>0,'msg'=>'影片地址不能为空')));
		}
		
		if($id){
			$this->db->table('vedio')->where(array('id'=>$id))->update($data);
		}else{
			$data['add_time'] = time();
			$this->db->table('vedio')->insert($data);
		}
		exit(json_encode(array('code'=>0,'msg'=>'保存成功')));
	}
	
	//图片上传
	public function upload_img(){
		$file = request()->file('file');
		if($file == null){
			exit(json_array(array('code'=>1,"msg"=>'没有文件上传')));
		}
		$info = $file->move(ROOT_PATH.'public'.DS.'uploads');
		$ext = ($info->getExtension());
		if(!in_array($ext,array('jpg','jpeg','gif','png'))){
			exit(json_encode(array('code'=>1,'msg'=>'文件格式不支持')));
		}
		$img = '/uploads/'.$info->getSaveName();
		exit(json_encode(array('code'=>0,'msg'=>$img)));
	}
}
?>