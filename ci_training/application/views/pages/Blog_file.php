        <label for="blogfile" class="titles">File</label><br>
        <div class="errors">
            <?php 
                if (!empty($error))
                {
                    echo $error;
                }
            ?>
        </div>
        <div class="file-picker">
            <input type="file" name="blogfile" size="20" /><br>
        </div>
        <p>File size maximum of 2mb ,file types(png,jpg,gif)</p>
    <!---------- Submit Button -------->
        <input type="submit" name="submit" class="create-button" value="Create Blog" />

    </form>
    </div>
</div>  
