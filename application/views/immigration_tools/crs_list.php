<div class="row">
    <div class="col-md-12">
        <div class="box">
           <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>                
                    <div class="pull-right">                    
                        <a href="<?php echo site_url('adminController/cron_tab/cronJob_custom_fetchCRSLeads'); ?>"  class="btn btn-warning btn-sm">Fetch CRS Lead</a>
                    </div> &nbsp;&nbsp;
                    <div class="pull-right" style="margin-right: 10px;"> 
                    <?php if($this->Role_model->_has_access_('lead_management','get_lead_CSV')){?>
                        <a href="<?php echo base_url('adminController/lead_management/get_lead_CSV');?>" id="csv_down" class="btn btn-info btn-sm">Get All CSV</a><?php } ?>
                    </div>              
            </div>
            <br>
            <div class="col-md-12">
                <form action="crs_list" method="POST" onsubmit="return validate_sform();">
                     <div class="col-md-5">
            <div >
                <label for="date" class="control-label"><span class="text-danger">*</span>Filter By Date <?php echo DATE_FORMAT_LABEL_RT;?></label>
                <div class="form-group has-feedback">
                    <input type="text" name="date" value="<?php //echo $this->input->post('date'); ?>" class="form-control has-datepicker" id="date" data-date-format="DD-MM-YYYY"/>
                    <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                    <span class="text-danger date_err"><?php echo form_error('date');?></span>
                </div>
                <div >
               <button type="submit" class="btn btn-danger" >
                    <i class="fa fa-search"></i> <?php echo SEARCH_LABEL;?>
                </button>
            </div>
            </div>
            
            <?php echo form_close(); ?>
        </div>
            </div>
            <br>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Mobile No.</th>
                        <th>CRS Score</th>
                        <th>Date</th>
                        <th><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php $sr=0;foreach($immigration_tools as $p){ $zero=0;$one=1;$pk='id'; $table='student_crs_score';$sr++; ?>
                    <tr>
                        <td><?php echo $sr; ?></td>
                        <td><?php echo $p['fname'].''.$p['lname']; ?></td>
                        <td><?php echo $p['email'];?></td>
                        <td><?php echo $p['country_code'].' '.$p['phone'];?></td>
                        <td><?php echo $p['grand_total_crs']?></td>
                        <td><?php echo $p['created']?></td>
                        
                        <td>
                            <?php if($this->Role_model->_has_access_('lead_management','crs_view')){?>
                            <a href="<?php echo site_url('adminController/lead_management/crs_view/'.$p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="View"><span class="fa fa-eye"></span> </a> <?php } ?>
                            
                           
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
                <div class="pull-right">
                    <?php echo $this->pagination->create_links(); ?>                    
                </div>                
            </div>
        </div>
    </div>
</div>
<script src="<?php echo site_url('resources/js/jquery.min.js');?>"></script>   
<script type="text/javascript">
$(document).ready(function() {
    $('#date').daterangepicker(
    {   autoUpdateInput: false, 
        locale: {
          format: 'DD-MM-YYYY',
          cancelLabel: 'Clear'
        },
    }, 
    function(start, end, label) {
        
        //alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
    
    $('#date').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
    });
    
    $('#date').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
    });
 });       
    function validate_sform(){
        //alert('bbbb');
        var date = $("#date");        
        if(date.val() == "") {
            
            $('.date_err').text('Please select date!');
            $('#date_err').focus();
            return false;
        }else{            
            $('.date_err').text('');
            
            return true;             
        } 
    }
    
$(document).on('click', '#csv_down0', function() 
{

     var date = $("#date").val(); 
    $.post("<?php echo base_url('adminController/lead_management/get_lead_CSV');?>",{date:date},function(data){
                
            });
});

     $("#csv_down").click(function(){

          var date = $("#date").val();  
         

          event.preventDefault();

     // alert($(this).attr('href'));
if(date == "")
{
    date=1;
}
     var dd= $(this).attr('href') + '/'+date;

     //alert(dd)

      window.location =dd;

   

     });



</script>