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
                        $cgst_tax_amt = number_format(($package_price * $cgst)/100);
                        $sgst_tax = number_format(($package_price * $sgst)/100);
                        $totalamt = $package_price + $cgst_tax + $sgst_tax;
                        // $amtpaid = $amountpaid;
                        ?>                  
                    
                        <tr>                        
                        <td><?php echo $p["package_name"] ?></td>  
                        <td><?php echo $p["test_module_name"] ?></td>
                        <td><?php echo $p["programe_name"] ?></td>
                        <td><?php echo rtrim($category_name,', ') ?></td> 
                        <td><?php echo $p['center_name'] ?></td>                                                            
                        <td><?php echo $p["discounted_amount"] ?></td>
                        <td><span>CGST(<?php echo '@'.$cgst .'%'?>) -<?php echo $cgst_amt ?></span></br><span>SGST(<?php echo '@'.$sgst .'%'?>)-<?php echo $sgst_amt ?></span></td>
                        <td><?php echo CURRENCY.' '.$amountpayable ?></td>
                        <td><?php echo $amountpaid ; ?></td>                      
                        <td><?php echo $p["duration"].' '.$p["duration_type"] ?></td>
                        
                    </tr>
                    <?php } ?>

                    </tbody></table>