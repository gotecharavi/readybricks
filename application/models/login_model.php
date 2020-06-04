<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login_model extends CI_Model
{
    public $table = 'users';

	
    public function get_all()
    {
		return $this->db->get($this->table)->result();		
    }
	function login($username, $password)
	{
		// echo $username;
		// echo $password;
	   $this->db->select('UserId, Email, FirstName, LastName, Role,RoleName');
	   $this -> db -> from('users');
	   $this->db->join('roles','roles.RoleId=users.Role','left');
	   $this -> db -> where('Email', $username);
	   $this -> db -> where('Password', md5($password));
       $this -> db -> where('Status', TRUE);
	   $this -> db -> limit(1);
	 
	   $query = $this -> db -> get();
	  
	   if($query -> num_rows() == 1)
	   {
	     return $query->row();
	   }
	   else
	   {
	     return false;
	   }
	}
	 public function get_role($roleId)
    {
        return $this->db->where('RoleId', $roleId)->get('roles')->row();
    }
}

?>