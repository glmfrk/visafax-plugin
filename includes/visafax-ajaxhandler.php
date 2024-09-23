<?php

// AJAX handler for search form
add_action('wp_ajax_visa_partner_search', 'visa_partner_search');
add_action('wp_ajax_nopriv_visa_partner_search', 'visa_partner_search');

function visa_partner_search() {
    $citizen_country = intval($_POST['citizen_country']);
    $travel_country = intval($_POST['travel_country']);
    $visa_category = intval($_POST['visa_category']);

    $args = array(
        'post_type' => 'evisa_country',
        'tax_query' => array(
            array(
                'taxonomy' => 'citizen_country',
                'field' => 'term_id',
                'terms' => $citizen_country,
            ),
            array(
                'taxonomy' => 'travel_country',
                'field' => 'term_id',
                'terms' => $travel_country,
            ),
            array(
                'taxonomy' => 'visa_category',
                'field' => 'term_id',
                'terms' => $visa_category,
            ),
        ),
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $posts = [];
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');
            $citizen_country_terms = wp_get_post_terms($post_id, 'citizen_country', array('fields' => 'all'));
            $citizen_term = $citizen_country_terms ? $citizen_country_terms : null;

            $posts[] = array(
                'title' => get_the_title(),
                'url' => get_permalink(),
                'thumbnail' => $thumbnail_url,
                'citizens' => $citizen_term,
                'meta' => get_post_meta($post_id, '', true),
                'image' => get_post_meta($post_id, 'full_image', true), 
            );
        }
        wp_send_json_success(array('posts' => $posts));
    } else {
        wp_send_json_error(array('message' => 'No results found.'));
    }
    wp_die();
}



// AJAX handler to send the message
add_action('wp_ajax_send_visa_message', 'send_visa_message');
add_action('wp_ajax_nopriv_send_visa_message', 'send_visa_message');


function send_visa_message() {
    $fullName = sanitize_text_field($_POST['fullName']);
    $userEmail = sanitize_email($_POST['userEmail']);
    $phoneNumber = sanitize_text_field($_POST['phoneNumber']);
    $messageBox = sanitize_textarea_field($_POST['messageBox']);

    $to = 'golamfaruk204@gmail.com'; // Change to your email address
    $subject = 'New Visa Inquiry';
    $message = "Name: $fullName\nEmail: $userEmail\nPhone: $phoneNumber\nMessage: $messageBox";
    $headers = array('Content-Type: text/plain; charset=UTF-8', 'From: ' . $userEmail);

    if (wp_mail($to, $subject, $message, $headers)) {
        wp_send_json_success('Email sent successfully.');
    } else {
        error_log('Email sending failed.');
        wp_send_json_error('Email sending failed.');
    }
}

