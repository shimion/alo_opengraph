<?php

/**
 * The Image Sitemap class.
 *
 * @package All-in-One-SEO-Pack
 *
 * Optimize your image for SEO.
 *
 * @since x.x.x
 */

if ( ! class_exists( 'All_in_One_SEO_Pack_Image_Seo' ) ) {
	class All_in_One_SEO_Pack_Image_Seo extends All_in_One_SEO_Pack_Module {
		function __construct( ) {
			if ( get_class( $this ) === 'All_in_One_SEO_Pack_Image_Seo' ) {

				/**
				 * Human-readable name of the plugin.
				 *
				 * @since x.x.x
				 * @access public
				 * @var string $name.
				 */
				$this->name = __( 'Image SEO', 'all-in-one-seo-pack' );
				/**
				 * Option pre-fix.
				 *
				 * @since x.x.x
				 * @access public
				 * @var string $prefix.
				 */
				$this->prefix = 'aiosp_image_seo_';
				/**
				 * File directory.
				 *
				 * @since x.x.x
				 * @access public
				 * @var type $file.
				 */
				$this->file = __FILE__;
				add_filter( 'wp_get_attachment_image_attributes', array($this, 'edit_image_attributes'), 10 , 3 );
			}
			/**
			 * Help text.
			 *
			 * @since x.x.x
			 * @access public
			 * @var array $help_text.
			*/
			$this->help_text = array(
				'use_custom_stuff' => __( "Use AISEOP's customized titles", 'all-in-one-seo-pack' ),
				'title_format' => __( 'Title format of images', 'all-in-one-seo-pack' ),
			);
			/**
			 * Help anchors.
			 *
			 * @since x.x.x
			 * @access public
			 * @var array $help_anchors.
			*/
			$this->help_anchors = array(
				'title_format' => '#title_format',
				'use_custom_stuff' => '#use_custom_stuff',
			);
			/**
			 * Default options.
			 *
			 * @since x.x.x
			 * @access public
			 * @var array $default_options.
			*/
			$this->default_options = array(
					'use_custom_stuff'	=>
						array(
							'name' => __( 'Use AIOSEO Image Title and Alt tag',  'all-in-one-seo-pack' ),
						'type' => 'checkbox',
						),
						'title_format' => array(
							'name'	=> __( 'Image Title Format',  'all-in-one-seo-pack' ),
							'default' => '%image_title%',
							'type' => 'text',
							'sanitize' => 'text',
						)
						);
			// Load initial options / set defaults.
			$this->update_options( );

			$display = array();
			if ( isset( $this->options['aiosp_image_seo_types'] ) ) {
				$display = $this->options['aiosp_image_seo_types'];
			}
			/**
			 * Locations.
			 *
			 * @since x.x.x
			 * @access public
			 * @var array $locations.
			*/
			$this->locations = array(
				'image_seo'	=> array(
					'name' => $this->name,
				 'prefix' => 'aiosp_',
				 'type' => 'settings',
				 'options' => array(
				 	'title_format', 
				 	'use_custom_stuff',
				 	)
									)
			);
			/**
			 * Layout.
			 *
			 * @since x.x.x
			 * @access public
			 * @var array $locations.
			*/
			$this->layout = array(
				'default' => array(
						'name' => __( 'General Settings', 'all-in-one-seo-pack' ),
						'help_link' => 'http://semperplugins.com/documentation/general-settings/',
						'options' => array(),
						// This is set below, to the remaining options -- pdb.
					),
				'home'  => array(
						'name' => __( 'Home Page Settings', 'all-in-one-seo-pack' ),
						'help_link' => 'http://semperplugins.com/documentation/home-page-settings/',
						'options' => array( 'title_format' ),
					)
			);
			$other_options = array();
			foreach ( $this->layout as $k => $v ) {
				$other_options = array_merge( $other_options, $v['options'] );
			}

			$this->layout['default']['options'] = array_diff( array_keys( $this->default_options ), $other_options );
						$this->add_help_text_links();
			parent::__construct();
		}
		public function edit_image_attributes( $attr, $attachment, $size ) {
			$attr["alt"] = esc_html(get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ));
			$title = $attachment->post_title;
			$attr["title"] = esc_html( str_replace( "%image_title%", $attachment->post_title, $this->options['aiosp_image_seo_title_format']  ) );
			return $attr;
		}
	}
}



