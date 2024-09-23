<?php


// Shortcode for search filter box
add_shortcode('search_filter_box', 'search_filter_box_shortcode');
function search_filter_box_shortcode() {
    ob_start();

    $exploded = explode('/', $_SERVER['REQUEST_URI']);
    $selectedCountry = isset($exploded[3]) ? $exploded[3] : '';

    ?>
    <div class="visa_search_box">

        <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post" name="myVisaSelectForm" class="myVisaSelectForm" id="myVisaSelectForm">

            <div class="select-box">
                <label><?php esc_html_e('Applaying From', 'visa-partner'); ?></label>
                <select id="citizen_country" name="citizen_country" class="flag-select">
            
                    <?php
                    $countries = get_terms(array('taxonomy' => 'citizen_country', 'hide_empty' => false));
                    foreach ($countries as $country) {
                        echo '<option value="' . esc_attr($country->term_id) . '">' . esc_html($country->name) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="select-box">
                <label><?php esc_html_e('Want to Travel', 'visa-partner'); ?></label>
                <select id="travel_country" name="travel_country" class="flag-select">
                    <option value=""><?php esc_html_e('Destination Country', 'visa-partner'); ?></option>
                    <?php
                    $countries = get_terms(array('taxonomy' => 'travel_country', 'hide_empty' => false));
                
                    foreach ($countries as $country) {
                        $isSelected = $selectedCountry == $country->slug ? 'selected="selected"' : '';
                        echo '<option '.$isSelected.' value="' . esc_attr($country->term_id) . '">' . esc_html($country->name) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="select-box">
                <label><?php esc_html_e('Find Visa', 'visa-partner'); ?></label>
                <select id="visa_category" name="visa_category">
                    <option value=""><?php esc_html_e('--Select Your Visa--', 'visa-partner'); ?></option>
                    <?php
                    $categories = get_terms(array('taxonomy' => 'visa_category', 'hide_empty' => false));
                    foreach ($categories as $category) {
                        echo '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="thm-btn submit__btn btn-primary"><?php esc_html_e('Check Details', 'visa-partner'); ?></button>
        </form>
        <br>
        <div id="error" style="color: red;"></div>
        <div id="results" class="results"></div>
    </div>
    <?php
    return ob_get_clean();
}
