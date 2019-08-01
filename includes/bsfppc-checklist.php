<?php
require_once BSF_PPC_ABSPATH . 'includes/bsfppc-save-data.php';
$bsfppc_radio_button = get_option('bsfppc_radio_button_option_data');
$bsfppc_checklist_item_data = get_option('bsfppc_checklist_data');
wp_enqueue_script('bsfppc_backend_itemlist_js');
wp_enqueue_style('bsfppc_backend_css');
?>
<html>
<body>
<table class="form-table">
	<tbody>
		<tr>
			<th scope="row"> <p>Create a custom checklist</p> </th>
		   		<td>
			    	<table id ="list_table">
				    	<tr>
							<div class="input_fields_wrap">
								<input type="text" id="add_item_text_feild" class="item_input" name="bsfppc_checklist_item[]" required>
							</div>
						</tr>
					</table>
					<!-- <a class="add_field_button button-secondary ">Add item</a> -->
					<button type="button" id="Savelist" name="submit" class="button button-primary ppc_data" required   Value="Save List" />Add to list</button> <div class="popup-overlay">
					<p class="warning bsfppc-edit-waring-description">    List item cannot be blank</p></div>
				</td>
		</tr>
		<tr>
			<th scope="row"><p class="bsfppc_post"> Your List</p> </th>
			<td class="bsfppclistclass">	
				
				<div id="columns" class="ui-droppable ui-sortable bsfppcdragdrop">
					<?php
					if( !empty( $bsfppc_checklist_item_data)){?>
						<ul id="test" class="test">
								<?php
								foreach( $bsfppc_checklist_item_data as $key ){
									?>
									<li class="testy">
										<!-- <span class = "ui-sortable-handle "></span> --><span class = "down"></span> 
										<span class="dashicons dashicons-menu-alt3"></span> <input type="text" readonly="true" class="drag-feilds" value="<?php echo esc_attr($key); ?>" name="bsfppc_checklist_item[]" >			
										<button type="button" id = "Delete" name="Delete" class="button button-primary bsfppcdelete" value="<?php echo esc_attr($key); ?>" formnovalidate >Delete</button> 
										<?php
								}
					}
							else{
							echo "You have do not have any list please add items in the list";
							} ?>
									</li> 
						</ul>
				</div>
				<p class="bsfppc-description"> You can drag and drop the items to set the order</p>
				<button type="button" id = "Delete" name="Delete" class="button button-primary bsfppcedit" value="bsfppc_edit_items" formnovalidate >Edit Items</button>
				<button type="button" id = "saveitemlist" name="savelist" class="button button-primary bsfppcsave" value="bsfppc_save_items" formnovalidate >Save Changes </button>
				<div class="edit-warning">
					<p class="warning bsfppc-edit-waring-description">List item cannot be blank</p></div>
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>