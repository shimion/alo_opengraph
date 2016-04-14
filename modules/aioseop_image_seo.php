<?php
/**
 * @package All-in-One-SEO-Pack
 */
/**
 * The Image Sitemap class.
 */
if ( ! class_exists( 'All_in_One_SEO_Pack_Image_Seo' ) ) {
	class All_in_One_SEO_Pack_Image_Seo extends All_in_One_SEO_Pack_Module {
		function __construct( ) {
			if ( get_class( $this ) === 'All_in_One_SEO_Pack_Image_Seo' ) { // Set this up only when instantiated as this class
				$this->name = __( 'Image SEO', 'all-in-one-seo-pack' ); // Human-readable name of the plugin
				$this->prefix = 'aiosp_image_seo_';						  // option prefix
				$this->file = __FILE__;
			}
			$this->help_text = Array(
				"use_custom_stuff" => __( "Use AISEOP's customized titles", 'all-in-one-seo-pack' ),
				"title_format" => __( "Title format of images", 'all-in-one-seo-pack' ),
				
			);
			$this->help_anchors = Array(
				'title_format' => '#title_format',
				'use_custom_stuff' => '#use_custom_stuff'
			);
			$this->default_options = array(
					'use_custom_stuff'	=> 
						Array( 	
							'name'=> __( 'Use AIOSEO Image Title and Alt tag',  'all-in-one-seo-pack'), 
							'type' => 'checkbox' ),
					'title_format'=> 
						Array( 	
							'name'	=> __( 'Image Title Format',  'all-in-one-seo-pack'), 
							'default' => '%image_title%', 
							'type' => 'text', 
							'sanitize' => 'text',
					));
			// load initial options / set defaults
			$this->update_options( );

			$display = Array();
			if ( isset( $this->options['aiosp_image_seo_types'] ) ) $display = $this->options['aiosp_image_seo_types'];
			$this->locations = array(
				'image_seo'	=> 	Array( 'name' => $this->name, 'prefix' => 'aiosp_', 'type' => 'settings',
									   'options' => Array( 'title_format', 'use_custom_stuff' )  
									   )
			);
			$this->layout = Array(
				'default' => Array(
						'name' => __( 'General Settings', 'all-in-one-seo-pack' ),
						'help_link' => 'http://semperplugins.com/documentation/general-settings/',
						'options' => Array() // this is set below, to the remaining options -- pdb
					),
				'home'  => Array(
						'name' => __( 'Home Page Settings', 'all-in-one-seo-pack' ),
						'help_link' => 'http://semperplugins.com/documentation/home-page-settings/',
						'options' => Array( 'title_format')
					)
			);
			$other_options = Array();
			foreach( $this->layout as $k => $v )
				$other_options = array_merge( $other_options, $v['options'] );

			$this->layout['default']['options'] = array_diff( array_keys( $this->default_options ), $other_options );
						$this->add_help_text_links();
			parent::__construct();
		}
	}
}

