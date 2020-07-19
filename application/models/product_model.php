<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model
{
    public $table = 'product';

	public function get_Navigations_list(){
		return $this->db->select('NavigationId, NavName')->get('Navigations')->result();
	}
    public function get_all($Manufacture,$Price,$Sorting)
    {
    	if($Manufacture !=""){	
			$this->db->where_in('PManuId',explode(',',$Manufacture));    		
    	}
    	if($Price !=""){	
			$this->db->where('PPrice <='.$Price);    		
    	}
    	if($Sorting !=""){	
    		if($Sorting ==1){
    			$sort= "Desc";
    		}
    		if($Sorting ==2){
    			$sort= "Desc";
    		}
    		if($Sorting ==3){
    			$sort= "Asc";
    		}
			$this->db->order_by('PPrice',$sort);    		
    	}

		return $this->db->select('ProductId,PManuId,PName,PImage,PMinDeliveryDays,PPrice,PStock,PDescription,PAdditionalInfo,CompanyName')->join('users','users.UserId=product.PManuId')

		->where('product.IsAccount','1')
		->where('product.IsEdited','0')
		->where('product.PProductId','0')
		->where('product.PStatus','1')->get($this->table)->result();		
    }
    public function get_all_by_userid($id)
    {
		return $this->db->where('PManuId',$id)->where('product.PProductId','0')->get($this->table)->result();		
    }
	public function get_page($size, $pageno){

		$this->db
			// ->join('manufacture', 'product.PManuId = manufacture.MenuId', 'left')
			->join('users', 'users.UserId = product.PManuId', 'left')
		 	->order_by('product.ProductId desc')
			->limit($size, $pageno)
			->select('product.*,users.CompanyName');
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
			->join('users', 'users.UserId = product.PManuId', 'left')
		 	->order_by('product.ProductId desc')
			->select('product.*,users.CompanyName');
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("product.PName LIKE '%$params->search%' OR CompanyName LIKE '%$params->search%'
					OR PPrice LIKE '%$params->search%'");
//				$this->db->like("catName",$params->search);
			}	

		$data=$this->db->get($this->table)->result();
		$total=$this->count_where($params);
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where($params)
	{	
		$this->db
			->join('users', 'users.UserId = product.PManuId', 'left');

		if(isset($params->search) && !empty($params->search)){
				$this->db->where("product.PName LIKE '%$params->search%' OR CompanyName LIKE '%$params->search%'
					OR PPrice LIKE '%$params->search%'");
				// $this->db->like("catId",$params->search);
				// $this->db->like("catName",$params->search);
			}	
		return $this->db->count_all_results($this->table);
	}
    public function count_all()
	{
		return $this->db			
			->join('users', 'users.UserId = product.PManuId', 'left')
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
        return $this->db->where('ProductId', $id)->update($this->table, $data);
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