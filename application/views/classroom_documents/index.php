<div class="row">
    <div class="col-md-12">
    <div class="box box-flex-widget">
           <div class="box-header bg-danger">
                <h3 class="box-title text-primary"><?php echo $title;?></h3>
            	<div class="box-tools">
                    <?php 
                  if($this->Role_model->_has_access_('classroom_documents','add')){
                  ?>
                    <a href="<?php echo site_url('adminController/classroom_documents/add'); ?>" class="btn btn-danger btn-sm">Add</a> 
                <?php }?>
                </div>
            </div>
            <?php echo $this->session->flashdata('flsh_msg'); ?>
            <div class="col-md-12">
                <div class="box-body table-responsive table-cb-none mheight200">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                        <th><?php echo SR;?></th>
						<th>Classroom</th>
						<th>Content Type</th>
						<th>Documents Title</th>
						<th><?php echo STATUS;?></th>
                        <th><?php echo ACTION;?></th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php
				if(!empty($this->input->get('per_page'))) {

					$sr=$this->input->get('per_page');

				 } else{

					 $sr=0;

				 }
					foreach($classroom_documents as $p){ 
					$zero=0;
					$one=1;
					$pk='id'; 
					$table='classroom_documents';
					$sr++;
					?>
                    <tr>
						<td><?php echo $sr; ?></td>
                        <td><?php 
						foreach($p['classroom_documents_class'] as $key=>$val){
							
							echo $val['classroom_name'].', ';
						} 
						?>
						</td>
						<td><?php 
						foreach($p['classroom_documents_content_type'] as $key=>$val){
							
							echo $val['content_type_name'].', ';
						} 
						?>
						</td>
						 <td><?php echo $p['title']; ?></td>
                        <td>
                            <?php 
							#pr($p);
                            if($p['active']==1){
                                echo '<span class="text-success"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="Active"  >'.ACTIVE.'</a></span>';
                            }else{
                                echo '<span class="text-danger"><a href="javascript:void(0);" id='.$p['id'].' data-toggle="tooltip" title="De-Active" >'.DEACTIVE.'</a></span>';
                            }
                            ?>                                
                        </td>
						<td>
                        <?php 
                        if($this->Role_model->_has_access_('classroom_documents','edit')){
                        ?>
                        <a href="<?php echo site_url('adminController/classroom_documents/edit/'.$p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span> </a> 
                        <?php }?>

                        <?php 
                        if($this->Role_model->_has_access_('classroom_documents','view_document_details_')){
                        ?>
                        <a href="<?php echo site_url('adminController/classroom_documents/view_document_details_/'.$p['id']); ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="view"><span class="fa fa-eye"></span> </a> 
                        <?php }?>                            
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
                </div>
                <div class="pull-right">
                    <?php echo $this->pagination->create_links(); ?>                    
                </div>                
            </div>
        </div>
    </div>
</div>