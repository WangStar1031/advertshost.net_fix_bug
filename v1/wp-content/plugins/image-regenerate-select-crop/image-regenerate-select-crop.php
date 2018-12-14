<?php
/**
 * Plugin Name: Image Regenerate & Select Crop
 * Plugin URI: https://iuliacazan.ro/image-regenerate-select-crop/
 * Description: Regenerate and crop images, details and actions for image sizes registered and image sizes generated, clean up, placeholders and custom rules, WP-CLI commands.
 * Text Domain: sirsc
 * Domain Path: /langs
 * Version: 4.3
 * Author: Iulia Cazan
 * Author URI: https://profiles.wordpress.org/iulia-cazan
 * Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JJA37EHZXWUTJ
 * License: GPL2
 *
 * @package ic
 *
 * Copyright (C) 2014-2018 Iulia Cazan
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

$upload_dir = wp_upload_dir();
$dest_url   = $upload_dir['baseurl'] . '/placeholders';
$dest_path  = $upload_dir['basedir'] . '/placeholders';
if ( ! file_exists( $dest_path ) ) {
	@wp_mkdir_p( $dest_path );
}
define( 'SIRSC_PLUGIN_FOLDER', dirname( __FILE__ ) );
define( 'SIRSC_PLACEHOLDER_FOLDER', realpath( $dest_path ) );
define( 'SIRSC_PLACEHOLDER_URL', esc_url( $dest_url ) );
define( 'SIRSC_ASSETS_VER', '20180907.1207' );

/**
 * Class for Image Regenerate & Select Crop.
 */
class SIRSC_Image_Regenerate_Select_Crop {
	/**
	 * Class instance.
	 *
	 * @var object
	 */
	private static $instance;
	/**
	 * The plugin is configured.
	 *
	 * @var boolean
	 */
	public static $is_configured = false;

	/**
	 * Plugin settings.
	 *
	 * @var array
	 */
	public static $settings;
	/**
	 * Plugin user custom rules.
	 *
	 * @var array
	 */
	public static $user_custom_rules;
	/**
	 * Plugin user custom usable rules.
	 *
	 * @var array
	 */
	public static $user_custom_rules_usable;
	/**
	 * Excluded post types.
	 *
	 * @var array
	 */
	public static $exclude_post_type = array();
	/**
	 * Limit the posts.
	 *
	 * @var integer
	 */
	public static $limit9999 = 300;
	/**
	 * Crop positions.
	 *
	 * @var array
	 */
	public static $crop_positions = array();
	/**
	 * Plugin URL.
	 *
	 * @var string
	 */
	public static $plugin_url = '';
	/**
	 * Plugin debug to file.
	 *
	 * @var boolean
	 */
	public static $debug = false;
	/**
	 * Get active object instance
	 *
	 * @return object
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new SIRSC_Image_Regenerate_Select_Crop();
		}
		return self::$instance;
	}

	/**
	 * Class constructor. Includes constants, includes and init method.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Run action and filter hooks.
	 */
	private function init() {
		self::$settings          = get_option( 'sirsc_settings' );
		self::get_default_user_custom_rules();
		self::$is_configured     = ( ! empty( self::$settings ) ) ? true : false;
		self::$exclude_post_type = array( 'nav_menu_item', 'revision', 'custom_css', 'customize_changeset', 'oembed_cache', 'user_request', 'attachment' );
		if ( is_admin() ) {
			add_action( 'init', array( get_called_class(), 'maybe_save_settings' ), 1 );
			add_action( 'image_regenerate_select_crop_button', array( get_called_class(), 'image_regenerate_select_crop_button' ) );
			add_action( 'admin_enqueue_scripts', array( get_called_class(), 'load_assets' ) );
			add_action( 'init', array( get_called_class(), 'register_image_button' ) );
			add_action( 'add_meta_boxes', array( get_called_class(), 'register_image_meta' ), 10, 3 );
			add_action( 'wp_ajax_sirsc_show_actions_result', array( get_called_class(), 'show_actions_result' ) );
			add_action( 'plugins_loaded', array( get_called_class(), 'load_textdomain' ) );
			add_action( 'admin_menu', array( get_called_class(), 'admin_menu' ) );
			self::$crop_positions = array(
				'lt' => __( 'Left/Top', 'sirsc' ),
				'ct' => __( 'Center/Top', 'sirsc' ),
				'rt' => __( 'Right/Top', 'sirsc' ),
				'lc' => __( 'Left/Center', 'sirsc' ),
				'cc' => __( 'Center/Center', 'sirsc' ),
				'rc' => __( 'Right/Center', 'sirsc' ),
				'lb' => __( 'Left/Bottom', 'sirsc' ),
				'cb' => __( 'Center/Bottom', 'sirsc' ),
				'rb' => __( 'Right/Bottom', 'sirsc' ),
			);
			self::$plugin_url = admin_url( 'options-general.php?page=image-regenerate-select-crop-settings' );
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( get_called_class(), 'plugin_action_links' ) );
		}
		// This is global, as the image sizes can be also registerd in the themes or other plugins.
		add_filter( 'intermediate_image_sizes_advanced', array( get_called_class(), 'filter_ignore_global_image_sizes' ), 10, 2 );
		add_action( 'added_post_meta', array( get_called_class(), 'process_filtered_attachments' ), 10, 4 );
		if ( ! is_admin() && ! empty( self::$settings['placeholders'] ) ) {
			// For the front side, let's use placeolders if the case.
			if ( ! empty( self::$settings['placeholders']['force_global'] ) ) {
				add_filter( 'image_downsize', array( get_called_class(), 'image_downsize_placeholder_force_global' ), 10, 3 );
			} elseif ( ! empty( self::$settings['placeholders']['only_missing'] ) ) {
				add_filter( 'image_downsize', array( get_called_class(), 'image_downsize_placeholder_only_missing' ), 10, 3 );
			}
		}
	}

	/**
	 * The actions to be executed when the plugin is deactivated.
	 */
	public static function deactivate_plugin() {
		global $wpdb;
		$rows = $wpdb->get_results( $wpdb->prepare(
			'SELECT option_name FROM ' . $wpdb->options . ' WHERE option_name like %s OR option_name like %s OR option_name like %s ',
			$wpdb->esc_like( 'sirsc_settings' ) . '%',
			$wpdb->esc_like( 'sirsc_types' ) . '%',
			$wpdb->esc_like( 'sirsc_user_custom_rules' ) . '%'
		), ARRAY_A );
		if ( ! empty( $rows ) && is_array( $rows ) ) {
			foreach ( $rows as $v ) {
				delete_option( $v['option_name'] );
			}
		}
	}

	/**
	 * Load text domain for internalization.
	 */
	public static function load_textdomain() {
		load_plugin_textdomain( 'sirsc', false, basename( dirname( __FILE__ ) ) . '/langs/' );
	}

	/**
	 * Enqueue the css and javascript files
	 */
	public static function load_assets() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_style( 'sirsc-style', plugins_url( '/assets/css/style.css', __FILE__ ), array(), SIRSC_ASSETS_VER, false );
		wp_register_script( 'sirsc-custom-js', plugins_url( '/assets/js/custom.js', __FILE__ ), array(), SIRSC_ASSETS_VER, false );
		wp_localize_script( 'sirsc-custom-js', 'SIRSC_settings', array(
			'confirm_cleanup'        => __( 'Cleanup all?', 'sirsc' ),
			'confirm_regenerate'     => __( 'Regenerate all?', 'sirsc' ),
			'time_warning'           => __( 'This operation might take a while, depending on how many images you have.', 'sirsc' ),
			'irreversible_operation' => __( 'The operation is irreversible!', 'sirsc' ),
			'resolution'             => __( 'Resolution', 'sirsc' ),
		) );
		wp_enqueue_script( 'sirsc-custom-js' );
	}

	/**
	 * Add the new menu in tools section that allows to configure the image sizes restrictions.
	 */
	public static function admin_menu() {
		add_submenu_page(
			'options-general.php',
			'<div class="dashicons dashicons-format-gallery"></div> ' . __( 'Image Regenerate & Select Crop Settings', 'sirsc' ),
			'<div class="dashicons dashicons-format-gallery"></div> ' . __( 'Image Regenerate & Select Crop Settings', 'sirsc' ),
			'manage_options',
			'image-regenerate-select-crop-settings',
			array( get_called_class(), 'image_regenerate_select_crop_settings' )
		);
	}

	/**
	 * Load the post type settings if available.
	 *
	 * @param string|array|object $ob   The item to be exposed.
	 * @param boolean             $time Show microtime.
	 * @param boolean             $log  Write to error log.
	 */
	public static function debug( $ob = '', $time = true, $log = false ) {
		if ( true === self::$debug && ! empty( $ob ) ) {
			$debug  = PHP_EOL . ( true === $time ) ? '---' . microtime( true ) . PHP_EOL : '';
			$debug .= ( ! is_scalar( $ob ) ) ? print_r( $ob, 1 ) : $ob;
			file_put_contents( dirname( __FILE__ ) . '/logproc', PHP_EOL . $debug, FILE_APPEND );

			if ( true === $log ) {
				error_log( $debug );
			}
		}
	}

	/**
	 * Load the post type settings if available.
	 *
	 * @param string $post_type The post type.
	 */
	public static function get_post_type_settings( $post_type ) {
		$pt = '';
		if ( ! empty( $post_type ) && ! in_array( $post_type, self::$exclude_post_type, true ) ) {
			$pt = '_' . $post_type;
		}

		$tmp_set = get_option( 'sirsc_settings' . $pt );
		if ( ! empty( $tmp_set ) ) {
			self::$settings = $tmp_set;
		}
	}

	/**
	 * Load the user custom rules if available.
	 *
	 * @return void
	 */
	public static function get_default_user_custom_rules() {
		$default = array();
		for ( $i = 1; $i <= 20; $i ++ ) {
			$default[ $i ] = array(
				'type'     => '',
				'value'    => '',
				'original' => '',
				'only'     => array(),
				'suppress' => '',
			);
		}
		$opt = get_option( 'sirsc_user_custom_rules' );
		if ( ! empty( $opt ) ) {
			$opt = maybe_unserialize( $opt );
			if ( is_array( $opt ) ) {
				foreach ( $opt as $key => $value ) {
					if ( is_array( $value ) ) {
						$default[ $key ] = array_merge( $default[ $key ], $value );
					}
				}
			}
		}

		self::$user_custom_rules = $default;
		self::$user_custom_rules_usable = get_option( 'sirsc_user_custom_rules_usable' );
	}

	/**
	 * Load the settings for a post ID (by parent post type).
	 *
	 * @param integer $post_id The post ID.
	 */
	public static function load_settings_for_post_id( $post_id = 0 ) {
		$post = get_post( $post_id );
		if ( ! empty( $post->post_parent ) ) {
			$pt = get_post_type( $post->post_parent );
			if ( ! empty( $pt ) && ! in_array( $post->post_type, self::$exclude_post_type, true ) ) {
				self::get_post_type_settings( $pt );
			}
			self::hook_upload_extra_rules( $post_id, $post->post_type, $post->post_parent, $pt );
		} elseif ( ! empty( $post->post_type )
			&& ! in_array( $post->post_type, self::$exclude_post_type, true ) ) {
			self::get_post_type_settings( $post->post_type );
			self::hook_upload_extra_rules( $post_id, $post->post_type, 0, '' );
		}

		if ( empty( self::$settings ) ) {
			// Get the general settings.
			self::get_post_type_settings( '' );
		}
	}

	/**
	 * Attempts to override the settings for a single media file.
	 *
	 * @param integer $id          Attachment post ID.
	 * @param string  $type        Attachment post type.
	 * @param integer $parent_id   Attachment post parent ID.
	 * @param string  $parent_type Attachment post parent type.
	 * @return void
	 */
	public static function hook_upload_extra_rules( $id, $type, $parent_id = 0, $parent_type = '' ) {
		if ( ! isset( self::$settings['force_original_to'] ) ) {
			self::$settings['force_original_to'] = '';
		}
		if ( ! isset( self::$settings['complete_global_ignore'] ) ) {
			self::$settings['complete_global_ignore'] = array();
		}
		if ( ! isset( self::$settings['complete_global_ignore'] ) ) {
			self::$settings['restrict_sizes_to_these_only'] = array();
		}

		// First, let's apply user custom rules if any are set.
		self::apply_user_custom_rules( $id, $type, $parent_id, $parent_type );

		// Allow to hook from external scripts and create your own upload rules.
		self::$settings = apply_filters( 'sirsc_custom_upload_rule', self::$settings, $id, $type, $parent_id, $parent_type );
	}

	/**
	 * Attempts to override the settings for a single media file.
	 *
	 * @param integer $id          Attachment post ID.
	 * @param string  $type        Attachment post type.
	 * @param integer $parent_id   Attachment post parent ID.
	 * @param string  $parent_type Attachment post parent type.
	 * @return void
	 */
	public static function apply_user_custom_rules( $id, $type, $parent_id = 0, $parent_type = '' ) {
		if ( empty( self::$user_custom_rules_usable ) ) {
			// Fail-fast, no custom rule set.
			return;
		}
		foreach ( self::$user_custom_rules_usable as $key => $val ) {
			$apply        = false;
			$val['value'] = str_replace( ' ', '', $val['value'] );
			switch ( $val['type'] ) {
				case 'ID':
					// This is the attachment parent id.
					if ( in_array( $parent_id, explode( ',', $val['value'] ) ) ) {
						$apply = true;
					}
					break;
				case 'post_parent':
					// This is the post parent.
					$par = wp_get_post_parent_id( $parent_id );
					if ( in_array( $par, explode( ',', $val['value'] ) ) ) {
						$apply = true;
					}
					break;
				case 'post_type':
					// This is the attachment parent type.
					if ( in_array( $parent_type, explode( ',', $val['value'] ) ) ) {
						$apply = true;
					} elseif ( in_array( $type, explode( ',', $val['value'] ) ) ) {
						$apply = true;
					}
					break;
				case 'post_format':
					// This is the post format.
					$format = get_post_format( $parent_id );
					if ( in_array( $format, explode( ',', $val['value'] ) ) ) {
						$apply = true;
					}
					break;
				case 'post_tag':
					// This is the post tag.
					if ( has_tag( explode( ',', $val['value'] ), $parent_id ) ) {
						$apply = true;
					}
					break;
				case 'category':
					// This is the post category.
					if ( has_term( explode( ',', $val['value'] ), 'category', $parent_id ) ) {
						$apply = true;
					}
					break;
				default:
					// This is a taxonomy.
					if ( has_term( explode( ',', $val['value'] ), $val['type'], $parent_id ) ) {
						$apply = true;
					}
					break;
			}

			if ( true === $apply ) {
				// The post matched the rule.
				self::$settings = self::custom_rule_to_settings_rules( self::$settings, $val );

				// Fail-fast, no need to iterate more through the rules to speed things up.
				return;
			}
		}

		// The post did not matched any of the cusom rule.
		self::$settings = self::get_post_type_settings( $type );
	}

	/**
	 * Override and returns the settings after apllying a rule.
	 *
	 * @param array $settings The settings.
	 * @param array $rule     The rule.
	 * @return array
	 */
	public static function custom_rule_to_settings_rules( $settings = array(), $rule = array() ) {
		if ( empty( $rule ) || ! is_array( $rule ) ) {
			// Fail-fast, no need to continue.
			return $settings;
		}

		if ( ! empty( $rule['original'] ) ) {
			if ( '**full**' === $rule['original'] ) {
				$settings['force_original_to'] = '';
			} else {
				// Force original.
				$settings['force_original_to'] = $rule['original'];

				// Let's remove it from the global ignore if it was previously set.
				$settings['complete_global_ignore'] = array_diff(
					$settings['complete_global_ignore'],
					array( $rule['original'] )
				);
			}
		}
		if ( ! empty( $rule['only'] ) && is_array( $rule['only'] ) ) {
			// Make sure we only generate these image sizes.
			$rule['only'] = array_diff( $rule['only'], array( '**full**' ) );
			$settings['restrict_sizes_to_these_only'] = $rule['only'];
			$settings['restrict_sizes_to_these_only'] = array_unique( $settings['restrict_sizes_to_these_only'] );

			if ( ! empty( $settings['default_quality'] ) ) {
				foreach ( $settings['default_quality'] as $s => $q ) {
					if ( ! in_array( $s, $rule['only'] ) ) {
						array_push( $settings['complete_global_ignore'], $s );
					}
				}
			}

			$settings['complete_global_ignore'] = array_unique( $settings['complete_global_ignore'] );
		}

		// Fail-fast, no need to continue.
		return $settings;
	}

	/**
	 * Exclude globally the image sizes selected in the settings from being generated on upload.
	 *
	 * @param array $sizes    The computed image sizes.
	 * @param array $metadata The image metadata.
	 * @return array
	 */
	public static function filter_ignore_global_image_sizes( $sizes, $metadata = array() ) {
		if ( empty( $sizes ) ) {
			$sizes = get_intermediate_image_sizes();
		}
		if ( ! empty( self::$settings['complete_global_ignore'] ) ) {
			foreach ( self::$settings['complete_global_ignore'] as $s ) {
				if ( isset( $sizes[ $s ] ) ) {
					unset( $sizes[ $s ] );
				} else {
					$k = array_keys( $sizes, $s, true );
					if ( ! empty( $k[0] ) ) {
						unset( $sizes[ $k[0] ] );
					}
				}
			}
		}

		$sizes = self::filter_some_more_based_on_metadata( $sizes, $metadata );
		return $sizes;
	}

	/**
	 * Filter the sizes based on the metadata.
	 *
	 * @param array $sizes    Images sizes.
	 * @param array $metadata Uploaded image metadata.
	 * @return array
	 */
	public static function filter_some_more_based_on_metadata( $sizes, $metadata = array() ) {
		if ( empty( $metadata['file'] ) ) {
			// Fail-fast, no upload.
			return $sizes;
		}

		$args = array(
			'meta_key'       => '_wp_attached_file',
			'meta_value'     => $metadata['file'],
			'post_status'    => 'any',
			'post_type'      => 'attachment',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		);
		$post = new WP_Query( $args );
		if ( ! empty( $post->posts[0] ) ) {
			// The attachment was found.
			self::load_settings_for_post_id( $post->posts[0] );

			if ( ! empty( self::$settings['restrict_sizes_to_these_only'] ) ) {
				foreach ( $sizes as $s => $v ) {
					if ( ! in_array( $s, self::$settings['restrict_sizes_to_these_only'] ) ) {
						unset( $sizes[ $s ] );
					}
				}
			}
		}
		wp_reset_postdata();

		return $sizes;
	}

	/**
	 * Check if the attached image is required to be replaced with the "Force Original" from the settings.
	 *
	 * @param  integer $meta_id    Post meta id.
	 * @param  integer $post_id    Post ID.
	 * @param  string  $meta_key   Post meta key.
	 * @param  array   $meta_value Post meta value.
	 */
	public static function process_filtered_attachments( $meta_id = '', $post_id = '', $meta_key = '', $meta_value = '' ) {
		if ( ! empty( $post_id ) && '_wp_attachment_metadata' === $meta_key && ! empty( $meta_value ) ) {
			self::load_settings_for_post_id( $post_id );
			if ( ! empty( self::$settings['default_crop'] ) ) {
				foreach ( self::$settings['default_crop'] as $ck => $cv ) {
					if ( 'cc' !== $cv ) {
						self::make_images_if_not_exists( $post_id, $ck, $cv );
					}
				}
			}
			if ( ! empty( self::$settings['force_original_to'] ) ) {
				$size = self::get_all_image_sizes( self::$settings['force_original_to'] );
				return self::process_image_resize_brute( $post_id, $size['width'], $size['height'], self::$settings['force_original_to'] );
			}
		}
	}

	/**
	 * Identify a crop position by the image size and retrun the crop array.
	 *
	 * @param string $size_name Image size slug.
	 * @param string $selcrop   Perhaps a selected crop string.
	 * @return array|boolean
	 */
	public static function identify_crop_pos( $size_name = '', $selcrop = '' ) {
		if ( empty( $size_name ) ) {
			// Fail-fast.
			return false;
		}
		if ( ! empty( $selcrop ) ) {
			$sc = $selcrop;
		} else {
			$sc  = ( ! empty( self::$settings['default_crop'][ $size_name ] ) )
				? self::$settings['default_crop'][ $size_name ] : 'cc';
		}
		$c_v = $sc{0};
		$c_v = ( 'l' === $c_v ) ? 'left' : $c_v;
		$c_v = ( 'c' === $c_v ) ? 'center' : $c_v;
		$c_v = ( 'r' === $c_v ) ? 'right' : $c_v;
		$c_h = $sc{1};
		$c_h = ( 't' === $c_h ) ? 'top' : $c_h;
		$c_h = ( 'c' === $c_h ) ? 'center' : $c_h;
		$c_h = ( 'b' === $c_h ) ? 'bottom' : $c_h;

		return array( $c_v, $c_h );
	}

	/**
	 * Generates an image size version of a specified image.
	 *
	 * @param  integer $id         Attachemnt ID.
	 * @param  integer $max_width  Image max width.
	 * @param  integer $max_height Image max height.
	 * @param  string  $size_name  Maybe an image size name.
	 */
	public static function process_image_resize_brute( $id, $max_width, $max_height, $size_name = '' ) {
		self::load_settings_for_post_id( $id );

		// Get the metadata.
		$m = wp_get_attachment_metadata( $id );

		// Make sure we get in the DB and folders all image sizes with the custom restrictions.
		self::make_images_if_not_exists( $id, 'all' );

		$att = get_attached_file( $id, false );
		$img = wp_get_image_editor( $att );
		if ( ! is_wp_error( $img ) && ! empty( $m['file'] ) ) {
			$size       = $img->get_size();
			$to_replace = false;
			if ( ! empty( $max_width ) && ! empty( $max_height ) ) {
				if ( $size['width'] >= $size['height'] && $size['height'] >= $max_height && ! empty( self::$settings['default_crop'][ $size_name ] ) ) {
					// This is a crop.
					$img->resize( $max_width, $max_height, self::identify_crop_pos( $size_name ) );
					$to_replace = true;
				} elseif ( $size['width'] >= $size['height'] ) {
					// This is a landscape image, let's resize it by max width.
					if ( $size['width'] >= $max_width ) {
						$img->resize( $max_width, null );
						$to_replace = true;
					}
				} else {
					// This is a portrait image, let's resize it by max height.
					if ( $size['height'] >= $max_height ) {
						$img->resize( null, $max_height );
						$to_replace = true;
					}
				}
			} elseif ( ! empty( $max_width ) ) {
				// This is not restricted by height, but only by max width.
				if ( $size['width'] >= $max_width ) {
					$img->resize( $max_width, null );
					$to_replace = true;
				}
			} else {
				// This is not restricted by width, but only by max height.
				if ( $size['height'] >= $max_height ) {
					$img->resize( null, $max_height );
					$to_replace = true;
				}
			}
			if ( $to_replace ) {
				$img->set_quality( 100 );
				$saved      = $img->save();
				$upload_dir = wp_upload_dir();
				if ( @copy( $saved['path'], $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $m['file'] ) ) {
					@unlink( $saved['path'] );

					$m['width']  = $saved['width'];
					$m['height'] = $saved['height'];

					// Override the array.
					$m['sizes'][ $size_name ]['file']      = basename( $m['file'] );
					$m['sizes'][ $size_name ]['width']     = $saved['width'];
					$m['sizes'][ $size_name ]['height']    = $saved['height'];
					$m['sizes'][ $size_name ]['mime-type'] = $saved['mime-type'];

					wp_update_attachment_metadata( $id, $m );
				}
				return $m;
			}
		}
	}

	/**
	 * Compute image size readable info from settings.
	 *
	 * @param string $k    Image size slug.
	 * @param array  $info Settings array.
	 */
	public static function get_usable_info( $k, $info ) {
		$data = array(
			'is_ignored' => ( ! empty( $info['complete_global_ignore'] ) && in_array( $k, $info['complete_global_ignore'], true ) ) ? 1 : 0,
			'is_checked' => ( ! empty( $info['exclude'] ) && in_array( $k, $info['exclude'], true ) ) ? 1 : 0,
			'is_forced'  => ( ! empty( $info['force_original_to'] ) && $k === $info['force_original_to'] ) ? 1 : 0,
			'has_crop'   => ( ! empty( $info['default_crop'][ $k ] ) ) ? $info['default_crop'][ $k ] : 'cc',
			'quality'    => ( ! empty( $info['default_quality'][ $k ] ) ) ? (int) $info['default_quality'][ $k ] : 100,
			'line_class' => '',
		);
		$data['quality'] = ( empty( $data['quality'] ) ) ? 100 : $data['quality'];

		$data['line_class'] .= ( ! empty( $data['is_ignored'] ) ) ? ' _sirsc_ignored' : '';
		$data['line_class'] .= ( ! empty( $data['is_forced'] ) ) ? ' _sirsc_force_original' : '';
		$data['line_class'] .= ( empty( $data['is_checked'] ) ) ? ' _sirsc_included' : '';
		return $data;
	}

	/**
	 * Maybe execute the options update if the nonce is valid, then redirect.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function maybe_save_settings() {
		$nonce = filter_input( INPUT_POST, '_sirsc_settings_nonce', FILTER_DEFAULT );
		if ( empty( $nonce ) ) {
			return;
		}
		if ( ! empty( $nonce ) ) {
			if ( ! wp_verify_nonce( $nonce, '_sirsc_settings_save' ) || ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'Action not allowed.', 'sirsc' ), esc_html__( 'Security Breach', 'sirsc' ) );
			}

			$settings = array(
				'exclude'                => array(),
				'force_original_to'      => '',
				'complete_global_ignore' => array(),
				'placeholders'           => array(),
				'default_crop'           => array(),
				'default_quality'        => array(),
			);

			$user_custom_rules = self::get_default_user_custom_rules();

			$post_types   = filter_input( INPUT_POST, '_sirsc_post_types', FILTER_DEFAULT );
			$exclude      = filter_input( INPUT_POST, '_sirsrc_exclude_size', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );
			$ignore       = filter_input( INPUT_POST, '_sirsrc_complete_global_ignore', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );
			$forced       = filter_input( INPUT_POST, '_sirsrc_force_original_to', FILTER_DEFAULT, FILTER_SANITIZE_STRING );
			$placeholders = filter_input( INPUT_POST, '_sirsrc_placeholders', FILTER_DEFAULT, FILTER_SANITIZE_STRING );
			$crop         = filter_input( INPUT_POST, '_sirsrc_default_crop', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );
			$quality      = filter_input( INPUT_POST, '_sirsrc_default_quality', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY );

			$settings['exclude']                = ( ! empty( $exclude ) ) ? array_keys( $exclude ) : array();
			$settings['complete_global_ignore'] = ( ! empty( $ignore ) ) ? array_keys( $ignore ) : array();
			$settings['force_original_to']      = ( ! empty( $forced ) ) ? $forced : '';
			if ( 'force_global' === $placeholders ) {
				$settings['placeholders']['force_global'] = 1;
			} elseif ( 'only_missing' === $placeholders ) {
				$settings['placeholders']['only_missing'] = 1;
			}
			$settings['default_crop']    = ( ! empty( $crop ) ) ? $crop : array();
			$settings['default_quality'] = ( ! empty( $quality ) ) ? $quality : array();

			if ( ! empty( $post_types ) ) { // Specific post type.
				update_option( 'sirsc_settings_' . $post_types, $settings );
			} else { // General settings.
				update_option( 'sirsc_settings', $settings );
			}

			// Custom rules update.
			self::update_user_custom_rules();
			self::get_default_user_custom_rules();

			add_action( 'admin_notices', array( get_called_class(), 'on_settings_update_notice' ) );
		}
	}

	/**
	 * Output the admin success message for email test sent.
	 *
	 * @return void
	 */
	public static function on_settings_update_notice() {
		$class   = 'notice notice-success is-dismissible';
		$message = __( 'The plugin settings have been updated successfully.', 'sirsc' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}

	/**
	 * Maybe re-order the custom rules options as priorities.
	 *
	 * @access public
	 * @static
	 * @param array $usable_crules The rules to be prioritized.
	 * @return array
	 */
	public static function update_user_custom_rules_priority( $usable_crules = array() ) {
		if ( ! empty( $usable_crules ) ) {
			// Put the rules in the priority order.
			$ucr = array();
			$c   = 0;

			// Collect the ID rules.
			foreach ( $usable_crules as $k => $rule ) {
				if ( 'ID' === $rule['type'] ) {
					$ucr[ ++ $c ] = $rule;
					unset( $usable_crules[ $k ] );
				}
			}
			// Collect the post type rules.
			if ( ! empty( $usable_crules ) ) {
				foreach ( $usable_crules as $k => $rule ) {
					if ( 'post_type' === $rule['type'] ) {
						$ucr[ ++ $c ] = $rule;
						unset( $usable_crules[ $k ] );
					}
				}
			}
			// Collect the post format rules.
			if ( ! empty( $usable_crules ) ) {
				foreach ( $usable_crules as $k => $rule ) {
					if ( 'post_format' === $rule['type'] ) {
						$ucr[ ++ $c ] = $rule;
						unset( $usable_crules[ $k ] );
					}
				}
			}
			// Collect the post parent rules.
			if ( ! empty( $usable_crules ) ) {
				foreach ( $usable_crules as $k => $rule ) {
					if ( 'post_parent' === $rule['type'] ) {
						$ucr[ ++ $c ] = $rule;
						unset( $usable_crules[ $k ] );
					}
				}
			}
			// Collect the tags rules.
			if ( ! empty( $usable_crules ) ) {
				foreach ( $usable_crules as $k => $rule ) {
					if ( 'post_tag' === $rule['type'] ) {
						$ucr[ ++ $c ] = $rule;
						unset( $usable_crules[ $k ] );
					}
				}
			}
			// Collect the categories rules.
			if ( ! empty( $usable_crules ) ) {
				foreach ( $usable_crules as $k => $rule ) {
					if ( 'category' === $rule['type'] ) {
						$ucr[ ++ $c ] = $rule;
						unset( $usable_crules[ $k ] );
					}
				}
			}
			// Collect the test of the taxonomies rules.
			if ( ! empty( $usable_crules ) ) {
				foreach ( $usable_crules as $k => $rule ) {
					$ucr[ ++ $c ] = $rule;
					unset( $usable_crules[ $k ] );
				}
			}

			$usable_crules = $ucr;
		}

		return $usable_crules;
	}

	/**
	 * Maybe execute the custom rules options update.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function update_user_custom_rules() {
		$urules  = filter_input( INPUT_POST, '_user_custom_rule', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );
		$ucrules = array();
		foreach ( self::$user_custom_rules as $k => $v ) {
			if ( isset( $urules[ $k ] ) ) {
				$ucrules[ $k ] = ( ! empty( $urules[ $k ] ) ) ? $urules[ $k ] : '';
			}
		}
		foreach ( $ucrules as $k => $v ) {
			if ( ! empty( $v['type'] ) && ! empty( $v['original'] ) ) {
				if ( empty( $v['only'] ) || ! is_array( $v['only'] ) ) {
					$v['only'] = array();
				}
				if ( ! empty( $v['only'] ) ) {
					$ucrules[ $k ]['only'] = $v['only'];
				} else {
					if ( '**full**' !== $v['original'] ) {
						$ucrules[ $k ]['only'] = array( $v['original'] );
					}
				}
				if ( '**full**' !== $v['original'] ) {
					$ucrules[ $k ]['only'] = array_merge( $ucrules[ $k ]['only'], array( $v['original'] ) );
				}
				if ( ! empty( $ucrules[ $k ]['only'] ) ) {
					$ucrules[ $k ]['only'] = array_diff( $ucrules[ $k ]['only'], array( '**full**' ) );
				}
			}
		}
		$ucrules = self::update_user_custom_rules_priority( $ucrules );
		update_option( 'sirsc_user_custom_rules', $ucrules );

		$usable_crules = array();
		foreach ( $ucrules as $key => $val ) {
			if ( ! empty( $val['type'] ) && ! empty( $val['value'] )
				&& ! empty( $val['original'] ) && ! empty( $val['only'] )
				&& empty( $val['suppress'] ) ) {
				$usable_crules[] = $val;
			}
		}
		$usable_crules = self::update_user_custom_rules_priority( $usable_crules );
		update_option( 'sirsc_user_custom_rules_usable', $usable_crules );

		self::$user_custom_rules_usable = $usable_crules;
	}

	/**
	 * Functionality to manage the image regenerate & select crop settings.
	 */
	public static function image_regenerate_select_crop_settings() {
		if ( ! current_user_can( 'manage_options' ) ) {
			// Verify user capabilities in order to deny the access if the user does not have the capabilities.
			wp_die( esc_html__( 'Action not allowed.', 'sirsc' ) );
		}

		$allow_html = array(
			'table' => array(
				'class' => array(),
				'cellspacing' => array(),
				'cellpadding' => array(),
				'title' => array(),
			),
			'tbody' => array(),
			'tr' => array(),
			'td' => array( 'title' => array() ),
			'label' => array(),
			'input' => array(
				'type' => array(),
				'name' => array(),
				'id' => array(),
				'value' => array(),
				'checked' => array(),
				'onchange' => array(),
			),
		);

		// Display the form and the next digests contents.
		?>
		<div class="wrap">
			<h1 class="wp-heading-inline"><?php esc_html_e( 'Image Regenerate & Select Crop Settings', 'sirsc' ); ?></h1>
			<div class="sirsc-image-generate-functionality">
				<p><?php esc_html_e( 'Please make sure you visit and update your settings here whenever you activate a new theme or plugins, so that the new image size registered, adjusted or removed to be reflected also here, and in this way to assure the optimal behavior for the features of this plugin.', 'sirsc' ); ?></p>

				<?php
				if ( false === self::$is_configured ) {
					echo '<div class="update-nag">' . esc_html__( 'Image Regenerate & Select Crop Settings are not configured yet.', 'sirsc' ) . '</div><hr/>';
				}
				$post_types              = self::get_all_post_types_plugin();
				$_sirsc_post_types       = filter_input( INPUT_GET, '_sirsc_post_types', FILTER_DEFAULT );
				$settings                = maybe_unserialize( get_option( 'sirsc_settings' ) );
				$default_plugin_settings = $settings;
				if ( ! empty( $_sirsc_post_types ) ) {
					$settings = maybe_unserialize( get_option( 'sirsc_settings_' . $_sirsc_post_types ) );
				}
				?>
				<form id="sirsc_settings_frm" name="sirsc_settings_frm" action="" method="post">
					<?php wp_nonce_field( '_sirsc_settings_save', '_sirsc_settings_nonce' ); ?>

					<h3><?php esc_html_e( 'Option to Enable Placeholders', 'sirsc' ); ?></h3>
					<p><?php esc_html_e( 'This option allows you to display placeholders for the front-side images called programmatically (the images that are not embedded in the content with their src, but exposed using WordPress native functions). If there is no placeholder set, then the WordPress default behavior would be to display the full-size image instead of a missing image size, hence your pages might load slower, and when using grids, the items would not look even.', 'sirsc' ); ?></p>

					<style>

					</style>
					<table cellpadding="0" cellspacing="0" class="wp-list-table widefat striped sirsc-table">
						<tr class="middle">
							<td>
								<h3><a class="dashicons dashicons-info" title="<?php echo esc_attr( 'Details', 'sirsc' ); ?>" onclick="sirsc_toggle_info('#info_developer_mode')"></a>
									<?php esc_html_e( 'Images Placeholders Developer Mode', 'sirsc' ); ?></h3>
								<div class="sirsc_info_box_wrap">
									<div id="info_developer_mode" class="sirsc_info_box" onclick="sirsc_toggle_info('#info_developer_mode')">
										<?php esc_html_e( 'If you activate the "force global" option, all the images on the front-side that are related to posts will be replaced with the placeholders that mention the image size required. This is useful for debugging, to quickly identify the image sizes used for each layout and perhaps to help you regenerate the mission ones or decide what to keep or what to remove.', 'sirsc' ); ?><hr/><?php esc_html_e( 'If you activate the "only missing images" option, all the programmatically called images on the front-side that are related to posts and do not have the requested image size generated will be replaced with the placeholders that mention the image size required. This is useful for showing smaller images instead of the full-size images (as WordPress does by default), hence for speeding up the pages loading.', 'sirsc' ); ?>
									</div>
								</div>
							</td>
							<td>
								<label><input type="radio" name="_sirsrc_placeholders" id="_sirsrc_placeholders_none" value="" <?php checked( true, ( empty( $settings['placeholders'] ) ) ); ?> onchange="sirsc_autosubmit()" /> <?php esc_html_e( 'no placeholder', 'sirsc' ); ?></label>
							</td>
							<td>
								<label><input type="radio" name="_sirsrc_placeholders" id="_sirsrc_placeholders_force_global" value="force_global" <?php checked( true, ( ! empty( $settings['placeholders']['force_global'] ) ) ); ?> onchange="sirsc_autosubmit()" /> <?php esc_html_e( 'force global', 'sirsc' ); ?></label>
							</td>
							<td>
								<label><input type="radio" name="_sirsrc_placeholders" id="_sirsrc_placeholders_only_missing" value="only_missing" <?php checked( true, ( ! empty( $settings['placeholders']['only_missing'] ) ) ); ?> onchange="sirsc_autosubmit()" /> <?php esc_html_e( 'only missing images', 'sirsc' ); ?></label>
							</td>
							<td class="textright"><?php submit_button( __( 'Save Settings', 'sisrc' ), 'primary', '', false, array( 'id' => 'sirsc-settings-submit' ) ); ?></td>
						</tr>
					</table>

					<h3><?php esc_html_e( 'Option to Exclude Image Sizes', 'sirsc' ); ?></h3>
					<p><?php esc_html_e( 'This plugin provides the option to select image sizes that will be excluded from the generation of the new images. By default, all image sizes defined in the system will be allowed (these are programmatically registered by the themes and plugins you activate in your site, without you even knowing about these). You can set up a global configuration, or more specific configuration for all images attached to a particular post type. If no particular settings are made for a post type, then the default general settings will be used.', 'sirsc' ); ?> <b><?php esc_html_e( 'The options for which you made some settings are marked with * in the dropdown below.', 'sirsc' ); ?></b></p>

					<table cellpadding="0" cellspacing="0" class="wp-list-table widefat striped sirsc-table">
						<tr class="middle">
							<td><h3><?php esc_html_e( 'Apply the settings below for the selected option', 'sirsc' ); ?></h3></td>
							<td>
								<?php
								if ( ! empty( $post_types ) ) {
									$ptypes = array();
									$has    = ( ! empty( $default_plugin_settings ) ) ? '* ' : '';
									?>
									<select name="_sirsc_post_types" id="_sirsc_post_type" onchange="sirsc_load_post_type(this, '<?php echo esc_url( self::$plugin_url ); ?>')"><option value=""><?php echo esc_html( $has . esc_html__( 'General settings (used as default for all images)', 'sirsc' ) ); ?></option>
									<?php
									foreach ( $post_types as $pt => $obj ) {
										array_push( $ptypes, $pt );
										$is_sel = ( $_sirsc_post_types === $pt ) ? 1 : 0;
										$extra  = ( ! empty( $obj->_builtin ) ) ? '' : ' (custom post type)';
										$pt_s   = maybe_unserialize( get_option( 'sirsc_settings_' . $pt ) );
										$has    = ( ! empty( $pt_s ) ) ? '* ' : '';
										?>
										<option value="<?php echo esc_attr( $pt ); ?>"<?php selected( 1, $is_sel ); ?>><?php echo esc_html( $has . esc_html__( 'Settings for images attached to a ', 'sirsc' ) . ' ' . $pt . $extra ); ?></option>
										<?php
									}
									?>
									</select>
									<?php
									update_option( 'sirsc_types_options', $ptypes );
								}
								?>
							</td>
							<td class="textright"><?php submit_button( __( 'Save Settings', 'sisrc' ), 'primary', '', false ); ?></td>
						</tr>
					</table>
					<table cellpadding="0" cellspacing="0" class="wp-list-table widefat fixed striped sirsc-table notop">
						<thead>
							<tr class="middle noborder">
								<td id="th-set-ignore" scope="col" class="manage-column">
									<h3><a class="dashicons dashicons-info" title="<?php esc_attr_e( 'Details', 'sirsc' ); ?>" onclick="sirsc_toggle_info('#info_global_ignore')"></a>
										<span><?php esc_html_e( 'Global Ignore', 'sirsc' ); ?></span></h3>
									<div class="sirsc_info_box_wrap">
										<div id="info_global_ignore" class="sirsc_info_box" onclick="sirsc_toggle_info('#info_global_ignore')">
											<?php esc_html_e( 'This option allows you to exclude globally from the application some of the image sizes that are registered through various plugins and themes options, that you perhaps do not need at all in your application (these are just stored in your folders and database but not actually used/visible on the front-end).', 'sirsc' ); ?>
											<hr/><?php esc_html_e( 'By excluding these, the unnecessary image sizes will not be generated at all.', 'sirsc' ); ?>
										</div>
									</div>
								</td>
								<td id="th-set-info" scope="col" class="manage-column">
									<h3><a class="dashicons dashicons-info" title="<?php esc_attr_e( 'Details', 'sirsc' ); ?>" onclick="sirsc_toggle_info('#info_default_quality')"></a> <span><?php esc_html_e( 'Image Size Info', 'sirsc' ); ?></span></h3>
									<div class="sirsc_info_box_wrap">
										<div id="info_default_quality" class="sirsc_info_box" onclick="sirsc_toggle_info('#info_default_quality')">
											<?php esc_html_e( 'The quality option is allowing you to control the quality of the images that are generated for each of the image sizes, starting from the quality of the image you upload. This can be useful for performance.', 'sirsc' ); ?><hr><b><?php esc_html_e( 'However, please be careful not to change the quality of the full image or the quality of the image size that you set as the forced original.', 'sirsc' ); ?></b><hr><?php esc_html_e( 'Setting a lower quality is recommended for smaller images sizes, that are generated from the full/original file.', 'sirsc' ); ?>
										</div>
									</div>
								</td>
								<td id="th-set-hide" scope="col" class="manage-column">
									<h3><a class="dashicons dashicons-info" title="<?php esc_attr_e( 'Details', 'sirsc' ); ?>" onclick="sirsc_toggle_info('#info_exclude')"></a> <span><?php esc_html_e( 'Hide Preview', 'sirsc' ); ?></span></h3>
									<div class="sirsc_info_box_wrap">
										<div id="info_exclude" class="sirsc_info_box" onclick="sirsc_toggle_info('#info_exclude')">
											<?php esc_html_e( 'This option allows you to hide from the "Image Regenerate & Select Crop Settings" lightbox the details and options for the selected image sizes (when you or other admins are checking the image details, the hidden image sizes will not be shown).', 'sirsc' ); ?><hr/><?php esc_html_e( 'This is useful when you want to restrict from other users the functionality of crop or resize for particular image sizes, or to just hide the image sizes you added to global ignore.', 'sirsc' ); ?>
										</div>
									</div>
								</td>
								<td id="th-set-original" scope="col" class="manage-column">
									<h3><a class="dashicons dashicons-info" title="<?php esc_attr_e( 'Details', 'sirsc' ); ?>" onclick="sirsc_toggle_info('#info_force_original')"></a> <span><?php esc_html_e( 'Force Original', 'sirsc' ); ?></span></h3>
									<div class="sirsc_info_box_wrap">
										<div id="info_force_original" class="sirsc_info_box" onclick="sirsc_toggle_info('#info_force_original')">
											<?php esc_html_e( 'This option means that when uploading an image, the original image will be replaced completely by the image size you select (the image generated, scaled or cropped to a specific width and height will become the full size for that image going further).', 'sirsc' ); ?><hr/><?php esc_html_e( 'This can be very useful if you do not use the original image in any of the layouts at the full size, and this might save some storage space.', 'sirsc' ); ?><hr/><?php esc_html_e( 'Leave "nothing selected" to keep the full/original image as the file you upload (default WordPress behavior).', 'sirsc' ); ?>
										</div>
									</div>
								</td>
								<td id="th-set-crop" width="15%" scope="col" class="manage-column">
									<h3><a class="dashicons dashicons-info" title="<?php esc_attr_e( 'Default Crop', 'sirsc' ); ?>" onclick="sirsc_toggle_info('#info_default_crop')"></a> <span><?php esc_html_e( 'Default Crop', 'sirsc' ); ?></span></h3>
									<div class="sirsc_info_box_wrap">
										<div id="info_default_crop" class="sirsc_info_box" onclick="sirsc_toggle_info('#info_default_crop')">
											<?php esc_html_e( 'This option allows you to set a default crop position for the images generated for a particular image size. This option will be applied when you chose to regenerate an individual image or all of these, and also when a new image is uploaded.', 'sirsc' ); ?>
										</div>
									</div>
								</td>
								<td id="th-set-cleanup" width="12%" scope="col" class="manage-column">
									<h3><a class="dashicons dashicons-info" title="<?php esc_attr_e( 'Details', 'sirsc' ); ?>" onclick="sirsc_toggle_info('#info_clean_up')"></a> <span><?php esc_html_e( 'Cleanup', 'sirsc' ); ?></span></h3>
									<div class="sirsc_info_box_wrap">
										<div id="info_clean_up" class="sirsc_info_box" onclick="sirsc_toggle_info('#info_clean_up')">
											<?php esc_html_e( 'This option allows you to clean up all the image generated for a particular image size you already have in the application, and that you do not use or do not want to use anymore on the front-end.', 'sirsc' ); ?><hr/><b><?php esc_html_e( 'Please be careful, once you click to remove the images for a selected image size, the action is irreversible, the images generated up this point will be deleted from your folders and database records.', 'sirsc' ); ?></b> <?php esc_html_e( 'You can regenerate these later if you click the Regenerate button.', 'sirsc' ); ?>
										</div>
									</div>
								</td>
								<td id="th-set-regenerate" width="12%" scope="col" class="manage-column">
									<h3><a class="dashicons dashicons-info" title="<?php esc_attr_e( 'Details', 'sirsc' ); ?>" onclick="sirsc_toggle_info('#info_regenerate')"></a> <span><?php esc_html_e( 'Regenerate', 'sirsc' ); ?></span></h3>
									<div class="sirsc_info_box_wrap">
										<div id="info_regenerate" class="sirsc_info_box" onclick="sirsc_toggle_info('#info_regenerate')">
											<?php esc_html_e( 'This option allows you to regenerate the images for the selected image size.', 'sirsc' ); ?><hr/><b><?php esc_html_e( 'Please be careful, once you click the button to regenerate the selected image size, the action is irreversible, the images already generated will be overwritten.', 'sirsc' ); ?></b>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3"></td>
								<td colspan="4"><div><label><input type="radio" name="_sirsrc_force_original_to" id="_sirsrc_force_original_to_0" value="0" <?php checked( 1, 1 ); ?> onchange="sirsc_autosubmit()" /> <?php esc_html_e( 'nothing selected (keep the full/original file uploaded)', 'sirsc' ); ?></label></div></td>
							</tr>
						</thead>
						<tbody id="the-list">
							<?php $all_sizes  = self::get_all_image_sizes(); ?>
							<?php if ( ! empty( $all_sizes ) ) : ?>
								<?php foreach ( $all_sizes as $k => $v ) : ?>
									<?php
									$use  = self::get_usable_info( $k, $settings );
									$clon = '';
									if ( ! substr_count( $use['line_class'], '_sirsc_included' ) ) {
										$clon .= ' row-hide';
									}
									if ( substr_count( $use['line_class'], '_sirsc_ignored' ) ) {
										$clon .= ' row-ignore';
									}
									if ( substr_count( $use['line_class'], '_sirsc_force_original' ) ) {
										$clon .= ' row-original';
									}
									?>
									<tr class="hentry <?php echo esc_attr( $clon ); ?>">
										<td class="th-set-ignore">
											<div class="inner"><label><input type="checkbox" name="_sirsrc_complete_global_ignore[<?php echo esc_attr( $k ); ?>]" id="_sirsrc_complete_global_ignore_<?php echo esc_attr( $k ); ?>" value="<?php echo esc_attr( $k ); ?>" <?php checked( 1, $use['is_ignored'] ); ?>
											onchange="sirsc_autosubmit()" /> <?php esc_html_e( 'global ignore', 'sirsc' ); ?></label></div>
										</td>
										<td class="th-set-info">
											<div class="inner"><b><?php echo esc_html( $k ); ?></b><?php self::image_placeholder_for_image_size( $k, true ); ?></b>
											<p class="info"><?php echo wp_kses_post( self::size_to_text( $v ) ); ?></p>
											<?php esc_html_e( 'Quality', 'sirsc' ); ?> <input type="number" name="_sirsrc_default_quality[<?php echo esc_attr( $k ); ?>]" id="_sirsrc_default_quality_<?php echo esc_attr( $k ); ?>" max="100" min="10" value="<?php echo (int) $use['quality']; ?>" size="2" style="width: 7em" onchange="alert('<?php esc_attr_e( 'Please be aware that your are changing the quality of the images going further for this images size!', 'sirsc' ); ?>'); sirsc_autosubmit()"></div>
										</td>
										<td class="th-set-hide">
											<div class="inner"><label><input type="checkbox" name="_sirsrc_exclude_size[<?php echo esc_attr( $k ); ?>]" id="_sirsrc_exclude_size_<?php echo esc_attr( $k ); ?>" value="<?php echo esc_attr( $k ); ?>" <?php checked( 1, $use['is_checked'] ); ?> onchange="sirsc_autosubmit()" /> <?php esc_html_e( 'hide', 'sirsc' ); ?></label></div>
										</td>
										<td class="th-set-original">
											<div class="inner"><label><input type="radio" name="_sirsrc_force_original_to" id="_sirsrc_force_original_to_<?php echo esc_attr( $k ); ?>" value="<?php echo esc_attr( $k ); ?>" <?php checked( 1, $use['is_forced'] ); ?> onchange="sirsc_autosubmit()" /> <?php esc_html_e( 'force original', 'sirsc' ); ?></label></div>
										</td>
										<td class="th-set-crop">
											<div class="inner position"><?php if ( ! empty( $v['crop'] ) ) : ?>
												<?php esc_html_e( 'Crop Position', 'sirsc' ); ?><?php echo wp_kses( str_replace( 'crop_small_type_' . $k . '"', '_sirsrc_default_crop[' . $k . ']" onchange="sirsc_autosubmit()"', self::make_generate_images_crop( 0, $k, false, $use['has_crop'] ) ), $allow_html ); ?>
											<?php endif; ?></div>
										</td>
										<td class="th-set-cleanup textcenter">
											<?php $total_cleanup = self::calculate_total_to_cleanup( $_sirsc_post_types, $k ); ?>
											<?php if ( ! empty( $total_cleanup ) ) : ?>
												<span class="button widefat button-secondary" title="<?php echo intval( $total_cleanup ); ?>" onclick="sirsc_initiate_cleanup('<?php echo esc_attr( $k ); ?>');"><b class="dashicons dashicons-no" title="<?php esc_attr_e( 'Cleanup All', 'sirsc' ); ?>"></b> <?php esc_html_e( 'Cleanup', 'sirsc' ); ?></span>
												<div class="sirsc_button-regenerate-wrap title">
													<div id="_sirsc_cleanup_initiated_for_<?php echo esc_attr( $k ); ?>">
														<input type="hidden" name="_sisrsc_image_size_name" id="_sisrsc_image_size_name<?php echo esc_attr( $k ); ?>" value="<?php echo esc_attr( $k ); ?>"/>
														<input type="hidden" name="_sisrsc_post_type" id="_sisrsc_post_type<?php echo esc_attr( $k ); ?>" value="<?php echo esc_attr( $_sirsc_post_types ); ?>"/>
														<input type="hidden" name="_sisrsc_image_size_name_page" id="_sisrsc_image_size_name_page<?php echo esc_attr( $k ); ?>" value="0"/>
														<div class="sirsc_button-regenerate">
															<div><div id="_sirsc_cleanup_initiated_for_<?php echo esc_attr( $k ); ?>_result" class="result"><span class="spinner off"></span></div></div>
														</div>
														<div class="sirsc_clearAll"></div>
													</div>
												</div>
											<?php endif; ?>
										</td>
										<td class="th-set-regenerate textright">
											<?php if ( empty( $use['is_ignored'] ) ) { ?>
												<span class="button widefat button-primary" onclick="sirsc_initiate_regenerate('<?php echo esc_attr( $k ); ?>');"><b class="dashicons dashicons-update" title="<?php esc_attr_e( 'Regenerate All', 'sirsc' ); ?>"></b> <?php esc_html_e( 'Regenerate', 'sirsc' ); ?></span>
												<div class="sirsc_button-regenerate-wrap title on">
													<div id="_sirsc_regenerate_initiated_for_<?php echo esc_attr( $k ); ?>">
														<input type="hidden" name="_sisrsc_regenerate_image_size_name" id="_sisrsc_regenerate_image_size_name<?php echo esc_attr( $k ); ?>" value="<?php echo esc_attr( $k ); ?>"/>
														<input type="hidden" name="_sisrsc_post_type" id="_sisrsc_regenerate_post_type<?php echo esc_attr( $k ); ?>" value="<?php echo esc_attr( $_sirsc_post_types ); ?>"/>
														<input type="hidden" name="_sisrsc_regenerate_image_size_name_page" id="_sisrsc_regenerate_image_size_name_page<?php echo esc_attr( $k ); ?>" value="0"/>
														<div class="sirsc_button-regenerate">
															<div><div id="_sirsc_regenerate_initiated_for_<?php echo esc_attr( $k ); ?>_result" class="result"><span class="spinner off"></span></div></div>
														</div>
														<div class="sirsc_clearAll"></div>
													</div>
												</div>
											<?php } ?>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
							<tr>
								<td colspan="7" class="textright"><?php submit_button( __( 'Save Settings', 'sisrc' ), 'primary', '', false ); ?></td>
							</tr>
						</tbody>
					</table>


					<h3><?php esc_html_e( 'Advanced custom rules based on the post where the image will be uploaded', 'sirsc' ); ?></h3>
					<p>
						<?php esc_html_e( 'The advanced custom rules you configure below are global and will override all the other settings you set above.', 'sirsc' ); ?> <b><?php esc_html_e( 'Please be aware that the custom rules will apply only if you actually set up the post to use one of the rules below, and only then upload images to that post.', 'sirsc' ); ?></b>
					</p>
					<p>
						<?php esc_html_e( 'Very important: the order in which the rules are checked and have priority is: post ID, post type, post format, post parent, post tags, post categories, other taxonomies. Any of the rules that match first in this order will apply for the images that are generated when you upload images to that post (and the rest of the rules will be ignored). You can suppress at any time any of the rules and then enable these back as it suits you.', 'sirsc' ); ?>
					</p>
					<?php
					$select_ims = '';
					$checks_ims = '';
					if ( ! empty( $all_sizes ) ) {
						$select_ims .= '<option value="**full**">- ' . esc_attr( 'full/original' ) . ' -</option>';
						foreach ( $all_sizes as $k => $v ) {
							$select_ims .= '<option value="' . esc_attr( $k ) . '">' . esc_attr( $k ) . '</option>';
							$checks_ims .= ( ! empty( $checks_ims ) ) ? ', ' : '';
							$checks_ims .= '<label label-for="' . esc_attr( $k ) . '"><input type="checkbox" name="#NAME#" id="#ID#" value="' . esc_attr( $k ) . '">' . esc_attr( $k ) . '</label>';
						}
					}

					$taxonomies = get_taxonomies( array( 'public' => 1 ), 'objects' );
					$select_tax = '';
					if ( ! empty( $taxonomies ) ) {
						foreach ( $taxonomies as $k => $v ) {
							$select_tax .= '<option value="' . esc_attr( $k ) . '">' . esc_attr( $v->label ) . '</option>';
						}
					}
					$select_tax .= '<option value="ID">' . esc_html( 'Post ID', 'sirsc' ) . '</option>';
					$select_tax .= '<option value="post_parent">' . esc_html( 'Post Parent ID', 'sirsc' ) . '</option>';
					$select_tax .= '<option value="post_type">' . esc_html( 'Post Type', 'sirsc' ) . '</option>';
					?>

					<table cellpadding="0" cellspacing="0" class="wp-list-table widefat fixed striped sirsc-table sirsc-custom-rules">
						<thead>
							<tr class="middle noborder">
								<td id="th-rule-type" scope="col" class="manage-column" width="15%">
									<h3><span><?php esc_html_e( 'The post has', 'sirsc' ); ?></span></h3>
									<div class="row-hint"><?php esc_html_e( 'Ex: Categories', 'sirsc' ); ?></div>
								</td>
								<td id="th-rule-value" scope="col" class="manage-column" width="15%">
									<h3><span><?php esc_html_e( 'Value', 'sirsc' ); ?></span></h3>
									<div class="row-hint"><?php esc_html_e( 'Ex: gallery,my-photos', 'sirsc' ); ?></div>
								</td>
								<td id="th-rule-original" scope="col" class="manage-column" width="15%">
									<h3><span><?php esc_html_e( 'Force Original', 'sirsc' ); ?></span></h3>
									<div class="row-hint"><?php esc_html_e( 'Ex: large', 'sirsc' ); ?></div>
								</td>
								<td id="th-rule-only" scope="col" class="manage-column">
									<h3><span><?php esc_html_e( 'Generate only these image sizes for the rule', 'sirsc' ); ?></span></h3>
									<div class="row-hint"><?php esc_html_e( 'Ex: thumbnail, large', 'sirsc' ); ?></div>
								</td>
								<td id="th-rule-suppress" scope="col" class="manage-column" width="10%">
									<h3><span><?php esc_html_e( 'Suppress', 'sirsc' ); ?></span></h3>
								</td>
							</tr>
						</thead>
						<tbody id="the-list">

							<?php for ( $i = 1; $i <= 10; $i ++ ) : ?>
								<?php
								$class = 'row-hide';
								if ( ! empty( self::$user_custom_rules[ $i ]['type'] )
									&& ! empty( self::$user_custom_rules[ $i ]['value'] ) ) {
									$class = 'row-use';
								}
								if ( ! empty( self::$user_custom_rules[ $i ]['suppress'] )
									&& 'on' === self::$user_custom_rules[ $i ]['suppress'] ) {
									$class .= ' row-ignore';
								}
								$supp  = ( ! empty( self::$user_custom_rules[ $i ]['suppress'] ) && 'on' === self::$user_custom_rules[ $i ]['suppress'] ) ? ' checked="checked"' : '';
								?>
								<tr id="th-rule-row<?php echo (int) $i; ?>" class="hentry <?php echo esc_attr( $class ); ?>">
									<td class="th-rule-type">
										<select name="_user_custom_rule[<?php echo (int) $i; ?>][type]">
											<option value=""><?php esc_html_e( 'N/A', 'sirsc' ); ?></option>
											<?php
											echo str_replace(
												'value="' . esc_attr( self::$user_custom_rules[ $i ]['type'] ) . '"',
												'value="' . esc_attr( self::$user_custom_rules[ $i ]['type'] ) . '" selected="selected"',
												$select_tax
											); // WPCS: XSS OK.
											?>
										</select>
									</td>
									<td class="th-rule-value">
										<input type="text" name="_user_custom_rule[<?php echo (int) $i; ?>][value]"
											value="<?php echo esc_attr( self::$user_custom_rules[ $i ]['value'] ); ?>" size="20">
									</td>
									<td class="th-rule-original">
										<select name="_user_custom_rule[<?php echo (int) $i; ?>][original]">
											<?php
											$sel = ( ! empty( self::$user_custom_rules[ $i ]['original'] ) ) ? self::$user_custom_rules[ $i ]['original'] : 'large';
											echo str_replace(
												' value="' . $sel . '"',
												' value="' . $sel . '" selected="selected"',
												$select_ims
											); // WPCS: XSS OK.
											?>
										</select>
									</td>
									<td class="th-rule-only">
										<?php
										$only = str_replace( '#ID#', '_user_custom_rule_' . $i . '_only_', $checks_ims );
										$only = str_replace( '#NAME#', '_user_custom_rule[' . $i . '][only][]', $only );
										$sel  = ( ! empty( self::$user_custom_rules[ $i ]['only'] ) ) ? self::$user_custom_rules[ $i ]['only'] : array( 'thumbnail', 'large' );
										foreach ( $sel as $is ) {
											if ( ! empty( $class ) && substr_count( $class, 'row-use' ) ) {
												$only = str_replace(
													' value="' . $is . '"',
													' value="' . $is . '" checked="checked" class="row-use"',
													$only
												);
												$only = str_replace(
													' label-for="' . $is . '"',
													' label-for="' . $is . '" class="' . $class . '"',
													$only
												);
											}
										}
										echo $only; // WPCS: XSS OK.
										?>
									</td>
									<td class="th-rule-suppress textcenter">
										<input type="checkbox" name="_user_custom_rule[<?php echo (int) $i; ?>][suppress]" <?php echo $supp; // WPCS: XSS OK. ?>>
									</td>
								</tr>

								<tr class="<?php echo esc_attr( $class ); ?> rule-info">
									<td colspan="5">
										<?php
										if ( ! empty( $class ) && substr_count( $class, 'row-use' ) ) {

											echo '<div class="potential-rule ' . $class . '">'; // WPCS: XSS OK.
											if ( substr_count( $class, 'row-ignore' ) ) {
												esc_html_e( 'This rule is SUPPRESSED', 'sirsc' );
											} else {
												esc_html_e( 'This rule is ACTIVE', 'sirsc' );
											}
											echo ': ';

											if ( '**full**' === self::$user_custom_rules[ $i ]['original'] ) {
												echo sprintf(
													// Translators: %1$s type, %2$s value, %3$s only.
													esc_html__( 'uploading images to a post that has %1$s as %2$s will generate only the %3$s sizes.', 'sirsc' ),
													'<b>' . self::$user_custom_rules[ $i ]['type'] . '</b>',
													'<b>' . self::$user_custom_rules[ $i ]['value'] . '</b>',
													'<b>' . implode( ', ', array_unique( self::$user_custom_rules[ $i ]['only'] ) ) . '</b>'
												); // WPCS: XSS OK.
											} else {
												echo sprintf(
													// Translators: %1$s type, %2$s value, %3$s original, %4$s only.
													esc_html__( 'uploading images to a post that has %1$s as %2$s will force the original image to %3$s size and will generate only the %4$s sizes.', 'sirsc' ),
													'<b>' . self::$user_custom_rules[ $i ]['type'] . '</b>',
													'<b>' . self::$user_custom_rules[ $i ]['value'] . '</b>',
													'<b>' . self::$user_custom_rules[ $i ]['original'] . '</b>',
													'<b>' . implode( ', ', array_unique( self::$user_custom_rules[ $i ]['only'] ) ) . '</b>'
												); // WPCS: XSS OK.
											}
											echo '</div>'; // WPCS: XSS OK.
										}
										?>
									</td>
								</tr>
							<?php endfor; ?>

							<tr class="hentry">
								<td colspan="5" class="textright"><?php submit_button( __( 'Save Settings', 'sisrc' ), 'primary', '', false ); ?></td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>

			<br>
			<p>
				<span class="dashicons dashicons-format-quote"></span> <?php esc_html_e( 'The best thing about giving of ourselves is that what we get is always better than what we give.', 'sirsc' ); ?>

				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="JJA37EHZXWUTJ"><input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1"></form>
			</p>
		</div>
		<?php
	}

	/**
	 * For the featured image of the show we should be able to generate the missing image sizes.
	 */
	public static function register_image_button() {
		global $wp_version;
		if ( ! empty( $wp_version ) && preg_match_all( '/([1-9])\.([1-9])(\.([1-9])?)?/', $wp_version, $v ) ) {
			if ( ! empty( $v ) && ! empty( $v[1][0] ) && ! empty( $v[2][0] ) ) {
				// We can read the core version.
				if ( (int) $v[1][0] <= 4 && (int) $v[2][0] < 6 ) {
					// Before 4.6 we have only 2 parameters for admin_post_thumbnail_html hook.
					add_filter( 'admin_post_thumbnail_html', array( get_called_class(), 'append_image_generate_button_old' ), 10, 2 );
				} else {
					// Since 4.6 we have 3 parameters for admin_post_thumbnail_html hook.
					add_filter( 'admin_post_thumbnail_html', array( get_called_class(), 'append_image_generate_button' ), 10, 3 );
				}
			}
		}
	}

	/**
	 * Append the image sizes generator button to the edit media page.
	 */
	public static function register_image_meta() {
		global $post;
		if ( ! empty( $post->post_type ) && 'attachment' === $post->post_type ) {
			add_action( 'edit_form_top', array( get_called_class(), 'append_image_generate_button' ), 10, 2 );
		}
	}

	/**
	 * This can be used in do_action.
	 *
	 * @param integer $image_id Attachment ID.
	 */
	public static function image_regenerate_select_crop_button( $image_id = 0 ) {
		self::append_image_generate_button( '', '', $image_id );
	}

	/**
	 * Append or display the button for generating the missing image sizes and request individual crop of images, this is for core version < 4.6, for backward compatibility.
	 *
	 * @param string  $content       The button content.
	 * @param integer $post_id       The main post ID.
	 * @param integer $thumbnail_id  The attachemnt ID.
	 */
	public static function append_image_generate_button_old( $content, $post_id = 0, $thumbnail_id = 0 ) {
		$display = false;
		if ( is_object( $content ) ) {
			$thumbnail_id = $content->ID;
			$content      = '';
			$display      = true;
		}
		if ( ! empty( $post_id ) || ! empty( $thumbnail_id ) ) {
			if ( ! empty( $thumbnail_id ) ) {
				$thumb_id = $thumbnail_id;
				$display  = true;
			} else {
				$thumb_id = get_post_thumbnail_id( $post_id );
				$display  = false;
			}
			self::load_settings_for_post_id( $thumb_id );
			if ( ! empty( $thumb_id ) ) {
				$content = '
				<div class="sirsc-image-generate-functionality">
					<div id="sirsc_recordsArray_' . intval( $thumb_id ) . '">
						<input type="hidden" name="post_id" id="post_id' . 'thumb' . (int) $thumb_id . '" value="' . esc_attr( (int) $thumb_id ) . '" />' . self::make_generate_images_button( $thumb_id ) . ' &nbsp;
					</div>
				</div>
				' . $content;
			}
		}
		if ( $display ) {
			echo '<div class="sirsc_button-regenerate-wrap">' . $content . '</div>'; // WPCS: XSS OK.
		} else {
			return $content;
		}
	}

	/**
	 * Append or display the button for generating the missing image sizes and request individual crop of images.
	 *
	 * @param string  $content      The button content.
	 * @param integer $post_id      The main post ID.
	 * @param integer $thumbnail_id The attachemnt ID.
	 */
	public static function append_image_generate_button( $content, $post_id = 0, $thumbnail_id = 0 ) {
		$content_button    = '';
		$display           = false;
		$is_the_attachment = false;
		if ( is_object( $content ) ) {
			$thumbnail_id      = $content->ID;
			$display           = true;
			$is_the_attachment = true;
		}

		if ( ! empty( $post_id ) || ! empty( $thumbnail_id ) ) {
			if ( ! empty( $thumbnail_id ) ) {
				$thumb_id = $thumbnail_id;
			} else {
				$thumb_id = get_post_thumbnail_id( $post_id );
			}
			self::load_settings_for_post_id( $thumb_id );
			if ( ! empty( $thumb_id ) ) {
				$content_button = '
					<div class="sirsc-image-generate-functionality">
						<div id="sirsc_recordsArray_' . intval( $thumb_id ) . '">
							<input type="hidden" name="post_id" id="post_id' . 'thumb' . intval( $thumb_id ) . '" value="' . esc_attr( intval( $thumb_id ) ) . '" />' . self::make_generate_images_button( $thumb_id ) . ' &nbsp;
						</div>
					</div
					';
			}

			if ( ! $is_the_attachment && empty( $thumbnail_id ) ) {
				$content_button = '';
			}

			if ( ! $is_the_attachment ) {
				$content = $content_button . $content;
			}
		}

		if ( true === $display && true === $is_the_attachment ) {
			// When the button is in the attachment edit screen, we display the buttons.
			echo '<div class="sirsc_button-regenerate-wrap">' . $content_button . '</div>'; // WPCS: XSS OK.
		}

		return $content;
	}

	/**
	 * Return the html code for a button that triggers the image sizes generator.
	 *
	 * @param integer $attachment_id The attachment ID.
	 */
	public static function make_generate_images_button( $attachment_id = 0 ) {
		$button_regenerate = '
		<div class="sirsc_button-regenerate">
			<div id="sirsc_inline_regenerate_sizes' . (int) $attachment_id . '">
				<div class="button-primary button-large" onclick="sirsc_open_details(\'' . (int) $attachment_id . '\')"><div class="dashicons dashicons-format-gallery" title="' . esc_attr__( 'Details/Options', 'sirsc' ) . '"></div> ' . esc_html__( 'Image Details', 'sirsc' ) . '</div>
				<div class="button-primary button-large" onclick="sirsc_start_regenerate(\'' . (int) $attachment_id . '\')"><div class="dashicons dashicons-update" title="' . esc_attr__( 'Regenerate', 'sirsc' ) . '"></div> ' . esc_html__( 'Regenerate', 'sirsc' ) . '</div>
				<div id="sirsc_recordsArray_' . intval( $attachment_id ) . '_result" class="result"><span class="spinner inline off"></span></div>
			</div>
		</div>
		<div class="sirsc_clearAll"></div>';
		return $button_regenerate;
	}

	/**
	 * Return the sirsc_show_ajax_action.
	 *
	 * @param string $callback The callback.
	 * @param string $element  The element.
	 * @param string $target   The target.
	 */
	public static function make_ajax_call( $callback, $element, $target ) {
		$make_ajax_call = "sirsc_show_ajax_action('" . $callback . "', '" . $element . "', '" . $target . "');";
		return $make_ajax_call;
	}

	/**
	 * Return the array of keys=>values from the ajax post.
	 *
	 * @param array $sirsc_data The data.
	 */
	public static function parse_ajax_data( $sirsc_data ) {
		$result = false;
		if ( ! empty( $sirsc_data ) ) {
			$result = array();
			foreach ( $sirsc_data as $v ) {
				$result[ $v['name'] ] = $v['value'];
			}
		}
		return $result;
	}

	/**
	 * Execute and return the response of the callback, if the specified method exists.
	 */
	public static function show_actions_result() {
		if ( ! empty( $_REQUEST['sirsc_data'] ) ) {
			$post_data = self::parse_ajax_data( $_REQUEST['sirsc_data'] );
			if ( ! empty( $post_data['callback'] ) ) {
				if ( method_exists( get_called_class(), $post_data['callback'] ) ) {
					call_user_func( array( get_called_class(), $post_data['callback'] ), $post_data );
				}
			}
		}
		die();
	}

	/**
	 * Return the html code for a button that trriggers the image sizes generator.
	 *
	 * @param integer $attachment_id The attachment ID.
	 * @param string  $size          The size slug.
	 * @param boolean $click         True to append the onclick attribute.
	 * @param string  $selected      Selected crop.
	 */
	public static function make_generate_images_crop( $attachment_id = 0, $size = 'thumbnail', $click = true, $selected = '' ) {
		$id                = intval( $attachment_id ) . $size;
		$action            = ( $click ) ? ' onclick="sirsc_crop_position(\'' . $id . '\');"' : '';
		$button_regenerate = '<table class="sirsc-crop-pos wp-list-table widefat fixed" cellspacing="0" cellpadding="0" title="' . esc_attr__( 'Click to generate a crop of the image from this position', 'sirsc' ) . '">';
		$c                 = 0;
		if ( ! empty( self::$settings['default_crop'][ $size ] ) && empty( $selected ) ) {
			$selected = self::$settings['default_crop'][ $size ];
		}
		$selected = ( empty( $selected ) ) ? 'cc' : $selected;
		$selected = trim( $selected );
		foreach ( self::$crop_positions as $k => $v ) {
			$button_regenerate .= ( 0 === $c % 3 ) ? '<tr>' : '';
			$button_regenerate .= '<td title="' . esc_attr( $v ) . '"><label><input type="radio" name="crop_small_type_' . esc_attr( $size ) . '" id="crop_small_type' . esc_attr( $size ) . $id . '" value="' . esc_attr( $k ) . '"' . $action . ( ( $k === $selected ) ? ' checked="checked"' : '' ) . ' /></label></td>';
			$button_regenerate .= ( 2 === $c % 3 ) ? '</tr>' : '';
			++ $c;
		}
		$button_regenerate .= '</table>';
		return $button_regenerate;
	}

	/**
	 * Return the details about an image size for an image.
	 *
	 * @param string  $filename      The file name.
	 * @param array   $image         The image attributes.
	 * @param string  $size          The image size slug.
	 * @param integer $selected_size The selected image size.
	 */
	public static function allow_resize_from_original( $filename, $image, $size, $selected_size ) {
		$result     = array(
			'found'                => 0,
			'is_crop'              => 0,
			'is_identical_size'    => 0,
			'is_resize'            => 0,
			'is_proportional_size' => 0,
			'width'                => 0,
			'height'               => 0,
			'path'                 => '',
			'url'                  => '',
			'can_be_cropped'       => 0,
			'can_be_generated'     => 0,
			'native_crop_type'     => ( ! empty( $size[ $selected_size ]['crop'] ) ? true : false ),
		);
		$original_w = ( ! empty( $image['width'] ) ) ? $image['width'] : 0;
		$original_h = ( ! empty( $image['height'] ) ) ? $image['height'] : 0;

		$w = ( ! empty( $size[ $selected_size ]['width'] ) ) ? intval( $size[ $selected_size ]['width'] ) : 0;
		$h = ( ! empty( $size[ $selected_size ]['height'] ) ) ? intval( $size[ $selected_size ]['height'] ) : 0;
		$c = ( ! empty( $size[ $selected_size ]['crop'] ) ) ? $size[ $selected_size ]['crop'] : false;
		if ( empty( $image['sizes'][ $selected_size ]['file'] ) ) {
			// Not generated probably.
			if ( ! empty( $c ) ) {
				if ( $original_w >= $w && $original_h >= $h ) {
					$result['can_be_generated'] = 1;
				}
			} else {
				if ( ( 0 === $w && $original_h >= $h ) || ( 0 === $h && $original_w >= $w )
					|| ( 0 !== $w && 0 !== $h && ( $original_w >= $w || $original_h >= $h ) ) ) {
					$result['can_be_generated'] = 1;
				}
			}
		} else {
			$file = str_replace( basename( $filename ), $image['sizes'][ $selected_size ]['file'], $filename );
			if ( file_exists( $file ) ) {
				$c_image_size     = getimagesize( $file );
				$ciw              = intval( $c_image_size[0] );
				$cih              = intval( $c_image_size[1] );
				$result['found']  = 1;
				$result['width']  = $ciw;
				$result['height'] = $cih;
				$result['path']   = $file;
				if ( $ciw === $w && $cih === $h ) {
					$result['is_identical_size'] = 1;
					$result['can_be_cropped']    = 1;
					$result['can_be_generated']  = 1;
				}
				if ( ! empty( $c ) ) {
					$result['is_crop'] = 1;
					if ( $original_w >= $w && $original_h >= $h ) {
						$result['can_be_cropped']   = 1;
						$result['can_be_generated'] = 1;
					}
				} else {
					$result['is_resize'] = 1;
					if ( ( 0 === $w && $cih === $h ) || ( $ciw === $w && 0 === $h ) ) {
						$result['is_proportional_size'] = 1;
						$result['can_be_generated']     = 1;
					} elseif ( 0 !== $w && 0 !== $h && ( $ciw === $w || $cih === $h ) ) {
						$result['is_proportional_size'] = 1;
						$result['can_be_generated']     = 1;
					}
					if ( $original_w >= $w && $original_h >= $h ) {
						$result['can_be_generated'] = 1;
					}
				}
			} else {
				// To do the not exists but size exists.
				if ( ! empty( $c ) ) {
					if ( $original_w >= $w && $original_h >= $h ) {
						$result['can_be_generated'] = 1;
					}
				} else {
					if ( ( 0 === $w && $original_h >= $h ) || ( 0 === $h && $original_w >= $w )
						|| ( 0 !== $w && 0 !== $h && ( $original_w >= $w || $original_h >= $h ) ) ) {
						$result['can_be_generated'] = 1;
					}
				}
			}
		}
		return $result;
	}

	/**
	 * Return the html code that contains the description of the images sizes defined in the application and provides details about the image sizes of an uploaded image.
	 */
	public static function ajax_show_available_sizes() {
		if ( ! empty( $_REQUEST['sirsc_data'] ) ) {
			$post_data = self::parse_ajax_data( $_REQUEST['sirsc_data'] );
			if ( ! empty( $post_data['post_id'] ) ) {
				$post = get_post( $post_data['post_id'] );
				if ( ! empty( $post ) ) {
					self::load_settings_for_post_id( intval( $post_data['post_id'] ) );
					$all_size = self::get_all_image_sizes_plugin();
					$image    = wp_get_attachment_metadata( $post_data['post_id'] );
					$filename = get_attached_file( $post_data['post_id'] );
					if ( ! empty( $filename ) ) :
						$original_w = $image['width'];
						$original_h = $image['height'];
						$folder = str_replace( basename( $image['file'] ), '', $image['file'] );
						$upload_dir   = wp_upload_dir();
						$path = trailingslashit( trailingslashit( $upload_dir['basedir'] ) . $folder );
						$original_filesize = ( ! empty( $image['file'] ) ) ? @filesize( trailingslashit( $upload_dir['basedir'] ) . $image['file'] ) : 0;
						$img_filename = $folder . basename( $filename );
						$img_url = trailingslashit( $upload_dir['baseurl'] ) . $img_filename;
						?>
						<div class="sirsc_under-image-options"></div>
						<div class="sirsc_image-size-selection-box">
							<div class="sirsc_options-title">
								<div class="sirsc_options-close-button-wrap"><a class="sirsc_options-close-button" onclick="sirsc_clear_result('<?php echo (int) $post_data['post_id']; ?>');"><span class="dashicons dashicons-dismiss"></span></a></div>
								<h2><?php esc_html_e( 'Image Details & Options', 'sirsc' ); ?></h2>
								<a onclick="sirsc_open_details('<?php echo (int) $post_data['post_id']; ?>');"><span class="dashicons dashicons-update"></span></a>
							</div>
							<div class="inside">
						<?php if ( ! empty( $all_size ) ) : ?>
							<table class="wp-list-table widefat media the-sisrc-list">
								<thead>
									<tr>
										<th colspan="2"><?php esc_html_e( 'The original image', 'sirsc' ); ?>: <b><?php echo (int) $original_w; ?></b>x<b><?php echo (int) $original_h; ?></b>px, <?php esc_html_e( 'file size', 'sirsc' ); ?>: <b><?php echo self::human_filesize( $original_filesize ); // WPCS: XSS OK. ?></b>.
											<br><?php esc_html_e( 'File', 'sirsc' ); ?>: <a href="<?php echo esc_url( $img_url ); ?>" target="_blank"><div class="dashicons dashicons-admin-links"></div> <?php echo esc_html( $img_filename ); ?></a>
										</th>
									</tr>
									<tr>
										<th class="manage-column"><b><?php esc_html_e( 'Image size details & generated image', 'sirsc' ); ?></b></th>
										<th class="manage-column textcenter" width="120"><b><?php esc_html_e( 'Actions', 'sirsc' ); ?></b></th>
									</tr>
								</thead>
								<tbody id="the-list">
							<?php
							$count = 0;
							foreach ( $all_size as $k => $v ) {
								++ $count;
								$rez_img = self::allow_resize_from_original( $filename, $image, $all_size, $k );
								$action = '';
								$action_title = '';
								if ( ! empty( $rez_img['native_crop_type'] ) ) {
									$action_title = '<span class="sirsc-size-label"><div class="dashicons dashicons-image-crop"></div> ' . esc_html__( 'Crop image', 'sirsc' ) . '</span>';
								} else {
									$action_title = '<span class="sirsc-size-label"><div class="dashicons dashicons-editor-expand"></div> ' . esc_html__( 'Scale image', 'sirsc' ) . '</span>';
								}

								$maybelink = '';
								if ( ! empty( $rez_img['found'] ) ) {
									$ima = wp_get_attachment_image_src( $post_data['post_id'], $k );
									$im  = '<span id="idsrc' . intval( $post_data['post_id'] ) . $k . '"><img src="' . $ima[0] . '?v=' . time() . '" border="0" /><br /> ' . esc_html__( 'Resolution', 'sirsc' ) . ': <b>' . $rez_img['width'] . '</b>x<b>' . $rez_img['height'] . '</b>px</span>';
									$maybelink = '<a href="' . $ima[0] . '?v=' . time() . '" target="_blank"><div class="dashicons dashicons-admin-links"></div></a>';
								} else {
									$im = '<span id="idsrc' . intval( $post_data['post_id'] ) . $k . '">' . esc_html__( 'NOT FOUND', 'sirsc' ) . '</span>';
								}

								if ( ! empty( $rez_img['is_crop'] ) ) {
									if ( ! empty( $rez_img['can_be_cropped'] ) ) {
										$action_title = '<span class="sirsc-size-label"><div class="dashicons dashicons-image-crop"></div> ' . esc_html__( 'Crop image', 'sirsc' ) . '</span>';
										$action .= '<div class="sirsc_clearAll"></div>' . self::make_generate_images_crop( $post_data['post_id'], $k ) . '';
									} else {
										$action_title = '<span class="sirsc-size-label disabled"><div class="dashicons dashicons-image-crop"></div> ' . esc_html__( 'Crop image', 'sirsc' ) . '</span>';
									}
								}

								if ( ! empty( $rez_img['can_be_generated'] ) ) {
									if ( ! empty( $rez_img['native_crop_type'] ) ) {
										$action_title = '<span class="sirsc-size-label"><div class="dashicons dashicons-image-crop"></div> ' . esc_html__( 'Crop image', 'sirsc' ) . '</span>';
									} else {
										$action_title = '<span class="sirsc-size-label"><div class="dashicons dashicons-editor-expand"></div> ' . esc_html__( 'Scale image', 'sirsc' ) . '</span>';
									}
									$iddd    = intval( $post_data['post_id'] ) . $k;
									$action .= '<div class="sirsc_clearAll"></div><a class="button" onclick="sirsc_start_regenerate(\'' . $iddd . '\');"><b class="dashicons dashicons-update"></b> ' . esc_html__( 'Regenerate', 'sirsc' ) . '</a>';
								} else {
									if ( ! empty( $rez_img['native_crop_type'] ) ) {
										$action_title = '<span class="sirsc-size-label disabled"><div class="dashicons dashicons-image-crop"></div> ' . esc_html__( 'Crop image', 'sirsc' ) . '</span>';
									} else {
										$action_title = '<span class="sirsc-size-label disabled"><div class="dashicons dashicons-editor-expand"></div> ' . esc_html__( 'Scale image', 'sirsc' ) . '</span>';
									}

									$action .= '<table class="wp-list-table widefat fixed "><tr><td>' . esc_html__( 'Cannot be generated, the original image is smaller than the requested size.', 'sirsc' ) . '</td></tr></table>';
								}

								$cl        = ( 1 === $count % 2 ) ? 'alternate' : '';
								$size_text = self::size_to_text( $v );

								$size_quality = ( empty( self::$settings['default_quality'][ $k ] ) ) ? 100 : (int) self::$settings['default_quality'][ $k ];

								$filesize = ( ! empty( $image['sizes'][ $k ]['file'] ) ) ? @filesize( $path . $image['sizes'][ $k ]['file'] ) : 0;

								echo '<tr class="' . $cl . ' textright bottom-border"><td><b class="sirsc-size-label size"><span id="idsrc' . (int) $post_data['post_id'] . $k . '-url">' . $maybelink . '</span>' . $k . '</b> <span class="sirsc-small-info">' . esc_html__( 'Info', 'sirsc' ) . ': ' . $size_text . '</span></td><td width="120" class="textleft">' . $action_title . '<span class="sirsc-small-info">' . esc_html__( 'Quality', 'sirsc' ) . ': <b>' . $size_quality . '%</b></span>
								</td></tr>
								<tr class="' . $cl . '" id="sirsc_recordsArray_' . (int) $post_data['post_id'] . $k . '">
									<input type="hidden" name="post_id" id="post_id' . (int) $post_data['post_id'] . $k . '" value="' . (int) $post_data['post_id'] . '" />
									<input type="hidden" name="selected_size" id="selected_size' . (int) $post_data['post_id'] . $k . '" value="' . $k . '" />
									<td class="image-src-column"><div class="result_inline"><div id="sirsc_recordsArray_' . (int) $post_data['post_id'] . $k . '_result" class="result inline"><span class="spinner off"></span></div></div>' . $im . '<br><span class="image-size-column">' . esc_html__( 'File size', 'sirsc' ) . ': <b class="image-file-size">' . self::human_filesize( $filesize ) . '</b></span>
									</td>
									<td class="sirsc_image-action-column">' . $action . '</td>
								</tr>'; // WPCS: XSS OK.
							}
							echo '
								</tbody>
							</table>';
						endif;

						echo '</div></div>';
						echo '<script>
						jQuery(document).ready(function () {
							sirsc_arrange_center_element(\'.sirsc_image-size-selection-box\');
						 });</script>';
					else :
						?>
						<span class="sirsc_successfullysaved"><?php esc_html__( 'The file is missing!', 'sirsc' ); ?></span>
						<?php
					endif;
				}
			} else {
				echo '<span class="sirsc_successfullysaved">' . esc_html__( 'Something went wrong!', 'sirsc' ) . '</span>';
			}
		}
	}

	/**
	 * Return hmain readable files size.
	 *
	 * @access public
	 * @static
	 *
	 * @param  integer $bytes    Bytes.
	 * @param  integer $decimals Decimals.
	 *
	 * @return string
	 */
	public static function human_filesize( $bytes, $decimals = 2 ) {
		if ( empty( $bytes ) ) {
			return esc_html__( 'N/A', 'sirsc' );
		}
		$sz = 'BKMGTP';
		$factor = floor( ( strlen( $bytes ) - 1 ) / 3 );
		return sprintf( "%.{$decimals}f", $bytes / pow( 1024, $factor ) ) . @$sz[ $factor ];
	}
	/**
	 * Regenerate the image sizes for a specified image.
	 */
	public static function ajax_process_image_sizes_on_request() {
		if ( ! empty( $_REQUEST['sirsc_data'] ) ) {
			$post_data = self::parse_ajax_data( $_REQUEST['sirsc_data'] );
			if ( ! empty( $post_data['post_id'] ) ) {
				$post = get_post( $post_data['post_id'] );
				if ( ! empty( $post ) ) {
					self::load_settings_for_post_id( (int) $post_data['post_id'] );
					$sizes           = ( ! empty( $post_data['selected_size'] ) ) ? $post_data['selected_size'] : 'all';
					$crop_small_type = ( ! empty( $post_data[ 'crop_small_type_' . $sizes ] ) ) ? $post_data[ 'crop_small_type_' . $sizes ] : '';
					self::make_images_if_not_exists( $post_data['post_id'], $sizes, $crop_small_type );

					if ( 'all' !== $sizes ) {
						$image       = wp_get_attachment_metadata( $post_data['post_id'] );
						$th          = wp_get_attachment_image_src( $post_data['post_id'], $sizes );
						$th_src      = $th[0];
						$crop_table  = '';
						$tmp_details = self::get_all_image_sizes( $sizes );
						if ( ! empty( $tmp_details['crop'] ) ) {
							$crop_table = '<div class="sirsc_clearAll"></div>' . preg_replace( '/[\x00-\x1F\x80-\xFF]/', '', self::make_generate_images_crop( (int) $post_data['post_id'], $sizes ) ) . '<div class="sirsc_clearAll"></div><a class="button" onclick="sirsc_start_regenerate(\'' . (int) $post_data['post_id'] . $sizes . '\');"><b class="dashicons dashicons-update"></b> Regenerate</a>';
						}

						$filesize = 0;
						if ( ! empty( $th_src ) ) {
							$original_w = $image['width'];
							$original_h = $image['height'];
							$folder = str_replace( basename( $image['file'] ), '', $image['file'] );
							$upload_dir   = wp_upload_dir();
							$path = trailingslashit( trailingslashit( $upload_dir['basedir'] ) . $folder );
							$filesize = ( ! empty( $th_src ) ) ? @filesize( str_replace( $upload_dir['baseurl'], $upload_dir['basedir'], $th_src ) ) : 0;
						}

						echo '<script>
						jQuery(document).ready(function () {
							sirsc_thumbnail_details(\'' . intval( $post_data['post_id'] ) . '\', \'' . $sizes . '\', \'' . $th_src . '?v=' . time() . '\', \'' . $image['sizes'][ $sizes ]['width'] . '\', \'' . $image['sizes'][ $sizes ]['height'] . '\', \'' . addslashes( $crop_table ) . '\');
							jQuery(\'#sirsc_recordsArray_' . $post_data['post_id'] . $post_data['selected_size'] . ' .image-file-size\').html(\'' . self::human_filesize( $filesize ) . '\');
						});
						</script>'; // WPCS: XSS OK.
					}
					echo '<span class="sirsc_successfullysaved">' . esc_html__( 'Done!', 'sirsc' ) . '</span>';
				}
			} else {
				echo '<span class="sirsc_successfullysaved">' . esc_html__( 'Something went wrong!', 'sirsc' ) . '</span>';
			}
		}
	}

	/**
	 * Check if an image size should be generated or not for image meta.
	 *
	 * @param array  $image    The image metadata.
	 * @param string $sname    Image size slug.
	 * @param array  $sval     The image size detail.
	 * @param string $filename Image filename.
	 * @return boolean
	 */
	public static function check_if_execute_size( $image = array(), $sname = '', $sval = array(), $filename = '' ) {
		$execute = false;
		if ( empty( $image['sizes'][ $sname ] ) ) {
			$execute = true;
		} else {
			// Check if the file does exist, else generate it.
			if ( empty( $image['sizes'][ $sname ]['file'] ) ) {
				$execute = true;
			} else {
				$file = str_replace( basename( $filename ), $image['sizes'][ $sname ]['file'], $filename );
				if ( ! file_exists( $file ) ) {
					$execute = true;
				} else {
					// Check if the file does exist and has the required width and height.
					$w = ( ! empty( $sval['width'] ) ) ? (int) $sval['width'] : 0;
					$h = ( ! empty( $sval['height'] ) ) ? (int) $sval['height'] : 0;
					$c = ( ! empty( $sval['crop'] ) ) ? $sval['crop'] : false;

					$c_image_size = getimagesize( $file );
					$ciw          = (int) $c_image_size[0];
					$cih          = (int) $c_image_size[1];
					if ( ! empty( $c ) ) {
						if ( $w !== $ciw || $h !== $cih ) {
							$execute = true;
						}
					} else {
						if ( ( 0 === $w && $cih <= $h )
							|| ( 0 === $h && $ciw <= $w )
							|| ( 0 !== $w && 0 !== $h && $ciw <= $w && $cih <= $h ) ) {
							$execute = true;
						}
					}
				}
			}
		}
		return $execute;
	}

	/**
	 * Create the image for a specified attachment and image size if that does not exist and update the image metadata. This is useful for example in the cases when the server configuration does not permit to generate many images from a single uploaded image (timeouts or image sizes defined after images have been uploaded already). This should be called before the actual call of wp_get_attachment_image_src with a specified image size
	 *
	 * @param integer $id            Id of the attachment.
	 * @param array   $selected_size The set of defined image sizes used by the site.
	 * @param array   $small_crop    The position of a potential crop (lt = left/top, lc = left/center, etc.).
	 */
	public static function make_images_if_not_exists( $id, $selected_size = 'all', $small_crop = '' ) {
		try {
			$execute_crop = false;
			self::load_settings_for_post_id( $id );

			$alls = self::get_all_image_sizes_plugin();
			if ( 'all' === $selected_size ) {
				$sizes = $alls;
				if ( ! empty( self::$settings['complete_global_ignore'] ) ) {
					foreach ( self::$settings['complete_global_ignore'] as $ign ) {
						unset( $sizes[ $ign ] );
					}
				}
				if ( ! empty( self::$settings['restrict_sizes_to_these_only'] ) ) {
					foreach ( $sizes as $s => $v ) {
						if ( ! in_array( $s, self::$settings['restrict_sizes_to_these_only'] ) ) {
							unset( $sizes[ $s ] );
						}
					}
				}
			} else {
				if ( ! empty( $selected_size ) && ! empty( $alls[ $selected_size ] ) ) {
					// Force original also for the already uploaded images.
					if ( ! empty( self::$settings['force_original_to'] )
						&& $selected_size === self::$settings['force_original_to'] ) {
						$size = self::get_all_image_sizes( self::$settings['force_original_to'] );
						self::process_image_resize_brute( $id, $size['width'], $size['height'], $selected_size );
					}
					$sizes = array(
						$selected_size => $alls[ $selected_size ],
					);

					$execute_crop = true;
					if ( empty( $small_crop ) && ! empty( self::$settings['default_crop'][ $selected_size ] ) ) {
						$small_crop = self::$settings['default_crop'][ $selected_size ];
					}
				}
			}
			if ( ! empty( $sizes ) ) {
				$image    = wp_get_attachment_metadata( $id );
				$filename = get_attached_file( $id );
				if ( ! empty( $filename ) ) {
					foreach ( $sizes as $sname => $sval ) {
						$execute = self::check_if_execute_size( $image, $sname, $sval, $filename );
						if ( ! empty( $execute ) ) {
							$w = ( ! empty( $sval['width'] ) ) ? (int) $sval['width'] : 0;
							$h = ( ! empty( $sval['height'] ) ) ? (int) $sval['height'] : 0;
							$c = ( ! empty( $sval['crop'] ) ) ? $sval['crop'] : false;

							$new_meta = image_make_intermediate_size( $filename, $w, $h, $c );
							if ( ! empty( $new_meta ) && is_array( $new_meta ) ) {
								if ( ! empty( $new_meta['width'] ) && ! empty( $image['width'] )
									&& (int) $new_meta['width'] === (int) $image['width']
									&& (int) $new_meta['height'] === (int) $image['height'] ) {
									// The image is the same as the original one.
									if ( basename( $filename ) !== $new_meta['file'] ) {
										$tmp = str_replace( basename( $filename ), $new_meta['file'], $filename );
										unlink( $tmp );

										$image['sizes'][ $sname ]         = $new_meta;
										$image['sizes'][ $sname ]['file'] = basename( $filename );
										wp_update_attachment_metadata( $id, $image );
									}
								} else {
									$img_meta = $image; // Re-use the metadata.
									if ( ! empty( $img_meta ) ) {
										if ( empty( $img_meta['sizes'] ) ) {
											$img_meta['sizes'] = array();
										}
										$img_meta['sizes'][ $sname ] = $new_meta;
										wp_update_attachment_metadata( $id, $img_meta );
									} else {
										error_log( 'The media ' . (int) $id . ' has errors in the metadata. This could not be updated.' );
										// Attempt to create fallback.
										self::attempt_to_create_metadata( $id );
									}
									// Refresh the local metadata after the update.
									$image = wp_get_attachment_metadata( $id );
								}
							} else {
								// Let's check if there is already an image with the same size but under different size name (in order to update the attachment metadata in a proper way) as in this case the image_make_intermediate_size will not return anything as the image with the specified parameters already exists.
								$found_one      = false;
								$all_know_sizes = ( ! empty( $image['sizes'] ) ) ? $image['sizes'] : array();
								$img_meta       = wp_get_attachment_metadata( $id );
								if ( empty( $img_meta['file'] ) ) {
									error_log( 'The media ' . (int) $id . ' has errors in the metadata. This could not be updated.' );
									continue;
								}

								// We can use the original size if this is a match for the missing generated image size.
								$all_know_sizes['**full**'] = array(
									'file'   => basename( $img_meta['file'] ),
									'width'  => ( ! empty( $img_meta['width'] ) ) ? (int) $img_meta['width'] : 0,
									'height' => ( ! empty( $img_meta['height'] ) ) ? (int) $img_meta['height'] : 0,
								);
								// This is a strange case when the image size is only a DPI resolution variation.
								if ( 0 === $w && 0 === $h ) {
									$w = $all_know_sizes['**full**']['width'];
									$h = $all_know_sizes['**full**']['height'];
								}
								if ( true === $c ) {
									// We are looking for a perfect match image.
									foreach ( $all_know_sizes as $aisv ) {
										if ( (int) $aisv['width'] === $w && (int) $aisv['height'] === $h ) {
											$tmpfile = str_replace( basename( $filename ), $aisv['file'], $filename );
											if ( file_exists( $tmpfile ) ) {
												$found_one = $aisv;
												break;
											}
										}
									}
								} else {
									if ( 0 === $w ) {
										// For scale to maximum height.
										foreach ( $all_know_sizes as $aisv ) {
											if ( (int) $aisv['height'] === $h && 0 !== (int) $aisv['width'] ) {
												$tmpfile = str_replace( basename( $filename ), $aisv['file'], $filename );
												if ( file_exists( $tmpfile ) ) {
													$found_one = $aisv;
													break;
												}
											}
										}
									} elseif ( 0 === $h ) {
										// For scale to maximum width.
										foreach ( $all_know_sizes as $aisv ) {
											if ( (int) $aisv['width'] === $w && 0 !== (int) $aisv['height'] ) {
												$tmpfile = str_replace( basename( $filename ), $aisv['file'], $filename );
												if ( file_exists( $tmpfile ) ) {
													$found_one = $aisv;
													break;
												}
											}
										}
									} else {
										// For scale to maximum width or maximum height.
										foreach ( $all_know_sizes as $aisv ) {
											if ( ( (int) $aisv['height'] === $h && 0 !== (int) $aisv['width'] )
												|| ( (int) $aisv['width'] === $w && 0 !== (int) $aisv['height'] ) ) {
												$tmpfile = str_replace( basename( $filename ), $aisv['file'], $filename );
												if ( file_exists( $tmpfile ) ) {
													$found_one = $aisv;
													break;
												}
											}
										}
									}
								}
								if ( $found_one ) {
									$img_meta                    = wp_get_attachment_metadata( $id );
									$img_meta['sizes'][ $sname ] = $found_one;
									wp_update_attachment_metadata( $id, $img_meta );
								}
							}
						}

						// Re-cut the specified image size to the specified position.
						if ( $selected_size && ! empty( $small_crop ) ) {
							if ( $selected_size === $sname ) {
								$w   = ( ! empty( $sval['width'] ) ) ? (int) $sval['width'] : 0;
								$h   = ( ! empty( $sval['height'] ) ) ? (int) $sval['height'] : 0;
								$c   = self::identify_crop_pos( $sname, $small_crop );
								$img = wp_get_image_editor( $filename );
								if ( ! is_wp_error( $img ) ) {
									$img->resize( $w, $h, $c );
									$maybe_quality = ( ! empty( self::$settings['default_quality'][ $selected_size ] ) ) ? (int) self::$settings['default_quality'][ $selected_size ] : 100;
									$maybe_quality = ( $maybe_quality < 10 || $maybe_quality > 100 ) ? 100 : $maybe_quality;
									$img->set_quality( $maybe_quality );
									$saved = $img->save();
									if ( ! empty( $saved ) ) {
										$img_meta = wp_get_attachment_metadata( $id );
										if ( empty( $img_meta ) ) {
											$img_meta = $image;
										}
										if ( ! empty( $img_meta['sizes'] ) ) {
											$img_meta['sizes'][ $sname ] = $saved;
											wp_update_attachment_metadata( $id, $img_meta );
										}
									}
								}
							}
						}
					}
				}
			}
		} catch ( ErrorException $e ) {
			error_log( 'sirsc exception ' . print_r( $e, 1 ) );
		}
	}

	/**
	 * Attempts to create metadata from file if that exists for an id.
	 *
	 * @param integer $id Attachment post id.
	 */
	public static function attempt_to_create_metadata( $id ) {
		$fname = get_attached_file( $id );
		if ( ! empty( $fname ) ) {
			if ( file_exists( $fname ) ) {
				$fsize = getimagesize( $fname );
				$upls  = wp_upload_dir();
				wp_update_attachment_metadata( $id, array(
					'width'  => $fsize[0],
					'height' => $fsize[1],
					'path'   => str_replace( trailingslashit( $upls['basedir'] ), '', $fname ),
				) );
			}
		}
	}

	/**
	 * Returns a text description of an image size details.
	 *
	 * @param array $v Image size details.
	 */
	public static function size_to_text( $v ) {
		if ( 0 === (int) $v['height'] ) {
			$size_text = '<b>' . esc_html__( 'scale', 'sirsc' ) . '</b> ' . esc_html__( 'to max width of', 'sirsc' ) . ' <b>' . $v['width'] . '</b>px';
		} elseif ( 0 === (int) $v['width'] ) {
			$size_text = '<b>' . esc_html__( 'scale', 'sirsc' ) . '</b> ' . esc_html__( 'to max height of', 'sirsc' ) . ' <b>' . $v['height'] . '</b>px';
		} else {
			if ( ! empty( $v['crop'] ) ) {
				$size_text = '<b>' . esc_html__( 'crop', 'sirsc' ) . '</b> ' . esc_html__( 'of', 'sirsc' ) . ' <b>' . $v['width'] . '</b>x<b>' . $v['height'] . '</b>px';
			} else {
				$size_text = '<b>' . esc_html__( 'scale', 'sirsc' ) . '</b> ' . esc_html__( 'to max width of', 'sirsc' ) . ' <b>' . $v['width'] . '</b>px ' . esc_html__( 'or to max height of', 'sirsc' ) . ' <b>' . $v['height'] . '</b>px';
			}
		}
		return $size_text;
	}

	/**
	 * Returns an array of all the image sizes registered in the application.
	 *
	 * @param string $size Image size slug.
	 */
	public static function get_all_image_sizes( $size = '' ) {
		global $_wp_additional_image_sizes;
		$sizes = array();
		$get_intermediate_image_sizes = get_intermediate_image_sizes();
		// Create the full array with sizes and crop info.
		foreach ( $get_intermediate_image_sizes as $_size ) {
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ), true ) ) {
				$sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
				$sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
				$sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
				);
			}
		}
		if ( $size ) { // Get only 1 size if found.
			if ( isset( $sizes[ $size ] ) ) {
				return $sizes[ $size ];
			} else {
				return false;
			}
		}
		return $sizes;
	}

	/**
	 * Returns an array of all the image sizes registered in the application filtered by the plugin settings and for a specified image size name.
	 *
	 * @param string $size Image size slug.
	 */
	public static function get_all_image_sizes_plugin( $size = '' ) {
		$sizes = self::get_all_image_sizes( $size );
		if ( ! empty( self::$settings['exclude'] ) ) {
			$new_sizes = array();
			foreach ( $sizes as $k => $si ) {
				if ( ! in_array( $k, self::$settings['exclude'] ) ) {
					$new_sizes[ $k ] = $si;
				}
			}
			$sizes = $new_sizes;
		}
		if ( $size ) { // Get only 1 size if found.
			if ( isset( $sizes[ $size ] ) ) {
				return $sizes[ $size ];
			} else {
				return false;
			}
		}
		return $sizes;
	}

	/**
	 * Returns an array of all the post types allowed in the plugin filters.
	 */
	public static function get_all_post_types_plugin() {
		$post_types = get_post_types( array(), 'objects' );
		if ( ! empty( $post_types ) && ! empty( self::$exclude_post_type ) ) {
			foreach ( self::$exclude_post_type as $k ) {
				unset( $post_types[ $k ] );
			}
		}
		return $post_types;
	}

	/**
	 * Returns the number if images of "image size name" that can be clean up for a specified post type if is set, or the global number of images that can be clean up for the "image size name".
	 *
	 * @param string  $post_type       The post type.
	 * @param string  $image_size_name The size slug.
	 * @param integer $next_post_id    The next post to be processed.
	 */
	public static function calculate_total_to_cleanup( $post_type = '', $image_size_name = '', $next_post_id = 0 ) {
		global $wpdb;
		$total_to_delete = 0;
		if ( ! empty( $image_size_name ) ) {
			$cond_join = '';
			$cond_where = '';
			if ( ! empty( $post_type ) ) {
				$cond_join = ' LEFT JOIN ' . $wpdb->posts . ' as parent ON( parent.ID = p.post_parent )';
				$cond_where = $wpdb->prepare( ' AND parent.post_type = %s ', $post_type );
			}
			$tmp_query = $wpdb->prepare( ' SELECT count( p.ID ) as total_to_delete FROM ' . $wpdb->posts . ' as p LEFT JOIN ' . $wpdb->postmeta . ' as pm ON(pm.post_id = p.ID) ' . $cond_join . ' WHERE pm.meta_key like %s AND pm.meta_value like %s AND p.ID > %d ' . $cond_where,
				'_wp_attachment_metadata',
				'%' . $image_size_name . '%',
				intval( $next_post_id )
			); // WPCS: Unprepared SQL OK.
			$rows = $wpdb->get_results( $tmp_query, ARRAY_A ); // PHPCS:ignore WordPress.WP.PreparedSQL.NotPrepared
			if ( ! empty( $rows ) && is_array( $rows ) ) {
				$total_to_delete = $rows[0]['total_to_delete'];
			}
		}
		return $total_to_delete;
	}

	/**
	 * Remove the images from the folders and database records for the specified image size name.
	 */
	public static function ajax_cleanup_image_sizes_on_request() {
		if ( ! empty( $_REQUEST['sirsc_data'] ) ) {
			$post_data = self::parse_ajax_data( $_REQUEST['sirsc_data'] );
			if ( ! empty( $post_data['_sisrsc_image_size_name'] ) ) {
				global $wpdb;
				$_sisrsc_image_size_name = ( ! empty( $post_data['_sisrsc_image_size_name'] ) ) ? $post_data['_sisrsc_image_size_name'] : '';
				$_sisrsc_post_type       = ( ! empty( $post_data['_sisrsc_post_type'] ) ) ? $post_data['_sisrsc_post_type'] : '';
				$next_post_id            = ( ! empty( $post_data['_sisrsc_image_size_name_page'] ) ) ? $post_data['_sisrsc_image_size_name_page'] : 0;
				$max_in_one_go           = 10;
				$total_to_delete         = self::calculate_total_to_cleanup( $_sisrsc_post_type, $post_data['_sisrsc_image_size_name'], $next_post_id );
				$remaining_to_delete     = $total_to_delete;
				if ( $total_to_delete > 0 ) {
					$cond_join  = '';
					$cond_where = '';
					if ( ! empty( $_sisrsc_post_type ) ) {
						$cond_join  = ' LEFT JOIN ' . $wpdb->posts . ' as parent ON( parent.ID = p.post_parent ) ';
						$cond_where = $wpdb->prepare( ' AND parent.post_type = %s ', $_sisrsc_post_type );
					}
					echo '
					<div class="sirsc_under-image-options"></div>
					<div class="sirsc_image-size-selection-box">
						<div class="sirsc_options-title">
							<div class="sirsc_options-close-button-wrap"><a class="sirsc_options-close-button" onclick="jQuery(\'#_sirsc_cleanup_initiated_for_' . esc_attr( $post_data['_sisrsc_image_size_name'] ) . '_result\').html(\'\');"><span class="dashicons dashicons-dismiss"></span></a></div>
							<h2>' . esc_html__( 'REMAINING TO CLEAN UP', 'sirsc' ) . ': ' . $total_to_delete . '</h2>
						</div>
						<div class="inside">'; // WPCS: XSS OK.
					$rows = $wpdb->get_results( $wpdb->prepare( ' SELECT p.ID FROM ' . $wpdb->posts . ' as p LEFT JOIN ' . $wpdb->postmeta . ' as pm ON(pm.post_id = p.ID) ' . $cond_join . ' WHERE pm.meta_key like %s AND pm.meta_value like %s AND p.ID > %d ' . $cond_where . ' ORDER BY pm.meta_id ASC LIMIT 0, %d ',
						'_wp_attachment_metadata',
						'%' . $post_data['_sisrsc_image_size_name'] . '%',
						(int) $next_post_id,
						(int) $max_in_one_go
					), ARRAY_A ); // WPCS: Unprepared SQL OK.
					if ( ! empty( $rows ) && is_array( $rows ) ) {
						echo '<b class="spinner inline"></b><br /><ul>';
						foreach ( $rows as $v ) {
							echo '<li><hr />';
							$image_meta = wp_get_attachment_metadata( $v['ID'] );
							$filename = realpath( get_attached_file( $v['ID'] ) );
							$unset = false;
							$deleted = false;
							if ( ! empty( $filename ) ) {
								$string = ( ! empty( $image_meta['sizes'][ $_sisrsc_image_size_name ]['file'] ) ) ? $image_meta['sizes'][ $_sisrsc_image_size_name ]['file'] : '';
								$file = str_replace( basename( $filename ), $string, $filename );
								$file = realpath( $file );
								$th = wp_get_attachment_image_src( $v['ID'], $_sisrsc_image_size_name );
								$th_src = $th[0];
								if ( file_exists( $file ) && $file != $filename ) {
									/** Make sure not to delete the original file */
									echo __( 'The image ', 'sirsc' ) . ' <b>' . $th_src . '</b> ' . esc_html__( 'has been deleted.', 'sirsc' ); // WPCS: XSS OK.
									@unlink( $file );
									$unset = true;
									$deleted = true;
								} else {
									echo esc_html__( 'The image', 'sirsc' ) . ' <b>' . $th_src . '</b> ' . esc_html__( 'could not be deleted (it is the original file).', 'sirsc' ); // WPCS: XSS OK.
								}
							}
							if ( $unset ) {
								unset( $image_meta['sizes'][ $_sisrsc_image_size_name ] );
								wp_update_attachment_metadata( $v['ID'], $image_meta );
							} else {
								unset( $image_meta['sizes'][ $_sisrsc_image_size_name ] );
								wp_update_attachment_metadata( $v['ID'], $image_meta );
								if ( ! $deleted ) {
									echo esc_html__( 'The image', 'sirsc' ) . ' ' . $_sisrsc_image_size_name . ' ' . esc_html__( ' could not be found.', 'sirsc' ); // WPCS: XSS OK.
								}
							}
							-- $remaining_to_delete;
							$next_post_id = $v['ID'];
							echo '</li>';
						}
						echo '</ul>';
					}
					echo '
						</div>
					</div>';
				}
				if ( $remaining_to_delete > 0 ) {
					echo '<script>
					jQuery(document).ready(function () {
						sirsc_continue_cleanup(\'' . esc_attr( $_sisrsc_image_size_name ) . '\', \'' . intval( $next_post_id ) . '\');
					 }).delay(2000);
					</script>';
				} else {
					echo '
					<script>
					jQuery(document).ready(function () {
						sirsc_finish_cleanup(\'' . esc_attr( $_sisrsc_image_size_name ) . '\');
					}).delay(4000);
					</script>';
					echo '<span class="sirsc_successfullysaved">' . esc_html__( 'Done!', 'sirsc' ) . '</span>';
				}
			} else {
				echo '<span class="sirsc_successfullysaved">' . esc_html__( 'Something went wrong!', 'sirsc' ) . '</span>';
			}
		}
	}

	/**
	 * Regenerate all the images for the specified image size name.
	 */
	public static function ajax_regenerate_image_sizes_on_request() {
		if ( ! empty( $_REQUEST['sirsc_data'] ) ) {
			$post_data = self::parse_ajax_data( $_REQUEST['sirsc_data'] );
			if ( ! empty( $post_data['_sisrsc_regenerate_image_size_name'] ) ) {
				global $wpdb;
				$_sisrsc_post_type = ( ! empty( $post_data['_sisrsc_post_type'] ) ) ? $post_data['_sisrsc_post_type'] : '';
				$cond_join         = '';
				$cond_where        = '';
				if ( ! empty( $_sisrsc_post_type ) ) {
					$cond_join  = ' LEFT JOIN ' . $wpdb->posts . ' as parent ON( parent.ID = p.post_parent ) ';
					$cond_where = $wpdb->prepare( ' AND parent.post_type = %s ', $_sisrsc_post_type );
				}
				$next_post_id    = ( ! empty( $post_data['_sisrsc_regenerate_image_size_name_page'] ) ) ? $post_data['_sisrsc_regenerate_image_size_name_page'] : 0;
				$total_to_update = 0;
				$image_size_name = $post_data['_sisrsc_regenerate_image_size_name'];
				$use_condition   = ! empty( $post_data['_sisrsc_regenerate_image_size_name_page'] ) ? true : false;

				$rows = $wpdb->get_results( $wpdb->prepare( ' SELECT count(p.ID) as total_to_update FROM ' . $wpdb->posts . ' as p ' . $cond_join . ' WHERE p.ID > %d AND ( p.post_mime_type like %s OR p.post_mime_type like %s OR p.post_mime_type like %s )' . $cond_where . ' ORDER BY p.ID ASC ', (int) $next_post_id, 'image/gif', 'image/jpeg', 'image/png' ), ARRAY_A ); // WPCS: Unprepared SQL OK.
				if ( ! empty( $rows ) && is_array( $rows ) ) {
					$total_to_update = $rows[0]['total_to_update'];
				}
				if ( $total_to_update > 0 ) {
					echo '
					<div class="sirsc_under-image-options"></div>
					<div class="sirsc_image-size-selection-box">
						<div class="sirsc_options-title">
							<div class="sirsc_options-close-button-wrap"><a class="sirsc_options-close-button" onclick="sirsc_finish_regenerate(\'' . esc_attr( $image_size_name ) . '\'); "><span class="dashicons dashicons-dismiss"></span></a></div>
							<h2>' . esc_html__( 'REMAINING TO REGENERATE', 'sirsc' ) . ': ' . (int) $total_to_update . '</h2>
						</div>
						<div class="inside">';
					$rows = $wpdb->get_results( $wpdb->prepare( ' SELECT p.ID FROM ' . $wpdb->posts . ' as p ' . $cond_join . ' WHERE p.ID > %d AND ( p.post_mime_type like %s OR p.post_mime_type like %s OR p.post_mime_type like %s )' . $cond_where . ' ORDER BY p.ID ASC LIMIT 0, 1', (int) $next_post_id, 'image/gif', 'image/jpeg', 'image/png' ), ARRAY_A ); // WPCS: Unprepared SQL OK.
					if ( ! empty( $rows ) && is_array( $rows ) ) {
						foreach ( $rows as $v ) {
							echo '<center><hr />';
							$filename = get_attached_file( $v['ID'] );
							if ( ! empty( $filename ) && file_exists( $filename ) ) {
								self::make_images_if_not_exists( $v['ID'], $image_size_name );
								$image = wp_get_attachment_metadata( $v['ID'] );
								$th = wp_get_attachment_image_src( $v['ID'], $image_size_name );
								if ( ! empty( $th[0] ) ) {
									$th_src = $th[0];
									echo '<span class="imagewrap"><img src="' . $th_src . '?cache=' . time() . '" /><b class="spinner inline"></b></span><hr />' . $th_src; // WPCS: XSS OK.
								} else {
									echo esc_html__( 'Could not generate, the original is too small.', 'sirsc' ) . '<hr />';
								}
							} else {
								echo esc_html__( 'Could not generate, the original file is missing.', 'sirsc' ) . '<hr />' . $filename; // WPCS: XSS OK.
							}
							echo '</center>';
							$next_post_id = $v['ID'];
						}
					}
					echo '</div></div>';
				}
				$remaining_to_update = $total_to_update - 1;
				if ( $remaining_to_update >= 0 ) {
					echo '<script>jQuery(document).ready(function () {';
					if ( $use_condition ) {
						echo '
						if ( \'0\' != jQuery(\'#_sisrsc_regenerate_image_size_name_page' . esc_attr( $image_size_name ) . '\').val() ) {
							sirsc_continue_regenerate(\'' . esc_attr( $image_size_name ) . '\', \'' . intval( $next_post_id ) . '\');
						}';
					} else {
						echo 'sirsc_continue_regenerate(\'' . esc_attr( $image_size_name ) . '\', \'' . intval( $next_post_id ) . '\'); ';
					}
					echo '
					}).delay(2000); </script>';
				} else {
					echo '
					<script>
					jQuery(document).ready(function () {
						sirsc_finish_regenerate(\'' . esc_attr( $image_size_name ) . '\');
					}).delay(4000);
					</script>';
					echo '<span class="sirsc_successfullysaved">' . esc_html__( 'Done!', 'sirsc' ) . '</span>';
				}
			} else {
				echo '<span class="sirsc_successfullysaved">' . esc_html__( 'Something went wrong!', 'sirsc' ) . '</span>';
			}
		}
	}

	/**
	 * Replace all the front side images retrieved programmatically with wp function with the placeholders instead of the full size image.
	 *
	 * @param string  $f  The file.
	 * @param integer $id The pot ID.
	 * @param string  $s  The size slug.
	 */
	public static function image_downsize_placeholder_force_global( $f, $id, $s ) {
		$img_url = self::image_placeholder_for_image_size( $s );
		$size    = self::get_all_image_sizes( $s );
		return array( $img_url, $size['width'], $size['height'], true );
	}

	/**
	 * SIRSC_Image_Regenerate_Select_Crop::image_downsize_placeholder_only_missing() Replace the missing images sizes with the placeholders instead of the full size image. As the "image size name" is specified, we know what width and height the resulting image should have. Hence, first, the potential image width and height are matched against the entire set of image sizes defined in order to identify if there is the exact required image either an alternative file with the specific required width and height already generated for that width and height but with another "image size name" in the database or not. Basically, the first step is to identify if there is an image with the required width and height. If that is identified, it will be presented, regardless of the fact that the "image size name" is the requested one or it is not even yet defined for this specific post (due to a later definition of the image in the project development). If the image to be presented is not identified at any level, then the code is trying to identify the appropriate theme placeholder for the requested "image size name". For that we are using the placeholder function with the requested "image size name". If the placeholder exists, then this is going to be presented, else we are logging the missing placeholder alternative that can be added in the image_placeholder_for_image_size function.
	 *
	 * @param string  $f  The file.
	 * @param integer $id The pot ID.
	 * @param string  $s  The size slug.
	 */
	public static function image_downsize_placeholder_only_missing( $f, $id, $s ) {
		$all_sizes = self::get_all_image_sizes();
		if ( 'full' !== $s && ! empty( $all_sizes[ $s ] ) ) {
			try {
				$execute    = false;
				$image      = wp_get_attachment_metadata( $id );
				$filename   = get_attached_file( $id );
				$rez_img    = self::allow_resize_from_original( $filename, $image, $all_sizes, $s );
				$upload_dir = wp_upload_dir();
				if ( ! empty( $rez_img['found'] ) ) {
					$url         = str_replace( $upload_dir['basedir'], $upload_dir['baseurl'], $rez_img['path'] );
					$crop        = ( ! empty( $rez_img['is_crop'] ) ) ? true : false;
					$alternative = array( $url, $rez_img['width'], $rez_img['height'], $crop );
					return $alternative;
				}
				$request_w   = (int) $all_sizes[ $s ]['width'];
				$request_h   = (int) $all_sizes[ $s ]['height'];
				$alternative = array(
					'name'         => $s,
					'file'         => $f,
					'width'        => $request_w,
					'height'       => $request_h,
					'intermediate' => true,
				);
				$found_match = false;
				$image['width'] = ( ! empty( $image['width'] ) ) ? (int) $image['width'] : 0;
				$image['height'] = ( ! empty( $image['height'] ) ) ? (int) $image['height'] : 0;
				if ( $request_w === (int) $image['width'] && $request_h === (int) $image['height'] && ! empty( $image['file'] ) ) {
					$tmp_file = str_replace( basename( $filename ), basename( $image['file'] ), $filename );
					if ( file_exists( $tmp_file ) ) {
						$folder      = str_replace( $upload_dir['basedir'], '', $filename );
						$old_file    = basename( str_replace( $upload_dir['basedir'], '', $filename ) );
						$folder      = str_replace( $old_file, '', $folder );
						$alternative = array(
							'name'         => 'full',
							'file'         => $upload_dir['baseurl'] . $folder . basename( $image['file'] ),
							'width'        => (int) $image['width'],
							'height'       => (int) $image['height'],
							'intermediate' => false,
						);
						$found_match = true;
					}
				}
				if ( ! empty( $image['sizes'] ) ) {
					foreach ( $image['sizes'] as $name => $var ) {
						if ( $found_match ) {
							break;
						}
						if ( $request_w === (int) $var['width'] && $request_h === (int) $var['height'] && ! empty( $var['file'] ) ) {
							$tmp_file = str_replace( basename( $filename ), $var['file'], $filename );
							if ( file_exists( $tmp_file ) ) {
								$folder      = str_replace( $upload_dir['basedir'], '', $filename );
								$old_file    = basename( str_replace( $upload_dir['basedir'], '', $filename ) );
								$folder      = str_replace( $old_file, '', $folder );
								$alternative = array(
									'name'         => $name,
									'file'         => $upload_dir['baseurl'] . $folder . $var['file'],
									'width'        => (int) $var['width'],
									'height'       => (int) $var['height'],
									'intermediate' => true,
								);
								$found_match = true;
								break;
							}
						}
					}
				}
				if ( ! empty( $alternative ) && $found_match ) {
					$placeholder = array( $alternative['file'], $alternative['width'], $alternative['height'], $alternative['intermediate'] );
					return $placeholder;
				} else {
					$img_url = self::image_placeholder_for_image_size( $s );
					if ( ! empty( $img_url ) ) {
						$width           = (int) $request_w;
						$height          = (int) $request_w;
						$is_intermediate = true;
						$placeholder     = array( $img_url, $width, $height, $is_intermediate );
						return $placeholder;
					} else {
						return;
					}
				}
			} catch ( ErrorException $e ) {
				error_log( 'sirsc exception ' . print_r( $e, 1 ) );
			}
		}
	}

	/**
	 * Generate a placeholder image for a specified image size name.
	 *
	 * @param string  $selected_size The selected image size slug.
	 * @param boolean $force_update  True is the update is forced, to clear the cache.
	 */
	public static function image_placeholder_for_image_size( $selected_size, $force_update = false ) {
		$dest     = realpath( SIRSC_PLACEHOLDER_FOLDER ) . '/' . $selected_size . '.png';
		$dest_url = esc_url( SIRSC_PLACEHOLDER_URL . '/' . $selected_size . '.png' );
		if ( file_exists( $dest ) ) {
			if ( ! $force_update ) {
				return $dest_url;
			}
		}
		$alls = self::get_all_image_sizes_plugin();
		if ( ! empty( $alls[ $selected_size ] ) ) {
			$size = $alls[ $selected_size ];
			$iw   = (int) $size['width'];
			$ih   = (int) $size['height'];
			if ( ! empty( $size['width'] ) && empty( $size['height'] ) ) {
				$ih = $iw;
			} elseif ( empty( $size['width'] ) && ! empty( $size['height'] ) ) {
				$iw = $ih;
			}
			if ( $iw >= 9999 ) {
				$iw = self::$limit9999;
			}
			if ( $ih >= 9999 ) {
				$ih = self::$limit9999;
			}

			if ( function_exists( 'imagettfbbox' ) ) {
				$im = @imagecreatetruecolor( $iw, $ih );
				$white = @imagecolorallocate( $im, 255, 255, 255 );
				$rand  = @imagecolorallocate( $im, mt_rand( 0, 150 ), mt_rand( 0, 150 ), mt_rand( 0, 150 ) );
				@imagefill( $im, 0, 0, $rand );
				$font = @realpath( SIRSC_PLUGIN_FOLDER . '/assets/fonts' ) . '/arial.ttf';
				@imagettftext( $im, 6.5, 0, 2, 10, $white, $font, 'placeholder' );
				@imagettftext( $im, 6.5, 0, 2, 20, $white, $font, $selected_size );
				@imagettftext( $im, 6.5, 0, 2, 30, $white, $font, $size['width'] . 'x' . $size['height'] . 'px' );
				@imagepng( $im, $dest, 9 );
				@imagedestroy( $im );
			} elseif ( class_exists( 'Imagick' ) ) {
				$im = new Imagick();
				$draw = new ImagickDraw();
				$pixel = new ImagickPixel( '#' . mt_rand( 10, 99 ) . mt_rand( 10, 99 ) . mt_rand( 10, 99 ) );
				$im->newImage( $iw, $ih, $pixel );
				$draw->setFillColor( '#FFFFFF' );
				$draw->setFont( 'Arial' );
				$draw->setFontSize( 12 );
				$draw->setGravity( Imagick::GRAVITY_CENTER );
				$im->annotateImage( $draw, 0, 0, 0, $size['width'] . 'x' . $size['height'] . 'px' );
				$im->setImageFormat( 'png' );
				$im->writeimage( $dest );
			} else {
				$dest_url = 'https://dummyimage.com/' . $size['width'] . 'x' . $size['height'] . '/' . mt_rand( 10, 99 ) . mt_rand( 10, 99 ) . mt_rand( 10, 99 ) . '/ffffff&text=' . $size['width'] . 'x' . $size['height'] . 'px&fsize=12';
			}
		}
		return $dest_url;
	}

	/**
	 * Add the plugin settings and plugin URL links.
	 *
	 * @param array $links The plugin links.
	 */
	public static function plugin_action_links( $links ) {
		$all   = array();
		$all[] = '<a href="' . esc_url( self::$plugin_url ) . '">' . esc_html__( 'Settings', 'sirsc' ) . '</a>';
		$all[] = '<a href="http://iuliacazan.ro/image-regenerate-select-crop">' . esc_html__( 'Plugin URL', 'sirsc' ) . '</a>';
		$all   = array_merge( $all, $links );
		return $all;
	}
}

$sirsc_image_regenerate_select_crop = SIRSC_Image_Regenerate_Select_Crop::get_instance();
add_action( 'wp_loaded', array( $sirsc_image_regenerate_select_crop, 'filter_ignore_global_image_sizes' ) );
register_deactivation_hook( __FILE__, array( $sirsc_image_regenerate_select_crop, 'deactivate_plugin' ) );

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	/**
	 * Quick WP-CLI command to for SIRSC plugin that allows to regenerate and remove images.
	 */
	class SIRSC_Image_Regenerate_Select_Crop_CLI_Command extends WP_CLI_Command {
		/**
		 * Prepare command arguments.
		 *
		 * @param array $args Command default arguments.
		 */
		private static function prepare_args( $args ) {
			$rez = array(
				'site_id'   => 1,
				'post_type' => '',
				'size_name' => '',
				'parent_id' => '',
				'all_sizes' => array(),
			);
			if ( ! isset( $args[0] ) ) {
				WP_CLI::error( esc_html__( 'Please specify the site id (1 if not multisite).', 'sirsc' ) );
				return;
			} else {
				$rez['site_id'] = intval( $args[0] );
			}

			if ( is_multisite() ) {
				switch_to_blog( $rez['site_id'] );
			}
			WP_CLI::line( '******* SIRSC EXECUTE OPERATION ON SITE ' . $rez['site_id'] . ' *******' );
			if ( ! isset( $args[1] ) ) {
				$pt = get_option( 'sirsc_types_options', array() );
				if ( ! empty( $pt ) ) {
					$av = '';
					foreach ( $pt as $k => $v ) {
						$av .= ( '' === $av ) ? '' : ', ';
						$av .= $v;
					}
				} else {
					$pt = SIRSC_Image_Regenerate_Select_Crop::get_all_post_types_plugin();
					$av = '';
					foreach ( $pt as $k => $v ) {
						$av .= ( '' === $av ) ? '' : ', ';
						$av .= $k;
					}
				}
				WP_CLI::error( 'Please specify the post type (one of: ' . $av . ', etc).' );
				return;
			} else {
				$rez['post_type'] = trim( $args[1] );
			}

			if ( ! empty( $args['the_command'] ) && 'rawcleanup' === $args['the_command'] ) {
				// This is always all.
				$args[2] = 'all';
			}
			$all_sizes        = SIRSC_Image_Regenerate_Select_Crop::get_all_image_sizes();
			$rez['all_sizes'] = $all_sizes;
			if ( ! isset( $args[2] ) ) {
				$ims = '';
				foreach ( $all_sizes as $k => $v ) {
					$ims .= ( '' === $ims ) ? '' : ', ';
					$ims .= $k;
				}
				WP_CLI::error( 'Please specify the image size name (one of: ' . $ims . ').' );
				return;
			} else {
				if ( 'all' === $args[2] || ! empty( $all_sizes[ $args[2] ] ) || ! empty( $args['is_cleanup'] ) ) {
					$rez['size_name'] = trim( $args[2] );
				} else {
					WP_CLI::error( 'Please specify a valid image size name.' );
					return;
				}
			}
			if ( isset( $args[3] ) ) {
				$rez['parent_id'] = (int) $args[3];
			}

			return $rez;
		}

		/**
		 * Arguments order and types : (int)site_id (string)post_type (string)size_name (int)parent_id
		 *
		 * @param array $args       Command default arguments.
		 * @param array $assoc_args Command associated arguments.
		 */
		public function regenerate( $args, $assoc_args ) {
			$config = self::prepare_args( $args );
			if ( ! is_array( $config ) ) {
				return;
			}

			$show_log = ( ! empty( $assoc_args['show-info'] ) ) ? true : false;
			extract( $config ); // PHPCS:ignore WordPress.Functions.DontExtract
			if ( ! empty( $post_type ) && ! empty( $size_name ) && ! empty( $all_sizes ) ) {
				global $wpdb;
				$execute_sizes = array();
				if ( 'all' === $size_name ) {
					$execute_sizes = $all_sizes;
				} else {
					if ( ! empty( $all_sizes[ $size_name ] ) ) {
						$execute_sizes[ $size_name ] = $size_name;
					}
				}
				$rows = self::make_query( $post_type, $parent_id, 'REGENERATE' );
				if ( ! empty( $rows ) && is_array( $rows ) ) {
					if ( ! empty( $execute_sizes ) ) {
						foreach ( $execute_sizes as $sn => $sv ) {
							$progress = \WP_CLI\Utils\make_progress_bar( '------- REGENERATE ' . $sn, count( $rows ) );
							foreach ( $rows as $v ) {

								SIRSC_Image_Regenerate_Select_Crop::load_settings_for_post_id( $v['ID'] );
								if ( ! empty( SIRSC_Image_Regenerate_Select_Crop::$settings['restrict_sizes_to_these_only'] )
									&& ! in_array( $sn, SIRSC_Image_Regenerate_Select_Crop::$settings['restrict_sizes_to_these_only'] ) ) {
									// This might be restricted from the theme or the plugin custom rules.
									continue;
								}

								$filename = get_attached_file( $v['ID'] );
								if ( ! empty( $filename ) && file_exists( $filename ) ) {
									SIRSC_Image_Regenerate_Select_Crop::make_images_if_not_exists( $v['ID'], $sn );
									// $image = wp_get_attachment_metadata( $v['ID'] );
									$th = wp_get_attachment_image_src( $v['ID'], $sn );
									if ( ! empty( $th[0] ) ) {
										if ( true === $show_log ) {
											WP_CLI::success( $th[0] );
										}
									} else {
										WP_CLI::line( esc_html__( 'Could not generate, the original is too small.', 'sirsc' ) );
									}
								} else {
									WP_CLI::line( esc_html__( 'Could not generate, the original file is missing', 'sirsc' ) . ' ' . $filename . ' !' );
								}
								$progress->tick();
							}
							$progress->finish();
						}
					}
				}
				WP_CLI::success( 'ALL DONE!' );
			} else {
				WP_CLI::error( 'Unexpected ERROR' );
			}
		}
		/**
		 * Arguments order and types : (int)site_id (string)post_type (string)size_name (int)parent_id.
		 *
		 * @param array $args       Command default arguments.
		 * @param array $assoc_args Command associated arguments.
		 */
		public function cleanup( $args, $assoc_args ) {
			$is_forced = ( ! empty( $assoc_args['force'] ) ) ? true : false;
			$config    = self::prepare_args( array_merge( $args, array( 'is_cleanup' => true ) ) );
			if ( ! is_array( $config ) ) {
				return;
			}

			$show_log = ( ! empty( $assoc_args['show-info'] ) ) ? true : false;
			extract( $config ); // PHPCS:ignore WordPress.Functions.DontExtract
			if ( ! empty( $post_type ) && ! empty( $size_name ) && ! empty( $all_sizes ) ) {
				global $wpdb;
				$execute_sizes = array();
				if ( 'all' === $size_name ) {
					$execute_sizes = $all_sizes;
				} else {
					if ( ! empty( $all_sizes[ $size_name ] ) || $is_forced ) {
						$execute_sizes[ $size_name ] = $size_name;
					}
				}

				$rows = self::make_query( $post_type, $parent_id, 'REMOVE' );
				if ( ! empty( $rows ) && is_array( $rows ) ) {
					if ( ! empty( $execute_sizes ) ) {
						foreach ( $execute_sizes as $sn => $sv ) {
							$progress = \WP_CLI\Utils\make_progress_bar( '------- REMOVE ' . $sn, count( $rows ) );
							foreach ( $rows as $v ) {
								$image_meta = wp_get_attachment_metadata( $v['ID'] );
								if ( ! empty( $image_meta['sizes'][ $sn ] ) ) {
									$filename = realpath( get_attached_file( $v['ID'] ) );
									if ( ! empty( $filename ) ) {
										$string = ( ! empty( $image_meta['sizes'][ $sn ]['file'] ) ) ? $image_meta['sizes'][ $sn ]['file'] : '';
										$file   = str_replace( basename( $filename ), $string, $filename );
										$file   = realpath( $file );
										if ( ! empty( $file ) ) {
											if ( file_exists( $file ) && $file !== $filename ) {
												// Make sure not to delete the original file.
												if ( true === $show_log ) {
													WP_CLI::success( $file . ' ' . esc_html__( 'was removed', 'sirsc' ) );
												}
												@unlink( $file );
											} else {
												WP_CLI::line( esc_html__( 'Could not remove', 'sirsc' ) . ' ' . $file . '. ' . esc_html__( 'The image is missing or it is the original file.', 'sirsc' ) );
											}
										}
									}
									unset( $image_meta['sizes'][ $sn ] );
									wp_update_attachment_metadata( $v['ID'], $image_meta );
								}
								$progress->tick();
							}
							$progress->finish();
						}
					}
				}
				WP_CLI::success( 'ALL DONE!' );
			} else {
				WP_CLI::error( 'Unexpected ERROR' );
			}
		}

		/**
		 * Arguments order and types : (int)site_id (string)post_type.
		 *
		 * @param array $args       Command default arguments.
		 * @param array $assoc_args Command associated arguments.
		 */
		public function rawcleanup( $args, $assoc_args ) {
			$is_forced = ( ! empty( $assoc_args['force'] ) ) ? true : false;
			$config = self::prepare_args( array_merge( $args, array(
				'is_cleanup'  => true,
				'the_command' => 'rawcleanup',
			) ) );
			if ( ! is_array( $config ) ) {
				return;
			}

			$show_log = ( ! empty( $assoc_args['show-info'] ) ) ? true : false;
			extract( $config ); // PHPCS:ignore WordPress.Functions.DontExtract
			if ( ! empty( $post_type ) ) {
				global $wpdb;

				$rows = self::make_query( $post_type, $parent_id, 'REMOVE' );
				if ( ! empty( $rows ) && is_array( $rows ) ) {
					$progress = \WP_CLI\Utils\make_progress_bar( '------- RAW REMOVE FILES (keep only originals)', count( $rows ) );
					foreach ( $rows as $v ) {
						$image_meta = wp_get_attachment_metadata( $v['ID'] );
						$filename   = realpath( get_attached_file( $v['ID'] ) );
						if ( empty( $filename ) ) {
							$d = maybe_unserialize( $image_meta );
							if ( ! empty( $d['file'] ) ) {
								$upload_dir = wp_upload_dir();
								$filename   = trailingslashit( $upload_dir['basedir'] ) . $d['file'];
							}
						}
						if ( ! empty( $filename ) ) {
							$ext  = explode( '.', $filename );
							$ext  = $ext[ count( $ext ) - 1 ];
							$name = substr( $filename, 0, - ( strlen( $ext ) + 1 ) );
							if ( ! empty( $name ) && ! empty( $ext ) ) {
								$list = glob( $name . '-*x*.' . $ext, GLOB_BRACE );
								if ( ! empty( $list ) ) {
									foreach ( $list as $removable ) {
										if ( file_exists( $removable ) && $removable !== $filename ) {
											// Make sure not to delete the original file.
											if ( true === $show_log ) {
												WP_CLI::success( $removable . ' ' . esc_html__( 'was removed', 'sirsc' ) );
											}
											@unlink( $removable );
										} else {
											WP_CLI::line( esc_html__( 'Could not remove', 'sirsc' ) . ' ' . $removable . esc_html__( '. The image is missing or it is the original file.', 'sirsc' ) );
										}
									}
								}
							}
						}
						$progress->tick();
					}
					$progress->finish();
				}
				WP_CLI::success( 'ALL DONE!' );
			} else {
				WP_CLI::error( 'Unexpected ERROR' );
			}
		}

		/**
		 * Retrun the posts that match the SIRSC criteria.
		 *
		 * @param string         $post_type Maybe a post type.
		 * @param string|integer $parent_id Attachment parents (numeric or * for all).
		 * @param string         $action    Action title, regenerate or remove.
		 */
		private function make_query( $post_type = '', $parent_id = 0, $action = 'REGENERATE' ) {
			global $wpdb;
			$args  = array();
			$query = ' SELECT p.ID FROM ' . $wpdb->posts . ' as p ';
			if ( ! empty( $post_type ) && 'all' !== $post_type ) {
				$query .= ' INNER JOIN ' . $wpdb->posts . ' as parent ON( parent.ID = p.post_parent ) ';
			}
			$query .= ' WHERE ( p.post_mime_type like %s OR p.post_mime_type like %s OR p.post_mime_type like %s ) ';
			$args[] = '%' . $wpdb->esc_like( 'image/gif' ) . '%';
			$args[] = '%' . $wpdb->esc_like( 'image/jpeg' ) . '%';
			$args[] = '%' . $wpdb->esc_like( 'image/png' ) . '%';

			if ( ! empty( $post_type ) && 'all' !== $post_type ) {
				$query .= ' AND parent.post_type = %s ';
				$args[] = $post_type;
				if ( ! empty( $parent_id ) ) {
					$query .= ' AND parent.ID = %d ';
					$args[] = $parent_id;
					WP_CLI::line( '------- EXECUTE ' . $action . ' FOR IMAGES ASSOCIATED TO ' . $post_type . ' WITH ID = ' . $parent_id . ' -------' );
				} else {
					$query .= ' AND parent.ID IS NOT NULL ';
					WP_CLI::line( '------- EXECUTE ' . $action . ' FOR ALL IMAGES ASSOCIATED TO ' . $post_type . ' -------' );
				}
			}

			if ( 'all' === $post_type ) {
				WP_CLI::line( '------- EXECUTE ' . $action . ' FOR ALL IMAGES ASSOCIATED TO ALL TYPES -------' );
			}

			$query .= ' ORDER BY p.ID ASC LIMIT 0, 50000';
			$rows   = $wpdb->get_results( $wpdb->prepare( $query, $args ), ARRAY_A ); //PHPCS:ignore WordPress.WP.PreparedSQL.NotPrepared
			return $rows;
		}
	}

	WP_CLI::add_command( 'sirsc', 'SIRSC_Image_Regenerate_Select_Crop_CLI_Command' );
}
