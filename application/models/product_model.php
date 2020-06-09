<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model
{
    public $table = 'product';

	public function get_Navigations_list(){
		return $this->db->select('NavigationId, NavName')->get('Navigations')->result();
	}
    public function get_all($Manufacture,$Price)
    {
    	if($Manufacture !=""){	
			$this->db->where_in('PManuId',array($Manufacture));    		
    	}

		return $this->db->where('PStatus','1')->get($this->table)->result();		
    }
    public function get_all_by_userid($id)
    {
		return $this->db->where('PManuId',$id)->get($this->table)->result();		
    }
	public function get_page($size, $pageno){
		$this->db
			// ->join('manufacture', 'product.PManuId = manufacture.MenuId', 'left')
			->join('users', 'users.UserId = product.PManuId', 'left')
			->limit($size, $pageno)
			->select('product.*,users.CompanyName');
// 			->get('category')
			
// ->join('Navigations', 'Roles.NavigationId = Navigations.NavigationId', 'left outer');
			
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
		->select('catId,catName,catStatus');
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
				// $this->db->like("catId",$params->search);
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
        return $this->db->where('ProductId', $id)->get($this->table)->row();
    }
  
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('ProductId', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('ProductId', $id)->delete($this->table);
        return $this->db->affected_rows();
    }
    public function changestatus($id, $data)
    {
        return $this->db->where('CatId', $id)->update($this->table, $data);
	}
	public function getId($id)
    {
        return $this->db->where('ProductId', $id)->get($this->table)->row();
	}
	public function getWithJoin($id)
    {

		$data['product_by_id']=$this->db->select('product.*,users.CompanyName')->join('users','users.UserId=product.PManuId')->where('product.ProductId', $id)->get($this->table)->row();		
		$data['product_by_pid']=$this->db->where('product.PProductId', $id)->get($this->table)->row();		
		return $data;
    }
	// print  json_encode($this->country->get_all());
}

?>