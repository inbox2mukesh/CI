<div class="role-manage_controller">

    <div class="row">
        <div class="col-md-12">
        <div class="box box-flex-widget">
                <div class="box-header bg-danger">
                    <h3 class="box-title text-primary"><?php echo $title;?></h3>
                    <div class="box-tools">
                        <?php
                            if($this->Role_model->_has_access_('role','manage_controller_method')){
                        ?>
                        <a href="<?php echo site_url('adminController/role/manage_controller_method'); ?>" class="btn btn-danger btn-sm">Manage methods</a> <?php } ?>
                    </div>
                </div>
                <div class="msg"><?php echo $this->session->flashdata('flsh_msg');?></div>

                <div class="col-md-12">
                <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                        <thead>
                        <tr>
                            <th width="5%"><?php echo SR;?></th>
                            <th width="19%">Controller name</th>
                            <th width="19%">Alias</th>
                            <th width="19%">Desc.</th>
                            <!-- <th>Icon</th> -->
                            <th width="19%"><?php echo STATUS;?></th>
                            <th width="19%">Add Module desc.</th>
                            <!-- <th>
                                <?php
                                    if($this->Role_model->_has_access_('role','resetMenuPriority_')){
                                ?>
                                &nbsp;<input type="button" name="clearAll" id="clearAll" value="Reset All" onclick="resetMenuPriority();" class="btn-info">
                                <?php } ?>
                            </th> -->
                        </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php $sr=0;foreach($all_controller_list as $r){ $zero=0;$one=1;$pk='id'; $table='controller_list'; $sr++;
                            ?>
                        <tr>
                            <td><?php echo $sr; ?></td>
                            <td>
                                <?php
                                $l = @count($r['controller_name'])-5;
                                echo substr($r['controller_name'], 0, $l);
                                ?>
                            </td>
                            <td><?php echo $r['controller_alias']; ?></td>
                            <td><?php echo $r['controller_desc']; ?></td>
                            <!-- <td>
                                <?php
                                    if($r['menuIcon']){
                                        echo '<img src="'.base_url(MENU_ICON_FILE_PATH.$r["menuIcon"]).'" style="width:50px;height:40px;"/>';
                                    }else{
                                        echo NO_ICON;
                                    }
                                ?>
                            </td> -->
                            <td>
                                <?php
                                if($r['active']==1){
                                    echo '<span class="text-success"><a href="javascript:void(0);" id='.$r['id'].' data-toggle="tooltip" title="Active">'.ACTIVE.'</a></span>';
                                }else{
                                    echo '<span class="text-danger"><a href="javascript:void(0);" id='.$r['id'].' data-toggle="tooltip" title="In-active">'.DEACTIVE.'</a></span>';
                                }
                                ?>
                            </td>

                            <td>
                                <a href="javascript:void(0)" class="btn btn-green btn-sm link-btn-ui-100" data-toggle="modal" data-target="#modal-module-desc" name="<?php echo $r['controller_name'];?>" id="<?php echo $r['id'];?>" title="<?php echo $r['controller_name'];?>" onclick="fillControllerID(this.id,this.name)"><span class="fa fa-plus"></span> &nbsp;Add/Update Desc.</a>
                            </td>

                            <!-- <td>
                                <?php
                                    if($this->Role_model->_has_access_('role','updateMenuPriority_')){
                                ?>
                                <select name="menuPriorityDD<?php echo $sr;?>" id="menuPriorityDD<?php echo $sr;?>" class="form-control subdd selectpicker selectpicker-ui-100" onchange="updateMenuPriority(this.value,'<?php echo $r['id'];?>')">
                                    <option value="">Select</option>
                                    <?php
                                        $n=$controllerCount;
                                        for ($i=1; $i <= $n; $i++){
                                            $selected = ($r['menuPriority'] == $i) ? ' selected="selected"' : "";
                                            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                        }
                                    ?>
                                </select><?php } ?>
                            </td> -->
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>

                </div>
                </div>
                <div class="pagination-right">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
            </div>
        </div>
    </div>

    <!-- modal box for add modal-method-desc starts-->
    <div class="modal fade" id="modal-module-desc" style="display: none;">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-heading text-info">Add/Update Module Desc.</h4>
            <h5 class="msg_controller_desc"></h5>
        </div>

        <div class="modal-body">
            <div class="row form-flate-ui">
       
                <div class="box-info">
                    <div class="box-body">
               

                        <div class="col-md-12">
                            <label for="cDesc" class="control-label text-success controllerName"></label>
                        </div>

                        <div class="col-md-12">
                            <label for="module_alias" class="control-label">Module alias<span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" name="module_alias" class="form-control input-ui-100" id="module_alias">
                                <span class="text-danger module_alias_err"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="module_desc" class="control-label">Module description</label>
                            <div class="form-group">
                                <textarea name="module_desc" class="form-control textarea-ui-16" id="module_desc"></textarea>
                            </div>
                        </div>

                        <!-- <form id="submit_icon">
                            <div class="col-md-12">
                            <label for="menuIcon" class="control-label">Upload Icon</label>
                            <?php echo MENU_ICON_ALLOWED_TYPES_LABEL; ?>
                            <div class="form-group">
                            <input type="file" name="menuIcon" id="menuIcon" class="form-control input-file-ui-100 input-file-ui" onchange="validate_file_type_svg(this.id)"/>
                            <button class="btn btn-info btn-ui-100" id="btn_upload" type="submit">Upload</button>
                                <div id="menu_icon_msg"></div>
                            </div>
                            <span class="text-danger menuIcon_err"></span>
                            </div>
                        </form>

                        <div class="col-md-1">
                            <div class="form-group">
                            <input type="hidden" name="image_id_icon" id="image_id_icon" class="form-control" /> </div>
                        </div> -->

                        <input type="hidden" name="controller_id" id="controller_id">

                 
                    </div>
                </div>
       
            </div>
        </div>

        <div class="modal-footer">
            <div class="col-md-12">
            <!-- <button type="button" class="btn btn-default pull-left btn-ui-100" data-dismiss="modal">Close</button> -->
            <?php
                if($this->Role_model->_has_access_('role','add_Module_Description_')){
            ?>
            <button type="button" class="btn btn-danger btn-w-100 btn-ui-100" id="saveModuleDesc" onclick="saveModuleDesc();">Save</button><?php } ?>
        </div>
        </div>

    </div>
    </div>
    </div>
    <!-- modal box for add doc ends-->
 </div>


<?php ob_start(); ?>
<script type="text/javascript">

function fillControllerID(controller_id,controller){

        $('.msg_controller_desc').html('')
        $('#controller_id').val(controller_id);
        $('.controllerName').text(controller);

        $.ajax({
            url: "<?php echo site_url('adminController/role/ajax_get_module_desc');?>",
            async : true,
            type: 'post',
            data: {controller_id: controller_id},
            dataType: 'json',
            success: function(response){
                if(response.status=='true'){
                    $('#module_alias').val(response.controller_alias);
                    $('#module_desc').val(response.controller_desc);
                }else{
                    $('#module_alias').val(response.controller_alias);
                    $('#module_desc').val(response.controller_desc);
                }
            }
        });
    }

    function saveModuleDesc(){

        var module_alias=document.getElementById("module_alias").value;
        var module_desc=document.getElementById("module_desc").value;
        var controller_id = document.getElementById("controller_id").value;
        //var image_id_icon = document.getElementById("image_id_icon").value;

        if($("#module_alias").val() == ""){
            $('.module_alias_err').text('Please enter module alias');
            $('#module_alias').focus();
            return false;
        }else{
            $('.module_alias_err').text('');
        }

        $.ajax({
            url: "<?php echo site_url('adminController/role/add_Module_Description_');?>",
            async : true,
            type: 'post',
            data: {controller_id: controller_id, module_desc: module_desc, module_alias: module_alias},
            dataType: 'json',
            success: function(response){
                if(response.status=='true'){
                    $('.msg_controller_desc').html(response.msg);
                }else{
                    $('.msg_controller_desc').html(response.msg);
                }
            }
        });

    }

/*$(document).ready(function(){
      $(".subdd").change(function(e){
          var id = $(this).attr("id");
          var value = this.value;
          $(".subdd option").each(function(){
            var idParent = $(this).parent().attr("id");
            if (id != idParent){
              if (this.value == value){
                this.remove();
              }
            }
        });
        //$('.subdd').selectpicker('refresh');
      });
});*/
</script>
<?php
global $customJs;
$customJs = ob_get_clean();
?>