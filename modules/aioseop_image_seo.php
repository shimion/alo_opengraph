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
				$this->file = __FILE__;									  // the current file		
			}
			parent::__construct();
		}
	}
}

