<?php 
    /**
     * User class
     *
     * @package     File
     * @subpackage  User class for user based operations
     * @category    Category
     * @author      T0590
     * @link        http://localhost/ci_training/blog
     */

    class User extends CI_Controller
    {
        /**
         * Constructor of the controller
         *
         * @param       none
         * @return      none
         */
        function __construct()
        {
            parent::__construct();
            $this->load->model('user_model', 'user');
            $this->load->helper('url');
            $this->load->library('session');
        }

        /**
         * Function for the index page
         *
         * @param       none
         * @return      none
         */
        public function index()
        {   
            
            //loads helper functions and libraries 
            $this->load->helper('form');
            $this->load->library('form_validation');

            if ( ! file_exists(APPPATH.'views/pages/login.php'))
            {
                    // Whoops, we don't have a page for that!
                    show_404();
            }

            //set admin mail and details
            $this->user->getAdmin();
            
            /**
             * title passes through this variable
             *
             * @var string
             */
            $data['page_title'] = 'Login Page';

            //Validation rules are set up
            $this->form_validation->set_rules('username', 'Username', array('required', 'min_length[5]'));
            $this->form_validation->set_rules('password', 'Password', array('required', 'min_length[8]'));

           //check the user logged or not
            if (checkLogin() == FALSE )
            {
                //validation of form are checked
                if ($this->form_validation->run() === FALSE) 
            
                {
                    //call the views for the display
                    $this->load->view('pages/login',$data);

                    $this->load->view('templates/footer');
                }

                else
                {   
                    //Validating the data before insertion
                    $_POST["username"] = $this->checkData($_POST["username"]);
                    $_POST["password"] = $this->checkData($_POST["password"]);

                    //call a model check_user function to check user in db
                    $number = $this->user->checkUser();
                    

                    if ($number == 1) 
                    {
                        //redirect to home page in blog controller
                        redirect('blog/home');
                    }
                    else
                    {   
                        //session create for user identifier
                        $this->session->set_userdata('unauthorised', 'Unauthorised Entry!!');

                        //call index function
                        redirect(current_url());
                    }
                }
            }
            else
            {
                //redirect to home page
                redirect('blog/home');
            }
        }

        /**
         * Function for checking the data with XSS & htmlescape
         *
         * @param       string $item Input strings
         * @return      string $item validated string
         */
        private function checkData($value)
        {
            //Validate with XSS filter
            $value = $this->security->xss_clean($value);
            
            //Validate with escape
            $value = html_escape($value);

            return $value;
        }

        /**
         * Function for the logout operations
         *
         * @param       none
         * @return      none
         */
        public function logout()
        {
            //sessions are cleared
            session_destroy();

            /**
             * title passes through this variable
             *
             * @var string
             */
            $data['page_title'] = 'Login Page';

            //redirect to index pages
            $this->index();

        }

    }    
?>