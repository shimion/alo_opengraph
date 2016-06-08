<?php

/**
 * The Image Sitemap class.
 *
 * @author Semper Fi Web Design.
 * @copyright http://semperplugins.com
 * @package All-in-One-SEO-Pack
 *
 * Optimize your image for SEO.
 *
 * @since 1.0.0
 */

if ( ! class_exists( 'All_in_One_SEO_Pack_Image_Seo' ) ) {
	class All_in_One_SEO_Pack_Image_Seo extends All_in_One_SEO_Pack_Module {
		function __construct( ) {
			if ( get_class( $this ) === 'All_in_One_SEO_Pack_Image_Seo' ) {

				/**
				 * Human-readable name of the plugin.
				 *
				 * @since 1.0.0
				 * @access public
				 * @var string $name.
				 */
				$this->name = __( 'Image SEO', 'all-in-one-seo-pack' );
				/**
				 * Option pre-fix.
				 *
				 * @since 1.0.0
				 * @access public
				 * @var string $prefix.
				 */
				$this->prefix = 'aiosp_image_seo_';
				/**
				 * File directory.
				 *
				 * @since 1.0.0
				 * @access public
				 * @var type $file.
				 */
				$this->file = __FILE__;
				add_filter( 'wp_get_attachment_image_attributes', array( $this, 'edit_image_attributes'), 10 , 2 );
				add_filter( 'get_image_tag', array( $this, 'edit_image_tag'), 10 , 4 );
			}
			/**
			 * Help text.
			 *
			 * @since 1.0.0
			 * @access public
			 * @var array $help_text.
			*/
			$this->help_text = array(
				'use_custom_stuff' => __( "Use AISEOP's customized titles", 'all-in-one-seo-pack' ),
				'title_format' => __( 'Title format of images', 'all-in-one-seo-pack' ),
				'alt_format' => __( 'Alt tag format', 'all-in-one-seo-pack' )
			);
			/**
			 * Help anchors.
			 *
			 * @since 1.0.0
			 * @access public
			 * @var array $help_anchors.
			*/
			$this->help_anchors = array(
				'alt_format' => '#alt_format',
				'title_format' => '#title_format',
				'use_custom_stuff' => '#use_custom_stuff',
			);
			/**
			 * Default options.
			 *
			 * @since 1.0.0
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
						),
						'alt_format' => array(
							'name'	=> __( 'Alt Tag Format',  'all-in-one-seo-pack' ),
							'default' => '%alt%',
							'type' => 'text',
							'sanitize' => 'text',
						),
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
			 * @since 1.0.0
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
				 	'alt_format', 
				 	'use_custom_stuff',
				 	)
									)
			);
			/**
			 * Layout.
			 *
			 * @since 1.0.0
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
						'options' => array( 'title_format','alt_format' ),
					)
			);
			global $post;


			$other_options = array();
			foreach ( $this->layout as $k => $v ) {
				$other_options = array_merge( $other_options, $v['options'] );
			}

			$this->layout['default']['options'] = array_diff( array_keys( $this->default_options ), $other_options );
						$this->add_help_text_links();
			parent::__construct();
		}
		
		public function find_replacements( $post ) {
			$categories =  wp_get_post_categories ( $post->ID );
			$category_title = get_cat_name( $categories[0] );
			$post_type = get_post_type( $post->ID );
			$replacements = array(
				'%blog_title%' => get_bloginfo( 'name' ),
				'%post_title%' => $post->post_title,
				'%category_title%' => $category_title,
				'%post_type%' => $post_type
			);
			return $replacements;
		}


		/**
		 * Helper function to apply image title format where appropriate.
		 *
		 * Use the format options to display the image title
		 *
		 * @since 1.0.0
		 *
		 * @param string $title Title being passed.
		 */
		public function apply_title_format( $title ) {
			global $post;

			$title = str_replace( '%image_title%', $title, $this->options['aiosp_image_seo_title_format'] );
				foreach ( $this->find_replacements( $post ) as $key => $value ) {
					if ( strrpos( $title, $key ) != false ) {
							$title = str_replace( $key, $value, $title );
					}
				}
			return $title;
		}

		public function apply_alt_format( $alt ) {
			$alt = str_replace( '%alt%', $alt, $this->options['aiosp_image_seo_alt_format'] );
			foreach ( $this->find_replacements( $post ) as $key => $value ) {
					if ( strrpos( $title, $key ) != false ) {
							$title = str_replace( $key, $value, $title );
					}
			}
			return $alt;
		}


		/**
		 * Edit image attributes.
		 *
		 * Insert AISEOP values into images if they are set.
		 *
		 * @since 1.0.0
		 *
		 * @param array  $attr  Attributes for image contained in meta values.
		 * @param object $attachment Attachment object.
		 */
		public function edit_image_attributes( $attr, $attachment ) {
			$attr['alt'] = $this->apply_alt_format( get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) );
			$attr['title'] = $this->apply_title_format( $attachment->post_title );
			return $attr;
		}

		/**
		 * Add image tags.
		 *
		 * Insert AISEOP values into images if they are set for embedded images.
		 *
		 * @since 1.0.0
		 *
		 * @param string  $html  Markup returned for html tag
		 * @param int $id Attachment id.
		 */
		public function edit_image_tag( $html, $id, $alt, $title ) {
			$post = get_post( $id );
			$title = $this->apply_title_format( $post->post_title );
			$formatted_alt = $this->apply_alt_format( $alt );
			$html = str_replace(' />', ' title="' . esc_attr( $title ) . '" />', $html );
			return str_replace("alt=\"{$alt}\"", "alt=\"{$formatted_alt}\"", $html);;
		}
	}
}



