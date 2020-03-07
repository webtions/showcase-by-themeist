<?php
/**
 * Showcase Custom Post Type
 * REFER TO http://wp.tutsplus.com/tutorials/plugins/a-guide-to-wordpress-custom-post-types-taxonomies-admin-columns-filters-and-archives/
 */


// Adds Custom Post Type
add_action('init', 'themeist_register_showcase_post_types');

// Adds columns in the admin view for thumbnail and taxonomies
add_filter( 'manage_edit-showcase_columns', 'showcase_edit_columns' );
add_action( 'manage_showcase_posts_custom_column', 'showcase_columns', 10, 2 );

// Register Posttype
function themeist_register_showcase_post_types() {

	global $dot_options;

	$labels = array(
		'name' => __( 'Showcase', 'flattrendz' ),
		'singular_name' => __( 'Showcase Item', 'flattrendz' ),
		'add_new' => __( 'Add New Item', 'flattrendz' ),
		'add_new_item' => __( 'Add New Showcase Item', 'flattrendz' ),
		'edit_item' => __( 'Edit Showcase Item', 'flattrendz' ),
		'new_item' => __( 'Add New Showcase Item', 'flattrendz' ),
		'view_item' => __( 'View Item', 'flattrendz' ),
		'search_items' => __( 'Search Showcase', 'flattrendz' ),
		'not_found' => __( 'No showcase items found', 'flattrendz' ),
		'not_found_in_trash' => __( 'No showcase items found in trash', 'flattrendz' )
	);


	$args = array(
		'labels' => $labels,
		'public' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-heart',
		'can_export'          => true,
		'has_archive'         => true,

		//$dot_options = get_option('');

		//if( isset( $dot_options['portfolio_slug'] ) && '' != $dot_options['portfolio_slug'] ) {

			'rewrite' => array(
				'slug' => 			'flat-design-gallery',
				'with_front' => 		false,
				'feeds' =>		true,
			),
			//'rewrite' => array( 'slug' => $dot_options['showcase_slug'] ), // Permalinks format
		//}
		//else {

		//	'rewrite' => array( 'slug' => 'portfolio' ), // Permalinks format
		//  https://github.com/Automattic/jetpack/issues/8
		// add_action('init', 'my_custom_init');
		// function my_custom_init() {
		//     add_post_type_support( 'your-custom-post-type-name', 'publicize' );
		// }
		//}
		'supports' => array('title', 'thumbnail', 'publicize'),
		'taxonomies' => array( 'flat_gallery_type')
	   );

	register_post_type( 'showcase' , $args );
}


/**
 * Add Columns to Showcase Edit Screen
 * http://wptheming.com/2010/07/column-edit-pages/
 */

function showcase_edit_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		"thumbnail" => __('Thumbnail', 'flattrendz'),
		'title' => __( 'Title', 'flattrendz' ),
		'url' => __( 'URL', 'flattrendz' ),
		"type" => __('Category', 'flattrendz'),
		"date" => __('Date', 'flattrendz')
	);
	return $columns;
}


function showcase_columns( $column, $post_id ) {

	global $post;


	// Code from: http://wpengineer.com/display-post-thumbnail-post-page-overview
	switch ( $column ) {

		/* If displaying the 'duration' column. */
		case 'url' :

			/* Get the post meta. */
			$url = get_post_meta( $post_id, '_dot_showcase_url', true );

			/* If no duration is found, output a default message. */
			if ( empty( $url ) )
				printf( __( '<strong> -- NO LINK -- </strong>', 'flattrendz' ) );

			/* If there is a duration, append 'minutes' to the text string. */
			else
				printf( __( '<a href="%s" target="_blank"> Open Site </a>', 'flattrendz' ), $url );

			break;

		// Display the thumbnail in the column view
		case "thumbnail":

			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

			// Display the featured image in the column view if possible
			if ( $thumbnail_id ) {
				$thumb = wp_get_attachment_image( $thumbnail_id, 'thumbnail' );
			}
			if ( isset( $thumb ) ) {
				echo $thumb;
			} else {
				printf( __( '<strong> -- None -- </strong>', 'flattrendz' ) );
			}
			break;

		// Display the gallery type in the column view
		case "type":

			/* Get the genres for the post. */
			$terms = get_the_terms( $post_id, 'flat_gallery_type' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'flat_gallery_type' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'flat_gallery_type', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				printf( __( '<strong> -- Not categorised -- </strong>', 'flattrendz' ));
			}

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;

	}
}

?>