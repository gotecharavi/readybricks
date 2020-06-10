<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manufacture_model extends CI_Model
{
    public $table = 'manufacture';

    public function get_all()
    {
		return $this->db->get($this->table)->result();		
	}
	
    public function get_all_manufacture()
    {
		return $this->db->join('users','users.UserId=manufacture.UserId')->get($this->table)->result();		
    }
    public function get_all_active_manufacture()
    {
		return $this->db->select('users.UserId,users.CompanyName')->join('users','users.UserId=manufacture.UserId')
			->join('product','product.PManuId=users.UserId')
			->where('users.IsAccount','1')
			->where('users.Status','1')
			->where('users.PUserId','0')
		 	->group_by('users.UserId')
			->get($this->table)->result();		
    }
	public function get_page($size, $pageno){
		$this->db
			->limit($size, $pageno)
			->select('city.CName as CityName, country.CName,state.SName,users.*,manufacture.MenuId,manufacture.GSTIN,manufacture.VatNumber')
			 ->join('users', 'users.UserId = manufacture.UserId', 'inner')
			->join('country','country.CId=users.CountryId','left')
			->join('state','state.StateId=users.StateId','left')
			->join('city','city.CityId=users.CityId','left')
			->where('users.IsAccount','1')
			->where('users.PUserId','0')
		 	->group_by('users.UserId');
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
			->select('city.CName as CityName, country.CName,state.SName,users.*,manufacture.MenuId,manufacture.GSTIN,manufacture.VatNumber')
			 ->join('users', 'users.UserId = manufacture.UserId', 'inner')
			->join('country','country.CId=users.CountryId','left')
			->join('state','state.StateId=users.StateId','left')
			->join('city','city.CityId=users.CityId','left')
			->where('users.IsAccount','1');
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("CompanyName LIKE '%$params->search%' OR Email LIKE '%$params->search%' OR Address LIKE '%$params->search%' OR MobileNumber LIKE '%$params->search%'  ");
//				$this->db->like("catName",$params->search);
			}	
	 	$this->db->group_by('users.UserId');

		$data=$this->db->get($this->table)->result();
		$total=$this->count_where($params);
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where($params)
	{	
			 $this->db->join('users', 'users.UserId = manufacture.UserId', 'inner')
			->join('country','country.CId=users.CountryId','left')
			->join('state','state.StateId=users.StateId','left')
			->join('city','city.CityId=users.CityId','left')
			->where('users.IsAccount','1');

		if(isset($params->search) && !empty($params->search)){
				$this->db->where("CompanyName LIKE '%$params->search%' OR Email LIKE '%$params->search%' OR Address LIKE '%$params->search%' OR MobileNumber LIKE '%$params->search%'  ");
				// $this->db->like("catName",$params->search);
			}
	 	$this->db->group_by('users.UserId');
	 	return count($this->db->get($this->table)->result());
	}
    public function count_all()
	{
			 $this->db
			 ->join('users', 'users.UserId = manufacture.UserId', 'inner')
			->join('country','country.CId=users.CountryId','left')
			->join('state','state.StateId=users.StateId','left')
			->join('city','city.CityId=users.CityId','left')
			->where('users.IsAccount','1')
		 	->group_by('users.UserId');
		 	return count($this->db->get($this->table)->result());
	}
    public function get()
    {
        return $this->db->where('MenuId', $id)->get($this->table)->row();
	}
	public function getId($id)
    {
        return $this->db->where('MenuId', $id)->get($this->table)->row();
    }
    public function getWithJoin($id)
    {
		$data['trans1']=$this->db->select('users.*,country.CName,state.SName,manufacture.*,city.CName as CityName')->join('users','users.UserId=manufacture.UserId')
		->join('country','country.CId=users.CountryId')
		->join('state','state.StateId=users.StateId')
		->join('city','city.CityId=users.CityId')
		->where('users.UserId', $id)->get($this->table)->row();		
		$data['trans2']=$this->db->select('users.*,country.CName,state.SName,manufacture.*,city.CName as CityName')->join('users','users.UserId=manufacture.UserId')
		->join('country','country.CId=users.CountryId')
		->join('state','state.StateId=users.StateId')
		->join('city','city.CityId=users.CityId')
		->where('users.PUserId', $id)->get($this->table)->row();		
		return $data;
    }

  
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('MenuId', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
    	$this->db->where('UserId',$id)->delete($this->table);
        $this->db->where('UserId', $id)->delete('users');
        return $this->db->affected_rows();
    }
    public function changestatus($id, $data)
    {
        return $this->db->where('UserId', $id)->update('users', $data);
    }

    public function getmobile($mobile)
    {
        return $this->db->where('PhoneNo', $mobile)->get($this->table)->row();
    }

	
}

?>