<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transporter_model extends CI_Model
{
    public $table = 'transporter';

    public function get_all()
    {
		return $this->db->get($this->table)->result();		
    }
	public function get_page($size, $pageno){
		$this->db
			->limit($size, $pageno)
			->select('city.CName as CityName,country.CName,state.SName,users.UserId,users.CountryId,users.StateId,users.CityId,users.CompanyName,transporter.TransId,users.FirstName,users.LastName,users.Image,users.MobileNumber ,users.Address,users.PUserId,users.IsEdited,users.Email,users.Status,transporter.GSTIN,transporter.VatNumber')
			->join('users','users.UserId=transporter.UserId')
			->join('country','country.CId=users.CountryId','left')
			->join('city','city.CityId=users.CityId','left')
			->where('users.isAccount','1')
			->where('users.PUserId','0')
			->order_by('users.UserId')
			->join('state','state.StateId=users.StateId','left');
			
		$data=$this->db->get($this->table)->result();
		// echo "<pre>";
		// print_r($data);
		// exit;
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
			->select('city.CName as CityName,country.CName,state.SName,users.UserId,users.CountryId,users.StateId,users.CityId,users.CompanyName,transporter.TransId,users.FirstName,users.LastName,users.Image,users.MobileNumber ,users.Address,users.PUserId,users.IsEdited,users.Email,users.Status,transporter.GSTIN,transporter.VatNumber')
			->join('users','users.UserId=transporter.UserId')
			->join('country','country.CId=users.CountryId','left')
			->where('users.isAccount','1')
			->join('state','state.StateId=users.StateId','left')
			->join('city','city.CityId=users.CityId','left')
			->where('users.isAccount','1')
			->order_by('users.UserId')
			->where('users.PUserId','0');
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("CompanyName LIKE '%$params->search%' OR Email LIKE '%$params->search%' OR Address LIKE '%$params->search%' OR MobileNumber LIKE '%$params->search%'  ");
//				$this->db->like("catName",$params->search);
			}	

		$data=$this->db->get($this->table)->result();
		$total=$this->count_where($params);
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where($params)
	{	
// 		$this->db
// ->join('Navigations', 'Roles.NavigationId = Navigations.NavigationId', 'left outer');
	$this->db->join('users','users.UserId=transporter.UserId')
			->join('country','country.CId=users.CountryId','left')
			->join('city','city.CityId=users.CityId','left')
			->where('users.isAccount','1')
			->where('users.PUserId','0')
			->join('state','state.StateId=users.StateId','left');

		if(isset($params->search) && !empty($params->search)){
				$this->db->where("CompanyName LIKE '%$params->search%' OR Email LIKE '%$params->search%' OR Address LIKE '%$params->search%' OR MobileNumber LIKE '%$params->search%'  ");
				// $this->db->like("catName",$params->search);
			}	
 	return count($this->db->get($this->table)->result());
	}
    public function count_all()
	{
		$this->db->join('users','users.UserId=transporter.UserId')
			->join('country','country.CId=users.CountryId','left')
			->join('city','city.CityId=users.CityId','left')
			->where('users.isAccount','1')
			->where('users.PUserId','0')
			->join('state','state.StateId=users.StateId','left');
		 	return count($this->db->get($this->table)->result());
	}
    public function get($id)
    {
        return $this->db->where('TransId', $id)->get($this->table)->row();
    }
  
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('TransId', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('UserId', $id)->delete($this->table);
        $this->db->where('UserId', $id)->delete('users');
        return $this->db->affected_rows();
    }
    public function changestatus($id, $data)
    {
        return $this->db->where('TransId', $id)->update($this->table, $data);
    }
    public function getmobile($mobile)
    {
        return $this->db->where('PhoneNo', $mobile)->get($this->table)->row();
    }

	public function searchcustomer($params){
	$this->db->select('customer.TransId,customer.Name,customer.PhoneNo,customer.AltPhoneNo,customer.Address as OrderAddress,orders.SerialNo')
	->join('orders', 'orders.OTransId = TransId', 'inner');
	$this->db->where("Name LIKE '%$params->search%' OR PhoneNo LIKE '%$params->search%' OR customer.Address LIKE '%$params->search%' OR orders.SerialNo LIKE '%$params->search%'");
		$this->db->where('orders.Status !=', '4');

	$this->db->group_by('customer.TransId');
	$data=$this->db->get($this->table)->result();

	return $data;
//				$this->db->like("catName",$params->search);
	}
	public function getWithJoin($id)
    {
		$data['trans1']=$this->db->join('users','users.UserId=transporter.UserId')->where('users.UserId', $id)->get($this->table)->row();		
		$data['trans2']=$this->db->join('users','users.UserId=transporter.UserId')->where('users.PUserId', $id)->get($this->table)->row();		
		return $data;
		// return $this->db->join('users','users.UserId=transporter.UserId')->where('users.UserId', $id)->get($this->table)->row();		
    }
	
}

?>