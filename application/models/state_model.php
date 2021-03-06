<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class State_model extends CI_Model
{
    public $table = 'state';

	public function get_Navigations_list(){
		return $this->db->select('NavigationId, NavName')->get('Navigations')->result();
	}
    public function get_all()
    {
		return $this->db->get($this->table)->result();		
    }
    public function get_all_by_countryId($id)
    {
		return $this->db->where('SCountryId',$id)->get($this->table)->result();		
    }
	public function get_page($size, $pageno){
		$this->db
			->limit($size, $pageno)
			->select('state.StateId,state.SCountryId,state.SName,state.SStatus,country.CName')
			->join('country', 'country.CId = state.SCountryId', 'inner')
			->order_by('StateId desc');

		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();

		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
		->select('state.StateId,state.SCountryId,state.SName,state.SStatus,country.CName')
		->join('country', 'country.CId = state.SCountryId', 'inner')
		->order_by('StateId desc');
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("CName LIKE '%$params->search%' OR SName LIKE '%$params->search%'");
//				$this->db->like("catName",$params->search);
			}	

		$data=$this->db->get($this->table)->result();
		$total=$this->count_where($params);
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where($params)
	{	
		$this->db
		->join('country', 'country.CId = state.SCountryId', 'inner');
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("CName LIKE '%$params->search%'");
				// $this->db->like("catId",$params->search);
				// $this->db->like("catName",$params->search);
			}	
		return $this->db->count_all_results($this->table);
	}
    public function count_all()
	{
		return $this->db			
			->join('country', 'country.CId = state.SCountryId', 'inner')
			->count_all_results($this->table);
	}
    public function get($id)
    {
        return $this->db->where('StateId', $id)->get($this->table)->row();
	}
	
	public function getName($name,$country,$id=NULL)
    {
		if($id){
			return $this->db->where('StateId !=', $id)->where('SName',$name)->where('SCountryId',$country)->get($this->table)->row();
		}
        return $this->db->where('SName',$name)->where('SCountryId',$country)->get($this->table)->row();
    }
  
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('StateId', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('StateId', $id)->delete($this->table);
        return $this->db->affected_rows();
    }
    public function changestatus($id, $data)
    {
        return $this->db->where('CatId', $id)->update($this->table, $data);
    }
	
}

?>