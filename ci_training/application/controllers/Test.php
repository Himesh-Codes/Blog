<?php
  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   *    http://example.com/index.php/test
   *  - or -
   *    http://example.com/index.php/test/index
   *  - or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/test/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */
  /**
   *  
   */
  class Test extends CI_Controller
  {

      
      public function email()
      {
            $this->email->from('emailtest2019october@gmail.com','Himesh');
            $this->email->to('himesh.sylesh@triassicsolutions.com');
            $this->email->subject('Email testing');
            $this->email->message('Email testing successfully run');
            $this->email->attach('C:\Users\T0590\Downloads\CPP-TrainingSchedule.xlsx');
            if (!$this->email->send()) 
            {
                echo "Mail send failed";
            }
            else
            {
                echo "Mail send succesfully";
            }
      }

      function __construct()
      {
            parent::__construct();
            $this->load->library('email');
      }
  }
?>