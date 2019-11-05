<?php 
    /**
     * User class for model
     *
     * @package     File upload
     * @subpackage  Section for model 
     * @category    Category
     * @author      T0590
     * @link        http://localhost/ci_training/file_model
     */
    class File_model extends CI_Model
    { 
        /**
         * Constructor of the file_model 
         *
         * @param       none
         * @return      none
         */
        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        /**
         * Function for the insert data into db
         *
         * @param       none
         * @return      none
         */
        public function upload()
        {
            try
            {
                //query binding
                $sql = "INSERT INTO user_file (userid, filename, filetype, filesize ) VALUES (?,?,?,?)";     
                $result = $this->db->query($sql, array($_SESSION['user_id'],  $this->upload->data('file_name'), $_FILES['userfile']['type'], $_FILES['userfile']['size']));
            }
            catch (Exception $e)
            {
                //redirect to home page
                redirect('blog/home');
            }
        }

         /**
         * Function for the get data
         *
         * @param       none
         * @return      none
         */
         public function get_data()
         {  
            //check if admin
            if (checkRole() == 'admin') 
            {
               //Query for get db data
                $query = $this->db->select('user_file.id, userid, username, filename, filesize, filetype, created_at')
                ->join('user','user.id = user_file.userid')
                ->order_by('user_file.id','DESC')
                ->get('user_file');
            }
            
            else
            {
                //Query for get db data
                $query = $this->db->select('user_file.id, userid, username, filename, filesize, filetype, created_at')
                ->join('user','user.id = user_file.userid')
                ->where('user_file.userid', $_SESSION['user_id'])
                ->order_by('user_file.id','DESC')
                ->get('user_file');
            }

            return $query->result_array();
         }

         /**
         * Function for the delete file
         *
         * @param       string $id id to be delete in db
         * @return      none
         */
         public function drop_file($id)
         {
            try
            {
                //delete from db
                $this->db->where('id', $id);
                $this->db->delete('user_file');
            }

            catch(Exception $e)
            {
                redirect('file');
            }
         }



    }   
?>