<?php echo form_open_multipart('file/do_uploads');?>
    <div class="upload-section">
        <h2>INSERT THE FILE</h2><br>
        <p>File size of maximum 2mb, file types(gif/png/jpg/docx/pdf) </p><br>    
        <div class="errors">
            <?php 
                echo $error;
            ?>
        </div>
        <input type="file" name="userfile" size="20" />
    </div>
    <div class="submit-section">
        <input type="submit" value="Upload" class="upload-submit" />
    </div>
</form>
