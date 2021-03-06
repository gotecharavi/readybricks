<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('./application/libraries/base_ctrl.php');
class Requests_ctrl extends base_ctrl {
	function __construct() {
		parent::__construct();		
	    $this->load->model('request_model','model');
		$this->load->model('manufacture_model','manufacture_model');
		$this->load->model('users_model','users_model');
		$this->load->model('transporter_model','transporter_model');
		$this->load->model('Product_model','product_model');
		$this->load->model('Vehicle_model','vehicle_model');
		$this->load->model('Driver_model','driver_model');
		
		
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

		if($data->viewtype == 'Edited'){

			if($data->role == '3'){
					// select puserid recprd
				$getrows= $this->manufacture_model->getWithJoin($data->id);

	            $updateUser=$this->users_model->update($getrows['trans1']->UserId,array('Address'=>$getrows['trans2']->Address,'Landmark'=>$getrows['trans2']->Landmark,'CountryId'=>$getrows['trans2']->CountryId,'StateId'=>$getrows['trans2']->StateId,'CityId'=>$getrows['trans2']->CityId,'CompanyName'=>$getrows['trans2']->CompanyName,'FirstName'=>$getrows['trans2']->FirstName,'LastName'=>$getrows['trans2']->LastName,'Image'=>$getrows['trans2']->Image,'IsAccount'=>'1','IsEdited'=>0,'Reason'=>'','Status'=>'1'));

	            $updateManufacture = $this->manufacture_model->update($getrows['trans1']->MenuId,array('GSTIN'=>$getrows['trans2']->GSTIN,'VatNumber'=>$getrows['trans2']->VatNumber));

	            $deleteSubUser = $this->manufacture_model->delete($getrows['trans2']->UserId);

				print json_encode( array("success"=>TRUE,"msg"=>'Approved'));

			}
			if($data->role == '4'){

				$getrows= $this->transporter_model->getWithJoin($data->id);

	            $updateUser=$this->users_model->update($getrows['trans1']->UserId,array('Address'=>$getrows['trans2']->Address,'Landmark'=>$getrows['trans2']->Landmark,'CountryId'=>$getrows['trans2']->CountryId,'StateId'=>$getrows['trans2']->StateId,'CityId'=>$getrows['trans2']->CityId,'CompanyName'=>$getrows['trans2']->CompanyName,'FirstName'=>$getrows['trans2']->FirstName,'LastName'=>$getrows['trans2']->LastName,'Image'=>$getrows['trans2']->Image,'IsAccount'=>'1','IsEdited'=>0,'Reason'=>'','Status'=>'1'));

	            $updateManufacture = $this->transporter_model->update($getrows['trans1']->MenuId,array('GSTIN'=>$getrows['trans2']->GSTIN,'VatNumber'=>$getrows['trans2']->VatNumber));

	            $deleteSubUser = $this->transporter_model->delete($getrows['trans2']->UserId);

				print json_encode( array("success"=>TRUE,"msg"=>'Approved'));

			}
			exit;
		}else{

		print json_encode( array("success"=>TRUE,"msg"=>$this->model->approve($data->id)));

		}


//		print json_encode( array("success"=>TRUE,"msg"=>$this->model->approve($data->id)));

	}
	public function approve_vehicle()
	{
		$data=$this->post();
		if($data->viewtype == 'Edited'){

				$getrows= $this->vehicle_model->getWithJoin($data->id);
				$record = array('VRcNo'=>$getrows['vehicle_by_pid']->VRcNo,'VNo'=>$getrows['vehicle_by_pid']->VNo,'Reason'=>'','IsAccount'=>'1','IsEdited'=>0,'VStatus'=>'1');
				if($getrows['vehicle_by_pid']->VRcImage !=""){
					$record['VRcImage']=$getrows['vehicle_by_pid']->VRcImage;
				}


	             $updateUser=$this->vehicle_model->update($getrows['vehicle_by_id']->VId,$record);

	            $deleteSubUser = $this->vehicle_model->delete($getrows['vehicle_by_pid']->VId);

				print json_encode( array("success"=>TRUE,"msg"=>'Approved'));



		}else{

		print json_encode( array("success"=>TRUE,"msg"=>$this->vehicle_model->approve_vehicle($data->id)));
		}

	}
	public function rejectSaveVehicle()
	{
		$data=$this->post();
		print json_encode( array("success"=>TRUE,"msg"=>$this->vehicle_model->rejectSaveVehicle($data)));

	}

	public function approve_driver()
	{
		$data=$this->post();
		if($data->viewtype == 'Edited'){

				$getrows= $this->driver_model->getWithJoin($data->id);
				$record= array('DFirstName'=>$getrows['driver_by_pid']->DFirstName,'DLastName'=>$getrows['driver_by_pid']->DLastName,'DMobileNumber'=>$getrows['driver_by_pid']->DMobileNumber,'DPassword'=>$getrows['driver_by_pid']->DPassword,'DAddress'=>$getrows['driver_by_pid']->DAddress,'DLicenceNo'=>$getrows['driver_by_pid']->DLicenceNo,'Reason'=>'','IsAccount'=>'1','IsEdited'=>0,'DStatus'=>'1');
				if($getrows['driver_by_pid']->DImage !=""){
					$record['DImage']=$getrows['driver_by_pid']->DImage;
				}
				if($getrows['driver_by_pid']->DLicenceImage !=""){
					$record['DLicenceImage']=$getrows['driver_by_pid']->DLicenceImage;
				}


	             $updateUser=$this->driver_model->update($getrows['driver_by_id']->DId,$record);

	            $deleteSubUser = $this->driver_model->delete($getrows['driver_by_pid']->DId);

				print json_encode( array("success"=>TRUE,"msg"=>'Approved'));



		}else{

		print json_encode( array("success"=>TRUE,"msg"=>$this->driver_model->approve_driver($data->id)));
		}

	}
	public function rejectSaveDriver()
	{
		$data=$this->post();
		print json_encode( array("success"=>TRUE,"msg"=>$this->driver_model->rejectSaveDriver($data)));

	}

	public function approve_product()
	{
		$data=$this->post();
		if($data->viewtype == 'Edited'){

				$getrows= $this->product_model->getWithJoin($data->id);

	            $updateUser=$this->product_model->update($getrows['product_by_id']->ProductId,array('PName'=>$getrows['product_by_pid']->PName,'PImage'=>$getrows['product_by_pid']->PImage,'PMinDeliveryDays'=>$getrows['product_by_pid']->PMinDeliveryDays,'PPrice'=>$getrows['product_by_pid']->PPrice,'PStock'=>$getrows['product_by_pid']->PStock,'PDescription'=>$getrows['product_by_pid']->PDescription,'PAdditionalInfo'=>$getrows['product_by_pid']->PAdditionalInfo,'IsAccount'=>'1','IsEdited'=>0,'Reason'=>'','PStatus'=>'1'));

	            $deleteSubUser = $this->product_model->delete($getrows['product_by_pid']->ProductId);

				print json_encode( array("success"=>TRUE,"msg"=>'Approved'));



		}else{

		print json_encode( array("success"=>TRUE,"msg"=>$this->model->approve_product($data->id)));
		}

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
	public function getDriverById()
	{	
		$data=$this->post();

		print json_encode($this->driver_model->getWithJoin($data->DId));
	}
	public function getVehicleById()
	{	
		$data=$this->post();

		print json_encode($this->vehicle_model->getWithJoin($data->VId));
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