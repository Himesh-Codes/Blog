<?php 
    /**
     * Blog Class
     *
     * @package     Blog
     * @subpackage  Section for model 
     * @category    Category
     * @author      T0590
     * @link        http://localhost/ci_training/blog_model
     */
    class Blog_model extends CI_Model
    { 

        /**
         * Constructor of the blog_model 
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
         * Function for the insert data
         *
         * @param       none
         * @return      none
         */
        public function create()
        {
            //Load all libraries and helper function
            $this->load->helper('url');

            /**
             * A key variable to save to the database       
             *
             * @var string
             */
            $slug = url_title($this->input->post('title'), 'dash', TRUE);

            //protecting identifiers in table
            /*$this->db->protect_identifiers('user_blog');*/

            try
            {
                //query binding
                $sql = "INSERT INTO user_blog (userid, slug, title, category, description, attachment) VALUES (?,?,?,?,?,?)";     
                $result = $this->db->query($sql, array($_SESSION['user_id'], $slug, $_POST["title"], $_POST["category"], $_POST["description"], 
                    $_SESSION['file-name']));
            }
            catch (Exception $e)
            {
                //redirect to home page
                redirect('blog/home');
            }
        }


        /**
         * Function for getting the data from db
         *
         * @param      none
         * @return     array  fetched results 
         */
        public function get_data()
        {   
            //check admin or not
            if (checkRole() == 'admin') 
            {
               //Query for get latest 10 blogs from db
                $query = $this->db->select('user_blog.id, username ,userid, title, category_name, date, description, attachment')
                ->join('category','category.id = user_blog.category','left')
                ->join('user','user.id = user_blog.userid','left')
                ->order_by('user_blog.id', 'DESC')
                ->get('user_blog');
            }

            else
            {
                //Query for get latest 10 blogs from db
                 $query = $this->db->select('user_blog.id, username ,userid, title, category_name, date, description, attachment')
                ->join('category','category.id = user_blog.category','left')
                ->join('user','user.id = user_blog.userid','left')
                ->order_by('user_blog.id', 'DESC')
                ->limit(20)
                ->get('user_blog');
            }

            return $query->result_array();
        }

        /**
         * Function for getting the category from db
         *
         * @param      none
         * @return     array  fetched results 
         */
        public function get_category()
        {
            //Query for getting the category data from db category table
            $query = $this->db->select('id, category_name')
                ->get('category');

            return $query->result_array();
        }

        /**
         * Function for delete the blog
         *
         * @param      string $id blog id to be deleted in db
         * @return     none 
         */
         public function delete_blog($id)
        {   
             try
            {
                $this->db->where('id', $id);
                $this->db->delete('user_blog');
            }

            catch (Exception $e)
            {
                //redirect to home page
                redirect('blog/home');
            }
        }

        /**
         * Function for delete the blog
         *
         * @param      string $id blog id in db
         * @return     array $row result array
         */
        public function get_blog($id)
        {
            try
            {
                $query = $this->db->select('user_blog.id, title, category_name, description, attachment')
                        ->join('category','category.id = user_blog.category','left')
                        ->where('user_blog.id',$id)
                        ->get('user_blog');

                $query->row_array();
            }

            catch(Exception $e)
            {
                //redirect to home page
                redirect('blog/home');
            }

            return $query->row_array();
        }
         /**
         * Function for update the blog
         *
         * @param      string $id blog id in db
         * @param      string $filename filename
         * @return     none
         */
         public function update($id,  $filename)
         {
            try
            {
                $array = array(
                                    'title' => $_POST['title'],
                                    'category' => $_POST["category"],
                                    'description' => $_POST["description"],
                                    'attachment' => $filename
                            );

                $this->db->where('id', $id);
                $this->db->update('user_blog', $array);
            }

            catch(Exception $e)
            {
                //redirect to home page
                redirect('blog/home');
            }
         }

    }  
?>