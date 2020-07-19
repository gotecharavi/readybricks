<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model
{
    public $table = 'customer';

    public function get_all()
    {
		return $this->db->get($this->table)->result();		
    }
	public function get_page($size, $pageno){
		$this->db
			->limit($size, $pageno)
			->select('city.CName as CityName,country.CName,state.SName,users.UserId,users.CountryId,users.StateId,users.CityId,users.CompanyName,customer.CustId,users.FirstName,users.LastName,users.Image,users.MobileNumber ,users.Address,users.Email,users.Status,customer.GSTIN,customer.VatNumber')
			->join('users','users.UserId=customer.UserId')
			->join('country','country.CId=users.CountryId','left')
			->join('city','city.CityId=users.CityId','left')
			->join('state','state.StateId=users.StateId','left')
			->where('users.IsAccount','1')
			->order_by('users.UserId')
			->where('users.PUserId','0');
			
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
			->select('city.CName as CityName,country.CName,state.SName,users.UserId,users.CountryId,users.StateId,users.CityId,users.CompanyName,customer.CustId,users.FirstName,users.LastName,users.Image,users.MobileNumber ,users.Address,users.Email,users.Status,customer.GSTIN,customer.VatNumber')
			->join('users','users.UserId=customer.UserId')
			->join('city','city.CityId=users.CityId','left')
			->join('country','country.CId=users.CountryId','left')
			->join('state','state.StateId=users.StateId','left')
			->order_by('users.UserId')
			->where('users.IsAccount','1')
			->where('users.PUserId','0');
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("CONCAT(users.FirstName, ' ', users.LastName)  LIKE '%$params->search%' OR Email LIKE '%$params->search%' OR Address LIKE '%$params->search%' OR MobileNumber LIKE '%$params->search%'  ");
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
			$this->db->join('users','users.UserId=customer.UserId')
			->join('city','city.CityId=users.CityId','left')
			->join('country','country.CId=users.CountryId','left')
			->join('state','state.StateId=users.StateId','left')
			->where('users.IsAccount','1')
			->where('users.PUserId','0');

		if(isset($params->search) && !empty($params->search)){
				$this->db->where("CONCAT(users.FirstName, ' ', users.LastName) LIKE '%$params->search%' OR Email LIKE '%$params->search%' OR Address LIKE '%$params->search%' OR MobileNumber LIKE '%$params->search%'  ");
				// $this->db->like("catName",$params->search);
			}	
	 	return count($this->db->get($this->table)->result());
	}
    public function count_all()
	{
		 $this->db			
			->join('users','users.UserId=customer.UserId')
			->join('country','country.CId=users.CountryId','left')
			->join('city','city.CityId=users.CityId','left')
			->join('state','state.StateId=users.StateId','left')
			->where('users.IsAccount','1')
			->where('users.PUserId','0');
	 	return count($this->db->get($this->table)->result());

	}
    public function get($id)
    {
        return $this->db->where('CustId', $id)->get($this->table)->row();
    }
  
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('CustId', $id)->update($this->table, $data);
    }
	public function getId($id){
		$this->db
			->select('city.CName as CityName,district.DName,country.CName,state.SName,users.UserId,users.CountryId,users.StateId,users.CityId,users.CompanyName,customer.CustId,users.FirstName,users.LastName,users.MobileNumber ,users.Address,users.Landmark,users.Email,users.Status,customer.GSTIN,customer.VatNumber')
			->join('users','users.UserId=customer.UserId')
			->join('country','country.CId=users.CountryId','left')
			->join('city','city.CityId=users.CityId','left')
			->join('district','district.DistrictId=users.DistrictId','left')
			->join('state','state.StateId=users.StateId','left')
			->where('users.UserId', $id);
		return $this->db->get($this->table)->row();
	}


    public function delete($id)
    {
        $this->db->where('CustId', $id)->delete($this->table);
        return $this->db->affected_rows();
    }
    public function changestatus($id, $data)
    {
        return $this->db->where('CustId', $id)->update($this->table, $data);
    }
    public function getmobile($mobile)
    {
        return $this->db->where('PhoneNo', $mobile)->get($this->table)->row();
    }

	public function searchcustomer($params){
	$this->db->select('customer.CustId,customer.Name,customer.PhoneNo,customer.AltPhoneNo,customer.Address as OrderAddress,orders.SerialNo')
	->join('orders', 'orders.OCustId = CustId', 'inner');
	$this->db->where("Name LIKE '%$params->search%' OR PhoneNo LIKE '%$params->search%' OR customer.Address LIKE '%$params->search%' OR orders.SerialNo LIKE '%$params->search%'");
		$this->db->where('orders.Status !=', '4');

	$this->db->group_by('customer.CustId');
	$data=$this->db->get($this->table)->result();

	return $data;
//				$this->db->like("catName",$params->search);
	}
	
}

?>