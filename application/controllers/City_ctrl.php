<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('./application/libraries/base_ctrl.php');
class City_ctrl extends base_ctrl {
	function __construct() {
		parent::__construct();		
		$this->load->model('City_model','model');
		$this->load->model('country_model','country');
	    $this->load->model('state_model','state');
	    $this->load->model('city_model','city');
	    $this->load->model('district_model','district');
	}
	public function index()
	{
//		print_r($this->auth);
		// if($this->is_authentic($this->auth->RoleId, $this->user->UserId, 'Category')){
			$data['fx']='return '.json_encode(array("insert"=>$this->auth->IsInsert==="1","update"=>$this->auth->IsUpdate==="1","delete"=>$this->auth->IsDelete==="1"));
			$data['read']=$this->auth->IsRead;
			$this->load->view('City_view', $data);
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
		// echo "<pre>";
		// print_r($data);
		// exit;
		$tmpdata['CName']=$data->Name;
		$tmpdata['CCountryId']=$data->Country;
		$tmpdata['CStateId']=isset($data->State)?$data->State:$data->CStateId;
		$tmpdata['CDistrictId']=isset($data->District)?$data->District:$data->CDistrictId;
		$tmpdata['CStatus']='1';
		if(!isset($data->CityId))
		{
			if($this->model->getName($data->Name,$data->District,$data->State,$data->Country)){
				$msg='Data Already Exist';
				$success=FALSE;
			}else{
				if($this->auth->IsInsert){
					$id=$this->model->add($tmpdata);
					$msg='Data inserted successfully';
					$success=TRUE;
				}
			}
					
		}
		else{
			if($this->auth->IsUpdate){
				// echo "<pre>";
				// print_r($this->model->getName($data->Name,$data->State,$data->Country,$data->CityId));
				// exit;
				if($this->model->getName($data->Name,$tmpdata['CDistrictId'],$tmpdata['CStateId'],$data->Country,$data->CityId)){
					$msg='Data Already Exist';
					$success=FALSE;
				}else{
					$id=$this->model->update($data->CityId, $tmpdata);
					$success=TRUE;
					$msg='Data updated successfully';	
				}			
			}		
		}
		print json_encode(array('success'=>$success, 'msg'=>$msg, 'id'=>$id));
	}

	public function delete()
	{
		if($this->auth->IsDelete){
			$data=$this->post();
			// echo "<pre>";
			// print_r($data);
			// exit;
			print json_encode( array("success"=>TRUE,"msg"=>$this->model->delete($data->id->CityId)));
		}
		else{
			print json_encode( array("success"=>FALSE,"msg"=>"You are not permitted"));
		}
	}
	public function changestatus()
	{
		$data=$this->post();
		$newdata['catStatus']=$data->status;
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
	public function get_Country_list(){
		print  json_encode($this->country->get_all());
	}
	public function get_State_list(){
		$data=$this->post();
		print  json_encode($this->state->get_all_by_countryId($data->id));
	}
	public function get_District_list(){
		$data=$this->post();
		print  json_encode($this->district->get_all_by_countryId_stateId($data->cid,$data->sid));
	}
	public function get_City_list(){
		$data=$this->post();
		print  json_encode($this->city->get_all_by_countryId_stateId($data->cId,$data->sId));
	}	
}

?>