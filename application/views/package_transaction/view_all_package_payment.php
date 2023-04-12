<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?PHP ECHO $title;?></h3>
            </div>
            
            <?php echo form_open('adminController/Package_transaction/all_package_payment'); ?>
            
                <div class="box-body">
                   
                        <?php $searchInput=$this->input->get('search'); ?>

                        <div class="col-md-3">
                            <label for="search" class="control-label">Search</label>
                            <div class="form-group">
                                <input type="text" name="search" class="form-control input-ui-100" value="<?php echo (isset($searchInput) ? $searchInput : ""); ?>">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="status" class="control-label">Payment Status</label>
                            <div class="form-group">
                                <select name="payment_status" id="payment_status" class="form-control selectpicker selectpicker-ui-100">
                                    <option value="">Select <?php echo $this->input->post('payment_status');?></option>
                                    <?php 
                                    foreach($package_payment_status as $val) { 
                                        $sel=$this->input->post('payment_status') == $val['status'] ? "selected" : "";
                                       // $pp=$val['status']>'failed' ? "a" : "b";
                                       /* if($this->input->post('payment_status') == $val) 
                                       {
                                        $sel="selected";
                                       }
                                       else {
                                        $sel="";
                                       } */
                                        
                                        ?>
                                     <option value="<?php echo $val['status'];?>" <?php echo $sel;?>><?php echo ucwords($val['status']);?></option> 
                                    <?php }?>
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="test_module_id" class="control-label">Payment Date</label>
                            <div class="form-group">
                                <input type="text" name="payment_date" class="form-control datepicker input-ui-100" value="<?php echo $this->input->post('payment_date'); ?>" readonly />
                            </div>
                        </div>
            
                </div>
                <div class="box-footer">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-danger rd-20" name="submit" value="search" style="margin-right:5px;">
                        <i class="fa fa-search"></i> <?php echo SEARCH_LABEL;?>
                    </button>
                    <a href="" class="btn btn-reset rd-20"> Reset</a>
                </div>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>    
</div>

<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
            <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
                <div class="box-tools">
                    
                </div>

            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>

            <div  class="table-ui-scroller">
            <div class="table-responsive table-hr-scroller mheight200" id="printableArea">   
                <table class="table table-striped table-bordered table-sm">
                      <thead>
                            <tr>
                                <th><?php echo SR; ?></th>
                                <th>UID</th>
                                <th>Student Name</th>
                                <th>Mobile No.</th>
                                <th>Email</th>
                                <th>Location</th>
                                <th>Package Type</th>
                                <th>Package Detail</th>
                                <th>Amount</th>
                                <th>Payment Status</th>
                                <th>Payment Date</th>
                                <th>Token No.</th>
                                <th>Order ID</th>
                                <th>Payment Gateway ID</th>                               
                                <th>Last Visit Page</th> 
                                <th class='noPrint'><?php echo ACTION; ?></th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php
                            if (!empty($this->input->get('per_page'))) {

                                $sr = $this->input->get('per_page');
                            } else {

                                $sr = 0;
                            }
                            foreach ($transaction as $s) {
                               
                                $sr++;
                                
                            ?>
                                <tr>
                                    <td><?php echo $sr; ?></td>
                                    <td><?php echo $s['UID']; ?></td>
                                    <td><?php echo $s['fname'] . ' ' . $s['lname'].' ('.$s['UID'].')'; ?></td>
                                    <td><?php echo $s['country_code'].' '.$s['mobile']; ?></td>
                                    <td><?php echo $s['email']; ?></td>
                                    <td><?php echo $s['city_name'].' - '.$s['state_name'].' - '.$s['country_name']; ?></td>
                                    <td><?php echo $s['pack_type'];?></td>
                                    <td><?php 
                                    $date_st=date_create($s['subscribed_on']);
                                    $date_st=date_format($date_st,"d-m-Y");
                                    $date_end=date_create($s['expired_on']);
                                    $date_end=date_format($date_end,"d-m-Y");
                                    
                                    echo $s['test_module_name'].' - '.$s['programe_name'].' - '.$s['package_name'].' - '.$s['package_duration'].' - '.$s['batch_name'].' - Start: '.$date_st.' - Expired: '.$date_end; ?></td>
                                    <td><?php echo $s['currency'].' '. $s['amount_paid'] ;?></td>
                                    <td><?php echo $s['status']; ?></td>
                                    <td><?php echo $s['created']; ?></td>
                                    <td><a href="javascript:void(0)" class="text-black"><?php echo $s['checkout_token_no']; ?></a></td>
                                    <td><a href="javascript:void(0)" class="text-black"><?php echo $s['order_id']; ?></a></td>
                                    <td><a href="javascript:void(0)" class="text-black"><?php echo $s['payment_id']; ?></a></td>
                                    
                                    <td><?php echo $s['page']; ?> Page</td>
                                    <td>
                                    <a data-toggle="modal" data-target="#exampleModalshortview<?php echo $sr; ?>" >Short View</a>
                                    <a data-toggle="modal" data-target="#exampleModal<?php echo $sr; ?>">Detail View</a>
                                    <div class="modal fade" id="exampleModalshortview<?php echo $sr; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel" style="float: left; font-weight:600">Short Payment Response</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body" >
                                    <?php 
                                    $payment_full_response=$s['payment_full_response']; 
                                    $json_string = json_decode($payment_full_response, JSON_PRETTY_PRINT);                                  
                                    if(!empty($json_string['last_payment_error']['message']))
                                    {
                                        echo $json_string['last_payment_error']['message'];
                                    } 
                                    else {                                       
                                        if(isset($json_string['status']) && $json_string['status'] !="N")
                                        {
                                            echo ucwords($json_string['status']);
                                        }
                                        else {
                                            $dt= rtrim($payment_full_response,'"');
                                            echo ltrim($dt,'"');
                                        }                                      
                                    }    
                                    ?>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    
                                    </div>
                                    </div>
                                    </div>
                                    </div>

                                    <div class="modal fade" id="exampleModal<?php echo $sr; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel" style="float: left; font-weight:600">Full Payment Response</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body" style="height:400px; overflow-y:auto">
                                    <?php 
                                    $payment_full_response=$s['payment_full_response'];    
                                    $json_string = json_decode($payment_full_response, JSON_PRETTY_PRINT);
                                    echo '<pre>';
                                    print_r($json_string);      
                                    ?>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                
                                
                                
                                </td>



                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="pull-right">
                        <?php echo $this->pagination->create_links(); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>