<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
			// menggunakan title
			$this->template->title = 'Dashboard';

			$data = array(); // memanggil fungsi model dengan array / fungsi lainnya
			$this->template->content->view('v_dashboard', $data);

			// menggunakan footer
			$this->template->footer = 'nusantaradigital.com';

			// Publish the template
			$this->template->publish();
	}

}

/* End of file Dashboard.php */
/* Location: ./application/modules/dashboard/controllers/Dashboard.php */
