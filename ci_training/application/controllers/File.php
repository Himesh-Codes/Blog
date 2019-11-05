<?php 
    /**
     * User class
     *
     * @package     File
     * @subpackage  FIle class for user based file operations
     * @category    Category
     * @author      T0590
     * @link        http://localhost/ci_training/blog
     */
    class File extends CI_Controller
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
            $this->load->model('file_model', 'files');
            $this->load->library('session');
            $this->load->helper(array('form', 'url', 'file'));
            $this->load->library('upload');
            $this->load->library('email');
        }

        /**
         * Function for the file index
         *
         * @param       none
         * @return      none
         */
        public function index()
        {   
            //check if the user is authorised for profile page entry
            if (checkLogin() == FALSE) 
            {
                //clear all sections
                session_destroy();

                //call index function in user controller
                 redirect('user/logout');
            }

            if ( ! file_exists(APPPATH.'views/pages/file_page.php'))
            {
                    // Whoops, we don't have a page for that!
                    show_404();
            }

            /**
             * title passes through this variable
             *
             * @var string
             */
            $data['page_title'] = 'File Page';

            //add a reference session to upload method
            $this->session->set_tempdata('HTTP_REFER','TRUE',300);

            $this->load->view('templates/header', $data);
            $this->load->view('pages/file_page',array('error'=> ''));

            //call database retrieve

            /**
             * Blog content passes
             *
             * @var string
             */
            $data['content'] = $this->files->get_data();

            $this->load->view('pages/file_preview',$data);
            $this->load->view('templates/footer');

        }

        /**
         * Function for the file upload 
         *
         * @param       none
         * @return      none
         */
        public function do_uploads()
        { 
            //check if the user is authorised for home page entry
            if (checkLogin() == FALSE) 
            {
                //clear all sections
                session_destroy();

                //call index function in user controller
                 redirect('user/logout');
            }
           
            //check if path is refferred by index page
            if(!isset($_SESSION['HTTP_REFER']))
            {
                // redirect them to index
                redirect('file/index');
            }

            if ( ! file_exists(APPPATH.'views/pages/file_page.php'))
            {
                    // Whoops, we don't have a page for that!
                    show_404();
            }

            /**
             * title passes through this variable
             *
             * @var string
             */
            $data['page_title'] = 'File Page';

            //set of configurations
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'gif|jpg|png|pdf|docx';
            $config['max_size']             = 2048;
            $config['encrypt_name']         = TRUE;

            //configuration setup in library
            $this->load->library('upload',$config);
            $this->upload->initialize($config);

            //if file uploads fails
            if ( $this->upload->do_upload('userfile') == FALSE)
            {   
                
                $this->load->view('templates/header', $data);
                /**
                 * error of form
                 *
                 * @var string
                 */
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('pages/file_page',$error);

                 //call database retrieve

                /**
                 * Blog content passes
                 *
                 * @var string
                 */
                $data['content'] = $this->files->get_data();

                $this->load->view('pages/file_preview',$data);
                $this->load->view('templates/footer');
            }

            else
            {   
                //call to the model to save data in db
                $this->files->upload();

                //mail send to user after sucessfull upload
                emailSend($this->upload->data('full_path'), $_SESSION['email'], 'file', $_SESSION['username']);

                //add a reference session to upload method
                $this->session->set_flashdata('success','File Uploads Successfully');

                // redirect them to index
                redirect('file');
            }
        }

        /**
         * Function for the file delete
         *
         * @param       string $id id of blog to be deleted
         * @param       string $loc location of file
         * @return      none
         */ 
        public function file_delete($id = '', $loc = '')
        {
            //check if the user is authorised for page entry
            if (checkLogin() == FALSE) 
            {
                //clear all sections
                session_destroy();

                //call index function in user controller
                 redirect('user/logout');
            }

            //check role ifnot admin redirect
            if (checkRole() != 'admin') 
            {
                //clear all sections
                session_destroy();

                //call index function in user controller
                 redirect('user/logout');
            }
           
             //get parameter value url decoded
            $decodeid = urldecode($id);
            $decodeuserid = urldecode($loc);

            //let the value base64 decoded
            $id = base64_decode($decodeid);
            $loc = base64_decode($decodeuserid);

            try
            {
                //unlink the file
                unlink($loc);

                //delete in database
                $this->files->drop_file($id); 

            }

            catch(Exception $e)
            {
                redirect('file');
            }

            //refresh after delete
            redirect('file');
        }
    }   
?>