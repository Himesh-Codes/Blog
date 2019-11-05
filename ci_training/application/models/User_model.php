<?php 
    /**
     * User class for model
     *
     * @package     File upload
     * @subpackage  Section for model 
     * @category    Category
     * @author      T0590
     * @link        http://localhost/ci_training/blog_model
     */
    class User_model extends CI_Model
    { 
        /**
         * Constructor of the user_model 
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
         * Function for get admin 
         *
         * @param      none
         * @return     none
         */
        public function getAdmin()
        {
            //Query for get latest 10 blogs from db
            $query = $this->db->select('emailid')
                ->where('userrole', 'admin')
                ->get('user');

            //get the id of user and userrole
            $row = $query->row_array();

            //session create for admin
            $this->session->set_userdata('admin_mail', $row['emailid']);
        }

        /**
         * Function for check whether a user exist
         *
         * @param      none
         * @return     object $query $query passed
         */
        public function checkUser()
        {    
            
            //hashing the password
            $_POST['password'] = sha1($_POST['password']);

            //Query for get latest 10 blogs from db
            $query = $this->db->select('id, username, password, userrole, emailid')
                ->where('username', $_POST['username'])
                ->where('password', $_POST['password'])
                ->get('user');

            //get number of rows
            $number = $query->num_rows();

            //get the id of user and userrole
            $row = $query->row_array();

            if ($number == 1) 
            {
                //session create for user identifier
                $this->session->set_userdata('user_id', $row['id']);

                //session create for user identifier
                $this->session->set_userdata('username', $row['username']);

                //session create for user role
                $this->session->set_userdata('user_role', $row['userrole']);

                //session create for user identifier
                $this->session->set_userdata('email', $row['emailid']);
            }

            // The $query result object will no longer be available
            $query->free_result();  

            return $number;
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
         * Function for insert account data of user
         *
         * @param      none
         * @return    none
         */
        public function create_account($user_data)
        {
             try
            {
                /**
                 * Avariable to save password that's encrypted       
                 *
                 * @var string
                 */
                $password = sha1($user_data['password']);

                //query binding to user table
                $sql1 = "INSERT INTO user (username, password, emailid) VALUES (?,?,?)";     
                $this->db->query($sql1, array($user_data['username'], $password, $user_data["email"]));

                //get last inserted id
                $last_id = $this->db->insert_id();

                //query binding to user details table
                $sql2 = "INSERT INTO user_details (userid, firstname, lastname, gender, frequency) VALUES (?,?,?,?,?)";     
                $this->db->query($sql2, array($last_id, $user_data['firstname'], $user_data["lastname"], $user_data['gender'], $user_data['frequency']));

                //user subscription
                foreach ($user_data["list"] as $values) 
                {
                     //query binding to user subscription table
                    $sql3 = "INSERT INTO user_subscription (userid, subscription) VALUES (?,?)";     
                    $this->db->query($sql3, array($last_id, $values));
                }
                

            }
            catch (Exception $e)
            {
                //redirect to home page
                redirect('user');
            }
        }

         /**
         * Function for get data of specified user
         *
         * @param      integer $id id of user
         * @return    none
         */
         public function get_data()
         {
            //Query for getting the data from user
            $query = $this->db->select('username, firstname, emailid, lastname, gender, frequency')
                ->join('user_details','user.id = user_details.userid')
                ->where('user.id',$_SESSION['user_id'])
                ->get('user');

            $query1 =  $this->db->select('subscription')
                ->where('userid',$_SESSION['user_id'])
                ->get('user_subscription');

            return array("details"=> $query->result_array() , "subscribe"=> $query1->result_array());
         }


        /**
         * Function for delete account from db
         *
         * @param      none
         * @return    none
         */
        public function delete_account()
        {
            try
            {
                //delete user_blogs
                $this->db->where('userid', $_SESSION['user_id']);
                $this->db->delete('user_blog');

                //delete user_files
                $this->db->where('userid', $_SESSION['user_id']);
                $this->db->delete('user_file');

                //delete user subscription
                $this->db->where('userid', $_SESSION['user_id']);
                $this->db->delete('user_subscription');

                 //delete user details
                $this->db->where('userid', $_SESSION['user_id']);
                $this->db->delete('user_details');

                 //delete user 
                $this->db->where('id', $_SESSION['user_id']);
                $this->db->delete('user');
            }

            catch (Exception $e)
            {
                //redirect to home page
                redirect('blog/home');
            }
        }

        /**
         * Function for update account from db
         *
         * @param      none
         * @return    none
         */
        public function update_account()
        {
            try
            {
                //user table update
                $array = array(
                                'username' => $_POST['username'],
                                'emailid' => $_POST['email'],
                            );

                $this->db->where('id', $_SESSION['user_id']);
                $this->db->update('user', $array);

                //update user details table
                $array = array(
                                'firstname' => $_POST["firstname"],
                                'lastname' => $_POST["lastname"],
                                'gender' => $_POST["gender"],
                                'frequency' => $_POST["frequency"]
                            );

                $this->db->where('userid', $_SESSION['user_id']);
                $this->db->update('user_details', $array);

                //user subscription updation
                 $this->db->where('userid', $_SESSION['user_id']);
                $this->db->delete('user_subscription');

                foreach ($_POST["list"] as $values) 
                {
                     //query binding to user subscription table
                    $sql3 = "INSERT INTO user_subscription (userid, subscription) VALUES (?,?)";     
                    $this->db->query($sql3, array($_SESSION['user_id'], $values));
                }
            }

            catch(Exception $e)
            {
                //redirect to home page
                redirect('blog/home');
            }
        }

        /**
         * Function for get all the username
         *
         * @param      none
         * @return    none
         */
        public function get_usernames()
        {
            //query for get username other than user's current username
            $query = $this->db->select('username')
                    ->where('id !=', $_SESSION['user_id'])
                    ->get('user');

            //return array of result
            return $query->result_array();
        }

        /**
         * Function for get all the emails
         *
         * @param      none
         * @return    none
         */
        public function get_emails()
        {
            //query for get email other than user's current username
            $query = $this->db->select('emailid')
                    ->where('id !=', $_SESSION['user_id'])
                    ->get('user');
                    
            //return array of result
            return $query->result_array();
        }
    }   
?>