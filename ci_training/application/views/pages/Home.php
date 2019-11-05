<?php
    //message for account creation
    if ($this->session->flashdata('success_account') == TRUE) 
    {
        echo "<p class='success'>";
        echo $this->session->flashdata('success_account');
        echo "</p>";
    }
?>
<div class="content"><div class="blog-contain">
    <p class="blog-create"><a href="<?php echo base_url();?>blog/form/1" >Add Blog</a></p>
    <?php 
    if (empty($content)) 
    {
       echo "<p class='no-data'> No data to display.... </p>";
    }
    else
    {
         foreach ($content as $blog_item): ?>
        
        <div class="blogs">
            <h4><?php echo $blog_item['category_name']; ?></h4>
            <h2><?php echo $blog_item['title']; ?>
            <?php 
                if ($_SESSION['user_id'] == $blog_item['userid'] || checkRole() == 'admin' ) 
                {
            ?>      
                    <span class="blog-icons"><a href="#" onclick= "drop(<?php echo $blog_item['id']?>, <?php echo $blog_item['userid']?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>
                    <span class="blog-icons"><a href="#"  onclick= "edit(<?php echo $blog_item['id']?>, <?php echo $blog_item['userid']?>)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></span>
            <?php
                }
             ?>
             </h2>
            <!-- Date Section -->
            <p class="dates"><?php echo $blog_item['date'];  ?><span> &nbsp;BY <?php echo $blog_item['username']; ?></span></p>
            <div class="blog-content">
                <!--------- Description Section ----------->
                <p class="half-text" id="<?php echo $blog_item['id'] ?>h"><?php echo word_limiter($blog_item['description'], 20);  ?></p>
                <span class ="dots" id="<?php echo $blog_item['id'] ?>d">....</span>
            </div>
            <div id="<?php echo $blog_item['id'] ?>f">
                   <!------------Full text to be displayed -------->
                <p ><?php echo nl2br($blog_item['description']); ?></p>
                <!----- Blog image ----->
                <div class="image-section" >
                    <?php 
                    /************* Check if the attachment exist ***************/
                        if ($blog_item['attachment'] != NULL) 
                        {
                     ?>
                    <img src="../uploads/<?php echo $blog_item['attachment']; ?>" alt="Image of blog!!!" />
                    <?php  
                        }
                    ?>
                </div>
            </div>
            
            </br><button onclick="readMore(<?php echo $blog_item['id']?>);" id="<?php echo $blog_item['id']?>b" class="read-more">Read more...</button>
        </div>
        <script type="text/javascript">
            /********* Initialise properties*************/
            function loadItems(id)
            {
              var dots = document.getElementById(id+"d");
              var button = document.getElementById(id+"b");
              var halfText = document.getElementById(id+"h");
              var fullText = document.getElementById(id+"f");
            
                  fullText.style.display = 'none';
                  halfText.style.display = 'block';
                  button.innerHTML = 'Read more...';
                  dots.style.display = 'inline';
            }
        </script>
        <script>loadItems(<?php echo $blog_item['id']?>);</script>
        <?php endforeach; }?>
</div>

