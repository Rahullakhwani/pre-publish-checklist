<?php
/**
 * Pre-Publish Check list php for displaying the contents on the
 * general settings tab.
 * PHP version 7
 *
 * @category PHP
 * @package  Pre-Publish Checklist.
 * @author   Display Name <username@ShubhamW.com>
 * @license  http://brainstormforce.com
 * @link     http://brainstormforce.com
 */

$cpt_checklist = PPC_Loader::get_instance()->get_list();

// function get_current_post_type_list( $post_type ) {
// 	$cpt_checklist = PPC_Loader::get_instance()->get_list();

// 	if( isset( $cpt_checklist[$post_type ] ) ) {
// 		return $cpt_checklist[$post_type ];
// 	}

// 	return array();
	
// }

// delete_option( 'ppc_checklist_data' );
// delete_option( 'ppc_cpt_checklist_data' );
// var_dump(get_option( 'ppc_cpt_checklist_data', array() ));
// var_dump($cpt_checklist);
// wp_die();

$ppc_checklist_item_data = array();
if( ! empty( $cpt_checklist ) && ( isset( $_GET['type'] ) && array_key_exists($_GET['type'], $cpt_checklist) ) ) {
	$ppc_checklist_item_data = $cpt_checklist[$_GET['type']];
}



wp_enqueue_script( 'ppc_backend_itemlist_js' );
wp_enqueue_style( 'ppc_backend_css' );
wp_enqueue_script( 'jquery' );
wp_enqueue_script( 'jquery-ui-core' );
wp_enqueue_script( 'jquery-ui-sortable' );
wp_enqueue_script( 'jQuery-ui-droppable' );
?>

<div>
	<?php
		$ppc_post_types = get_option( 'ppc_post_types_to_display' );
	?>	
	<ul id="pts" class="pts" name ="post-type-selected">
		<?php
			foreach ($ppc_post_types as $ppc_post ) {
		?>
		<li><a href="?page=ppc&tab=ppc-checklist&type=<?php echo $ppc_post;?>" class=""><?php echo $ppc_post = ucfirst($ppc_post); ?> </a></li><?php
					}
				?>	
	</ul>
</div>
<div class="ppc-table-wrapper">
<table class="form-table ppc-form-table">
	<tbody>
		<!-- <tr>
			<th scope="row"><p class="ppc-list-label"><span class=""></span><?php esc_html_e( 'Set a checklist for', 'pre-publish-checklist' ); ?></p> </th>
			<td class="">
				<?php
				$ppc_post_types = get_option( 'ppc_post_types_to_display' );
				// var_dump($ppc_post_types);
				?>
				<select id="pts" name="post-type-selected">
					<option value= "default">--Select one--</option>
				<?php
				foreach ($ppc_post_types as $ppc_post ) {
					?><option value= "<?php echo $ppc_post;?>"><?php echo $ppc_post; ?></option> <?php
					}
				?>	
				</select>
			</td>
		</tr> -->
		<tr>
			<th scope="row"><p class="ppc-list-label"><span class="spinner ppc-spinner"></span><?php esc_html_e( 'Pre-Publish Checklist', 'pre-publish-checklist' ); ?></p> </th>
			<td class="ppc-list-table">
				<div id="columns" class="ppcdragdrop">
				
			<?php
			if ( ! empty( $ppc_checklist_item_data ) ) {
			?>
				<ul id="ppc-ul" class="ppc-ul"> 
			<?php
			foreach ( $ppc_checklist_item_data as $ppc_key => $ppc_value  ) {
				?>
									<li class="ppc-li">
										<span class="dashicons dashicons-menu-alt2 ppc-move-dashicon"></span> <input type="text" readonly="true" class="ppc-drag-feilds" $ppc_item_key ="<?php echo esc_attr( $ppc_key ); ?>" value="<?php echo esc_attr( $ppc_value ); ?>" name="ppc_checklist_item[]" >
										<button type="button" id = "edit" name="Edit" class="ppcedit" value="<?php echo esc_attr( $ppc_key ); ?>"> <span class="dashicons dashicons-edit"></span>Edit</button>
										<button type="button" id ="Delete" name="Delete" class="ppcdelete" value="<?php echo esc_attr( $ppc_key ); ?>"> <span class="dashicons dashicons-trash ppc-delete-dashicon"></span>Delete</button>
									</li>
				<?php
			}
		}
		?>
						</ul>
				</div>
				<p class="ppc-empty-list"><?php esc_html_e( 'You do not have any items in the list. Please add items in the list.', 'pre-publish-checklist' ); ?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"> <p class="ppc-label"><?php esc_html_e( 'Add New Item in Checklist', 'pre-publish-checklist' ); ?></p> </th>
			<td class="ppc-table">
				<table id ="list_table">
					<tr><div class="ppc_input_feild">
						<input type="text" id="add_item_text_feild" class="ppc-item-input" name="ppc_checklist_item[]" minlength= 1 >
						<button type="button" id="ppc-Savelist" name="submit" class="button button-primary ppc_data"   Value="Save List" /><?php esc_html_e( 'Add to List', 'pre-publish-checklist' ); ?></button>
						<br>

						<div class="ppc-warning-div">
							<div class="ppc-hide-empty-warning">
							<p class="warning ppc-list-waring-description"><?php esc_html_e( 'List item cannot be blank', 'pre-publish-checklist' ); ?></p>
							</div>
						</div>
					</div>
					</tr>
				</table>					
			</td>
		</tr>

	</tbody>
</table>
</div>


