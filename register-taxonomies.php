<?php

/*-----------------------------------------------------------------------------------*/
/*	Register Custom Taxonomy - flat-gallery-type
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'themeist_register_showcase_taxonomies' );

function themeist_register_showcase_taxonomies() {

    /* Theme Platform taxonomy. */
    register_taxonomy(
        'flat_gallery_type', //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        array( 
            'showcase' //post type name
        ),
        array(
            'public' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'hierarchical' => true,
            'query_var' => true,
            'show_tagcloud' => false,

            'labels' => array(
                'name' => __( 'Showcase Type' ),
                'singular_name' => __( 'Showcase Type' ),
                'search_items' => __( 'Search Showcase Type' ),
                'popular_items' => __( 'Popular Showcase Type' ),
                'all_items' => __( 'All Showcase Types' ),
                'parent_item' => __( 'Parent Showcase Type' ),
                'parent_item_colon' => __( 'Parent Showcase Type:' ),
                'edit_item' => __( 'Edit Showcase Type' ),
                'update_item' => __( 'Update Showcase Type' ),
                'add_new_item' => __( 'Add New Showcase Type' ),
                'new_item_name' => __( 'New Showcase Type' ),
            ),

            // this sets the taxonomy view URL (must have category base i.e. /platform)
            // this can be any depth e.g. themeist.co/themes/platform
            'rewrite' => array(
                'with_front' =>         false,  // Don't display the category base before
                'slug' =>           'flat-gallery-type' // This controls the base slug that will display before each term
            ),
        )
    );  

}

?>