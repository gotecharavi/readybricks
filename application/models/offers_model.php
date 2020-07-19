<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offers_model extends CI_Model
{
    public $table = 'offers';

    public function get_all()
    {
		return $this->db->where('CStatus','1')->get($this->table)->result();		
    }
	public function get_page($size, $pageno){
		$this->db
			->limit($size, $pageno);
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno);
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("catName LIKE '%$params->search%'");
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
				$this->db->where("catName LIKE '%$params->search%'");
				// $this->db->like("CId",$params->search);
				// $this->db->like("catName",$params->search);
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
        return $this->db->where('CId', $id)->get($this->table)->row();
    }
  
	public function checkName($name,$id=null){
		if($id){
			return $this->db->where('CName', $name)->where('CId !=',$id)->get($this->table)->row();
		}
		return $this->db->where('CName', $name)->get($this->table)->row();
	}
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
        $this->db->where('OId', $id)->delete($this->table);
        return $this->db->affected_rows();
    }
    public function changestatus($id, $data)
    {
        return $this->db->where('OId', $id)->update($this->table, $data);
    }
	
}

?>