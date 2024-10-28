
<div class="ace-accrodion-box">
		<form method = "post" class="register_form ace-accrodion-field">
			<div class="row">
				<div class="col-md-2">
					<label ><?php _e('Name of Label','ace-user-management'); ?></label>
				</div>
				<div class="col-md-10">
		        	<input class="form-control" type="text" name="input_label" value="<?php  ?>" placeholder="<?php _e('Type your label of field','ace-user-management'); ?>" required>
			    </div>
	        </div>
	        <div class="row">
				<div class="col-md-2">
					<label> <?php _e('PlaceHolder','ace-user-management'); ?></label>
				</div>
				<div class="col-md-10">
		        	<input class="form-control" type="text" name="input_placeholder" value="<?php  ?>" placeholder="<?php _e('Type your placeholder of field','ace-user-management'); ?>" required />
			    </div>
	        </div>
	        <div class="row">
				<div class="col-md-2">
					<label><?php _e('Name of Input','ace-user-management'); ?></label>
				</div>
				<div class="col-md-10">
		        	<input class="form-control" type="text" name="input_name" value="<?php  ?>" placeholder="<?php _e('Type your name of field','ace-user-management'); ?>"required>
			    </div>
	        </div>
	        <div class="row">
				<div class="col-md-2">
					<label><?php _e('Name of Input Type','ace-user-management'); ?></label>
				</div>
				<div class="col-md-10">
		        	<select class="form-control" name="input_type" id="input_type">
				        <option value="text"><?php _e('Text','ace-user-management'); ?></option>
				        <option value="textarea"><?php _e('Textarea','ace-user-management'); ?></option>
				        <option value="dropdown"><?php _e('Dropdown','ace-user-management'); ?></option>
			    	</select>
		    	</div>
	        </div>
	        <div class="row" id="row">
	        </div>
	         <div class="row">
				<div class="col-md-2">
				</div>
				<div class="col-md-6">
	        		<input type="submit" name="submit_form" class="btn btn-primary submit_btn">
			    </div>
	        </div>
	    </form>
	</div><br><br>
    <?php 
    	// echo "<pre>";
    	global $wpdb;
    	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ace_register_fields ORDER BY sortby", OBJECT );
    ?>
    <div class="ace-accrodion-box-label">
	  <div id="ace-accordion" class="ace-accrodion-field panel-group">
	  	<form name="sorting"  method="post" >
		  	<table class="table">
		  		<tbody>
		    		<ul class="table_thead">
		    				<li><?php _e('Label','ace-user-management'); ?></li>
		    				<li><?php _e('Name','ace-user-management'); ?></li>
		    				<li><?php _e('Type','ace-user-management'); ?></li>
		    		</ul>
				<?php
			    	if( !empty(  $update_massage ) ){
			    		echo '<div class="alert alert-success">'.$update_massage.'</div>';
			    	}
			    	$count = 1;
				    foreach ($results as $key => $value ) { 
				    	$dropdown_options =  explode(",", $value->dropdown_options);
			    ?>
			    <tr>
			    	<td>
			    		<input type="hidden" name="id_update_[]" value="<?php echo $value->id; ?>">
				    	<div class="panel a_">
						    <div class="panel-heading">
						      <h4 class="panel-title ">
						        	<a href="#<?php echo $value->id; ?>" class="accordion-toggle collapsed fa fa-chevron-down" data-toggle="collapse" data-parent="#accordion"><?php echo '<p class="field_count_">'.$count.'</p>'; ?><span class="title_"><?php echo ucfirst($value->input_label); ?></span><span class="title_"><?php echo $value->input_name; ?></span><span class="title_"><?php echo ucfirst($value->input_type); ?></span>
						        		<button class="btn btn-primary edit"><?php _e('Edit Field','ace-user-management'); ?></button>

						        	</a>		
						        </h4>
						    </div>
						    <div id="<?php echo $value->id; ?>" class="panel-collapse collapse">
						      	<div class="panel-body">
						          <form method="post">
						          	<div class="form-group">
									    <label for=""><?php _e('Input Label','ace-user-management'); ?></label>
									    <input type="text" name="f_lable_update" class="form-control" id="" value="<?php echo $value->input_label; ?>">
									</div>
									<div class="form-group">
									    <label for=""><?php _e('Input Placeholder','ace-user-management'); ?></label>
									    <input type="text" name="f_place_update" class="form-control" id="" value="<?php echo $value->input_placeholder;?>">
									</div>
									<label for=""><?php _e('Input Type','ace-user-management') ?></label>
									<select class="form-control" name="input_type_update" id="input_type">
								        <option value="text" <?php if( $value->input_type == 'text'){  echo "selected"; } ?>>Text</option>
								        <option value="textarea" <?php if($value->input_type == 'textarea'){ echo "selected"; } ?>>Textarea</option>
								        <option value="dropdown" <?php if($value->input_type == 'dropdown'){ echo "selected"; } ?>>Dropdown</option>
							    	</select>
									<?php if( !empty($value->dropdown_options ) ) { ?>
									<div class="form-group">
									    <label for=""><?php _e('Dropdown Options','ace-user-management'); ?></label>
									    <input type="text" class="form-control" name="dr_options_update" id="" value="<?php echo $value->dropdown_options;?>">
									</div>
									<?php }?>
									<div class="form-group">
									    <label for=""><?php _e('Input Name','ace-user-management'); ?></label>
									    <input type="text" name="input_name_update" class="form-control" id="pwd" value="<?php echo $value->input_name;?>">
									</div>
									<input type="hidden" name="id_update" value="<?php echo $value->id; ?>">
									<input type="submit" name="update" value="<?php _e('Update','ace-user-management'); ?>" class="btn btn-primary submit_btn"/>
									<input type="button"  class="delete_ btn btn-primary submit_btn"" data-id="<?php echo $value->id; ?>" value="<?php _e('Delete','ace-user-management'); ?>">
						          </form>
						        </div>
						    </div>
				    	</div>
					</td>
				</tr>
			</div>
		</div>
					<?php  $count++; }	?>
				</tbody>
			</table>
			<input type="submit" name="savelayout" value="<?php _e('Save','ace-user-management'); ?>" class="btn btn-primary submit_btn save_btn" <?php if( empty( $results )){
    		echo "disabled";
    	} ?>>
		</form>
	  </div>
	</div>
  <!-- </div> -->
</body>
</html>