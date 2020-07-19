<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicle_model extends CI_Model
{
    public $table = 'vehicle';

    public function get_all()
    {
        return $this->db->get($this->table)->result();      
    }
    public function get_all_with_id($id)
    {
        return $this->db
          ->where('vehicle.IsAccount','1')
          ->where('vehicle.PVehicleId =','0')
         ->where("(vehicle.VStatus ='1' AND vehicle.IsEdited ='0')")
         ->where('VTransId',$id)->get($this->table)->result();      
    }
    public function get_all_by_id($id)
    {
        return $this->db
         ->where('vehicle.PVehicleId =','0')
         ->where('VTransId',$id)->get($this->table)->result();      
    }
    public function get_Transporter_list()
    {
        return $this->db->where('Role','4')->get('users')->result();      
    }
  
  	public function get_page($size, $pageno){
		$this->db
			->limit($size, $pageno)
             ->select('vehicle.*,users.CompanyName')
             ->join('users', 'users.UserId = vehicle.VTransId', 'inner')
             ->where('users.PUserId =','0')
             ->where('vehicle.PVehicleId =','0')
            ->where('vehicle.IsAccount','1')
            ->where('vehicle.IsEdited','0');
 		
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
         ->select('vehicle.*,users.CompanyName')
         ->join('users', 'users.UserId = vehicle.VTransId', 'inner')
         ->where('users.PUserId =','0')
         ->where('vehicle.PVehicleId =','0')
         ->where('vehicle.IsAccount','1');
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("VRcNo LIKE '%$params->search%' OR VNo LIKE '%$params->search%'");

		}	

		$data=$this->db->get($this->table)->result();
		$total=$this->count_where($params);
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where($params)
	{	
        $this->db
         ->join('users', 'users.UserId = vehicle.VTransId', 'inner')
         ->where('users.PUserId =','0')
         ->where('vehicle.PVehicleId =','0')
         ->where('vehicle.IsAccount','1');

		if(isset($params->search) && !empty($params->search)){
				$this->db->where("VRcNo LIKE '%$params->search%' OR VNo LIKE '%$params->search%' ");
			
		}	

		return $this->db->count_all_results($this->table);
	}
    public function count_all()
	{
		return $this->db			
         ->join('users', 'users.UserId = vehicle.VTransId', 'inner')
         ->where('users.PUserId =','0')
         ->where('vehicle.PVehicleId =','0')
         ->where('vehicle.IsAccount','1')

			->count_all_results($this->table);
	}
    public function get($id)
    {
        return $this->db->where('VId', $id)->get($this->table)->row();
    }
    public function getwhere($column,$condition)
    {
        return $this->db->where($column,$condition)->get($this->table)->row();
    }
    public function getWithJoin($id)
    {

        $data['vehicle_by_id']=$this->db->select('vehicle.*,users.CompanyName')->join('users','users.UserId=vehicle.VTransId')->where('vehicle.VId', $id)->get($this->table)->row();       
        $data['vehicle_by_pid']=$this->db->select('vehicle.*,users.CompanyName')->join('users','users.UserId=vehicle.VTransId')->where('vehicle.PVehicleId', $id)->get($this->table)->row();       

///        $this->db->where('vehicle.PVehicleId', $id)->get($this->table)->row();      
        return $data;
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
       $this->db->where('VId', $id)->delete($this->table);
       return $this->db->affected_rows();
    }
    public function changestatus($id, $data)
    {
        return $this->db->where('VId', $id)->update($this->table, $data);
    }
    public function approve_vehicle($id)
    {

        return $this->db->where('VId', $id)->update('vehicle', ['IsAccount'=>'1','Reason'=>'','IsEdited'=>'0','VStatus'=>'1']);
        // $this->db->where('PUserId', $id)->delete('users');
    }
    public function rejectSaveVehicle($data)
    {
        if(isset($data->data->VId)){
              $this->db->where('PVehicleId', $data->data->VId)->delete('vehicle');
            return $this->db->where('VId', $data->data->VId)->update('vehicle', ['Reason'=>$data->data->Reason,'IsEdited'=>'0','IsAccount'=>'2']);
        }
        // return $this->db->where('UserId', $data->data->UserId)->update('users', ['Reason'=>$data->data->Reason,'IsAccount'=>'2']);

    }
	

}

?>