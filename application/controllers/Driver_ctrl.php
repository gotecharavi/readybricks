<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('./application/libraries/base_ctrl.php');
class Driver_ctrl extends base_ctrl {
	function __construct() {
		parent::__construct();		
	    $this->load->model('driver_model','model');
	}
	public function index()
	{
//		print_r($this->auth);
		// if($this->is_authentic($this->auth->RoleId, $this->user->UserId, 'Category')){
			$data['fx']='return '.json_encode(array("insert"=>$this->auth->IsInsert==="1","update"=>$this->auth->IsUpdate==="1","delete"=>$this->auth->IsDelete==="1"));
			$data['read']=$this->auth->IsRead;
			$this->load->view('Driver_view', $data);
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
		$tmpdata['DTransId']=$data->Transporter;
		$tmpdata['DFirstName']=$data->DFirstName;
		$tmpdata['DLastName']=$data->DLastName;
		$tmpdata['DMobileNumber']=$data->DMobileNumber;
		$tmpdata['Reason']='';
		$tmpdata['IsAccount']=1;
		$tmpdata['IsEdited']=0;
		$tmpdata['DStatus']='1';
		if(!isset($data->DId))
		{
			if($this->auth->IsInsert){
				$id=$this->model->add($tmpdata);
				$msg='Data inserted successfully';
				$success=TRUE;
			}
					
		}
		else{
			if($this->auth->IsUpdate){
			if(isset($data->baseimage)){
		 		$new_data=explode(",",$data->baseimage);
		        $exten=explode('/',$new_data[0]);
	            $exten1=explode(';',$exten[1]);
	            $decoded=base64_decode($new_data[1]);
	            $img_name='img_'.uniqid().'.'.$exten1[0];
	            file_put_contents(APPPATH.'../uploads/'.$img_name,$decoded);
	            $tmpdata['DLicenceImage']=$img_name;
		        unset($data->baseimage);
	        }
			if(isset($data->baseimage1)){
		 		$new_data=explode(",",$data->baseimage1);
		        $exten=explode('/',$new_data[0]);
	            $exten1=explode(';',$exten[1]);
	            $decoded=base64_decode($new_data[1]);
	            $img_name='img_'.uniqid().'.'.$exten1[0];
	            file_put_contents(APPPATH.'../uploads/'.$img_name,$decoded);
	            $tmpdata['DImage']=$img_name;
		        unset($data->baseimage1);
	        }
	        if(isset($data->Password)){
				$tmpdata['DPassword']=md5($data->Password);
	        }

				$id=$this->model->update($data->DId, $tmpdata);
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
	public function changestatus()
	{
		$data=$this->post();
		$newdata['DStatus']=$data->status;
		$this->model->changestatus($data->id,$newdata);
		$success=TRUE;
		$msg='Status Changed successfully';				
		print json_encode(array('success'=>$success, 'msg'=>$msg));

	}

	public function get_Navigations_list(){
		print  json_encode($this->model->get_Navigations_list());
	}
	public function get_Transporter_list(){
		print  json_encode($this->model->get_Transporter_list());
	}
	
	public function get()
	{	
		$data=$this->post();
		print json_encode($this->model->get($data->RoleId));
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