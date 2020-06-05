<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('./application/libraries/base_ctrl.php');
class Requests_ctrl extends base_ctrl {
	function __construct() {
		parent::__construct();		
	    $this->load->model('request_model','model');
		$this->load->model('manufacture_model','manufacture_model');
		$this->load->model('transporter_model','transporter_model');
		$this->load->model('Product_model','product_model');
		
		
	}
	public function index()
	{
//		print_r($this->auth);
		// if($this->is_authentic($this->auth->RoleId, $this->user->UserId, 'Category')){
			$data['fx']='return '.json_encode(array("insert"=>$this->auth->IsInsert==="1","update"=>$this->auth->IsUpdate==="1","delete"=>$this->auth->IsDelete==="1"));
			$data['read']=$this->auth->IsRead;
			$this->load->view('Requests_view', $data);
		// }
		// else
		// {
		// 	$this->load->view('forbidden');
		// }
	}

	public function save()
	{
		$data=$this->post();
		$success=FALSE;
		$msg= 'You are not permitted.';
		$id=0;
		$tmpdata['Name']=$data->Name;
		$tmpdata['Status']='1';
		if(!isset($data->CustId))
		{
			if($this->auth->IsInsert){
				$id=$this->model->add($tmpdata);
				$msg='Data inserted successfully';
				$success=TRUE;
			}
					
		}
		else{
			if($this->auth->IsUpdate){
				$id=$this->model->update($data->PumpId, $data);
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
	public function approve()
	{
		$data=$this->post();

		print json_encode( array("success"=>TRUE,"msg"=>$this->model->approve($data->id)));

	}
	public function approve_product()
	{
		$data=$this->post();

		print json_encode( array("success"=>TRUE,"msg"=>$this->model->approve_product($data->id)));

	}
		
	public function rejectSaveProduct()
	{
		$data=$this->post();
	// echo "<pre>";
	// 		print_r($data);
	// 		exit;
		print json_encode( array("success"=>TRUE,"msg"=>$this->model->rejectSaveProduct($data)));

	}
	public function reject()
	{
		$data=$this->post();
			// echo "<pre>";
			// print_r($data);
			// exit;
		print json_encode( array("success"=>TRUE,"msg"=>$this->model->reject($data->id)));

	}
	public function changestatus()
	{
		$data=$this->post();
		$newdata['Status']=$data->status;
		$this->model->changestatus($data->id,$newdata);
		$success=TRUE;
		$msg='Status Changed successfully';				
		print json_encode(array('success'=>$success, 'msg'=>$msg));

	}

	public function get_Navigations_list(){
		print  json_encode($this->model->get_Navigations_list());
	}
	
	public function get()
	{	
		$data=$this->post();
		print json_encode($this->model->get($data->RoleId));
	}
	public function getUserById()
	{	
		$data=$this->post();
		if(isset($data->type)){
			print json_encode($this->transporter_model->getWithJoin($data->UserId));
			exit;
		}
		print json_encode($this->manufacture_model->getWithJoin($data->UserId));
	}
	
	public function getProductById()
	{	
		$data=$this->post();

		print json_encode($this->product_model->getWithJoin($data->PId));
	}
	public function get_all()
	{		
		print json_encode($this->model->get_all());
	}
	public function get_page()
	{	
		$data=$this->post();
		print json_encode($this->model->get_page($data->size, $data->pageno));
	}
	public function get_page_where()
	{	
		$data=$this->post();
		print json_encode($this->model->get_page_where($data->size, $data->pageno, $data));
	}	
}

?>