<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Driver_model extends CI_Model
{
    public $table = 'driver';

    public function get_all()
    {
        return $this->db->get($this->table)->result();      
    }
    public function get_all_with_id($id)
    {
        return $this->db
         ->where('driver.IsAccount','1')
         ->where('driver.PDriverId =','0')
         ->where("(driver.DStatus ='1' AND driver.IsEdited ='0')")
         ->where('DTransId',$id)->get($this->table)->result();      
    }
    public function get_all_by_id($id)
    {
        return $this->db
         ->where('driver.PDriverId =','0')
         ->where('DTransId',$id)->get($this->table)->result();      
    }
    public function get_Transporter_list()
    {
        return $this->db->where('Role','4')->get('users')->result();      
    }
  
    public function get_page($size, $pageno){
        $this->db
            ->limit($size, $pageno)
             ->select('driver.*,users.CompanyName')
             ->join('users', 'users.UserId = driver.DTransId', 'inner')
             ->where('users.PUserId =','0')
             ->where('driver.PDriverId =','0')
            ->where('driver.IsAccount','1');
        
        $data=$this->db->get($this->table)->result();
        $total=$this->count_all();
        return array("data"=>$data, "total"=>$total);
    }
    public function get_page_where($size, $pageno, $params){
        $this->db->limit($size, $pageno)
         ->select('driver.*,users.CompanyName')
         ->join('users', 'users.UserId = driver.DTransId', 'inner')
         ->where('users.PUserId =','0')
         ->where('driver.PDriverId =','0')
        ->where('driver.IsAccount','1');
        if(isset($params->search) && !empty($params->search)){
                $this->db->where("DFirstName LIKE '%$params->search%' OR DLastName LIKE '%$params->search%'
                        OR DMobileNumber LIKE '%$params->search%'
                        OR DLicenceNo LIKE '%$params->search%'
                    ");

        }   

        $data=$this->db->get($this->table)->result();
        $total=$this->count_where($params);
        return array("data"=>$data, "total"=>$total);
    }
    public function count_where($params)
    {   
        if(isset($params->search) && !empty($params->search)){
                $this->db->where("DFirstName LIKE '%$params->search%' OR DLastName LIKE '%$params->search%'
                        OR DMobileNumber LIKE '%$params->search%'
                        OR DLicenceNo LIKE '%$params->search%'
                    ");
            
        }   

        return $this->db->count_all_results($this->table);
    }
    public function count_all()
    {
        return $this->db            
             ->join('users', 'users.UserId = driver.DTransId', 'inner')
             ->where('users.PUserId =','0')
             ->where("(driver.DStatus ='1' AND driver.IsEdited ='0')")

            ->count_all_results($this->table);
    }
    public function get($id)
    {
        return $this->db->where('DId', $id)->get($this->table)->row();
    }
    public function getwhere($column,$condition)
    {
        return $this->db->where($column,$condition)->get($this->table)->row();
    }
    public function getwherenotid($column,$condition,$id)
    {
        return $this->db->where($column,$condition)->where('DId !=',$id)->get($this->table)->row();
    }
  
    public function getWithJoin($id)
    {

        $data['driver_by_id']=$this->db->select('driver.*,users.CompanyName')->join('users','users.UserId=driver.DTransId')->where('driver.DId', $id)->get($this->table)->row();       
        $data['driver_by_pid']=$this->db->select('driver.*,users.CompanyName')->join('users','users.UserId=driver.DTransId')->where('driver.PDriverId', $id)->get($this->table)->row();       

        return $data;
    }
    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('DId', $id)->update($this->table, $data);
    }
    public function checklogin($email)
    {
        return $this->db->select('DId,DFirstName,DLastName,DPassword,DMobileNumber,DStatus')->where("DMobileNumber ='".$email."' AND IsEdited='0' ")->get($this->table)->row(); //OR  Email='".$email."'
    }

    public function delete($id)
    {
       $this->db->where('DId', $id)->delete($this->table);
       return $this->db->affected_rows();
    }
    public function changestatus($id, $data)
    {
        return $this->db->where('DId', $id)->update($this->table, $data);
    }
    public function approve_driver($id)
    {

        return $this->db->where('DId', $id)->update('driver', ['IsAccount'=>'1','Reason'=>'','IsEdited'=>'0','DStatus'=>'1']);
    }
    public function rejectSaveDriver($data)
    {
        if(isset($data->data->DId)){
              $this->db->where('PDriverId', $data->data->DId)->delete('driver');

            return $this->db->where('DId', $data->data->DId)->update('driver', ['Reason'=>$data->data->Reason,'IsEdited'=>'0','IsAccount'=>'2']);
        }
        // return $this->db->where('UserId', $data->data->UserId)->update('users', ['Reason'=>$data->data->Reason,'IsAccount'=>'2']);

    }
	

}

?>