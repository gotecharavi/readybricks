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
		$this->db
		 ->limit($size, $pageno)
		 ->select('orders.OId,orders.Created_At,users.FirstName,users.LastName,users.MobileNumber,count(orders_detail.OdProductId) as TotalProduct,sum(orders_detail.OdQty) as TotalQty,orders.OTotal,orders.OStatus')
		 ->join('users', 'users.UserId = orders.OUserId')
		 ->join('orders_detail', 'orders_detail.OdOrderId = orders.OId')
		 ->order_by('orders.OId desc')
		 ->group_by('orders.OId');

		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
		 ->select('orders.OId,orders.Created_At,users.FirstName,users.LastName,users.MobileNumber,count(orders_detail.OdProductId) as TotalProduct,sum(orders_detail.OdQty) as TotalQty,orders.OTotal,orders.OStatus')
		 ->join('users', 'users.UserId = orders.OUserId')
		 ->join('orders_detail', 'orders_detail.OdOrderId = orders.OId')
		 ->order_by('orders.OId desc')
		 ->group_by('orders.OId');
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("CONCAT(users.FirstName, ' ', users.LastName)  LIKE '%$params->search%' OR MobileNumber LIKE '%$params->search%' ");

		}	

		$data=$this->db->get($this->table)->result();
		$total=$this->count_where($params);
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where($params)
	{	
        $this->db
		 ->join('users', 'users.UserId = orders.OUserId')
		 ->join('orders_detail', 'orders_detail.OdOrderId = orders.OId')
		 ->group_by('orders.OId');

		if(isset($params->search) && !empty($params->search)){
				$this->db->where("CONCAT(users.FirstName, ' ', users.LastName)  LIKE '%$params->search%' OR MobileNumber LIKE '%$params->search%' ");
			
		}	

		return $this->db->count_all_results($this->table);

	}
    public function count_all($filter ="")
	{
		$where= "";
		// if($filter->search !=null){
		// 	$where = " And  orders.OrderId = '".$filter->search."' ";
		// }
		return $this->db			
			 ->join('users', 'users.UserId = orders.OUserId')
			 ->join('orders_detail', 'orders_detail.OdOrderId = orders.OId')
			 ->group_by('orders.OId')
			->get($this->table)->num_rows();

	}


    public function get($id)
    {
        return $this->db->where('OId', $id)->get($this->table)->row();
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
        return $this->db->where('OId', $id)->update($this->table, $data);
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