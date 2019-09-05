<?php
/**
 * BSF Pre Publish Check list.
 *
 * PHP version 7
 *
 * @category PHP
 * @package  Pre Publish Check-list.
 * @author   Display Name <username@ShubhamW.com>
 * @license  http://brainstormforce.com
 * @link     http://brainstormforce.com
 */

if ( ! class_exists( 'PPC_Loader' ) ) :
	/**
	 * Pre Publish Check list doc comment.
	 *
	 * PHP version 7
	 *
	 * @category PHP
	 * @package  Pre-Publish Checklist.
	 * @author   Display Name <username@ShubhamW.com>
	 * @license  http://brainstormforce.com
	 * @link     http://brainstormforce.com
	 */
	class PPC_Loader {

		/**
		 * Member Variable
		 *
		 * @var instance
		 */
		private static $instance;
		/**
		 *  Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {
			$this->ppc_default_list_data();
			$this->ppc_load();
			add_action( 'admin_enqueue_scripts', array( $this, 'ppc_plugin_backend_js' ) );
			add_action( 'init', array( $this, 'ppc_save_data' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'ppc_metabox_scripts' ) );
			add_action( 'wp_ajax_ppc_checklistitem_add', array( $this, 'ppc_add_item' ), 1 );
			add_action( 'wp_ajax_nopriv_ppc_checklistitem_add', array( $this, 'ppc_add_item' ), 1 );
			add_action( 'wp_ajax_ppc_checklistitem_delete', array( $this, 'ppc_delete_item' ), 1 );
			add_action( 'wp_ajax_nopriv_ppc_checklistitem_delete', array( $this, 'ppc_delete_item' ), 1 );
			add_action( 'wp_ajax_ppc_checklistitem_drag', array( $this, 'ppc_drag_item' ), 1 );
			add_action( 'wp_ajax_nopriv_ppc_checklistitem_drag', array( $this, 'ppc_drag_item' ), 1 );
			add_action( 'wp_ajax_ppc_checklistitem_edit', array( $this, 'ppc_edit_item' ), 1 );
			add_action( 'wp_ajax_nopriv_ppc_checklistitem_edit', array( $this, 'ppc_edit_item' ), 1 );
		}


		public function ppc_default_list_data() {
			$ppc_default_checklist_data = array("Spelling & Grammar Checked","Featured Image Assigned","Category Selected","Formatting Done","Title is Catchy","Social Images Assigned" ,"Done SEO");
			
			add_option( 'ppc_checklist_data', $ppc_default_checklist_data );
		}
		/**
		 * Loads classes and includes.
		 *
		 * @since 1.0
		 * @return void
		 */
		private static function ppc_load() {
			include_once PPC_ABSPATH . 'classes/class-ppc-pagesetups.php';
		}
		/**
		 * Plugin Styles for admin dashboard.
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function ppc_plugin_backend_js() {
			$ppc_radio_button        = get_option( 'ppc_radio_button_option_data' );
			$ppc_checklist_item_data = get_option( 'ppc_checklist_data' );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jQuery-ui-droppable' );
			wp_register_script( 'ppc_backend_checkbox_js', PPC_PLUGIN_URL . '/assets/js/ppc-checkbox.js', null, '1.0', false );
			wp_register_script( 'ppc_backend_itemlist_js', PPC_PLUGIN_URL . '/assets/js/ppc-itemlist.js', null, '1.0', false );
			wp_register_style( 'ppc_backend_css', PPC_PLUGIN_URL . '/assets/css/ppc-css.css', null, '1.0', false );
			wp_localize_script(
				'ppc_backend_checkbox_js',
				'ppc_radio_obj',
				array(
					'option' => $ppc_radio_button,
					'data'   => $ppc_checklist_item_data,
				)
			);
			wp_localize_script( 'ppc_backend_itemlist_js', 'ppc_add_delete_obj', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
		}
		/**
		 * Localize script for ajax in the meta box
		 *
		 * @since 1.0.0
		 */
		public function ppc_metabox_scripts() {
			$ppc_screen                = get_current_screen();
			$ppc_post_types_to_display = get_option( 'ppc_post_types_to_display' );
			if ( ! empty( $ppc_post_types_to_display ) ) {
				if ( is_object( $ppc_screen ) ) {
					if ( in_array( $ppc_screen->post_type, $ppc_post_types_to_display, true ) ) {
						wp_localize_script(
							'ppc_backend_checkbox_js',
							'ppc_meta_box_obj',
							array( 'url' => admin_url( 'admin-ajax.php' ) )
						);
					}
				}
			}
		}

		/**
		 * Save order of the list
		 *
		 * Saves the order of the drag and drop list and updates it in the database
		 *
		 * @since 1.0.0
		 */
		public function ppc_drag_item() {
			if ( ! empty( $_POST['ppc_item_drag_var'] ) ) {//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				$ppc_new_drag_items = ( ! empty( $_POST['ppc_item_drag_var'] ) ? ( $_POST['ppc_item_drag_var'] ) : array() );//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				$ppc_new_drag_items = array_map( 'sanitize_text_field', $ppc_new_drag_items );
				if ( empty( $ppc_item_drag_contents ) || false === $ppc_item_drag_contents ) {
					$ppc_item_drag_contents = array();
				}
				foreach ( $ppc_new_drag_items as $ppc_dragitems ) {
					array_push( $ppc_item_drag_contents, $ppc_dragitems );
				}
				update_option( 'ppc_checklist_data', $ppc_item_drag_contents );
				echo 'sucess';
			}
			die();
		}

		/**
		 * Function for adding checklist  via ajax.
		 *
		 * Saves the checklist item in the database.
		 *
		 * @since 1.0.0
		 */
		public function ppc_add_item() {
			if ( ! empty( $_POST['ppc_item_content'] ) ) {//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				$ppc_newitems                = sanitize_text_field( $_POST['ppc_item_content'] );//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
					$ppc_checklist_item_data = get_option( 'ppc_checklist_data' );
				if ( empty( $ppc_checklist_item_data ) || false === $ppc_checklist_item_data ) {
					$ppc_checklist_item_data = array();
				}
					array_push( $ppc_checklist_item_data, $ppc_newitems );
					update_option( 'ppc_checklist_data', $ppc_checklist_item_data );
				?>
				<?php
				if ( ! empty( $ppc_checklist_item_data ) ) {
					foreach ( $ppc_checklist_item_data as $ppc_checklist_item_data_key ) {
						?>
								<li class="ppc-li">
								<!-- <span class = "down"></span> -->
								<span class="dashicons dashicons-menu-alt2 ppc-move-dashicon"></span> <input type="text" readonly="true" class="ppc-drag-feilds" value="<?php echo esc_attr( $ppc_checklist_item_data_key ); ?>" name="ppc_checklist_item[]" >
								<button type="button" id = "edit" name="Delete" class="ppcedit" value="<?php echo $ppc_checklist_item_data_key; ?>"> <span class="dashicons dashicons-edit"></span>Edit</button>
										<button type="button" id = "Delete" name="Delete" class="ppcdelete" value="<?php echo $ppc_checklist_item_data_key ; ?>"> <span class="dashicons dashicons-trash ppc-delete-dashicon"></span>Delete</button>
								<?php
					}
				} else {
					echo 'You have do not have any list please add items in the list';
				}
				?>
							</li>
							<?php
							die();
			}
		}

		/**
		 * Function for delete via ajax.
		 *
		 * Deletes the checklist item from the options table as well as post meta.
		 *
		 * @since 1.0.0
		 */
		public function ppc_delete_item() {
			if ( isset( $_POST['delete'] ) ) {//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				global $wpdb;
				$ppc_post_types_to_display = get_option( 'ppc_post_types_to_display' );
				$ppc_checklist_item_data   = get_option( 'ppc_checklist_data' );
				$ppc_delete_value          = sanitize_text_field($_POST['delete']) ;//PHPCS:ignore:WordPress.Security.NonceVerification.Missing				
				$ppc_delete_key            = array_search( $ppc_delete_value, $ppc_checklist_item_data, true);				unset( $ppc_checklist_item_data[ $ppc_delete_key ] );
				update_option( 'ppc_checklist_data', $ppc_checklist_item_data );
				echo 'sucess';
				$ppc_all_post_ids = get_posts(
					array(
						'posts_per_page' => -1,
						'post_type'      => $ppc_post_types_to_display,
						'post_status'    => array( 'publish', 'pending', 'draft' ),
						'fields'         => 'ids',
					)
				);
				if ( ! empty( $ppc_all_post_ids ) ) {
					foreach ( $ppc_all_post_ids as $ppc_postid ) {
						$ppc_pre_value = get_post_meta( $ppc_postid, '_ppc_meta_key', true );
						if ( ! empty( $ppc_pre_value ) ) {
							$ppc_post_delete_key = array_search( $ppc_delete_value, $ppc_pre_value, true );
							if ( false !== $ppc_post_delete_key ) {
								unset( $ppc_pre_value[ $ppc_post_delete_key ] );
								update_post_meta(
									$ppc_postid,
									'_ppc_meta_key',
									$ppc_pre_value
								);
							}
						}
					}
				}
				echo 'sucess';
			}
			die();
		}

		/**
		 * Function for editing checklist  via ajax.
		 *
		 * Edits the checklist item in the database.
		 *
		 * @since 1.0.0
		 */
		public function ppc_edit_item() {
			if ( isset( $_POST['ppc_edit_value'] ) && isset( $_POST['ppc_prev_value'] ) ) {//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
				global $wpdb;
				$ppc_post_types_to_display = get_option( 'ppc_post_types_to_display' );
				$ppc_checklist_item_data   = get_option( 'ppc_checklist_data' );
				$ppc_post_types_to_display = get_option( 'ppc_post_types_to_display' );
				if ( ! empty( $ppc_checklist_item_data ) ) {
					$ppc_prev_value                              = sanitize_text_field( $_POST['ppc_prev_value'] );//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
					$ppc_edit_value                              = sanitize_text_field( $_POST['ppc_edit_value'] );//PHPCS:ignore:WordPress.Security.NonceVerification.Missing
					$ppc_edit_key                                = array_search( $ppc_prev_value, $ppc_checklist_item_data, true );
					$ppc_checklist_item_data[ $ppc_edit_key ] = $ppc_edit_value;
					update_option( 'ppc_checklist_data', $ppc_checklist_item_data );
					echo 'sucess';
					$ppc_all_post_ids = get_posts(
						array(
							'posts_per_page' => -1,
							'post_type'      => $ppc_post_types_to_display,
							'post_status'    => array( 'publish', 'pending', 'draft' ),
							'fields'         => 'ids',
						)
					);
					if ( ! empty( $ppc_all_post_ids ) ) {
						foreach ( $ppc_all_post_ids as $ppc_postid ) {
							$ppc_pre_checklist_values = get_post_meta( $ppc_postid, '_ppc_meta_key', true );
							if ( ! empty( $ppc_pre_checklist_values ) ) {
								$ppc_post_edit_key = array_search( $ppc_prev_value, $ppc_pre_checklist_values, true );
								if ( false !== $ppc_post_edit_key ) {
									$ppc_pre_checklist_values[ $ppc_post_edit_key ] = $ppc_edit_value;
									update_post_meta(
										$ppc_postid,
										'_ppc_meta_key',
										$ppc_pre_checklist_values
									);
								}
							}
						}
					}
					echo 'sucess';
				}
				echo 'empty';
			}
			die();
		}

		/**
		 * Function for saving the Form data.
		 *
		 * Adds value from general settings page to the database.
		 *
		 * @since 1.0.0
		 */
		public function ppc_save_data() {

			$page = ! empty( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : null;
			if ( 'ppc' !== $page ) {
				return;
			}

			if ( ! empty( $_POST['ppc-form'] ) && wp_verify_nonce( sanitize_text_field( $_POST['ppc-form'] ), 'ppc-form-nonce' ) ) {
				if ( isset( $_POST['submit_radio'] ) ) {
	
					$_POST['submit_radio'] = sanitize_text_field( $_POST['submit_radio'] );
					if ( ! empty( $_POST['ppc_radio_button_option'] ) ) {
						$ppc_radio = sanitize_text_field( $_POST['ppc_radio_button_option'] );
						update_option( 'ppc_radio_button_option_data', $ppc_radio );
					}
					$ppc_radio_button_data = get_option( 'ppc_radio_button_option_data' );
				}

				if ( isset( $_POST['submit_radio'] ) ) {
					$_POST['submit_radio'] = sanitize_text_field( $_POST['submit_radio'] );
					$ppc_post_types     = array();
					if ( ! empty( $_POST['posts'] ) ) {
						$ppc_post_types = $_POST['posts'];
					}
					update_option( 'ppc_post_types_to_display', $ppc_post_types );
					$ppc_post_types_to_display = get_option( 'ppc_post_types_to_display' );
				}
			}
		}
	}
	PPC_Loader::get_instance();
endif;


