<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loginmodel extends CI_Model {

	function login($email, $password)
	{
		$search_email = $this->db->join('users_groups', 'users_groups.user_id = users.id', 'left')
       				 			 ->join('groups', 'groups.id = users_groups.group_id', 'left')
       				 			 ->where('email', $email)
       				 			 ->get('users',1);

		//validasi keberadaaan user
        if ($search_email->num_rows() > 0) {
        	
        	$get_row = $search_email->row();//membuat objek user

        	// validasi status aktif user
        	$active_state = $get_row->active;
        	if ($active_state == 0) {
      			$this->session->set_flashdata('notif', 'Akun anda tidak aktif silahkan hubungi admin');
      			redirect('Login','refresh');
        	}

        	// validasi status aktif user
        	$get_password = $get_row->password;

        	if (password_verify($password , $get_password)) { // validasi password user

        		// return value jika berhasil

        		// setting session
        		$this->set_session($get_row);
        		$update_last_login = $this->db->where('id', $this->session->userdata('user_id'))
        									  ->update('users', array('last_login' => time()));

        		return true;
        		// return value jika berhasil
        	}else{
        		// gagal login
				$this->session->set_flashdata('notif', 'Maaf password yang anda masukan salah');
      			redirect('Login','refresh');
        	}
		// jika tidak terdaftar
        }else{
      		$this->session->set_flashdata('notif', 'Akun Anda Tidak Terdaftar');
      		redirect('Login','refresh');
        }
	}	


	function set_session($user)
	{
		$session = array(
		    'user_id'        => $user->id, //id user
		    'nama'       => $user->name,
		    'email'          => $user->email,
		    'level'     	 => $user->group_id,
		    'login_stat'     => TRUE,
		    'base_url' 		 => $user->url,
		    'old_last_login' => $user->last_login
		);

		$this->session->set_userdata($session);

		return TRUE;
	}

  function logout()
  {
    return $this->session->sess_destroy();
  }

}

/* End of file Loginmodel.php */
/* Location: ./application/modules/Login/models/Loginmodel.php */