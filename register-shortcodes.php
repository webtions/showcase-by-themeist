<?php


	function dot_irt_top_posts ( $atts ) {

	    // get our variable from $atts
	    extract(shortcode_atts(array(
	        'container' => 'li',
	        'number' => '10',
	        'post_type' => 'post',
	        'year' => '',
	        'monthnum' => '',
	        'show_count' => '1',
	    ), $atts));

	    global $wpdb;

	    $request = "SELECT * FROM $wpdb->posts, $wpdb->postmeta";
	    $request .= " WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id";

	    if ($year != '') {
	        $request .= " AND YEAR(post_date) = '$year'";
	    }

	    if ($monthnum != '') {
	        $request .= " AND MONTH(post_date) = '$monthnum'";
	    }

	    $request .= " AND post_status='publish' AND post_type='$post_type' AND meta_key='_recommended'";
	    $request .= " ORDER BY $wpdb->postmeta.meta_value+0 DESC LIMIT $number";
	    $posts = $wpdb->get_results($request);

	    $return = '';


	    foreach ($posts as $item) {
	        $post_title = stripslashes($item->post_title);
	        //$post_excerpt = strip_tags( $item->post_content );
	        $permalink = get_permalink($item->ID);
	        $post_count = $item->meta_value;
	        $url = get_post_meta( $item->ID, '_dot_showcase_url', true );

	        $return .= '<' . $container . '>';
	        //$return .= '<h2><a href="' . $url . '" rel="nofollow title="' . sprintf( __('Visit %s', 'flattrendz'), $post_title ) . '" target="_blank">' . $post_title . ' <i class="icon-white icon-external-link"></i></a></h2>';
	        $return .= '<h2><a href="' . $permalink . '" title="' . $post_title.'" >' . $post_title . '</a></h2>';
// $return .= '<p><small>';
// $return .= human_time_diff( get_the_time('U', $item->ID), current_time('timestamp') ) . ' ago';
// $return .= '</small></p>';

	        if ( $show_count == '1') {
	            $return .= '<span class="votes">' . $post_count . ' likes</span> ';
				//$return .= do_shortcode("[dot_recommends id=$item->ID]");
	            //$return .= '<div class="votes">'. do_shortcode("[dot_recommends id='$item->ID']") . '</div>';

	            //$return .= '<a href="#" class="dot-irecommendthis votes" id="dot-irecommendthis-'.$item->ID.'" title="Recommend this"><i class="icon-heart"></i> <span class="dot-irecommendthis-count">' . $post_count . ' likes</span></a> ';

	        }

	        $return .= get_the_post_thumbnail($item->ID, 'thumbnail-showcase');
	        $return .= '</' . $container . '>';

	    }
	    return '<div class="top_10_posts">' . $return . '</div>';

	}
	add_shortcode('irt_top_posts','dot_irt_top_posts');

	?>