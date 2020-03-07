<?php

/* Filter the 'enter title here' text. */
add_filter( 'enter_title_here', 'themeist_showcase_enter_title_here', 10, 2 );

/**
 * Changes the 'Enter title here' text in the title box.
 *
 * @since 0.1.0
 */
function themeist_showcase_enter_title_here( $title, $post ) {

	if ( in_array( $post->post_type, array( 'showcase' ) ) ) {
		$post_type = get_post_type_object( $post->post_type );
		$title = sprintf( 'Enter %s name here', strtolower($post_type->labels->singular_name ) );
	}

	return $title;
}





?>