<?php

/**
 * Modify responses to REST API (Only GET callback)
 *
 * @link https://developer.wordpress.org/rest-api/extending-the-rest-api/modifying-responses/
 */

// Get Custom Post Data 
function recipes_get_post_meta_cb($object, $field_name, $request){
    return get_post_meta($object['id'], $field_name, true); 
}

// Get Category Names from ID
function recipes_get_categories_names( $object, $field_name, $request ) {

    $formatted_categories = array();

    $categories = get_the_category( $object['id'] );

    foreach ($categories as $category) {
        $formatted_categories[] = $category->name;
    }

    return $formatted_categories;
}



add_action( 'init', 'recipes_json_init' );
/**
 * Register a Recipes post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function recipes_json_init() {
    $labels = array(
        'name'               => _x('Recipes', 'wholegrain' ),
        'singular_name'      => __('Recipe', 'wholegrain'),
        'add_new_item'       => __('Add New Recipe', 'wholegrain'),
        'edit_item'          => __('Edit Recipe', 'wholegrain'),
        'new_item'           => __('New Recipe', 'wholegrain'),
        'view_item'          => __('View Recipe', 'wholegrain'),
        'not_found'          => __('No Recipes Found', 'wholegrain'),
        'not_found_in_trash' => __('No Recipes found in Trash', 'wholegrain')
    );
 
    $args = array(
        'labels'             => $labels,
        'public,'            => true,
        'description'        => 'One recipe complete with title, editor, category and ingredients',
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-admin-page',
        'menu_position'      => 5,
        'show_in_admin_bar'  => false,
        'show_in_nav_menus'  => true,
        'show_ui'            => true,
        'show_in_rest'       => true,
        'name_admin_bar'     => 'Recipes',
        'taxonomies'         => array( 'category' ),
        'supports'           => array( 'title', 'editor', 'post-formats', 'revisions' )
    );

    register_rest_field('recipes', 'ingredients', 
        array(
        'get_callback' => 'recipes_get_post_meta_cb', 
        'schema' => null
        )
    );

    register_rest_field( 'recipes', 'categories_names',
        array(
            'get_callback'    => 'recipes_get_categories_names',
            'update_callback' => null,
            'schema'          => null,
        )
    );

    register_post_type( 'recipes', $args );
}
