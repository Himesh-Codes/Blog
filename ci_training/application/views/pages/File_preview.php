<div class="success" id='sucess-file'>
             <?php 
                if (isset($_SESSION['success'])) 
                {
                   echo $_SESSION['success'];
                }
            ?>
        </div>
<h2 class="upload-heading">Your uploaded files</h2>
 <div class="preview-container">
    <?php 
        if (empty($content)) 
        {
           echo "<p class='no-data'>No data to display......</p>";
        }
        else
        {
     ?>
           <div class="table-contain">
              <!-- table section starts -->
            <table>
                <tr>
                    <th>sl.no:</th>
                    <th>Name</th>
                    <th>File</th>
                    <th>Filename</th>
                    <th>Filesize</th>
                    <th>Filetype</th>
                    <th>Created On</th>
                    <?php 
                        if (checkRole() == 'admin') 
                        {
                    ?>
                             <th>Action</th>
                    <?php
                        }
                     ?>
                </tr>
                <?php
                    /**
                     * No for table row
                     *
                     * @var string
                     */
                    $no = 0;

                    // output data of each row
                    foreach($content as $row) 
                    {   
                       $no++; 
                ?>

                <!-- ********* Display section ******** -->
                <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $row["username"] ?></td>
                    <!-- ******** Image section ******** -->
                    <?php
                    //get the type of file
                    $arr = explode("/", $row['filetype'], 2);
                    $ext = $arr[1];

                    /**
                     * location of file
                     *
                     * @var string
                     */
                    $location = './uploads/'.$row['filename'];

                        if ($ext == 'jpeg' || $ext == 'png' || $ext == 'gif' ) 
                        {
                            ?>

                            <td><a href="#"  onclick="window.open('<?php echo $location?>','name','width=600,height=400')"><img  src='<?php echo $location?>' alt='loading....'></a></td>
                            <?php 
                        }
                        /******* pdf section ********/
                        else if ($ext == 'pdf') 
                        {
                            ?>
                            <td><a href="<?php echo $location?>" download><img  src='./assets/pdf.png' alt='loading....'></a></td>
                            <?php 
                        }
                        /****** document section **********/
                        else if ($ext == 'docx') 
                        {
                            ?>
                            <td><a href="<?php echo $location?>" download><img  src='./assets/docx.png' alt='loading....'></a></td>
                            <?php 
                        }
                    ?>
                    <td><?php echo $row["filename"] ?></td>
                    <td><?php echo $row["filesize"] ?></td>
                    <td><?php echo $row["filetype"] ?></td>
                    <td><?php echo $row["created_at"] ?></td>
                     <?php 
                        if (checkRole() == 'admin') 
                        {
                            //filename for deletion
                            $name = $row['filename'];
                    ?>      
                            <td><a href='#' onclick = "file_drop(<?php echo $row['id'] ?>, '<?php echo $name ?>' );">Delete</a></td>
                    <?php
                        }
                     ?>
                    
                </tr>

                <?php 
                }
                ?>
            </table><br> 
           </div>
    <?php 
        }
     ?>
</div>