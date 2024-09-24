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


// Add image upload field to 'Add New' form
function visafax_add_taxonomy_image_field() {
    ?>
    <div class="form-field term-group">
        <label for="visafax_image"><?php _e( 'Country Flag', 'visafax' ); ?></label>
        <input type="button" class="button button-secondary visafax_upload_image_button" id="visafax_image_button" value="<?php _e( 'Upload Image', 'visafax' ); ?>" />
        <input type="hidden" id="visafax_image" name="visafax_image" value="">
        <div id="visafax_image_preview"></div>
    </div>
    <?php
}
add_action( 'citizen_country_add_form_fields', 'visafax_add_taxonomy_image_field', 10, 2 );
add_action( 'travel_country_add_form_fields', 'visafax_add_taxonomy_image_field', 10, 2 );

// Add image upload field to 'Edit' form
function visafax_edit_taxonomy_image_field( $term ) {
    $image_id = get_term_meta( $term->term_id, 'visafax_image', true );
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="visafax_image"><?php _e( 'Country Flag', 'visafax' ); ?></label></th>
        <td>
            <input type="button" class="button button-secondary visafax_upload_image_button" id="visafax_image_button" value="<?php _e( 'Upload Image', 'visafax' ); ?>" />
            <input type="hidden" id="visafax_image" name="visafax_image" value="<?php echo esc_attr( $image_id ); ?>">
            <div id="visafax_image_preview">
                <?php if ( $image_id ) : ?>
                    <img src="<?php echo wp_get_attachment_image_url( $image_id, 'thumbnail' ); ?>" style="max-width: 150px;">
                <?php endif; ?>
            </div>
        </td>
    </tr>
    <?php
}
add_action( 'citizen_country_edit_form_fields', 'visafax_edit_taxonomy_image_field', 10, 2 );
add_action( 'travel_country_edit_form_fields', 'visafax_edit_taxonomy_image_field', 10, 2 );


// Save term image meta
function visafax_save_taxonomy_image( $term_id ) {
    if ( isset( $_POST['visafax_image'] ) && '' !== $_POST['visafax_image'] ) {
        $image = intval( $_POST['visafax_image'] );
        update_term_meta( $term_id, 'visafax_image', $image );
    } else {
        delete_term_meta( $term_id, 'visafax_image' );
    }
}
add_action( 'created_citizen_country', 'visafax_save_taxonomy_image', 10, 2 );
add_action( 'edited_citizen_country', 'visafax_save_taxonomy_image', 10, 2 );
add_action( 'created_travel_country', 'visafax_save_taxonomy_image', 10, 2 );
add_action( 'edited_travel_country', 'visafax_save_taxonomy_image', 10, 2 );



