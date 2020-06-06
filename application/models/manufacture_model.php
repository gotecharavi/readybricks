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
	public function get_page($size, $pageno){
		$this->db
			->limit($size, $pageno)
			->select('country.CName,state.SName,users.*,manufacture.MenuId,manufacture.GSTIN,manufacture.VatNumber')
			 ->join('users', 'users.UserId = manufacture.UserId', 'inner')
			->join('country','country.CId=users.CountryId','left')
			->join('state','state.StateId=users.StateId','left')
			->where('users.isAccount','1')
		 	->group_by('UserId');
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
		->select('CustId,Name,PhoneNo,AltPhoneNo,Address,Date,Status');
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("Name LIKE '%$params->search%' OR PhoneNo LIKE '%$params->search%' OR Address LIKE '%$params->search%'  ");
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

		if(isset($params->search) && !empty($params->search)){
				$this->db->where("Name LIKE '%$params->search%' OR PhoneNo LIKE '%$params->search%' OR Address LIKE '%$params->search%'  ");				// $this->db->like("catId",$params->search);
				// $this->db->like("catName",$params->search);
			}	
		return $this->db->count_all_results($this->table);
	}
    public function count_all()
	{
		return $this->db			
			->count_all_results($this->table);
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
		return $this->db->join('users','users.UserId=manufacture.UserId')->where('users.UserId', $id)->get($this->table)->row();		
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