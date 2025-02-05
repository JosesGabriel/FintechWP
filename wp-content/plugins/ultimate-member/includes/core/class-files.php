<?php
namespace um\core;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'um\core\Files' ) ) {


	/**
	 * Class Files
	 * @package um\core
	 */
	class Files {


		/**
		 * @var
		 */
		var $upload_temp;


		/**
		 * @var
		 */
		var $upload_baseurl;


		/**
		 * @var
		 */
		var $upload_basedir;


		/**
		 * Files constructor.
		 */
		function __construct() {

			$this->setup_paths();

			add_action( 'template_redirect', array( &$this, 'download_routing' ) );

			$this->fonticon = array(
				'pdf' 	=> array('icon' 	=> 'um-faicon-file-pdf-o', 'color' => '#D24D4D' ),
				'txt' 	=> array('icon' 	=> 'um-faicon-file-text-o' ),
				'csv' 	=> array('icon' 	=> 'um-faicon-file-text-o' ),
				'doc' 	=> array('icon' 	=> 'um-faicon-file-text-o', 'color' => '#2C95D5' ),
				'docx' 	=> array('icon' 	=> 'um-faicon-file-text-o', 'color' => '#2C95D5' ),
				'odt' 	=> array('icon' 	=> 'um-faicon-file-text-o', 'color' => '#2C95D5' ),
				'ods' 	=> array('icon' 	=> 'um-faicon-file-excel-o', 'color' => '#51BA6A' ),
				'xls' 	=> array('icon' 	=> 'um-faicon-file-excel-o', 'color' => '#51BA6A' ),
				'xlsx' 	=> array('icon' 	=> 'um-faicon-file-excel-o', 'color' => '#51BA6A' ),
				'zip' 	=> array('icon' 	=> 'um-faicon-file-zip-o' ),
				'rar' 	=> array('icon'		=> 'um-faicon-file-zip-o' ),
				'mp3'	=> array('icon'		=> 'um-faicon-file-audio-o' ),
				'jpg' 	=> array('icon' 	=> 'um-faicon-picture-o' ),
				'jpeg' 	=> array('icon' 	=> 'um-faicon-picture-o' ),
				'png' 	=> array('icon' 	=> 'um-icon-image' ),
				'gif' 	=> array('icon' 	=> 'um-icon-images' ),
				'eps' 	=> array('icon' 	=> 'um-icon-images' ),
				'psd' 	=> array('icon' 	=> 'um-icon-images' ),
				'tif' 	=> array('icon' 	=> 'um-icon-image' ),
				'tiff' 	=> array('icon' 	=> 'um-icon-image' ),
			);

			$this->default_file_fonticon = 'um-faicon-file-o';
		}


		/**
		 * File download link generate
		 *
		 * @param int $form_id
		 * @param string $field_key
		 * @param int $user_id
		 *
		 * @return string
		 */
		function get_download_link( $form_id, $field_key, $user_id ) {
			$field_key = urlencode( $field_key );

			if ( UM()->is_permalinks ) {
				$url = get_home_url( get_current_blog_id() );
				$nonce = wp_create_nonce( $user_id . $form_id . 'um-download-nonce' );
				$url = $url . "/um-download/{$form_id}/{$field_key}/{$user_id}/{$nonce}";
			} else {
				$url = get_home_url( get_current_blog_id() );
				$nonce = wp_create_nonce( $user_id . $form_id . 'um-download-nonce' );
				$url = add_query_arg( array( 'um_action' => 'download', 'um_form' => $form_id, 'um_field' => $field_key, 'um_user' => $user_id, 'um_verify' => $nonce ), $url );
			}

			//add time to query args for sites with the cache
			return add_query_arg( array( 't' => time() ), $url );
		}


		/**
		 * @return bool
		 */
		function download_routing() {
			if ( 'download' !== get_query_var( 'um_action' ) ) {
				return false;
			}

			$query_form = get_query_var( 'um_form' );
			if ( empty( $query_form ) ) {
				return false;
			}

			$form_id = get_query_var( 'um_form' );
			$query_field = get_query_var( 'um_field' );
			if ( empty( $query_field ) ) {
				return false;
			}
			$field_key = urldecode( get_query_var( 'um_field' ) );
			$query_user = get_query_var( 'um_user' );
			if ( empty( $query_user ) ) {
				return false;
			}

			$user_id = get_query_var( 'um_user' );
			$user = get_userdata( $user_id );

			if ( empty( $user ) || is_wp_error( $user ) ) {
				return false;
			}
			$query_verify = get_query_var( 'um_verify' );
			if ( empty( $query_verify ) ||
			     ! wp_verify_nonce( $query_verify, $user_id . $form_id . 'um-download-nonce' ) ) {
				return false;
			}

			um_fetch_user( $user_id );
			$field_data = get_post_meta( $form_id, '_um_custom_fields', true );
			if ( empty( $field_data[ $field_key ] ) ) {
				return false;
			}

			if ( ! um_can_view_field( $field_data[ $field_key ] ) ) {
				return false;
			}

			$field_value = UM()->fields()->field_value( $field_key );
			if ( empty( $field_value ) ) {
				return false;
			}

			$download_type = $field_data[ $field_key ]['type'];
			if ( $download_type === 'file' ) {
				$this->file_download( $user_id, $field_key, $field_value );
			} else {
				$this->image_download( $user_id, $field_key, $field_value );
			}

			return false;
		}


		/**
		 * @param $user_id
		 * @param $field_key
		 * @param $field_value
		 */
		function image_download( $user_id, $field_key, $field_value ) {
			$file_path = UM()->uploader()->get_upload_base_dir() . $user_id . DIRECTORY_SEPARATOR . $field_value;
			if ( ! file_exists( $file_path ) ) {
				if ( is_multisite() ) {
					//multisite fix for old customers
					$file_path = str_replace( DIRECTORY_SEPARATOR . 'sites' . DIRECTORY_SEPARATOR . get_current_blog_id() . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $file_path );
				}
			}

			//validate traversal file
			if ( validate_file( $file_path ) === 1 ) {
				return;
			}

			$file_info = get_user_meta( $user_id, $field_key . "_metadata", true );

			$pathinfo = pathinfo( $file_path );
			$size = filesize( $file_path );
			$originalname = ! empty( $file_info['original_name'] ) ? $file_info['original_name'] : $pathinfo['basename'];
			$type = ! empty( $file_info['type'] ) ? $file_info['type'] : $pathinfo['extension'];

			header('Content-Description: File Transfer');
			header('Content-Type: ' . $type );
			header('Content-Disposition: inline; filename="' . $originalname . '"');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . $size);

			$levels = ob_get_level();
			for ( $i = 0; $i < $levels; $i++ ) {
				@ob_end_clean();
			}

			readfile( $file_path );
			exit;
		}


		/**
		 * @param $user_id
		 * @param $field_key
		 * @param $field_value
		 */
		function file_download( $user_id, $field_key, $field_value ) {
			$file_path = UM()->uploader()->get_upload_base_dir() . $user_id . DIRECTORY_SEPARATOR . $field_value;
			if ( ! file_exists( $file_path ) ) {
				if ( is_multisite() ) {
					//multisite fix for old customers
					$file_path = str_replace( DIRECTORY_SEPARATOR . 'sites' . DIRECTORY_SEPARATOR . get_current_blog_id() . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $file_path );
				}
			}

			//validate traversal file
			if ( validate_file( $file_path ) === 1 ) {
				return;
			}

			$file_info = get_user_meta( $user_id, $field_key . "_metadata", true );

			$pathinfo = pathinfo( $file_path );
			$size = filesize( $file_path );
			$originalname = ! empty( $file_info['original_name'] ) ? $file_info['original_name'] : $pathinfo['basename'];
			$type = ! empty( $file_info['type'] ) ? $file_info['type'] : $pathinfo['extension'];

			header('Content-Description: File Transfer');
			header('Content-Type: ' . $type );
			header('Content-Disposition: attachment; filename="' . $originalname . '"');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . $size);

			$levels = ob_get_level();
			for ( $i = 0; $i < $levels; $i++ ) {
				@ob_end_clean();
			}

			readfile( $file_path );
			exit;
		}


		/**
		 * Remove file by AJAX
		 */
		function ajax_remove_file() {
			UM()->check_ajax_nonce();

			/**
			 * @var $src
			 */
			extract( $_REQUEST );
			$this->delete_file( $src );

			wp_send_json_success();
		}


		/**
		 * Resize image AJAX handler
		 */
		function ajax_resize_image() {
			UM()->check_ajax_nonce();

			/**
			 * @var $key
			 * @var $src
			 * @var $coord
			 * @var $user_id
			 */
			extract( $_REQUEST );

			if ( ! isset( $src ) || ! isset( $coord ) ) {
				wp_send_json_error( esc_js( __( 'Invalid parameters', 'ultimate-member' ) ) );
			}

			$coord_n = substr_count( $coord, "," );
			if ( $coord_n != 3 ) {
				wp_send_json_error( esc_js( __( 'Invalid coordinates', 'ultimate-member' ) ) );
			}

			$image_path = um_is_file_owner( $src, $user_id, true );
			if ( ! $image_path ) {
				wp_send_json_error( esc_js( __( 'Invalid file ownership', 'ultimate-member' ) ) );
			}

			UM()->uploader()->replace_upload_dir = true;
			$output = UM()->uploader()->resize_image( $image_path, $src, $key, $user_id, $coord );
			UM()->uploader()->replace_upload_dir = false;

			// add custom filter
			$output = apply_filters('um_ajax_resize_image', $output);

			delete_option( "um_cache_userdata_{$user_id}" );

			wp_send_json_success( $output );
		}



		/**
		 * Image upload by AJAX
		 */
		function ajax_image_upload() {
			$ret['error'] = null;
			$ret = array();

			$id = $_POST['key'];
			$timestamp = $_POST['timestamp'];
			$nonce = $_POST['_wpnonce'];
			$user_id = $_POST['user_id'];

			UM()->fields()->set_id = $_POST['set_id'];
			UM()->fields()->set_mode = $_POST['set_mode'];

			/**
			 * UM hook
			 *
			 * @type filter
			 * @title um_image_upload_nonce
			 * @description Change Image Upload nonce
			 * @input_vars
			 * [{"var":"$nonce","type":"bool","desc":"Nonce"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage
			 * <?php add_filter( 'um_image_upload_nonce', 'function_name', 10, 1 ); ?>
			 * @example
			 * <?php
			 * add_filter( 'um_image_upload_nonce', 'my_image_upload_nonce', 10, 1 );
			 * function my_image_upload_nonce( $nonce ) {
			 *     // your code here
			 *     return $nonce;
			 * }
			 * ?>
			 */
			$um_image_upload_nonce = apply_filters( "um_image_upload_nonce", true );

			if ( $um_image_upload_nonce ) {
				if ( ! wp_verify_nonce( $nonce, "um_upload_nonce-{$timestamp}" ) && is_user_logged_in() ) {
					// This nonce is not valid.
					$ret['error'] = __( 'Invalid nonce', 'ultimate-member' );
					wp_send_json_error( $ret );
				}
			}

			if ( isset( $_FILES[ $id ]['name'] ) ) {

				if ( ! is_array( $_FILES[ $id ]['name'] ) ) {

					UM()->uploader()->replace_upload_dir = true;
					$uploaded = UM()->uploader()->upload_image( $_FILES[ $id ], $user_id, $id );
					UM()->uploader()->replace_upload_dir = false;
					if ( isset( $uploaded['error'] ) ){
						$ret['error'] = $uploaded['error'];
					} else {
						$ts = current_time( 'timestamp' );
						$ret[ ] = $uploaded['handle_upload'];
					}

				}

			} else {
				$ret['error'] = __( 'A theme or plugin compatibility issue', 'ultimate-member' );
			}
			wp_send_json_success( $ret );
		}


		/**
		 * File upload by AJAX
		 */
		function ajax_file_upload() {
			$ret['error'] = null;
			$ret = array();

			/* commented for enable download files on registration form
			 * if ( ! is_user_logged_in() ) {
				$ret['error'] = 'Invalid user';
				die( json_encode( $ret ) );
			}*/

			$nonce = $_POST['_wpnonce'];
			$id = $_POST['key'];
			$timestamp = $_POST['timestamp'];

			UM()->fields()->set_id = $_POST['set_id'];
			UM()->fields()->set_mode = $_POST['set_mode'];

			/**
			 * UM hook
			 *
			 * @type filter
			 * @title um_file_upload_nonce
			 * @description Change File Upload nonce
			 * @input_vars
			 * [{"var":"$nonce","type":"bool","desc":"Nonce"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage
			 * <?php add_filter( 'um_file_upload_nonce', 'function_name', 10, 1 ); ?>
			 * @example
			 * <?php
			 * add_filter( 'um_file_upload_nonce', 'my_file_upload_nonce', 10, 1 );
			 * function my_file_upload_nonce( $nonce ) {
			 *     // your code here
			 *     return $nonce;
			 * }
			 * ?>
			 */
			$um_file_upload_nonce = apply_filters("um_file_upload_nonce", true );

			if ( $um_file_upload_nonce  ) {
				if ( ! wp_verify_nonce( $nonce, 'um_upload_nonce-'.$timestamp  ) && is_user_logged_in() ) {
					// This nonce is not valid.
					$ret['error'] = 'Invalid nonce';
					wp_send_json_error( $ret );

				}
			}


			if( isset( $_FILES[ $id ]['name'] ) ) {

				if ( ! is_array( $_FILES[ $id ]['name'] ) ) {

					$user_id = $_POST['user_id'];

					UM()->uploader()->replace_upload_dir = true;
					$uploaded = UM()->uploader()->upload_file( $_FILES[ $id ], $user_id, $id );
					UM()->uploader()->replace_upload_dir = false;
					if ( isset( $uploaded['error'] ) ){

						$ret['error'] = $uploaded['error'];

					} else {

						$uploaded_file = $uploaded['handle_upload'];
						$ret['url'] = $uploaded_file['file_info']['name'];
						$ret['icon'] = UM()->files()->get_fonticon_by_ext( $uploaded_file['file_info']['ext'] );
						$ret['icon_bg'] = UM()->files()->get_fonticon_bg_by_ext( $uploaded_file['file_info']['ext'] );
						$ret['filename'] = $uploaded_file['file_info']['basename'];
						$ret['original_name'] = $uploaded_file['file_info']['original_name'];

					}

				}

			} else {
				$ret['error'] = __('A theme or plugin compatibility issue','ultimate-member');
			}


			wp_send_json_success( $ret );
		}


		/**
		 * Allowed image types
		 *
		 * @return array
		 */
		function allowed_image_types() {
			/**
			 * UM hook
			 *
			 * @type filter
			 * @title um_allowed_image_types
			 * @description Extend allowed image types
			 * @input_vars
			 * [{"var":"$types","type":"array","desc":"Image ext types"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_filter( 'um_allowed_image_types', 'function_name', 10, 1 );
			 * @example
			 * <?php
			 * add_filter( 'um_allowed_image_types', 'my_allowed_image_types', 10, 1 );
			 * function my_allowed_image_types( $types ) {
			 *     // your code here
			 *     return $types;
			 * }
			 * ?>
			 */
			return apply_filters( 'um_allowed_image_types', array(
				'png'   => 'PNG',
				'jpeg'  => 'JPEG',
				'jpg'   => 'JPG',
				'gif'   => 'GIF'
			) );
		}


		/**
		 * Allowed file types
		 *
		 * @return mixed
		 */
		function allowed_file_types() {
			/**
			 * UM hook
			 *
			 * @type filter
			 * @title um_allowed_file_types
			 * @description Extend allowed File types
			 * @input_vars
			 * [{"var":"$types","type":"array","desc":"Files ext types"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_filter( 'um_allowed_file_types', 'function_name', 10, 1 );
			 * @example
			 * <?php
			 * add_filter( 'um_allowed_file_types', 'my_allowed_file_types', 10, 1 );
			 * function my_allowed_file_types( $types ) {
			 *     // your code here
			 *     return $types;
			 * }
			 * ?>
			 */
			return apply_filters( 'um_allowed_file_types', array(
				'pdf'   => 'PDF',
				'txt'   => 'Text',
				'csv'   => 'CSV',
				'doc'   => 'DOC',
				'docx'  => 'DOCX',
				'odt'   => 'ODT',
				'ods'   => 'ODS',
				'xls'   => 'XLS',
				'xlsx'  => 'XLSX',
				'zip'   => 'ZIP',
				'rar'   => 'RAR',
				'mp3'   => 'MP3',
				'jpg'   => 'JPG',
				'jpeg'  => 'JPEG',
				'png'   => 'PNG',
				'gif'   => 'GIF',
				'eps'   => 'EPS',
				'psd'   => 'PSD',
				'tif'   => 'TIF',
				'tiff'  => 'TIFF',
			) );
		}


		/**
		 * Get extension icon
		 *
		 * @param $extension
		 *
		 * @return string
		 */
		function get_fonticon_by_ext( $extension ) {
			if ( isset( $this->fonticon[$extension]['icon'] ) ) {
				return $this->fonticon[$extension]['icon'];
			} else {
				return $this->default_file_fonticon;
			}
		}


		/**
		 * Get extension icon background
		 *
		 * @param $extension
		 *
		 * @return string
		 */
		function get_fonticon_bg_by_ext( $extension ) {
			if ( isset( $this->fonticon[$extension]['color'] ) ) {
				return $this->fonticon[$extension]['color'];
			} else {
				return '#666';
			}
		}


		/**
		 * Setup upload directory
		 */
		function setup_paths() {

			$this->upload_dir = wp_upload_dir();

			$this->upload_basedir = $this->upload_dir['basedir'] . '/ultimatemember/';
			$this->upload_baseurl = $this->upload_dir['baseurl'] . '/ultimatemember/';

			/**
			 * UM hook
			 *
			 * @type filter
			 * @title um_upload_basedir_filter
			 * @description Change Uploads Basedir
			 * @input_vars
			 * [{"var":"$basedir","type":"string","desc":"Uploads basedir"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_filter( 'um_upload_basedir_filter', 'function_name', 10, 1 );
			 * @example
			 * <?php
			 * add_filter( 'um_upload_basedir_filter', 'my_upload_basedir', 10, 1 );
			 * function my_upload_basedir( $basedir ) {
			 *     // your code here
			 *     return $basedir;
			 * }
			 * ?>
			 */
			$this->upload_basedir = apply_filters( 'um_upload_basedir_filter', $this->upload_basedir );
			/**
			 * UM hook
			 *
			 * @type filter
			 * @title um_upload_baseurl_filter
			 * @description Change Uploads Base URL
			 * @input_vars
			 * [{"var":"$baseurl","type":"string","desc":"Uploads base URL"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_filter( 'um_upload_baseurl_filter', 'function_name', 10, 1 );
			 * @example
			 * <?php
			 * add_filter( 'um_upload_baseurl_filter', 'my_upload_baseurl', 10, 1 );
			 * function my_upload_baseurl( $baseurl ) {
			 *     // your code here
			 *     return $baseurl;
			 * }
			 * ?>
			 */
			$this->upload_baseurl = apply_filters( 'um_upload_baseurl_filter', $this->upload_baseurl );

			// @note : is_ssl() doesn't work properly for some sites running with load balancers
			// Check the links for more info about this bug
			// https://codex.wordpress.org/Function_Reference/is_ssl
			// http://snippets.webaware.com.au/snippets/wordpress-is_ssl-doesnt-work-behind-some-load-balancers/
			if ( is_ssl() || stripos( get_option( 'siteurl' ), 'https://' ) !== false
			     || ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) ) {
				$this->upload_baseurl = str_replace("http://", "https://",  $this->upload_baseurl);
			}

			$this->upload_temp = $this->upload_basedir . 'temp/';
			$this->upload_temp_url = $this->upload_baseurl . 'temp/';

			if ( ! file_exists( $this->upload_basedir ) ) {
				$old = umask(0);
				@mkdir( $this->upload_basedir, 0755, true );
				umask( $old );
			}

			if ( ! file_exists( $this->upload_temp ) ) {
				$old = umask(0);
				@mkdir( $this->upload_temp , 0755, true );
				umask( $old );
			}

		}


		/**
		 * Generate unique temp directory
		 *
		 * @return mixed
		 */
		function unique_dir(){
			$unique_number = UM()->validation()->generate();
			$array['dir'] = $this->upload_temp . $unique_number . '/';
			$array['url'] = $this->upload_temp_url . $unique_number . '/';
			return $array;
		}


		/**
		 * Get path only without file name
		 *
		 * @param $file
		 *
		 * @return string
		 */
		function path_only( $file ) {

			return trailingslashit( dirname( $file ) );
		}


		/**
		 * Fix image orientation
		 *
		 * @param $rotate
		 * @param $source
		 *
		 * @return resource
		 */
		function fix_image_orientation( $rotate, $source ) {
			if ( extension_loaded('exif') ){
				$exif = @exif_read_data( $source );

				if (isset($exif['Orientation'])) {
					switch ($exif['Orientation']) {
						case 3:
							$rotate = imagerotate($rotate, 180, 0);
							break;

						case 6:
							$rotate = imagerotate($rotate, -90, 0);
							break;

						case 8:
							$rotate = imagerotate($rotate, 90, 0);
							break;
					}
				}
			}
			return $rotate;
		}


		/**
		 * Process an image
		 *
		 * @param $source
		 * @param $destination
		 * @param int $quality
		 *
		 * @return array
		 */
		function create_and_copy_image($source, $destination, $quality = 100) {

			$info = @getimagesize($source);

			if ($info['mime'] == 'image/jpeg'){

				$image = imagecreatefromjpeg( $source );

			} else if ($info['mime'] == 'image/gif'){

				$image = imagecreatefromgif( $source );

			} else if ($info['mime'] == 'image/png'){

				$image = imagecreatefrompng( $source );
				imagealphablending( $image, false );
				imagesavealpha( $image, true );

			}

			list($w, $h) = @getimagesize( $source );
			if ( $w > UM()->options()->get('image_max_width') ) {

				$ratio = round( $w / $h, 2 );
				$new_w = UM()->options()->get('image_max_width');
				$new_h = round( $new_w / $ratio, 2 );

				if ( $info['mime'] == 'image/jpeg' ||  $info['mime'] == 'image/gif' ){

					$image_p = imagecreatetruecolor( $new_w, $new_h );
					imagecopyresampled( $image_p, $image, 0, 0, 0, 0, $new_w, $new_h, $w, $h );
					$image_p = $this->fix_image_orientation( $image_p, $source );

				}else if( $info['mime'] == 'image/png' ){

					$srcImage = $image;
					$targetImage = imagecreatetruecolor( $new_w, $new_h );
					imagealphablending( $targetImage, false );
					imagesavealpha( $targetImage, true );
					imagecopyresampled( $targetImage, $srcImage,   0, 0, 0, 0, $new_w, $new_h, $w, $h );

				}

				if ( $info['mime'] == 'image/jpeg' ){
					$has_copied = imagejpeg( $image_p, $destination, $quality );
				}else if ( $info['mime'] == 'image/gif' ){
					$has_copied = imagegif( $image_p, $destination );
				}else if ( $info['mime'] == 'image/png' ){
					$has_copied = imagepng( $targetImage, $destination, 0 ,PNG_ALL_FILTERS);
				}

				$info['um_has_max_width'] = 'custom';
				$info['um_has_copied'] = $has_copied ? 'yes':'no';

			} else {

				$image = $this->fix_image_orientation( $image, $source );

				if ( $info['mime'] == 'image/jpeg' ){
					$has_copied = imagejpeg( $image, $destination, $quality );
				}else if ( $info['mime'] == 'image/gif' ){
					$has_copied = imagegif( $image, $destination );
				}else if ( $info['mime'] == 'image/png' ){
					$has_copied = imagepng( $image , $destination , 0 ,PNG_ALL_FILTERS);
				}

				$info['um_has_max_width'] = 'default';
				$info['um_has_copied'] = $has_copied ? 'yes':'no';
			}

			return $info;
		}


		/**
		 * Process a file
		 *
		 * @param $source
		 * @param $destination
		 */
		function upload_temp_file( $source, $destination ) {

			move_uploaded_file( $source, $destination );
		}


		/**
		 * Process a temp upload
		 *
		 * @param $source
		 * @param $destination
		 * @param int $quality
		 *
		 * @return string
		 */
		function new_image_upload_temp( $source, $destination, $quality = 100 ){

			$unique_dir = $this->unique_dir();

			$this->make_dir( $unique_dir['dir'] );

			$info = $this->create_and_copy_image( $source, $unique_dir['dir'] . $destination, $quality );

			$url = $unique_dir['url'] . $destination ;

			return $url;

		}


		/**
		 * Process a temp upload for files
		 *
		 * @param $source
		 * @param $destination
		 *
		 * @return string
		 */
		function new_file_upload_temp( $source, $destination ){

			$unique_dir = $this->unique_dir();

			$this->make_dir( $unique_dir['dir'] );

			$this->upload_temp_file( $source, $unique_dir['dir'] . $destination );

			$url = $unique_dir['url'] . $destination;

			return $url;

		}


		/**
		 * Make a Folder
		 *
		 * @param $dir
		 */
		function make_dir( $dir ) {
			$old = umask(0);
			@mkdir( $dir, 0755, true);
			umask( $old );
		}


		/**
		 * Get extension by mime type
		 *
		 * @param $mime
		 *
		 * @return mixed
		 */
		function get_extension_by_mime_type( $mime ) {
			$split = explode('/', $mime );
			return $split[1];
		}


		/**
		 * Get file data
		 *
		 * @param $file
		 *
		 * @return mixed
		 */
		function get_file_data( $file ) {
			$array['size'] = filesize( $file );
			return $array;
		}


		/**
		 * Get image data
		 *
		 * @param $file
		 *
		 * @return mixed
		 */
		function get_image_data( $file ) {

			$finfo = finfo_open( FILEINFO_MIME_TYPE );

			$mime_type = finfo_file( $finfo, $file );

			if( function_exists('exif_imagetype') ){

				$array_exif_image_mimes = array( IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG );

				$allowed_types = apply_filters('um_image_upload_allowed_exif_mimes', $array_exif_image_mimes );

				if( ! in_array( @exif_imagetype( $file ), $allowed_types ) ) {

					$array['invalid_image'] = true;

					return $array;
				}

			}else{

				$array_image_mimes = array('image/jpeg','image/png','image/gif');

				$allowed_types = apply_filters('um_image_upload_allowed_mimes', $array_image_mimes );

				if ( ! in_array( $mime_type, $allowed_types ) ) {

					$array['invalid_image'] = true;

					return $array;
				}

			}

			$array['size'] = filesize( $file );

			$image_data = @getimagesize( $file );

			$array['image'] = $image_data;

			$array['invalid_image'] = false;

			list($width, $height, $type, $attr) = $image_data;

			$array['width'] = $width;

			$array['height'] = $height;

			$array['ratio'] = $width / $height;

			$array['extension'] = $this->get_extension_by_mime_type( $mime_type );


			return $array;
		}


		/**
		 * If a value exists in comma seperated list
		 *
		 * @param $value
		 * @param $array
		 *
		 * @return bool
		 */
		function in_array( $value, $array ) {

			if ( in_array( $value, explode(',', $array ) ) ){
				return true;
			}

			return false;
		}


		/**
		 * This function will delete file upload from server
		 *
		 * @param $src
		 */
		function delete_file( $src ) {

			if ( strstr( $src, '?' ) ) {
				$splitted = explode( '?', $src );
				$src = $splitted[0];
			}

			$is_temp = um_is_temp_upload( $src );
			if ( $is_temp ) {
				unlink( $is_temp );
				rmdir( dirname( $is_temp ) );
			} else {
				wp_die( __('Ultimate Member: Not a valid temp file','ultimate-member') );
			}
		}


		/**
		 * Delete a main user photo
		 *
		 * @param $user_id
		 * @param $type
		 */
		function delete_core_user_photo( $user_id, $type ) {

			delete_user_meta( $user_id, $type );

			/**
			 * UM hook
			 *
			 * @type action
			 * @title um_after_remove_{$type}
			 * @description Make some actions after remove file
			 * @input_vars
			 * [{"var":"$user_id","type":"int","desc":"User ID"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_action( 'um_after_remove_{$type}', 'function_name', 10, 1 );
			 * @example
			 * <?php
			 * add_action( 'um_after_remove_{$type}', 'my_after_remove_file', 10, 1 );
			 * function my_after_remove_file( $user_id ) {
			 *     // your code here
			 * }
			 * ?>
			 */
			do_action( "um_after_remove_{$type}", $user_id );

			$dir = $this->upload_basedir . $user_id . DIRECTORY_SEPARATOR;
			$prefix = $type;
			chdir($dir);
			$matches = glob($prefix.'*',GLOB_MARK);

			if( is_array($matches) && !empty($matches)) {
				foreach($matches as $match) {
					if( is_file($dir.$match) ) unlink($dir.$match);
				}
			}

			if ( count(glob("$dir/*")) === 0) {
				rmdir( $dir );
			}

			UM()->user()->remove_cache( $user_id );
		}


		/**
		 * Resize a local image
		 *
		 * @param $file
		 * @param $crop
		 *
		 * @return string
		 */
		function resize_image( $file, $crop ) {

			$targ_x1 = $crop[0];
			$targ_y1 = $crop[1];
			$targ_x2 = $crop[2];
			$targ_y2 = $crop[3];

			$info = @getimagesize( $file );

			if ( $info['mime'] == 'image/gif' ) {

				$img_r = imagecreatefromgif( $file );
				$dst_r = imagecreatetruecolor( $targ_x2, $targ_y2 );
				imagecopy( $dst_r, $img_r, 0, 0, $targ_x1, $targ_y1, $targ_x2, $targ_y2 );
				imagegif( $dst_r, $this->path_only( $file ) . basename( $file ) );

			} elseif ( $info['mime'] == 'image/png' ) {

				$img_r = imagecreatefrompng( $file );
				$dst_r = imagecreatetruecolor( $targ_x2, $targ_y2 );
				imagealphablending( $dst_r, false);
				imagesavealpha( $dst_r, true);
				imagecopy( $dst_r, $img_r, 0, 0, $targ_x1, $targ_y1, $targ_x2, $targ_y2 );
				imagepng( $dst_r, $this->path_only( $file ) . basename( $file ) );

			} else {

				$img_r = imagecreatefromjpeg( $file );
				$dst_r = imagecreatetruecolor( $targ_x2, $targ_y2 );
				imagecopy( $dst_r, $img_r, 0, 0, $targ_x1, $targ_y1, $targ_x2, $targ_y2 );
				imagejpeg( $dst_r, $this->path_only( $file ) . basename( $file ), 100 );

			}

			$split = explode('/ultimatemember/temp/', $file );
			return $this->upload_temp_url . $split[1];
		}


		/**
		 * Make a user folder for uploads
		 *
		 * @param $user_id
		 */
		function new_user( $user_id ) {
			if ( !file_exists( $this->upload_basedir . $user_id . '/' ) ) {
				$old = umask(0);
				@mkdir( $this->upload_basedir . $user_id . '/' , 0755, true);
				umask($old);
			}
		}


		/**
		 * New user upload
		 *
		 * @param $user_id
		 * @param $source
		 * @param $key
		 *
		 * @return string
		 */
		function new_user_upload( $user_id, $source, $key ) {

			if( ! is_numeric( $user_id ) ){
				wp_die( __("Invalid user ID: ".json_encode( $user_id )." ",'ultimate-member') );
			}

			$user_id = trim( $user_id );

			// if he does not have uploads dir yet
			$this->new_user( $user_id );

			if ( is_user_logged_in() && ( get_current_user_id() != $user_id ) && ! UM()->roles()->um_user_can( 'can_edit_everyone' ) ) {
				wp_die( __( 'Unauthorized to do this attempt.', 'ultimate-member' ) );
			}

			/**
			 * UM hook
			 *
			 * @type filter
			 * @title um_allow_frontend_image_uploads
			 * @description Allow Fronend Image uploads
			 * @input_vars
			 * [{"var":"$allow","type":"bool","desc":"Allow"},
			 * {"var":"$user_id","type":"int","desc":"User ID"},
			 * {"var":"$key","type":"string","desc":"Field Key"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_filter( 'um_allow_frontend_image_uploads', 'function_name', 10, 3 );
			 * @example
			 * <?php
			 * add_filter( 'um_allow_frontend_image_uploads', 'my_allow_frontend_image_uploads', 10, 3 );
			 * function my_allow_frontend_image_uploads( $data ) {
			 *     // your code here
			 *     return $data;
			 * }
			 * ?>
			 */
			$allow_frontend_image_uploads = apply_filters( 'um_allow_frontend_image_uploads', false, $user_id, $key );

			if ( $allow_frontend_image_uploads == false && ! is_user_logged_in() && ( $key == 'profile_photo' || $key == 'cover_photo' ) ) {
				wp_die( __('Unauthorized to do this attempt.','ultimate-member') );
			}

			$ext = '.' . pathinfo($source, PATHINFO_EXTENSION);

			// copy & overwrite file

			if( in_array( $key , array('profile_photo','cover_photo') ) ){
				$filename = $key . $ext;
				$name = $key;
			}else{
				$filename = basename( $source );
			}



			if ( file_exists( $this->upload_basedir . $user_id . '/' . $filename ) ) {
				unlink( $this->upload_basedir . $user_id . '/' . $filename );
			}
			copy( $source, $this->upload_basedir . $user_id . '/' . $filename );

			$info = @getimagesize( $source );

			// thumbs
			if ( $key == 'profile_photo' ) {

				list($w, $h) = @getimagesize( $source );


				$sizes = UM()->options()->get( 'photo_thumb_sizes' );
				foreach( $sizes as $size ) {

					$ratio = round( $w / $h, 2 );
					$height = round( $size / $ratio, 2 );

					if ( file_exists(  $this->upload_basedir . $user_id . '/' . $name . '-' . $size . $ext ) ) {
						unlink( $this->upload_basedir . $user_id . '/' . $name . '-' . $size . $ext );
					}

					if ( $size < $w ) {

						if ( $info['mime'] == 'image/jpeg' ){
							$thumb_s = imagecreatefromjpeg( $source );
							$thumb = imagecreatetruecolor( $size, $size );
							imagecopyresampled( $thumb, $thumb_s, 0, 0, 0, 0, $size, $size, $w, $h );
							imagejpeg( $thumb, $this->upload_basedir . $user_id . '/' . $name . '-' . $size . $ext, 100);
							imagejpeg( $thumb, $this->upload_basedir . $user_id . '/' . $name . $ext, 100);
						}else if ( $info['mime'] == 'image/png' ){
							$thumb_s  = imagecreatefrompng( $source );
							$thumb = imagecreatetruecolor( $size, $size );
							imagealphablending( $thumb, false);
							imagesavealpha( $thumb, true);
							imagecopyresampled( $thumb, $thumb_s, 0, 0, 0, 0, $size, $size, $w, $h );
							imagepng( $thumb, $this->upload_basedir . $user_id . '/' . $name . '-' . $size . $ext );
						}else if ( $info['mime'] == 'image/gif' ){
							$thumb_s = imagecreatefromgif( $source );
							$thumb = imagecreatetruecolor( $size, $size );
							imagecopyresampled( $thumb, $thumb_s, 0, 0, 0, 0, $size, $size, $w, $h );
							imagegif( $thumb, $this->upload_basedir . $user_id . '/' . $name . '-' . $size . $ext);
							imagegif( $thumb, $this->upload_basedir . $user_id . '/' . $name . $ext);
						}
					}

				}

				// removes a synced profile photo
				delete_user_meta( $user_id, 'synced_profile_photo' );

			} else if ( $key == 'cover_photo' ) {

				list($w, $h) = @getimagesize( $source );

				$sizes = UM()->options()->get( 'cover_thumb_sizes' );
				foreach ( $sizes as $size ) {

					$ratio = round( $w / $h, 2 );
					$height = round( $size / $ratio, 2 );

					if ( file_exists(  $this->upload_basedir . $user_id . '/' . $name . '-' . $size . $ext ) ) {
						unlink( $this->upload_basedir . $user_id . '/' . $name . '-' . $size . $ext );
					}

					if ( $size < $w ) {

						if ( $info['mime'] == 'image/jpeg' ){
							$thumb = imagecreatetruecolor( $size, $height );
							$thumb_s = imagecreatefromjpeg( $source );
							imagecopyresampled( $thumb, $thumb_s, 0, 0, 0, 0, $size, $height, $w, $h );
							imagejpeg( $thumb, $this->upload_basedir . $user_id . '/' . $name . '-' . $size . $ext, 100);
						}else if ( $info['mime'] == 'image/png' ){
							$thumb_s  = imagecreatefrompng( $source );
							$thumb = imagecreatetruecolor( $size, $height );
							imagealphablending( $thumb, false);
							imagesavealpha( $thumb, true);
							imagecopyresampled( $thumb, $thumb_s, 0, 0, 0, 0, $size, $height, $w, $h );
							imagepng( $thumb, $this->upload_basedir . $user_id . '/' . $name . '-' . $size . $ext );
						}else if ( $info['mime'] == 'image/gif' ){
							$thumb = imagecreatetruecolor( $size, $height );
							$thumb_s = imagecreatefromgif( $source );
							imagecopyresampled( $thumb, $thumb_s, 0, 0, 0, 0, $size, $height, $w, $h );
							imagegif( $thumb, $this->upload_basedir . $user_id . '/' . $name . '-' . $size . $ext);
						}
					}

				}

			}

			// clean up temp
			$dir = dirname( $source );
			unlink( $source );
			rmdir( $dir );

			/**
			 * UM hook
			 *
			 * @type action
			 * @title um_before_upload_db_meta
			 * @description Update user's meta before upload
			 * @input_vars
			 * [{"var":"$user_id","type":"int","desc":"User ID"},
			 * {"var":"$key","type":"string","desc":"Meta key"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_action( 'um_before_upload_db_meta', 'function_name', 10, 2 );
			 * @example
			 * <?php
			 * add_action( 'um_before_upload_db_meta', 'my_before_upload_db_meta', 10, 2 );
			 * function my_before_upload_db_meta( $user_id, $key ) {
			 *     // your code here
			 * }
			 * ?>
			 */
			do_action( 'um_before_upload_db_meta', $user_id, $key );
			/**
			 * UM hook
			 *
			 * @type action
			 * @title um_before_upload_db_meta_{$key}
			 * @description Update user's meta before upload
			 * @input_vars
			 * [{"var":"$user_id","type":"int","desc":"User ID"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_action( 'um_before_upload_db_meta_{$key}', 'function_name', 10, 1 );
			 * @example
			 * <?php
			 * add_action( 'um_before_upload_db_meta_{$key}', 'my_before_upload_db_meta', 10, 1 );
			 * function my_before_upload_db_meta( $user_id ) {
			 *     // your code here
			 * }
			 * ?>
			 */
			do_action( "um_before_upload_db_meta_{$key}", $user_id );

			update_user_meta( $user_id, $key, $filename );

			/**
			 * UM hook
			 *
			 * @type action
			 * @title um_after_upload_db_meta
			 * @description Update user's meta before upload
			 * @input_vars
			 * [{"var":"$user_id","type":"int","desc":"User ID"},
			 * {"var":"$key","type":"string","desc":"Meta key"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_action( 'um_after_upload_db_meta', 'function_name', 10, 2 );
			 * @example
			 * <?php
			 * add_action( 'um_after_upload_db_meta', 'my_after_upload_db_meta', 10, 2 );
			 * function my_after_upload_db_meta( $user_id, $key ) {
			 *     // your code here
			 * }
			 * ?>
			 */
			do_action( 'um_after_upload_db_meta', $user_id, $key );
			/**
			 * UM hook
			 *
			 * @type action
			 * @title um_after_upload_db_meta_{$key}
			 * @description Update user's meta after upload
			 * @input_vars
			 * [{"var":"$user_id","type":"int","desc":"User ID"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_action( 'um_after_upload_db_meta_{$key}', 'function_name', 10, 1 );
			 * @example
			 * <?php
			 * add_action( 'um_after_upload_db_meta_{$key}', 'my_after_upload_db_meta', 10, 1 );
			 * function my_after_upload_db_meta( $user_id ) {
			 *     // your code here
			 * }
			 * ?>
			 */
			do_action( "um_after_upload_db_meta_{$key}", $user_id );

			// the url of upload
			return $this->upload_baseurl . $user_id . '/' . $filename;

		}


		/**
		 * Remove a directory
		 *
		 * @param $dir
		 */
		function remove_dir( $dir ) {
			if ( file_exists( $dir ) ) {
				foreach(glob($dir . '/*') as $file) {
					if(is_dir($file)) $this->remove_dir($file); else unlink($file);
				} rmdir($dir);
			}
		}


		/**
		 * Remove old files
		 * @param string $dir							Path to directoty.
		 * @param int|string $timestamp		Unix timestamp or PHP relative time. All older files will be removed.
		 */
		function remove_old_files( $dir, $timestamp = NULL ) {

			$removed_files = array();

			if ( empty( $timestamp ) ) {
				$timestamp = strtotime( '-1 day' );
			}
			elseif ( is_string( $timestamp ) && !is_numeric( $timestamp ) ) {
				$timestamp = strtotime( $timestamp );
			}

			if ( $timestamp && is_dir( $dir ) ) {

				$files = glob( $dir . '/*' );

				foreach ( (array) $files as $file ) {
					if ( in_array( wp_basename( $file ), array('.', '..') ) ) {
						continue;
					}
					elseif ( is_dir( $file ) ) {
						$this->remove_old_files( $file, $timestamp );
					}
					elseif ( is_file( $file ) ) {
						$fileatime = fileatime( $file );
						if ( $fileatime && $fileatime < (int) $timestamp ) {
							unlink( $file );
							$removed_files[] = $file;
						}
					}
				}
			}

			return $removed_files;
		}


		/**
		 * Format Bytes
		 *
		 * @param $size
		 * @param int $precision
		 *
		 * @return string
		 */
		function format_bytes( $size , $precision = 1 ) {
			if ( is_numeric( $size ) ) {
				$base = log( $size, 1024 );
				$suffixes = array( '', 'kb', 'MB', 'GB', 'TB' );
				$computed_size = round( pow( 1024, $base - floor( $base ) ), $precision );
				$unit = $suffixes[ floor( $base ) ];

				return $computed_size.' '.$unit;
			}

			return '';
		}


	}
}