
            <center>
            <form enctype="multipart/form-data" method="post" action="">
            <?php
          for($i=0; $i<3; $i++){
            echo '<div><input class="Input" type="file" name="file_n[]"></div>';
            } ?>
            <div><input type="reset" name="reset" value="Reset">&nbsp;<input type="submit" name="upl_files" value="upload"></div>
            </center>