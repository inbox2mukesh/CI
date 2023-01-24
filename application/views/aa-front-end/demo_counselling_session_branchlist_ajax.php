<option value="">Select </option>
<?php                             
                foreach ($SESSION_BRANCH_URL->error_message->data as $p)
                {                                
                echo '<option value="'.$p->center_id.'" >'.ucfirst($p->center_name).'</option>';
                } 
                ?>       
            