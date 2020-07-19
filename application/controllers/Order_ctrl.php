<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('./application/libraries/base_ctrl.php');
class Order_ctrl extends base_ctrl {
	function __construct() {
		parent::__construct();		
	    $this->load->model('Order_model','model');
	    $this->load->model('Order_Detail_model','order_detail_model');
		$this->load->model('Users_model','model1');
		$this->load->model('Product_model','product');
		$this->load->model('manufacture_model','manufacture');
	}
	public function index()
	{

		if($this->is_authentic($this->auth->RoleId, $this->user->UserId, 'Users')){
			$data['fx']='return '.json_encode(array("insert"=>$this->auth->IsInsert==="1","update"=>$this->auth->IsUpdate==="1","delete"=>$this->auth->IsDelete==="1"));
			$data['read']=$this->auth->IsRead;
			$this->load->view('Order_view', $data);
		}
		else
		{
			$this->load->view('forbidden');
		}
	}

	public function save()
	{
		$data=$this->post();
		$success=FALSE;
		$msg= 'You are not permitted.';
		$id=0;
		if(!isset($data->MenuId))
		{
			if(isset($data->baseimage) !=null){
		 		$new_data=explode(",",$data->baseimage);
		        $exten=explode('/',$new_data[0]);
	            $exten1=explode(';',$exten[1]);
	            $decoded=base64_decode($new_data[1]);
	            $img_name='img_'.uniqid().'.'.$exten1[0];
	            file_put_contents(APPPATH.'../uploads/menu/'.$img_name,$decoded);
	            $data->Image=$img_name;
	            $data->Status= 1;
		        unset($data->baseimage);
		        unset($data->image);
	    	}

			if($this->auth->IsInsert){
				$id=$this->model->add($data);
				$msg='Data inserted successfully';
				$success=TRUE;
			}
					
		}
		else{
			if($this->auth->IsUpdate){

			if(isset($data->baseimage) !=null){
		 		$new_data=explode(",",$data->baseimage);
		        $exten=explode('/',$new_data[0]);
	            $exten1=explode(';',$exten[1]);
	            $decoded=base64_decode($new_data[1]);
	            $img_name='img_'.uniqid().'.'.$exten1[0];
	            file_put_contents(APPPATH.'../uploads/menu/'.$img_name,$decoded);
	            $data->Image=$img_name;
		        unset($data->baseimage);
	        }
		        unset($data->catName);
//print_r($data)
				$id=$this->model->update($data->MenuId, $data);
				$success=TRUE;
				$msg='Data updated successfully';				
			}		
		}
		print json_encode(array('success'=>$success, 'msg'=>$msg, 'id'=>$id));
	}

	public function delete()
	{
		if($this->auth->IsDelete){
			$data=$this->post();
			print json_encode( array("success"=>TRUE,"msg"=>$this->model->delete($data->id)));
		}
		else{
			print json_encode( array("success"=>FALSE,"msg"=>"You are not permitted"));
		}
	}
	public function get_Category_list(){
		print  json_encode($this->model->get_Category_list());
	}
public function get_Navigations_list(){
		print  json_encode($this->model->get_Navigations_list());
	}
	
	public function get()
	{	
		$data=$this->post();
		print json_encode($this->model->get($data->UserId));
	}
	public function get_all()
	{		
		print json_encode($this->model->get_all());
	}
	public function get_all_user()
	{		
		print json_encode($this->model1->get_all_users());
	}
	public function get_order_detail()
	{		
		$data=$this->post();
		print json_encode($this->order_detail_model->get_order_detail($data));
	}
	public function get_page()
	{	
		$data=$this->post();

		if($data->pageType =='OrderItem'){

			print json_encode($this->order_detail_model->get_page($data->size, $data->pageno,$data));
		}else{
			print json_encode($this->model->get_page($data->size, $data->pageno,$data));
		}

		// $data_array=$this->model->get_page($data->size, $data->pageno,$data);
		// // echo "<pre>";
		// // 	print_r($data_array);
		// // 	exit;
		// foreach($data_array['data'] as $key =>$val){
		// 	$product_array=(array)json_decode($val->JsonDetails);
		// 	foreach($product_array as $pkey =>$pval){
		// 		// $pval=(array)$pval;
		// 	// 	echo "<pre>";
		// 		$pval->merchant=$this->model1->getId($pval->ManufactureId);
		// 		$pval->product=$this->product->getId($pval->ProductId);
		// 		$product_array[$pkey]=$pval;
		// 	}
		// 	$val->product_array=$product_array;
		
		// 	// echo "<pre>";
		// 	// print_r($val);
		// 	// exit;
		// 	$data_array['data'][$key]=$val;
		// }
		
		// print json_encode($data_array);
	}

	public function get_page_where()
	{	
		$data=$this->post();
		print json_encode($this->model->get_page_where($data->size, $data->pageno, $data));
	}	
	public function get_order_detail_latest_location()
	{	
		$data=$this->post();
		print json_encode($this->order_detail_model->get_order_detail_latest_location($data->id, $data->odid));
	}	
	public function changestatus()
	{
		$data=$this->post();
		$newdata['OdStatus']=$data->status;
		$curdate= date('Y-m-d h:i:s');
		if($data->status == 1){
		$newdata['AcceptedAt'] = $curdate;
		}
		if(isset($data->transId) !=null && $data->status ==2){
		$newdata['AssignedAt'] = $curdate;
		$newdata['OdTransId']=$data->transId;

		}
		if($data->status ==5){
		$newdata['RejectedAt'] = $curdate;
		}
		$this->order_detail_model->changestatus($data->id,$newdata);
		$success=TRUE;
		$msg='Status Changed successfully';				
		print json_encode(array('success'=>$success, 'msg'=>$msg));

	}
}

?>