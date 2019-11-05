<?php
    /**
     * Blog Class
     *
     * @package     Blog
     * @subpackage  Index page controller
     * @category    Category
     * @author      T0590
     * @link        http://localhost/ci_training/blog
     */
    
    class Blog extends CI_Controller
    {   


        /**
         * email status after blog creation passes
         *
         * @var string
         */
        private $email_status;

        /**
         * status for completion of file upload
         *
         * @var string
         */
        private $status;

        /**
         * variable to store update blog id
         *
         * @var string
         */
        private $blog_id;

        /**
         * Constructor of the blog controller
         *
         * @param       none
         * @return      none
         */
        function __construct()
        {
            parent::__construct();
            $this->load->model('blog_model', 'blog');
            $this->load->helper('url');
            $this->load->library('session');
            $this->load->library('email');
        }

        /**
         * Call the basic views and models of the blog
         *
         * @param       none
         * @return      none
         */
        public function home()
        {    
            //text helper used for text field
            $this->load->helper('text');

            //check if the user is authorised for home page entry
            if (checkLogin() == FALSE) 
            {
                //clear all sections
                session_destroy();

                //call index function in user controller
                 redirect('user/logout');
            }

            if ($this->session->flashdata('email') != NULL) 
            {
               
              echo "<script>
                    alert('Blog Successfully Created');
                    </script>";
            }


            if ( ! file_exists(APPPATH.'views/pages/home.php'))
            {
                    // Whoops, we don't have a page for that!
                    show_404();
            }

            /**
             * Blog title passes
             *
             * @var string
             */
            $data['page_title'] = 'Personal Blog';
            
            /**
             * Blog content passes
             *
             * @var string
             */
            $data['content'] = $this->blog->get_data();

            $this->load->view('templates/header', $data);
            $this->load->view('pages/home', $data);
            $this->load->view('templates/footer');
        }

        /**
         * Call the form for upload blog
         *
         * @param      string $id varaible with value 1 for create & 2 for update
         * @return      none
         */
        public function form($id)
        {
            //load libraries and helpers
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->library('upload');

            if ( ! file_exists(APPPATH.'views/pages/form.php'))
            {
                    // Whoops, we don't have a page for that!
                    show_404();
            }

            //check if the user is authorised for home page entry
            if (checkLogin() == FALSE) 
            {
                //clear all sections
                session_destroy();

                //call index function in user controller
                 redirect('user/logout');
            }

           if ( ($id == 2) && ($this->session->flashdata('id') != NULL))
           {
                $this->blog_id = $this->session->flashdata('id');
           }

           if ($id == 1) 
           {
               /**
                * Blog title passes
                *
                * @var string
                */
                $data['page_title'] = 'Add Content To Your Blog';
            
           }

          if($id == 2)
           {
                /**
                 * Blog title passes to update page
                 *
                 * @var string
                 */
                $data['page_title'] = 'Update Your Blog';

                /**
                 * Get values from db
                 *
                 * @var array
                 */
                 $data['result'] = $this->blog->get_blog($this->blog_id);
           }
            
            //Validation rules are set up
            $this->form_validation->set_rules('title', 'Title', array('required', 'min_length[5]','max_length[50]'));
            $this->form_validation->set_rules('description', 'Description', array('required', 'min_length[20]'));
            
            /**
             * Blog category fetched array
             *
             * @var array
             */
            $data['drop_options'] = $this->blog->get_category();


            if($this->session->has_userdata('status') == NULL)
            {
                //set value to know page is initially loaded
                $this->session->set_userdata('status', -1);

                $this->load->view('templates/header', $data);
                $this->load->view('pages/form', $data);
                $this->load->view('pages/blog_file');
                $this->load->view('templates/footer');

            }

            /**************************************************
             *
             *FILE UPLOAD SECTION
             *
             **************************************************/
           
            //set of configurations
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 2048;
            $config['max_width']            = 800;
            $config['max_height']            = 900;

            //check that create or update going and assign filename
           if ( ($id == 2) && ($this->session->userdata('filename') != NULL) ) 
            {   

                $config['file_name'] = $this->session->userdata('filename');
            }

            if ($this->session->userdata('status') == -1) 
            {
                    if (($this->form_validation->run() === FALSE))
                    {  

                        $this->load->view('templates/header', $data);
                        $this->load->view('pages/form', $data);
                        $this->load->view('pages/blog_file');
                        $this->load->view('templates/footer');
                        
                    }

                    elseif (!empty($_FILES['blogfile']['name']) ) 
                    {   

                        //assign an encrypted name to the  file
                        if ($id == 1) 
                        {
                             $config['encrypt_name']  = TRUE;
                        }

                        //configuration setup in library
                        $this->load->library('upload',$config);
                        $this->upload->initialize($config);

                        if( $this->upload->do_upload('blogfile') == FALSE )
                        {
                            $this->load->view('templates/header', $data);
                            $this->load->view('pages/form', $data);

                            /**
                             * error of form
                             *
                             * @var string
                             */
                            $error = array('error' => $this->upload->display_errors());

                            $this->load->view('pages/blog_file',$error);
                            $this->load->view('templates/footer');
                        }

                        else
                        {
                            // 1 to show no error sucess validation
                            $this->session->set_userdata('status', 1);
                        }
                    }

                    else 
                    {   
                        // 1 to show no error sucess validation
                        $this->session->set_userdata('status', 1);
                    }
            }
            

            //On success redirect to insert data & goto home
            if($this->session->userdata('status') == 1)
           
            {   
                //unset the validation checker session
                $this->session->unset_userdata('status');

                //Validating the data before insertion
                $_POST["title"] = $this->check($_POST["title"]);
                $_POST["description"] = $this->check($_POST["description"]);
                $_POST["category"] = $this->check($_POST["category"]);
                
                //path to file 
                $this->session->set_userdata('file-name', $this->upload->data('file_name'));

                //new blog is created in db
                if($id == 1)
                {

                    //call the model to insert the form data
                    $this->blog->create();

                    //unset file name session
                    $this->session->unset_userdata('file-name');
                }

                //update on db is carryon
                if ($id == 2) 
                { 
                    //check file is empty or not to give name
                    if (empty($_FILES['blogfile']['name'])) 
                    {
                       //call the model to insert the form data
                        $this->blog->update($this->blog_id, $this->session->userdata('filename'));

                         //unset session data after use
                        $this->session->unset_userdata('filename');
                    }

                    else
                    {
                        //call the model to insert the form data
                        $this->blog->update($this->blog_id, $this->upload->data('file_name'));
                    }

                     //seesion user data with edit 
                    $this->session->unset_userdata('edit');
                }
        
                //send mail 
                $this->email_status = emailSend($this->upload->data('full_path'),$_SESSION['email'],'blog','');

                //send mail to admin
                emailSend($this->upload->data('full_path'),$_SESSION['admin_mail'],'admin',$_SESSION['username']);
             
                if ($this->email_status == TRUE) 
                {
                    //message to display after successfull creation of blog
                    $this->session->set_flashdata('email','Success');
                }

               //call the home display the blogs 
                redirect('blog/home');
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
         * Call to delete blog
         *
         * @param       string $id id of the blog 
         * @param       strign $userid current user's id 
         * @return      none
         */
        public function delete($id = '', $userid = '')
        {

            //check if the user is authorised for page entry
            if (checkLogin() == FALSE) 
            {
                //clear all sections
                session_destroy();

                //call index function in user controller
                 redirect('user/logout');
            }


            //get parameter value url decoded
            $decodeid = urldecode($id);
            $decodeuserid = urldecode($userid);

            //let the value base64 decoded
            $id = base64_decode($decodeid);
            $userid = base64_decode($decodeuserid);

            
            //user previlage checking and admin
            if(checkUser( $userid ) == FALSE)
            {
                if (checkRole() != 'admin') 
                {
                    redirect('user/logout');
                }
                
            }
            
            //call the model to delete the data
                $this->blog->delete_blog($id);

            //redirect to home
                redirect('blog/home');
        }


        /**
         * Call to update blog
         *
         * @param       string $id id of the blog 
         * @param       strign $userid current user's id 
         * @return      none
         */
        public function update($id = '', $userid = '')
        {   
            //load libraries and helpers
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->library('upload');

            //check if the user is authorised for page entry
            if (checkLogin() == FALSE) 
            {
                //clear all sections
                session_destroy();

                //call index function in user controller
                 redirect('user/logout');
            }

            //parameters passed are decoded
            $decodeid = urldecode($id);
            $decodeuserid = urldecode($userid);

            //let the value base64 decoded
            $id = base64_decode($decodeid);
            $userid = base64_decode($decodeuserid);


            //user previlage checking and admin
            if(checkUser($userid) == FALSE)
            {
                if (checkRole()!= 'admin') 
                {
                    redirect('user/logout');
                }
                
            }

            /**
             * Get values from db
             *
             * @var array
             */
            $data['result'] = $this->blog->get_blog($id);

            /**
             * Blog title passes to update page
             *
             * @var string
             */
            $data['page_title'] = 'Update Your Blog';

            /**
             * Blog category fetched array
             *
             * @var array
             */
            $data['drop_options'] = $this->blog->get_category();

            //seesion user data with edit 
            $this->session->set_userdata('edit',TRUE);

            //call the views
            $this->load->view('templates/header', $data);
            $this->load->view('pages/form', $data);
            $this->load->view('pages/blog_file');
            $this->load->view('templates/footer');
        }

    }
?>