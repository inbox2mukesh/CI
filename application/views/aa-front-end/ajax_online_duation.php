<option value="">Select Duration</option>
<?php
                foreach($allOnlineCourseDuration->error_message->data as $p){
                ?>
                <option value="<?php echo $p->duration;?>"><?php echo $p->duration.' '.$p->duration_type;?></option>
                <?php } ?>
 