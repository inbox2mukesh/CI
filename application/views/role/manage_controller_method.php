<div class="role-manage_controller_method">
    <div class="row">
        <div class="col-md-12">
        <div class="box box-flex-widget">
                <div class="box-header bg-danger">
                    <h3 class="box-title text-primary"><?php echo $title;?></h3>
                    <div class="box-tools">
                        <?php
                            if($this->Role_model->_has_access_('role','manage_controller')){
                        ?>
                        <a href="<?php echo site_url('adminController/role/manage_controller'); ?>" class="btn btn-danger btn-sm">Manage controller</a> <?php } ?>
                    </div>
                </div>
                <?php echo $this->session->flashdata('flsh_msg');?>
                <?php echo form_open('adminController/role/manage_controller_method'); ?>
                <div class="box-body table-responsive">
                    <div class="clearfix flex-align-center">

                    <input type="hidden" name="fake_id" value="fake" class="form-control" id="fake_id"/>
                        <div class="col-md-4">
                            <label for="controller_id" class="control-label">Module</label>
                            <div class="form-group">
                                <select name="controller_id" id="controller_id" class="form-control selectpicker selectpicker-ui-100" data-show-subtext="true" data-live-search="true">
                                    <option value="">Select module</option>
                                    <?php
                                    foreach($all_controller_list as $p)
                                    {
                                        $selected = ($p['id'] == $this->input->post('controller_id')) ? ' selected="selected"' : "";
                                        echo '<option value="'.$p['id'].'" '.$selected.'>'.$p['controller_name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="submitBtn" style="margin-top:3px;">
                            <button type="submit" class="btn btn-danger btn-ui-100">
                                <i class="fa fa-search"></i> <?php echo SEARCH_LABEL;?>
                            </button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                    <div class="col-md-12">
                <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                        <thead>
                        <tr>
                            <th width="5%"><?php echo SR;?></th>
                            <th width="19%">Controller name</th>
                            <th width="19%">Method name</th>
                            <th width="19%">Method alias</th>
                            <th width="19%">Method desc.</th>
                            <!-- <th>Icon</th> -->
                            <th width="19%">Add Method desc.</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php $sr=0;foreach($all_method_list as $r){ $zero=0;$one=1;$pk='id'; $table='method_list'; $sr++;
                            ?>
                        <tr>
                            <td><?php echo $sr; ?></td>
                            <td>
                                <?php
                                echo $r['controller_name'];
                                ?>
                            </td>
                            <td><?php echo $r['method_name']; ?></td>
                            <td><?php echo $r['method_alias']; ?></td>
                            <td><?php echo $r['method_desc']; ?></td>
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
                                <a href="javascript:void(0)" class="btn btn-green btn-sm link-btn-ui-100" data-toggle="modal" data-target="#modal-method-desc" name="<?php echo $r['controller_name'];?>" id="<?php echo $r['id'];?>" title="<?php echo $r['method_name'];?>" onclick="fillMethodID(this.id,this.name,this.title)"><span class="fa fa-plus"></span> &nbsp;Add/Update Desc.</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    </table>
                    </div>
                </div>
                </div>
                <div class="pagination-right">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
            </div>
        </div>
    </div>

    <!-- modal box for add modal-method-desc starts-->
    <div class="modal fade" id="modal-method-desc" style="display: none;">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-heading text-info">Add/Update Method Desc.</h4>
            <h5 class="msg_method_desc"></h5>
        </div>

        <div class="modal-body">
            <div class="row">
            <div class="col-md-12">
                <div class="box-info">
               
                    <div class="clearfix">

                        <div class="col-md-12">
                            <label for="cDesc" class="control-label text-blue controllerName"></label>
                        </div>

                        <div class="col-md-6">
                            <label for="mDesc" class="control-label text-blue methodName"></label>
                        </div>

                        <div class="col-md-12">
                            <label for="method_alias" class="control-label">Method alias<span class="text-danger">*</span></label>
                            <div class="form-group">
                                <input type="text" name="method_alias" class="form-control input-ui-100" id="method_alias">
                                <span class="text-danger method_alias_err"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="method_desc" class="control-label">Method description</label>
                            <div class="form-group">
                                <textarea name="method_desc" class="form-control textarea-ui-16" id="method_desc"></textarea>
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

                        <input type="hidden" name="method_id" id="method_id">

                    </div>
                    </div>
           
            </div>
            </div>
        </div>

        <div class="modal-footer">
            <div class="col-md-12">
            <!-- <button type="button" class="btn btn-default pull-left btn-ui-100" data-dismiss="modal">Close</button> -->
            <?php
                if($this->Role_model->_has_access_('role','add_Method_Description_')){
            ?>
            <button type="button" class="btn btn-danger btn-w-100 btn-ui-100" id="saveMethodDesc" onclick="saveMethodDesc();">Save</button><?php } ?>
        </div>
        </div>

    </div>
    </div>
    </div>
    <!-- modal box for add doc ends-->
</div>
<?php ob_start(); ?>
<script type="text/javascript">
    function fillMethodID(method_id,controller,method){

        $('.msg_method_desc').html('')
        $('#method_id').val(method_id);
        $('.controllerName').text(controller);
        $('.methodName').text(method);
        /*var lastChar = method.substr(method.length - 1); // => "1"
        if(lastChar=='_' ||  method=='edit' || method=='remove'){
            $('#submit_icon').hide()
        }else{
            $('#submit_icon').show()
        }*/

        $.ajax({
            url: "<?php echo site_url('adminController/role/ajax_get_method_desc');?>",
            async : true,
            type: 'post',
            data: {method_id: method_id},
            dataType: 'json',
            success: function(response){
                if(response.status=='true'){
                    $('#method_alias').val(response.method_alias);
                    $('#method_desc').val(response.method_desc);
                }else{
                    $('#method_alias').val(response.method_alias);
                    $('#method_desc').val(response.method_desc);
                }
            }
        });
    }

    function saveMethodDesc(){

        var method_alias=document.getElementById("method_alias").value;
        var method_desc=document.getElementById("method_desc").value;
        var method_id = document.getElementById("method_id").value;
        //var image_id_icon = document.getElementById("image_id_icon").value;

        if($("#method_alias").val() == ""){
            $('.method_alias_err').text('Please enter method alias');
            $('#method_alias').focus();
            return false;
        }else{
            $('.method_alias_err').text('');
        }

        $.ajax({
            url: "<?php echo site_url('adminController/role/add_Method_Description_');?>",
            async : true,
            type: 'post',
            data: {method_id: method_id, method_desc: method_desc, method_alias: method_alias},
            dataType: 'json',
            success: function(response){
                if(response.status=='true'){
                    $('.msg_method_desc').html(response.msg);
                }else{
                    $('.msg_method_desc').html(response.msg);
                }
            }
        });

    }
</script>
<?php
global $customJs;
$customJs = ob_get_clean();
?>