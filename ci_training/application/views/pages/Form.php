<?php
    // Check a variable is passed from controller for edit case
    if (isset($result)) 
    {   
        $title = set_value('title') == false ? $result['title'] : set_value('title'); 
        $description = set_value('description') == false ? $result['description'] : set_value('description');
        $category = set_value('category') == false ? set_value('category', $result['category_name'] ): set_value('description');
        $this->session->set_flashdata('id',$result['id']);
        //check attachment is exist
        if ( $result['attachment'] != '' ) 
        {
           $this->session->set_userdata('filename',$result['attachment']);
        }
    
    }

    else
    {
        $title = set_value('title');
        $description = set_value('description');
        $category = set_value('category',$this->input->post('category'));
    }

?>
<div class="form-page">
    <div class="form-contain">
        <?php
        //for update the blog
            if(  $this->session->has_userdata('edit'))
            {   
                 echo form_open_multipart('blog/form/2'); 
            }
        //for create blog
            else
            {
                 echo form_open_multipart('blog/form/1');
            }
        ?>
        <!------ Label for the title ---->
        <label for="title" class="titles">Title</label>
        <span class="errors">
            <?php 
                    echo "*";
            ?> <br/>
        </span>
        <!----- Title input --------->
        <input type="text" name="title"  value="<?php echo $title;?>" /><br />
        <p>Atleast 10 charecters</p>
        <div class="errors">
            <?php echo form_error('title'); ?> 
        </div>

        <!--------- Category Field --------->
        <label for="category" class="titles" >Category</label><br/>
        <!---------- Category Input --------->
        <?php

            /**
             * Blog category options for dropdown 
             *
             * @var array
             */
            $options = array();
            foreach ($drop_options as $value) 
            {
               $options[strtolower($value['id'])] = $value['category_name'] ;
            }
                            

            echo form_dropdown('category', $options, $category);
        ?><br/>

        <!-------- Label for text ------->
        <label for="description" class="titles">Description</label>
        <span class="errors">
            <?php 
                    echo "*";
            ?> <br/>
        </span>
        <!------ Text input Area ----------->
        <textarea name="description"><?php echo $description;?></textarea><br />
        <p>Atleast 20 charecters</p>
        <div class="errors">
            <?php echo form_error('description'); ?> 
        </div>
