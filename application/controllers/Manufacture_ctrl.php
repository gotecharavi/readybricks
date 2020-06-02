<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('./application/libraries/base_ctrl.php');
class Manufacture_ctrl extends base_ctrl {
	function __construct() {
		parent::__construct();		
	    $this->load->model('customer_model','customer');
	    $this->load->model('users_model','users');
	    $this->load->model('manufacture_model','model');
	    $this->load->model('country_model','country');
	    $this->load->model('state_model','state');
	    $this->load->model('city_model','city');
	}
	public function index()
	{
//		print_r($this->auth);
		// if($this->is_authentic($this->auth->RoleId, $this->user->UserId, 'Category')){
			$data['fx']='return '.json_encode(array("insert"=>$this->auth->IsInsert==="1","update"=>$this->auth->IsUpdate==="1","delete"=>$this->auth->IsDelete==="1"));
			$data['read']=$this->auth->IsRead;
			$this->load->view('Manufacture_view', $data);
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
		$tmpdata['CompanyName']=$data->CompanyName;
		$tmpdata['Address']=$data->Address;
		$tmpdata['Landmark'] =$data->Landmark;
		$tmpdata['Password']=md5($data->Password);
		$tmpdata['CountryId']=$data->Country;
		$tmpdata['StateId']=$data->State;
		$tmpdata['CityId']=$data->City;
		if(!isset($data->UserId))
		{
			$tmpdata['Email']=$data->Email;
			$tmpdata['MobileNumber']=$data->MobileNumber;

			$tmpdata['IsEmailVerify'] =1;
			$tmpdata['IsMobileNumberVerify'] =1;
			$tmpdata['Role'] =3;
			$tmpdata['Type'] ='Normal';
			$tmpdata['Status']='1';
 
			if($this->users->checkEmail($tmpdata['Email'])){

				$msg='Email Address Already Exists';
				$success=FALSE;
				print json_encode(array('success'=>$success, 'msg'=>$msg, 'id'=>$id));
				exit;

			}
			if($this->users->checkMobileNumber($tmpdata['MobileNumber'])){

				$msg='Mobile Number Already Exists';
				$success=FALSE;
				print json_encode(array('success'=>$success, 'msg'=>$msg, 'id'=>$id));
				exit;

			}

			if(isset($data->baseimage) !=null){
		 		$new_data=explode(",",$data->baseimage);
		        $exten=explode('/',$new_data[0]);
	            $exten1=explode(';',$exten[1]);
	            $decoded=base64_decode($new_data[1]);
	            $img_name='img_'.uniqid().'.'.$exten1[0];
	            file_put_contents(APPPATH.'../uploads/menu/'.$img_name,$decoded);
	            $tmpdata['Image']=$img_name;

		        unset($data->baseimage);
		        unset($data->image);
	    	}


			if($this->auth->IsInsert){
				$id=$this->users->add($tmpdata);

				// Manufacture Data 
				$mdata['UserId'] = $id;
				$mdata['GSTIN'] = $data->GstNo;
				$mdata['VatNumber'] = $data->VatNo;

				$addmenu = $this->model->add($mdata);

				$msg='Data inserted successfully';
				$success=TRUE;
			}
					
		}
		else{
			if($this->auth->IsUpdate){

				$id=$this->users->update($data->UserId, $tmpdata);
				$mdata['GSTIN'] = $data->GstNo;
				$mdata['VatNumber'] = $data->VatNo;

				$updatemenu=$this->model->update($data->MenuId, $mdata);
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
		$newdata['Status']=$data->status;
		$this->model->changestatus($data->id,$newdata);
		$success=TRUE;
		$msg='Status Changed successfully';				
		print json_encode(array('success'=>$success, 'msg'=>$msg));

	}

	public function get_Navigations_list(){
		print  json_encode($this->model->get_Navigations_list());
	}
	public function get_Country_list(){
		print  json_encode($this->country->get_all());
	}
	public function get_State_list(){
		$data=$this->post();
		print  json_encode($this->state->get_all_by_countryId($data->id));
	}
	public function get_City_list(){
		$data=$this->post();
		print  json_encode($this->city->get_all_by_countryId_stateId($data->cId,$data->sId));
	}

	
	public function get()
	{	
		$data=$this->post();
		print json_encode($this->model->get($data->RoleId));
	}
	public function getId($id)
	{	
		// $data=$this->post();
		print json_encode($this->model->getId($id));
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