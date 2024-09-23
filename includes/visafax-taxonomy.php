<?php

// Register custom taxonomies
add_action('init', 'visafax_register_taxonomies');
function visafax_register_taxonomies() {
    $taxonomies = [
        'citizen_country' => 'Citizen Country',
        'travel_country' => 'Travel Country',
        'visa_category' => 'Visa Category'
    ];

    foreach ($taxonomies as $taxonomy => $label) {
        $labels = array(
            'name' => _x($label . 's', 'taxonomy general name', 'visafax'),
            'singular_name' => _x($label, 'taxonomy singular name', 'visafax'),
            'search_items' => __('Search ' . $label . 's', 'visafax'),
            'all_items' => __('All ' . $label . 's', 'visafax'),
            'parent_item' => __('Parent ' . $label, 'visafax'),
            'parent_item_colon' => __('Parent ' . $label . ':', 'visafax'),
            'edit_item' => __('Edit ' . $label, 'visafax'),
            'update_item' => __('Update ' . $label, 'visafax'),
            'add_new_item' => __('Add New ' . $label, 'visafax'),
            'new_item_name' => __('New ' . $label . ' Name', 'visafax'),
            'menu_name' => __($label, 'visafax'),
        );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => $taxonomy),
        );

        register_taxonomy($taxonomy, array('evisa_country'), $args);
    }
}