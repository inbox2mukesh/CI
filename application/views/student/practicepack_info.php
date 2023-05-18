<h4><b>Pack Info:</b> </h4>
                <table class="table table-striped table-bordered table-sm">
                    <thead style="background-color: pink">
                    <tr>
                        <th>Package Name</th>
                        <th>Course</th>
                        <th>Program</th>
                        <th>Category</th>
                        <th>Batch</th>                       
                        <th>Package Price</th>                        
                        <th>Taxes(CGST & SGST)</th>
                        <th>Total Amount Payable (Incl. Taxes)</th>
                        <th>Amount Paid</th>
                        <th>Duration</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">                    
                    <?php foreach($packageData as $p){
                        foreach ($p['Package_category'] as $pc) {
                            $category_name .= $pc['category_name'].', ';
                        }
                        foreach ($p['center_name'] as $pc) {
                            $batch_name .= $pc['center_name'].', ';
                        } 
                        $package_price = $p["discounted_amount"];
                        $cgst_tax_amt = $cgst_amt;
                        $sgst_tax_amt = $sgst_amt;
                        // $amountpayable = 
                        if($discount_type == 'Waiver')
                        {
                            $package_price = $package_amt;
                            $cgst_tax_amt = number_format(($package_price * $cgst)/100,2);
                            $sgst_tax_amt = number_format(($package_price * $sgst)/100,2);
                            $amountpayable = $package_price + $cgst_tax_amt + $sgst_tax_amt;
                            
                        }
                        
                        // $amtpaid = $amountpaid;($discount_type != 'Waiver')?$amountpayable:$totalamtpayable
                        ?>                  
                    
                        <tr>                        
                        <td><?php echo $p["package_name"] ?></td>  
                        <td><?php echo $p["test_module_name"] ?></td>
                        <td><?php echo $p["programe_name"] ?></td>
                        <td><?php echo rtrim($category_name,', ') ?></td> 
                        <td><?php echo $p['center_name'] ?></td>                                                            
                        <td><?php if($discount_type != 'Waiver') { ?>
                        <?php echo $p["discounted_amount"]; } else { ?>
                        
                            <?php echo CURRENCY.' '.$package_price.'( '.$p["discounted_amount"].'-'.$waiveramt.')'; } ?>
                        </td>
                        <td><span>CGST(<?php echo '@'.$cgst .'%'?>) -<?php echo $cgst_tax_amt ?></span></br><span>SGST(<?php echo '@'.$sgst .'%'?>)-<?php echo $sgst_tax_amt ?></span></td>
                        <td><?php echo CURRENCY.' '.$amountpayable; ?></td>
                        <td id="amountpaid"><?php echo $amountpaid ; ?></td>                      
                        <td><?php echo $p["duration"].' '.$p["duration_type"] ?></td>
                        
                    </tr>
                    <?php } ?>

                    </tbody></table>