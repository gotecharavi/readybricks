<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Kolkata");
class Order_model extends CI_Model
{
    public $table = 'orders';

    public function get_all()
    {
		return $this->db->get($this->table)->result();		
    }
    public function get_order_all()
    {
        return $this->db->select('OrderId,CustId,customer.Name as CustomerName,PhoneNo,AltPhoneNo,orders.Address,orders.PaymentCollection,orders.DateTime,orders.PermanentRemark,orders.OrderBy,orders.Remark,orders.OrderType,orders.Status,models.ModelId,cPersonName,models.Name as ModelName,pump.PumpId,pump.Name as PumpName') //,oMenuId,Qty,Price,SubTotal,Tax,GrandTotal // 1 pending 2 approved 3 processing  4 ready for devliery 5 deliveryed
		->join('customer', 'OCustId = CustId', 'inner')
		->join('models', 'models.ModelId = orders.ModelId', 'inner')
		->join('pump', 'pump.PumpId = orders.PumpId', 'inner')
		->order_by('OrderId', 'DESC')->get($this->table)->result();
    }
    public function get_order_status_all($status)
    {
        $this->db->select('OrderId,CustId,customer.Name as CustomerName,PhoneNo,AltPhoneNo,orders.Address,orders.PaymentCollection,orders.oUserId,orders.MainType,orders.PaymentMode,orders.OrderBy,orders.SerialNo,cPersonName,orders.Remark,orders.PermanentRemark,orders.OrderType,orders.Status,orders.SolutionType,orders.Reason,orders.DateTime,orders.PaymentReceivedBy,orders.ModelId,models.Name as ModelName,pump.PumpId,pump.Name as PumpName') //,oMenuId,Qty,Price,SubTotal,Tax,GrandTotal // 1 pending 2 approved 3 processing  4 ready for devliery 5 deliveryed
		->join('customer', 'OCustId = CustId', 'inner')
		->join('models', 'models.ModelId = orders.ModelId', 'inner')
		->join('pump', 'pump.PumpId = orders.PumpId', 'inner')
		->where('orders.Status', $status);


		if($status == 3){
			$this->db->order_by('orders.PaymentReceivedBy', 'ASC');
		}else{
			$this->db->order_by('DateTime', 'ASC');
		}
		return $this->db->get($this->table)->result();
    }
    public function get_payment_status_all($status)
    {

         $this->db->select('OrderId,CustId,customer.Name as CustomerName,PhoneNo,AltPhoneNo,orders.Address,orders.PaymentCollection,orders.oUserId,orders.MainType,orders.SolutionType,orders.PaymentMode,orders.ModelId,orders.OrderBy,orders.SerialNo,cPersonName,orders.PermanentRemark,orders.Remark,orders.OrderType,orders.PaymentReceivedBy,orders.Status,orders.DateTime,pump.PumpId,pump.Name as PumpName') //,oMenuId,Qty,Price,SubTotal,Tax,GrandTotal // 1 pending 2 approved 3 processing  4 ready for devliery 5 deliveryed
		->join('customer', 'OCustId = CustId', 'inner')
		->join('pump', 'pump.PumpId = orders.PumpId', 'inner')
		->where('orders.Status', '3')
		->where('orders.PaymentReceivedBy !=', '');

    	if($status=='Pending'){
			$this->db->where('orders.PaymentMode',$status);
    	}else{			
    		$this->db->where('orders.PaymentMode !=','Pending');
    	
    	}
		return $this->db->order_by('OrderId', 'DESC')->get($this->table)->result();
    }


    public function get_employee_orders($id,$status)
    {
        return $this->db->select('OrderId,orders.OUserId,orders.ModelId,orders.SerialNo,cPersonName,CustId,customer.Name as CustomerName,PhoneNo,AltPhoneNo,orders.Address,orders.PaymentCollection,orders.PaymentMode,orders.OrderBy,orders.Remark,orders.OrderType,orders.MainType,PermanentRemark,orders.Status,orders.DateTime,models.Name as ModelName,pump.PumpId,pump.Name as PumpName') //,oMenuId,Qty,Price,SubTotal,Tax,GrandTotal // 1 pending 2 approved 3 processing  4 ready for devliery 5 deliveryed
		->join('customer', 'OCustId = CustId', 'inner')
		->join('models', 'models.ModelId = orders.ModelId', 'inner')
		->join('pump', 'pump.PumpId = orders.PumpId', 'inner')
		->where('orders.Status', $status)
		->where("orders.OUserId LIKE '%$id%'")
//		->where_in('orders.OUserId',$id)

		->order_by('DateTime', 'Asc')->get($this->table)->result();
    }



	public function get_page($size, $pageno,$filter){
		$where ="";
	// 	if($filter->search !=null){
	// 		$where = " And  orders.OrderId = '".$filter->search."' ";
	// 	}
	//  $query= $this->db->query("SELECT orders.OrderId,CustId,customer.Name as CustomerName,SerialNo,cPersonName,PhoneNo,orders.Address,orders.PaymentCollection,orders.Signature,orders.BuildingType,orders.PaymentMode,orders.DateTime,orders.OrderBy,orders.Remark,orders.OrderType,orders.Status,pump.PumpId,pump.Name as PumpName, GROUP_CONCAT(models.Name SEPARATOR ',') as ModelName,GROUP_CONCAT(concat(users.FirstName, ' ', users.LastName) SEPARATOR ',') as UserFullName FROM orders INNER JOIN  customer ON OCustId = CustId INNER JOIN pump ON pump.PumpId = orders.PumpId INNER JOIN models INNER JOIN users   WHERE  FIND_IN_SET(models.ModelId,orders.ModelId)<> 0 AND FIND_IN_SET(users.UserId,orders.OUserId)<> 0   AND OrderType= 'Installation' $where GROUP BY orders.OrderId  ORDER BY orders.OrderId DESC LIMIT $pageno,$size ");
	 	

	// 	$data = $query->result();
	$this->db
		 ->join('users', 'users.UserId = orders.OUserId', 'left')
		 ->limit($size, $pageno)
		 ->select('orders.*,users.FirstName,users.LastName,users.MobileNumber,users.Email');


// ");
		$data=$this->db->get($this->table)->result();
		
		$total=count($data);
		return array("data"=>$data, "total"=>$total??'');
	}
	public function get_page_where($size, $pageno, $params){


	 $query= $this->db->query("SELECT orders.OrderId,CustId,customer.Name as CustomerName,SerialNo,cPersonName,PhoneNo,orders.Address,orders.PaymentCollection,orders.Signature,orders.BuildingType,orders.PaymentMode,orders.DateTime,orders.OrderBy,orders.Remark,orders.OrderType,orders.Status,pump.PumpId,pump.Name as PumpName, GROUP_CONCAT(models.Name SEPARATOR ',') as ModelName,GROUP_CONCAT(concat(users.FirstName, ' ', users.LastName) SEPARATOR ',') as UserFullName FROM orders INNER JOIN  customer ON OCustId = CustId INNER JOIN pump ON pump.PumpId = orders.PumpId INNER JOIN models INNER JOIN users   WHERE  FIND_IN_SET(models.ModelId,orders.ModelId)<> 0 AND FIND_IN_SET(users.UserId,orders.OUserId)<> 0   AND OrderType= 'Installation' AND (orders.OrderId LIKE '%$params->search%' OR customer.Name LIKE '%$params->search%' OR customer.Name LIKE '%$params->search%' OR OrderBy LIKE '%$params->search%' OR SerialNo LIKE '%$params->search%' OR orders.Address LIKE '%$params->search%' OR orders.PaymentCollection LIKE '%$params->search%'  OR orders.Address LIKE '%$params->search%' OR PhoneNo LIKE '%$params->search%' OR orders.BuildingType LIKE '%$params->search%' OR orders.PaymentMode LIKE '%$params->search%' OR orders.DateTime LIKE '%$params->search%')          

	 	GROUP BY orders.OrderId  ORDER BY orders.OrderId DESC LIMIT $pageno,$size


");
		$data = $query->result();
		$total=count($this->count_where($params));
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where($params)
	{	
		if(isset($params->search) && !empty($params->search)){
	return	$query= $this->db->query("SELECT count(orders.OrderId) as total  FROM orders INNER JOIN  customer ON OCustId = CustId INNER JOIN pump ON pump.PumpId = orders.PumpId INNER JOIN models INNER JOIN users   WHERE  FIND_IN_SET(models.ModelId,orders.ModelId)<> 0 AND FIND_IN_SET(users.UserId,orders.OUserId)<> 0   AND OrderType= 'Installation' AND (orders.OrderId LIKE '%$params->search%' OR customer.Name LIKE '%$params->search%' OR customer.Name LIKE '%$params->search%' OR OrderBy LIKE '%$params->search%' OR SerialNo LIKE '%$params->search%' OR orders.Address LIKE '%$params->search%' OR orders.PaymentCollection LIKE '%$params->search%'  OR orders.Address LIKE '%$params->search%' OR PhoneNo LIKE '%$params->search%' OR orders.BuildingType LIKE '%$params->search%' OR orders.PaymentMode LIKE '%$params->search%' OR orders.DateTime LIKE '%$params->search%')          

	 	GROUP BY orders.OrderId  ORDER BY orders.OrderId DESC")->result();
		}	

	}
    public function count_all($filter)
	{
		$where= "";
		if($filter->search !=null){
			$where = " And  orders.OrderId = '".$filter->search."' ";
		}
		return $this->db->query("SELECT count(orders.OrderId) as total FROM orders INNER JOIN  customer ON OCustId = CustId INNER JOIN pump ON pump.PumpId = orders.PumpId INNER JOIN models INNER JOIN users   WHERE  FIND_IN_SET(models.ModelId,orders.ModelId)<> 0 AND FIND_IN_SET(users.UserId,orders.OUserId)<> 0   AND OrderType= 'Installation' $where GROUP BY orders.OrderId  ORDER BY orders.OrderId DESC")
			->result();

	}


	public function get_page_maintenance($size, $pageno){
		$this->db
			->limit($size, $pageno)
			->select('OrderId,CustId,customer.Name as CustomerName,SerialNo,cPersonName,PhoneNo,orders.Address,orders.PaymentCollection,orders.Signature,orders.BuildingType,orders.PaymentMode,orders.DateTime,orders.OrderBy,orders.Remark,orders.OrderType,orders.Status,models.ModelId,models.Name as ModelName,pump.PumpId,pump.Name as PumpName') 
		->join('customer', 'OCustId = CustId', 'inner')
		->join('models', 'models.ModelId = orders.ModelId', 'inner')
		->join('pump', 'pump.PumpId = orders.PumpId', 'inner')
		->where('OrderType', 'Maintenance')
		->order_by('OrderId', 'DESC');
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all_maintenance();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where_maintenance($size, $pageno, $params){
		$this->db->limit($size, $pageno)
			->select('OrderId,CustId,customer.Name as CustomerName,SerialNo,cPersonName,PhoneNo,orders.Address,orders.PaymentCollection,orders.DateTime,orders.OrderBy,orders.Remark,orders.OrderType,orders.Status,models.ModelId,models.Name as ModelName,pump.PumpId,pump.Name as PumpName')
//			->join('users', 'oUserId = UserId', 'left outer');
		->join('customer', 'OCustId = CustId', 'inner')
		->join('models', 'models.ModelId = orders.ModelId', 'inner')
		->join('pump', 'pump.PumpId = orders.PumpId', 'inner');
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("customer.Name LIKE '%$params->search%' OR models.Name LIKE '%$params->search%' OR PhoneNo LIKE '%$params->search%' OR OrderBy LIKE '%$params->search%' ");

		}	
		$this->db->where('OrderType', 'Maintenance')
		->order_by('OrderId', 'DESC');

		$data=$this->db->get($this->table)->result();
		$total=$this->count_where_maintenance($params);
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where_maintenance($params)
	{	
		if(isset($params->search) && !empty($params->search)){

 		$this->db->join('customer', 'OCustId = CustId', 'inner')
		->join('models', 'models.ModelId = orders.ModelId', 'inner')
		->join('pump', 'pump.PumpId = orders.PumpId', 'inner')
		->where("customer.Name LIKE '%$params->search%' OR  models.Name LIKE '%$params->search%' OR PhoneNo LIKE '%$params->search%' OR OrderBy LIKE '%$params->search%' ")
		->where('OrderType', 'Maintenance');
			
		}	

		return $this->db->count_all_results($this->table);
	}
    public function count_all_maintenance()
	{
		return $this->db
		->join('customer', 'OCustId = CustId', 'inner')
		->join('models', 'models.ModelId = orders.ModelId', 'inner')
		->join('pump', 'pump.PumpId = orders.PumpId', 'inner')
		->where('OrderType', 'Maintenance')
		->order_by('OrderId', 'DESC')
				
			->count_all_results($this->table);
	}











    public function get($id)
    {
        return $this->db->where('OrderId', $id)->get($this->table)->row();
    }
    public function get_where_user($uid)
    {
        return $this->db->select('OrderId,CartId,cMenuId,Qty,Price,Total,oUserId,oFirstName,oLastName,oAddress,oLocation,oPhoneNumber,oEmail,orders.Status,orders.Date') //,oMenuId,Qty,Price,SubTotal,Tax,GrandTotal // 1 pending 2 approved 3 processing  4 ready for devliery 5 deliveryed
		->join('cart', 'oCartId = CartId', 'left outer')
		->order_by('OrderId', 'DESC')
		->where('oUserId', $uid)->get($this->table)->result();
    }//->where('cMenuId', $mid)
  
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('OrderId', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('OrderId', $id)->delete($this->table);
        return $this->db->affected_rows();
    }
    public function changestatus($id, $data)
    {
        return $this->db->where('OrderId', $id)->update($this->table, $data);
    }
	
	public function getserialno($cust){
	$this->db->select('orders.OrderId,orders.SerialNo,CPersonName,orders.OUserId,orders.ModelId,orders.DateTime,orders.BuildingType,orders.OrderBy,customer.CustId,AltPhoneNo,PermanentRemark,customer.Name,customer.PhoneNo,orders.Address as OrderAddress,pump.PumpId, pump.Name as PumpName')
	->join('customer', 'CustId = orders.OCustId', 'inner')
	//->join('models', 'models.ModelId = orders.ModelId', 'inner')
	->join('pump', 'pump.PumpId = orders.PumpId', 'inner')
	->where('orders.OCustId', $cust)
	->where('orders.SerialNo !=', '')
	->where('orders.OrderType','Installation');
	//$this->db->where("Name LIKE '%$params->search%' OR PhoneNo LIKE '%$params->search%' OR orders.Address LIKE '%$params->search%'");
	//$this->db->group_by('customer.CustId');
	$data=$this->db->get($this->table)->result();

	return $data;
	}

}

?>