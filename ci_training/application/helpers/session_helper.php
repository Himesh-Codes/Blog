<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('checkLogin'))
{   
    //function to check the login status
    function checkLogin()
   {  
      /**
       * singleton reference to the CodeIgniter super object 
       *
       * @var object
       */
       $CI =& get_instance();

       return (bool) $CI->session->userdata('user_id');
    }   
}

if ( ! function_exists('checkRole'))
{
    //function to check the user role
    function checkRole()
   {  
      /**
       * singleton reference to the CodeIgniter super object 
       *
       * @var object
       */
       $CI =& get_instance();

       return  $CI->session->userdata('user_role');
    }   
}

if ( ! function_exists('checkUser'))
{
    //function to check the user role
    function checkUser($id)
   {  
      /**
       * singleton reference to the CodeIgniter super object 
       *
       * @var object
       */
       $CI =& get_instance();

      if ($id == ($CI->session->userdata('user_id'))) 
      {
           return TRUE;
       }

       else
       {
            return FALSE;
       } 
    }   
}
?>