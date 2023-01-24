<option value="">Select </option>
<?php                             
                foreach ($SESSION_COURSE_URL->error_message->data as $p)
                {                                
                echo '<option value="'.$p->test_module_id.'" >'.ucfirst($p->test_module_name).'</option>';
                } 
                ?>       
            