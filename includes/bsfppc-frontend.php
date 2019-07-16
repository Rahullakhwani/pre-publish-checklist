<?php
require_once( BSF_PPC_ABSPATH . 'includes/bsfppc-save-data.php');
$bsfppc_radio_button = get_option('bsfppc_radio_button_option_data');
$bsfppc_checklist_item_data = get_option('bsfppc_checklist_data');
wp_enqueue_script('bsfppc_backend_itemlist_js');
wp_enqueue_style('bsfppc_backend_css');?>
<!DOCTYPE html>
<html>
<body>

	<h1>Please create a custom checklist </h1>
    <form method="POST">
    	<table><tr><td>
		<div class="input_fields_wrap">
			<div><input type="text" name="bsfppc_checklist_item[]" required></div>
		</div></td></tr>
	</table>
		<a class="add_field_button button-secondary">Add item</a>
		<input type="submit" id="form1" name="submit" class="button button-primary ppc_data" required   Value="Save List" />
	<form method="POST">
		<h2>Your List</h2>
		<?php
		if( !empty( $bsfppc_checklist_item_data)){
			foreach( $bsfppc_checklist_item_data as $key ){
			?>	 	
			<input type="text" readonly value="<?php echo esc_attr($key); ?>" name="bsfppc_checklist_item[]" >
			<button name="Delete" type="submit" class="button button-secondary" value="<?php echo esc_attr($key); ?>" formnovalidate >Delete</button>
			<?php
			}
		}
		else{
			echo "You have do not have any list please add items in the list";
		}?>
	</form>
	<h2>Settings</h2> 
	<p>On publish attempt </p>
		<form method ="POST">
			<input type="radio" name="bsfppc_radio_button_option" value="1" <?php checked($bsfppc_radio_button,1 ); ?> > <div class="bsfppc_radio_options">Prevent user from publishing.</div> 
			<p>The user will not be able to publish untill he checks all the checkboxes</p>
			<input type="radio" name="bsfppc_radio_button_option" value="2" <?php checked($bsfppc_radio_button,2 ); ?> > <div class="bsfppc_radio_options">Warn User before publishing. </div>  
			<p>The user will be warned before publishing </p>
			<input type="radio" name="bsfppc_radio_button_option" value="3" <?php checked($bsfppc_radio_button,3 ); ?> > <div class="bsfppc_radio_options">Do Nothing </div>
			<p>The user will be allowed to publish without any warning </p>
			<br/>
			<input type="submit" class="button button-primary"  name="submit_radio" Value="Save Setting"/>
		</form>
</body>
</html>



    
