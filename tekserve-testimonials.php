<?php
/**
 * Plugin Name: Tekserve Testimonials
 * Plugin URI: https://github.com/bangerkuwranger
 * Description: Custom Post Type for Testimonial Quotes; Includes Custom Fields & Genesis Shortcode
 * Version: 1.0
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


//create custom post type
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

//create custom fields for name and organization
add_action( 'admin_init', 'testimonial_custom_fields' );
function testimonial_custom_fields() {
    add_meta_box( 'tekserve_testimonial_meta_box', 'Testimonial Details', 'display_tekserve_testimonial_meta_box', 'tekserve_testimonial', 'side', 'high' );
}

// Retrieve current details based on testimonial ID
function display_tekserve_testimonial_meta_box( $tekserve_testimonial ) {
    $tekserve_testimonial_name = esc_html( get_post_meta( $tekserve_testimonial->ID, 'tekserve_testimonial_name', true ) );
	$tekserve_testimonial_organization = esc_html( get_post_meta( $tekserve_testimonial->ID, 'tekserve_testimonial_organization', true ) );
	?>
    <table>
        <tr>
            <td style="width: 100%">Name</td>
        </tr>
        <tr>
            <td><input type="text" size="30" name="tekserve_testimonial_name" value="<?php echo $tekserve_testimonial_name; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Organization</td>
        </tr>
        <tr>
            <td><input type="text" size="30" name="tekserve_testimonial_organization" value="<?php echo $tekserve_testimonial_organization; ?>" /></td>
        </tr>
    </table>
    <?php
}

//store custom field data
add_action( 'save_post', 'add_tekserve_testimonial_fields', 5, 2 );
function add_tekserve_testimonial_fields( $tekserve_testimonial_id, $tekserve_testimonial ) {
    // Check post type for 'tekserve_testimonial'
    if ( $tekserve_testimonial->post_type == 'tekserve_testimonial' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['tekserve_testimonial_name'] ) && $_POST['tekserve_testimonial_name'] != '' ) {
            update_post_meta( $tekserve_testimonial_id, 'tekserve_testimonial_name', sanitize_text_field( $_REQUEST['tekserve_testimonial_name'] ) );
        }
        if ( isset( $_POST['tekserve_testimonial_organization'] ) && $_POST['tekserve_testimonial_organization'] != '' ) {
            update_post_meta( $tekserve_testimonial_id, 'tekserve_testimonial_organization', sanitize_text_field( $_REQUEST['tekserve_testimonial_organization'] ) );
    	}
//     	$post_title = sanitize_text_field( $_REQUEST['tekserve_testimonial_name'] ).' '.sanitize_text_field( $_REQUEST['tekserve_testimonial_organization'] ).' '.$tekserve_testimonial_id;
    }
}

//set title to quote+name+organization+id
function tekserve_testimonial_set_title ($post_id, $post_content) {
    if ( $post_id == null || empty($_POST) )
        return;

    if ( !isset( $_POST['post_type'] ) || $_POST['post_type']!='tekserve_testimonial' )  
        return; 

    if ( wp_is_post_revision( $post_id ) )
        $post_id = wp_is_post_revision( $post_id );

    global $post;  
    if ( empty( $post ) )
        $post = get_post($post_id);

    if ( $_POST['tekserve_testimonial_name']!='' || $_POST['tekserve_testimonial_organization']!='' ) {
        global $wpdb;
        $title = '"' . $_POST['content'] . '" - Quote by ' . $_POST['tekserve_testimonial_name'] . ' from ' . $_POST['tekserve_testimonial_organization'] . '. ID - ' . $post_id;
        $where = array( 'ID' => $post_id );
        $wpdb->update( $wpdb->posts, array( 'post_title' => $title ), $where );
    }
}
add_action('save_post', 'tekserve_testimonial_set_title', 15, 2 );

if ( ! function_exists('tekserve_testimonials_type') ) {

// register testimonial type taxonomy
function tekserve_testimonials_type()  {

	$labels = array(
		'name'                       => 'Testimonial Types',
		'singular_name'              => 'Testimonial Type',
		'menu_name'                  => 'Testimonial Type',
		'all_items'                  => 'All Testimonial Types',
		'parent_item'                => 'Parent Testimonial Type',
		'parent_item_colon'          => 'Parent Testimonial Type:',
		'new_item_name'              => 'New Testimonial Type',
		'add_new_item'               => 'Add New Testimonial Type',
		'edit_item'                  => 'Edit Testimonial Type',
		'update_item'                => 'Update Testimonial Type',
		'separate_items_with_commas' => 'Separate Testimonial Types with commas',
		'search_items'               => 'Search Testimonial Types',
		'add_or_remove_items'        => 'Add or remove Testimonial Types',
		'choose_from_most_used'      => 'Choose from the most used Testimonial Types',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'query_var'                  => 'tekserve-testimonial-type',
		'rewrite'                    => false,
	);
	register_taxonomy( 'tekserve-testimonials-type', 'tekserve_testimonial', $args );

}

// Hook into the 'init' action
add_action( 'init', 'tekserve_testimonials_type', 0 );

}

// add shortcode tekserve-testimonial
//e.g. [tekserve-testimonial id="58"] -or- [tekserve-testimonial type="b2b"]
function tekserve_testimonial_shortcode( $atts ) {

	// attributes
	extract( shortcode_atts(
		array(
			'type' => '',
			'id' => '',
		), $atts )
	);
	
	//display multiple, i.e. if type is passed in shortcode
        if ($atts['type'] != ''){
            $testimonials = NEW WP_Query( array( 'post_type' => 'tekserve_testimonial', 'tekserve-testimonial-type' => $atts['type'], 'orderby' => 'rand' ) );
            while($testimonials->have_posts()){
                $testimonials->the_post();
                if ( genesis_get_custom_field('tekserve_testimonial_name') != '' ) {
                	$name = genesis_get_custom_field('tekserve_testimonial_name') . ', ';
                }
                else {
                	$name = '';
                }
                if ( genesis_get_custom_field('tekserve_testimonial_organization') != '' ) {
                	$organization = genesis_get_custom_field('tekserve_testimonial_organization');
                }
                else {
                	$organization = '';
                }
                //looped output
                $out .= '<li>
							<div class="tekserve-testimonial">
								<div class="tekserve-testimonial-quote">
									&#8220;' . apply_filters( 'the_content', get_the_content() ) . '&#8221;
								</div>
								<div class="tekserve-testimonial-source">
									&#8212;<span class="tekserve-testimonial-name">' . $name . '</span><span class="tekserve-testimonial-organization">' . $organization . '</span>
								</div>
							</div>
						</li>';
            }
            return '<ul class="tekserve-testimonial-ul">' . $out . '</ul>';
        }

        //display a single testimonial, i.e. if id is passed in shortcode
        $testimonial = NEW WP_Query( array( 'post_type' => 'tekserve_testimonial','post__in' => array($id) ) );
            while( $testimonial->have_posts() ) {
                $testimonial->the_post();
                if ( genesis_get_custom_field('tekserve_testimonial_name') != '' ) {
                	$name = genesis_get_custom_field('tekserve_testimonial_name') . ', ';
                }
                else {
                	$name = '';
                }
                if ( genesis_get_custom_field('tekserve_testimonial_organization') != '' ) {
                	$organization = genesis_get_custom_field('tekserve_testimonial_organization');
                }
                else {
                	$organization = '';
                }
                //output single div with testimonial
                $out = '<div class="tekserve-testimonial">
								<div class="tekserve-testimonial-quote">
									&#8220;' . apply_filters( 'the_content', get_the_content() ) . '&#8221;
								</div>
								<div class="tekserve-testimonial-source">
									&#8212;<span class="tekserve-testimonial-name">' . $name . '</span><span class="tekserve-testimonial-organization">' . $organization . '</span>
								</div>
							</div>';
            }
        return $out;
}
add_shortcode( 'tekserve-testimonial', 'tekserve_testimonial_shortcode' );

//include css to format quote(s) on single page
function include_tekserve_testimonials_style() {
	wp_enqueue_style ( 'tekserve_testimonials', plugins_url().'/tekservetestimonials/tekserve_testimonials.css' );
}

add_action( 'wp_enqueue_scripts', 'include_tekserve_testimonials_style' );


function tekserve_testimonial_type_filter() {
	global $typenow;
 
	// array of all the taxonomies to display, using taxonomy name or slug
	$taxonomies = array('tekserve-testimonials-type');
 
	// check for post type before creating menu
	if( $typenow == 'tekserve_testimonial' ){
 
		foreach ($taxonomies as $tax_slug) {
			$tax_obj = get_taxonomy($tax_slug);
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			if(count($terms) > 0) {
				echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
				echo "<option value=''>Show All $tax_name</option>";
				foreach ($terms as $term) { 
					echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
				}
				echo "</select>";
			}
		}
	}
}
add_action( 'restrict_manage_posts', 'tekserve_testimonial_type_filter' );