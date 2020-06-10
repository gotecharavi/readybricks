<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicle_model extends CI_Model
{
    public $table = 'vehicle';

    public function get_all()
    {
        return $this->db->get($this->table)->result();      
    }
  
  	public function get_page($size, $pageno){
		$this->db
			->limit($size, $pageno)
			->select('users.UserId,users.FirstName,users.LastName,users.Address,users.MobileNumber,users.Image,users.Email,users.Password,users.Role,users.Status')
            ->where("Role = '5'");
		
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
		->select('users.UserId,users.FirstName,users.LastName,users.Address,users.MobileNumber,users.Image,users.Email,users.Password,,users.Role,users.Status')
		->where("Role != '1'")	
        ->where("Status != '2'"); 
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("FirstName LIKE '%$params->search%' OR LastName LIKE '%$params->search%' OR Address LIKE '%$params->search%' OR MobileNumber LIKE '%$params->search%' OR  Email LIKE '%$params->search%' ");

		}	

		$data=$this->db->get($this->table)->result();
		$total=$this->count_where($params);
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where($params)
	{	
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("FirstName LIKE '%$params->search%' OR LastName LIKE '%$params->search%' OR Address LIKE '%$params->search%' OR MobileNumber LIKE '%$params->search%' OR  Email LIKE '%$params->search%' ");
			
		}	

		return $this->db->count_all_results($this->table);
	}
    public function count_all()
	{
		return $this->db			
			->count_all_results($this->table);
	}
    public function get($id)
    {
        return $this->db->where('UserId', $id)->get($this->table)->row();
    }
    public function getwhere($column,$condition)
    {
        return $this->db->where($column,$condition)->get($this->table)->row();
    }
  
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('VId', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
//        $this->db->where('UserId', $id)->delete($this->table);
        return $this->db->where('VId', $id)->update($this->table, array('Status'=>'2'));
  //      return $this->db->affected_rows();
    }
    public function changestatus($id, $data)
    {
        return $this->db->where('VId', $id)->update($this->table, $data);
    }
	

}

?>