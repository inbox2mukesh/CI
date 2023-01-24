<div class="role-manage_role">
 <div class="row">
  <div class="col-md-12">
    <div class="box">
        <div class="box-header bg-danger">
            <?php foreach($roledata as $r){$role_name=$r['name'];}?>
            <h3 class="box-title text-primary">Access list for <b><?php echo $role_name;?></b></h3>
            <span class="pull-right">
                <a href="<?php echo site_url('adminController/role/run_role');?>" class="btn btn-warning btn-sm link-btn-ui-100"><i class="fa fa-refresh"></i> Refresh role </a>
                <a href="<?php echo site_url('adminController/role/index');?>" class="btn btn-success btn-sm link-btn-ui-100"><i class="fa fa-list"></i> Go to role list </a>
            </span>

        </div>
            <?php echo $this->session->flashdata('flsh_msg');?>
            <?php echo form_open('adminController/role/manage_role_/'.$role['id']); ?>
        <div class="box-body table-responsive">
            <div class="col-md-12">
            <table class="table table-striped table-bordered table-sm">
                <tr>
					<th><?php echo SR;?></th>
                    <th>Id</th>
					<th>Module</th>
                    <th><input type="checkbox" id="select_all"> Task</th>
                </tr>
                <?php $sr=0; foreach($controllers as $c){ $sr++;?>
                <tbody id="myTable">
                <tr>
					<td><?php echo $sr; ?></td>
                    <td><?php echo $c['id']; ?></td>
					<td class="bg-danger module-check" title="<?php echo $c['controller_desc'];?>">
                    <label class="mrg-top-30">
                        <input type="checkbox" id="<?php echo $c['id'];?>" name="cb_controller[]" value="<?php echo $c['id'];?>" class="groupCont<?php echo $c['id'];?>" onclick="groupClass(this.id)">
                        <span class="checkmark"></span>
                    </label>
                    <b><?php echo $c['controller_alias'];?></b>

                    </td>
                    <?php $CI=&get_instance();?>
                    <td>
                        <?php
                            foreach($c['Methods'] as $m){
                                $is_checked = $CI->_is_checked($role['id'],$c['id'],$m['id']);
                            if($is_checked){
                                $ch= 'checked="checked"';
                            }else{
                                $ch='';
                            }
                        ?>
                                <!-- <span style="border: 5px solid gray;padding: 4px;">
                                    <label>
                                    <input type="checkbox" name="cb_method[]" value="<?php echo $c['id'].'~'.$m['id'];?>" <?php echo $ch;?> class="checkbox_allmethod">
                                    <?php echo str_replace('index', 'List', $m['method_name']);?>&nbsp;
                                </label>
                                </span> -->
                                <span>
                                <label>
                                    <input type="checkbox" name="cb_method[]" value="<?php echo $c['id'].'~'.$m['id'];?>" <?php echo $ch;?> class="checkbox_allmethod groupCont<?php echo $c['id'];?>">
                                    <a id="<?php echo $ch;?>" href="javascript:void(0)" title="<?php echo $m['method_desc'];?>"><?php echo $m['method_alias'];?>&nbsp;</a>
                                </label>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                    </tbody>
                    <?php } ?>
            </table>
            <input class="text-danger" type="text" name="ok" id='ok' value='save the access' disabled="disabled" >
            <span class="text-danger"><?php echo form_error('ok');?></span>
                        </div>
            
           
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-danger input-ui-100"><i class="fa fa-check"></i> Save</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
</div>
</div>
<?php ob_start(); ?>
<script type="text/javascript">
$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox_allmethod').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox_allmethod').each(function(){
                this.checked = false;
            });
        }
    });

    /*$('.checkbox_allmethod').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });*/
});

function groupClass(controller_id){

    if($('#'+controller_id).prop('checked') == true){
        var mclass = '.groupCont'+controller_id
         $(mclass).prop('checked',true);
    }else{
        var mclass = '.groupCont'+controller_id
        $(mclass).prop('checked',false);
    }
}
</script>
<?php
global $customJs;
$customJs = ob_get_clean();
?>
