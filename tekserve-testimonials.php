<?php
/**
 * Plugin Name: Tekserve Testimonials
 * Plugin URI: https://github.com/bangerkuwranger
 * Description: Custom Post Type for Testimonial Quotes; Includes Custom Fields
 * Version: 1.0a
 * Author: Chad A. Carino
 * Author URI: http://www.chadacarino.com
 * License: MIT
 */
/*
The MIT License (MIT)
Copyright (c) 2013 Chad A. Carino
 
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

add_action( 'init', 'create_post_type_testimonial' );
function create_post_type_testimonial() {
	register_post_type( 'tekserve_testimonial',
		array(
			'labels' => array(
				'name' => __( 'Testimonials' ),
				'singular_name' => __( 'Testimonial' ),
				'add_new' => 'Add New',
            	'add_new_item' => 'Add New Testimonial',
            	'edit' => 'Edit',
            	'edit_item' => 'Edit Testimonial',
            	'new_item' => 'New Testimonial',
            	'view' => 'View',
            	'view_item' => 'View Testimonial',
            	'search_items' => 'Search Testimonials',
            	'not_found' => 'No Testimonials found',
            	'not_found_in_trash' => 'No Testimonials found in Trash',
            	'parent' => 'Parent Testimonials',
			),
			'public' => true,
			'has_archive' => false,
            'supports' => array( 'editor', ),
		)
	);
}

add_action( 'admin_init', 'testimonial_custom_fields' );

function testimonial_custom_fields() {
    add_meta_box( 'tekserve_testimonial_meta_box',
        'Testimonial Details',
        'display_tekserve_testimonial_meta_box',
        'tekserve_testimonial', 'normal', 'high'
    );
}

function display_tekserve_testimonial_meta_box( $tekserve_testimonial ) {
    // Retrieve current details based on review ID
    $tekserve_testimonial_name = esc_html( get_post_meta( $tekserve_testimonial->ID, 'tekserve_testimonial_name', true ) );
	$tekserve_testimonial_organization = esc_html( get_post_meta( $tekserve_testimonial->ID, 'tekserve_testimonial_organization', true ) );
	?>
    <table>
        <tr>
            <td style="width: 100%">Name</td>
            <td><input type="text" size="80" name="tekserve_testimonial_name" value="<?php echo $tekserve_testimonial_name; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Organization</td>
            <td><input type="text" size="80" name="tekserve_testimonial_organization" value="<?php echo $tekserve_testimonial_organization; ?>" /></td>
        </tr>
    </table>
    <?php
}

add_action( 'save_post', 'add_tekserve_testimonial_fields', 10, 2 );

function add_tekserve_testimonial_fields( $tekserve_testimonial_id, $tekserve_testimonial ) {
    // Check post type for 'tekserve_testimonial'
    if ( $tekserve_testimonial->post_type == 'tekserve_testimonial' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['tekserve_testimonial_name'] ) && $_POST['tekserve_testimonial_name'] != '' ) {
            update_post_meta( $tekserve_testimonial_id, 'tekserve_testimonial_name', $_POST['tekserve_testimonial_tekserve_testimonial_name'] );
        }
        if ( isset( $_POST['tekserve_testimonial_organization'] ) && $_POST['tekserve_testimonial_organization'] != '' ) {
            update_post_meta( $tekserve_testimonial_id, 'tekserve_testimonial_organization', $_POST['tekserve_testimonial_tekserve_testimonial_organization'] );
    	}
    }
}