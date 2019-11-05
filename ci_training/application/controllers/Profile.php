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
    class Profile extends CI_Controller
    {   
        /**
         * title passes through this variable
         *
         * @var string
         */
        public $data;


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

            //loads helper functions and libraries 
            $this->load->helper('form');
            $this->load->library('form_validation');
        }

        /**
         * Function for the profile page
         *
         * @param       none
         * @return      none
         */
        public function user_profile()
        {   
            //check if the user is authorised for profile page entry
            if (checkLogin() == FALSE) 
            {
                //clear all sections
                session_destroy();

                //call index function in user controller
                 redirect('user/logout');
            }

            if ( ! file_exists(APPPATH.'views/pages/registration.php'))
            {
                    // Whoops, we don't have a page for that!
                    show_404();
            }

            /**
             * title passes through this variable
             *
             * @var string
             */
            $data['page_title'] = 'Profile Page';


            /**
             * Blog category fetched array
             *
             * @var array
             */
            $data['options'] = $this->user->get_category();

            /**
             * Get values from db
             *
             * @var array
             */
            $data['result'] = $this->user->get_data();

            $this->load->view('templates/header', $data);
            $this->load->view('pages/registration',$data);
            $this->load->view('templates/footer');
        }

        /**
         * Function for the registration operations
         *
         * @param      integer $num a variable to determine 2-update or 1-create 
         * @return      none
         */
        public function registration($num)
        {

            if ( ! file_exists(APPPATH.'views/pages/registration.php'))
            {
                    // Whoops, we don't have a page for that!
                    show_404();
            }

            //redirect if login
            if (checkLogin() == TRUE) 
            {
                if ($num == 1) 
                {
                    redirect('blog/home');
                }
              
            }

            if ($num == 2) 
            {
              /**
                 * Get values from db
                 *
                 * @var array
                 */
                $data['result'] = $this->user->get_data($_SESSION['user_id']);

            }
            
             if ($num == 2) 
             {
                
                /**
                 * title passes through this variable
                 *
                 * @var string
                 */
                $data['page_title'] = 'Profile Page';
             }

            if($num == 1)
             {
                /**
                 * title passes through this variable
                 *
                 * @var string
                 */
                $data['page_title'] = 'Registration Page';
             }
             

            /**
             * Blog category fetched array
             *
             * @var array
             */
            $data['options'] = $this->user->get_category();

            if ($num == 1) 
            {
                //Validation rules are set up
                $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|is_unique[user.username]|alpha_dash');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
                $this->form_validation->set_rules('confirm-password', 'Confirm Password', 'trim|required|matches[password]');
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.emailid]');
            }
            
           if($num == 2)
            {
                //Validation rules are set up
                $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|alpha_dash|callback_username_check');
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
            }
            $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required|alpha');
            $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required|alpha');
            $this->form_validation->set_rules('gender', 'Gender', 'trim');
           
            $this->form_validation->set_rules('list[]', 'Subscription', 'trim|required');
            $this->form_validation->set_rules('frequency', 'Subscription Frequency', 'trim|required');
       
            //user setting messages for errors
            $this->form_validation->set_message('is_unique', 'The %s is already taken please enter other');

            //validation of form are checked
            if ($this->form_validation->run() === FALSE) 
        
            {
                //call the views for the display
                $this->load->view('templates/header', $data);
                $this->load->view('pages/registration',$data);

                $this->load->view('templates/footer');

            }

            else
            {
               
                //Validating the data before insertion
                $user_data["username"] = $this->check($_POST["username"]);

                if ($num == 1) 
                {
                    $user_data["password"] = $this->check($_POST["password"]);
                    $user_data["confirm-password"] = $this->check($_POST["confirm-password"]);
                }
               
                $user_data["firstname"] = $this->check($_POST["firstname"]);
                $user_data["lastname"] = $this->check($_POST["lastname"]);
                $user_data["email"] = $this->check($_POST["email"]);
                $user_data["gender"] = isset($_POST["gender"]) ? $_POST["gender"] : '';
                $user_data["frequency"] = isset($_POST["frequency"]) ? $_POST["frequency"] : '';

               if ($num == 1) 
               {
                  //call the model to insert the form data
                    $this->user->create_account($user_data);

                    //set a message for sucess
                    $this->session->set_flashdata('success_account','Account created successfully');

                    //if success redirect to login
                    redirect('user');
               }

               if($num == 2)
               {
                 //call the model to update the form data in db
                 $this->user->update_account($user_data);

                 //set a message for sucess
                 $this->session->set_flashdata('success_account','Account updated successfully');

                 //if success redirect to login
                redirect('blog/home');

               }
            }
        }

         /**
         * Function for checking the data with XSS & htmlescape
         *
         * @param       string $item Input strings
         * @return      string $item validated string
         */
        private function check($value)
        {
            //Validate with XSS filter
            $value = $this->security->xss_clean($value);
            
            //Validate with escape
            $value = html_escape($value);

            return $value;
        }
        
        /**
         * Function for the delete profile operations
         *
         * @param       none
         * @return      none
         */
        public function delete_profile()
        {
            //check if the user is authorised for page entry
            if (checkLogin() == FALSE) 
            {
                //clear all sections
                session_destroy();

                //call index function in user controller
                 redirect('user/logout');
            }
        ?>
            <!-- confirmation -->
            <script type="text/javascript">
                    drop_profile();
            </script>

        <?php
            //call the model to delete user data
            $this->user->delete_account();

            //if success redirect to login
            redirect('user/logout');
        }

        /**
         * Function for the username check
         *
         * @param       string   $name for check username
         * @return      boolean
         */
        public function username_check($name)
        {
            //check the username in db
            $result = $this->user->get_usernames();

            $return = TRUE;

            $this->form_validation->set_message('username_check', 'The {field} is already used');

            foreach ($result as $row) 
            {
               if (strcmp($row['username'], $name) == 0) 
               {
                   $return = FALSE;
               }

            }

            return $return;
        }

        /**
         * Function for the email check
         *
         * @param       string   $mail for check username
         * @return      boolean
         */
        public function email_check($mail)
        {
            //check the username in db
            $result = $this->user->get_emails();

            $return = TRUE;

            $this->form_validation->set_message('email_check', 'The {field} is already used');

            foreach ($result as $row) 
            {
               if (strcmp($row['emailid'], $mail) == 0) 
               {
                   $return = FALSE;
               }

            }

            return $return;
        }
    }    
?>