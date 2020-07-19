<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City_model extends CI_Model
{
    public $table = 'city';

	public function get_Navigations_list(){
		return $this->db->select('NavigationId, NavName')->get('Navigations')->result();
	}
    public function get_all()
    {
		return $this->db->get($this->table)->result();		
    }
    public function get_all_by_countryId_stateId($cId,$sId)
    {
		return $this->db->where('CCountryId',$cId)->where('CStateId',$sId)->get($this->table)->result();		
    }
	public function get_page($size, $pageno){
		$this->db
			->limit($size, $pageno)
			->select('city.CityId,city.CName,city.CStatus,city.CCountryId,city.CStateId,state.SName,country.CName as country_name,district.DistrictId,district.DName')
			->join('district','district.DistrictId=city.CDistrictId')
			->join('state','state.StateId=city.CStateId')
			->join('country','country.CId=city.CCountryId')
			->order_by('CityId desc');
// 			->get('category')
			
// ->join('Navigations', 'Roles.NavigationId = Navigations.NavigationId', 'left outer');
			
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
		->select('city.CityId,city.CName,city.CStatus,city.CCountryId,city.CStateId,state.SName,country.CName as country_name,district.DistrictId,district.DName')
		->join('district','district.DistrictId=city.CDistrictId')
		->join('state','state.StateId=city.CStateId')
		->join('country','country.CId=city.CCountryId')
		->order_by('CityId desc');
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("country.CName LIKE '%$params->search%' OR SName LIKE '%$params->search%' OR DName LIKE '%$params->search%' OR city.CName LIKE '%$params->search%'");
//				$this->db->like("catName",$params->search);
			}	

		$data=$this->db->get($this->table)->result();
		$total=$this->count_where($params);
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where($params)
	{	
		$this->db
// ->join('Navigations', 'Roles.NavigationId = Navigations.NavigationId', 'left outer');
		->join('district','district.DistrictId=city.CDistrictId')
		->join('state','state.StateId=city.CStateId')
		->join('country','country.CId=city.CCountryId');

		if(isset($params->search) && !empty($params->search)){
				$this->db->where("country.CName LIKE '%$params->search%' OR SName LIKE '%$params->search%' OR DName LIKE '%$params->search%' OR city.CName LIKE '%$params->search%'");
				// $this->db->like("catId",$params->search);
				// $this->db->like("catName",$params->search);
			}	
		return $this->db->count_all_results($this->table);
	}
    public function count_all()
	{
		return $this->db			
			->join('district','district.DistrictId=city.CDistrictId')
			->join('state','state.StateId=city.CStateId')
			->join('country','country.CId=city.CCountryId')
			->count_all_results($this->table);
	}
    public function get($id)
    {
        return $this->db->where('CityId', $id)->get($this->table)->row();
	}
	public function getName($name,$district,$state,$country,$id=null)
    {
		if($id){
			return $this->db->where('CName', $name)->where('CStateId',$state)->where('CCountryId',$country)->where('CityId !=',$id)->get($this->table)->row();
		}
        return $this->db->where('CName', $name)->where('CDistrictId',$district)->where('CStateId',$state)->where('CCountryId',$country)->get($this->table)->row();
    }
  
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('CityId', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('CityId', $id)->delete($this->table);
        return $this->db->affected_rows();
    }
    public function changestatus($id, $data)
    {
        return $this->db->where('CatId', $id)->update($this->table, $data);
    }
	
}

?>