<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title;?></h3>
            </div>           

        <div class="box-body">
          <div class="clearfix"> 
          <div class="link-section" style="margin-bottom:15px;">

              <a class="text-blue" href="<?php echo site_url('resources/CSV-templates/Mock-Test-Scores-IELTS-CD-IELTS.csv'); ?>">Download IELTS/CD-IELTS Template</a><span style="margin-left:5px;margin-right:5px;"> | </span>

              <a class="text-blue" href="<?php echo site_url('resources/CSV-templates/Mock-Test-Scores-PTE.csv'); ?>">Download PTE Template</a><span style="margin-left:5px;margin-right:5px;"> | </span>
              
               <a class="text-blue" href="<?php echo site_url('resources/CSV-templates/Mock-Test-Scores-TOEFL.csv'); ?>">Download TOEFL Template</a>
            </div>
            
            <?php echo $this->session->flashdata('flsh_msg');?>
            <?php if(isset($error)) {echo $error;}?>            
            <?php
            $attributes = ['name' => 'upload_mock_test_add_form', 'id' => 'upload_mock_test_add_form'];
            echo form_open_multipart('adminController/mock_test/upload_mock_test/',$attributes); ?>           
          
          <div class="col-md-3">
            <label for="test_module_id" class="control-label"><span class="text-danger">*</span>Test module</label>
            <div class="form-group">
              <select name="test_module_id" id="test_module_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true" onchange="reflectPgmBatch(this.value,'mock_test');">
                <option value="">Select</option>
                <?php 
                foreach($all_test_module as $p)
                {
                  $selected = ($p['test_module_id'] == $this->input->post('test_module_id')) ? ' selected="selected"' : "";
                  echo '<option value="'.$p['test_module_id'].'" >'.$p['test_module_name'].'</option>';
                } 
                ?>
              </select>
              <span class="text-danger test_module_id_err"><?php echo form_error('test_module_id');?></span>
            </div>
          </div>

          <div class="col-md-3">
            <label for="programe_id" class="control-label"><span class="text-danger">*</span>Program</label>
            <div class="form-group">
              <select name="programe_id" id="programe_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
                <option data-subtext="" value="">Select program</option>
                <?php 
                foreach($all_programe_masters as $p)
                {
                  $selected = ($p['programe_id'] == $this->input->post('programe_id')) ? ' selected="selected"' : "";
                  echo '<option value="'.$p['programe_id'].'" '.$selected.'>'.$p['programe_name'].'</option>';
                } 
                ?>
              </select>
              <span class="text-danger programe_id_err"><?php echo form_error('programe_id');?></span>
            </div>
          </div>

          <div class="col-md-3">
            <label for="title" class="control-label"><span class="text-danger">*</span>CSV Title</label>
            <div class="form-group">
              <input type="text" name="title" value="<?php echo $this->input->post('title'); ?>" class="form-control input-ui-100" id="title" maxlength="60"/>
              <span class="text-danger title_err"><?php echo form_error('title');?></span>
            </div>
          </div>

          <div class="col-md-3">
            <label for="csvFile" class="control-label"><span class="text-danger">*</span>CSV</label>
            <div class="form-group">
              <input type="file" name="csvFile" value="<?php echo $this->input->post('csvFile'); ?>" class="form-control input-ui-100" id="csvFile"/>             
              <span class="text-danger csvFile_err"><?php echo form_error('csvFile');?></span>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group form-checkbox">
              <input type="checkbox" name="active" value="1" id="active" checked="checked"/>
              <label for="active" class="control-label">Active</label>
            </div>
          </div>         
            
          
        </div>
      </div>
            <div class="box-footer">
            <div class="col-md-12">
              <button type="submit" class="btn btn-danger rd-20">
                <i class="fa fa-check"></i> <?php echo SAVE_LABEL;?>
              </button>
            </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>


</div>

<?php ob_start(); ?>
<script>
$('#upload_mock_test_add_form').on('submit', function(e){
        e.preventDefault();
        var flag=1;
      var test_module_id=$('#test_module_id').val();
      var programe_id=$('#programe_id').val();
      var title=$('#title').val();
      var csvFile=$('#csvFile').val();
      
		if(test_module_id == "")
		{			
			$(".test_module_id_err").html('The Test module field is required.');
			flag=0;
		} else { $(".test_module_id_err").html(''); }
    if(programe_id == "")
		{			
			$(".programe_id_err").html('The Program field is required.');
			flag=0;
		} else { $(".programe_id_err").html(''); }
    if(title == "")
		{			
			$(".title_err").html('The Title field is required.');
			flag=0;
		} else { $(".title_err").html(''); }
    if(csvFile == "")
		{			
			$(".csvFile_err").html('The CSV field is required.');
			flag=0;
		} else { $(".csvFile_err").html(''); }
    if(flag == 1)
		{
			this.submit();			
		} 
});
</script>
<?php
global $customJs;
$customJs = ob_get_clean();
?>