<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model
{
    public $table = 'users';

    public function get_all()
    {
        return $this->db->get($this->table)->result();      
    }
    public function get_all_employee()
    {
        return $this->db->select("UserId,FirstName,LastName,PhoneNumber")->where("Role = '3' AND Status = '1' ")->get($this->table)->result();      
    }
    public function get_all_users()
    {
        return $this->db->where("Role != '1' AND Status = '1' ")->get($this->table)->result();      
    }
	public function get_page($size, $pageno){
		$this->db
			->limit($size, $pageno)
			->select('users.UserId,users.FirstName,users.LastName,users.Address,users.PhoneNumber,users.Image,users.Email,users.Password,users.Role,users.Status')
            ->where("Role != '1'") 
            ->where("Status != '2'"); 
		
		$data=$this->db->get($this->table)->result();
		$total=$this->count_all();
		return array("data"=>$data, "total"=>$total);
	}
	public function get_page_where($size, $pageno, $params){
		$this->db->limit($size, $pageno)
		->select('users.UserId,users.FirstName,users.LastName,users.Address,users.PhoneNumber,users.Image,users.Email,users.Password,,users.Role,users.Status')
		->where("Role != '1'")	
        ->where("Status != '2'"); 
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("FirstName LIKE '%$params->search%' OR LastName LIKE '%$params->search%' OR Address LIKE '%$params->search%' OR PhoneNumber LIKE '%$params->search%' OR  Email LIKE '%$params->search%' ");

		}	

		$data=$this->db->get($this->table)->result();
		$total=$this->count_where($params);
		return array("data"=>$data, "total"=>$total);
	}
	public function count_where($params)
	{	
		if(isset($params->search) && !empty($params->search)){
				$this->db->where("FirstName LIKE '%$params->search%' OR LastName LIKE '%$params->search%' OR Address LIKE '%$params->search%' OR PhoneNumber LIKE '%$params->search%' OR  Email LIKE '%$params->search%' ");
			
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
        return $this->db->where('UserId', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
//        $this->db->where('UserId', $id)->delete($this->table);
        return $this->db->where('UserId', $id)->update($this->table, array('Status'=>'2'));
  //      return $this->db->affected_rows();
    }
    public function getId($id)
    {
        return $this->db->where('UserId', $id)->get($this->table)->row();
    }
    public function changestatus($id, $data)
    {
        return $this->db->where('UserId', $id)->update($this->table, $data);
    }
	
    public function getemail($email)
    {
        return $this->db->where('Email', $email)->get($this->table)->row();
    }
    public function checkEmail($email)
    {
        return $this->db->where('Email',$email)->where('Status','1')->get($this->table)->row();
    }

    public function checkMobileNumber($MobileNumber)
    {
        return $this->db->where("MobileNumber",$MobileNumber)->where('Status','1')->get($this->table)->row();
    }

    public function checklogin($email)
    {
        return $this->db->select('UserId,Role,Type,Password')->where("MobileNumber ='".$email."' OR  Email='".$email."' AND Role!='1' AND Status= '1' ")->get($this->table)->row();
    }
    public function checkSocialEmail($email)
    {
        return $this->db->select("UserId,MobileNumber,Email,Role")->where('Email',$email)->where('Type !=','Normal')->where('Status','1')->get($this->table)->row();
    }

    public function getmobile($mobile)
    {
        return $this->db->where('PhoneNumber', $mobile)->get($this->table)->row();
    }


}

?>