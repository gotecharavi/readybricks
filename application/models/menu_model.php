<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public $table = 'menu';

	public function get_Category_list(){
		return $this->db->select('catId, catName')->where('catStatus = 1')->get('category')->result();
	}
	//public function get_Navigations_list(){
	// 	return $this->db->select('NavigationId, NavName')->get('Navigations')->result();
	// }
    public function get_all()
    {
		return $this->db->get($this->table)->result();		
    }
	public function get_page($size, $pageno){
		$this->db
			->limit($size, $pageno)
			->select('MenuId,ParentCatId,catName,Name,Info,Price,Image,Stock,Status')
			->join('category', 'ParentCatId = catId', 'left outer');
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
		->select('MenuId,ParentCatId,catName,Name,Info,Price,Image,Stock,Status')
		->join('category', 'ParentCatId = catId', 'left outer');
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("Name LIKE '%$params->search%' OR Info LIKE '%$params->search%' OR Price LIKE '%$params->search%' OR Stock LIKE '%$params->search%' ");

		}	

		$data=$this->db->get($this->table)->result();
		$total=$this->count_where($params);
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where($params)
	{	
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("Name LIKE '%$params->search%' OR Info LIKE '%$params->search%' OR Price LIKE '%$params->search%' OR Stock LIKE '%$params->search%' ");
			
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
        return $this->db->where('MenuId', $id)->get($this->table)->row();
    }
    public function get_where_cat($id)
    {
        return $this->db->where('ParentCatId', $id)->get($this->table)->result();
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
        $this->db->where('MenuId', $id)->delete($this->table);
        return $this->db->affected_rows();
    }
    public function changestatus($id, $data)
    {
        return $this->db->where('MenuId', $id)->update($this->table, $data);
    }
	

}

?>