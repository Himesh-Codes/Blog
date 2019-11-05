<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('emailSend'))
{   
    /**
     * Function for send mail
     *
     * @param       string $file file included in blog
     * @return      string $to email send address
     */
    function emailSend($file,$to,$use,$username)
    {       
          /**
           * singleton reference to the CodeIgniter super object 
           *
           * @var object
           */
           $CI =& get_instance();

            if ($use == 'admin') 
            {
                $title = 'Hi admin';
            }

            else
            {
                $title = 'Hi Blog User';
            }

            $CI->email->from('emailtest2019october@gmail.com', $title);
            $CI->email->to($to);
            $CI->email->subject('Email for the blog');
            if ($use == 'blog') 
            {
                 $CI->email->message('Blog is created successfuly');
            }
            elseif ($use == 'file')
            {
                $CI->email->message('Hi:'.$username.'File uploaded successfuly');
            }
            elseif ($use == 'admin') 
            {
                $CI->email->message('A new blog is created by a user:'.$username);
            }
            $CI->email->attach($file);
            
            if (!$CI->email->send()) 
            {
               return FALSE;
            }
            else
            {
                return TRUE;
            }
    }   
}

?>