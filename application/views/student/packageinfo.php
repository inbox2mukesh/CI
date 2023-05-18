  <div class="tb-package-information">
    <h4><b>Pack Info:</b></h4>
    <table class="table table-striped table-bordered table-sm">
        <thead style="background-color: pink">
            <tr>
                <th>Package Name</th>
                <th>Course</th>
                <th>Program</th>
                <th>Category</th>
                <th>Batch</th>
                <th>Course Type</th>
                <th>Package Price</th>
                <th>Taxes(CGST & SGST)</th>
                <th>Total Amount Payable (Incl. Taxes)</th>
                <th>Amount Paid</th>
                <th>Duration</th>
            </tr>
        </thead>
        <tbody id="myTable">
        <?php            
                    foreach($packageData as $p){
                        foreach ($p['Package_category'] as $pc) {
                            $category_name .= $pc['category_name'].', ';
                        }
                        foreach ($p['Package_batch'] as $pc) {
                            $batch_name .= $pc['batch_name'].', ';
                        }
                        foreach ($p['Package_timing'] as $pt) {
                            $course_timing .= $pt['course_timing'].', ';
                        }
        ?>
            <tr>
                    <td><?php echo $p["package_name"] ?></td>  
                    <td><?php echo $p["test_module_name"] ?></td>
                    <td><?php echo $p["programe_name"] ?></td>
                    <td><?php echo rtrim($category_name,', ') ?></td> 
                    <td><?php echo rtrim($batch_name,', ') ?></td> 
                    <td><?php echo rtrim($course_timing,', ') ?></td>                                       
                    <td><?php if($discount_type != 'Waiver') { ?>
                    <?php echo $p["discounted_amount"]; } else { ?>
                    
                        <?php echo CURRENCY.' '.$package_amt.'( '.$p["discounted_amount"].'-'.$waiveramt.')'; } ?>
                    </td>
                    <td><span>CGST(<?php echo $cgst .'%'?>) -<?php echo $cgst_amt ?></span></br><span>SGST(<?php echo $sgst .'%'?>)-<?php echo $sgst_amt ?></span></td>
                    <td id="tbpackprice"><?php echo CURRENCY.' '.$amountpayable ?></td>
                    <td id="amountpaid"><?php echo $amountpaid ; ?></td>
                    <td><?php echo $p["duration"].' '.$p["duration_type"] ?></td>
            </tr>
            <?php } ?>
        </tbody></table>
    </div>