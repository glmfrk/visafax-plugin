<?php

// Register shortcode for visa search filter box
add_shortcode('visafax_search_filter_box', 'search_filter_box_shortcode');

function search_filter_box_shortcode() {
    ob_start();

    // Get the country slug from the URL if available
    $exploded = explode('/', $_SERVER['REQUEST_URI']);
    $selectedCountry = isset($exploded[3]) ? sanitize_text_field($exploded[3]) : '';

    ?>
    <div class="visa_search_box">
        <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post" name="myVisaSelectForm" class="myVisaSelectForm" id="myVisaSelectForm">

            <!-- Applying From Country Selection -->
            <div class="select-box">
                <label><?php esc_html_e('Applying From', 'visafax'); ?></label>
                <div class="custom_select">
                    <select id="citizen_country" name="citizen_country" class="hide-select">
                        <?php
                        $countries = get_terms(array('taxonomy' => 'citizen_country', 'hide_empty' => false));
                        foreach ($countries as $country) {
                            $plugin_url = plugin_dir_url(__DIR__); 
                            $country_image = $plugin_url . 'assets/flags/' . esc_attr($country->slug) . '.png';
                            echo '<option value="' . esc_attr($country->term_id) . '" data-image="' . esc_attr($country_image) . '">' . esc_html($country->name) . '</option>';
                        }
                        ?>
                    </select>

                    <!-- Custom Dropdown (Citizen Country) -->
                    <div class="select_option" data-select="citizen_country">
                        <img src="<?php echo esc_attr($country_image); ?>" alt="">
                        <?php echo esc_html($country->name); ?>
                    </div>

                    <div class="custom_dropdown">
                        <?php foreach ($countries as $country) : 
                            $country_image = plugin_dir_url(__DIR__) . 'assets/flags/' . esc_attr($country->slug) . '.png';
                        ?>
                            <div data-value="<?php echo esc_attr($country->term_id); ?>" data-image="<?php echo esc_attr($country_image); ?>">
                                <img src="<?php echo esc_attr($country_image); ?>" alt="">
                                <?php echo esc_html($country->name); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Travel Destination Country Selection -->
            <div class="select-box">
                <label><?php esc_html_e('Want to Travel', 'visafax'); ?></label>
                <div class="custom_select">
                    <select id="travel_country" name="travel_country" class="hide-select">
                        <option value=""><?php esc_html_e('Destination Country', 'visafax'); ?></option>
                        <?php
                        $countries = get_terms(array('taxonomy' => 'travel_country', 'hide_empty' => false));
                        foreach ($countries as $country) {
                            $isSelected = $selectedCountry === $country->slug ? 'selected="selected"' : '';
                            $plugin_url = plugin_dir_url(__DIR__); 
                            $country_image = $plugin_url . 'assets/flags/' . esc_attr($country->slug) . '.png';
                            echo '<option value="' . esc_attr($country->term_id) . '" data-image="' . esc_attr($country_image) . '" ' . $isSelected . '>' . esc_html($country->name) . '</option>';
                        }
                        ?>
                    </select>

                    <!-- Custom Dropdown (Travel Country) -->
                    <div class="select_option" data-select="travel_country">
                        <img src="" alt="" />
                        <span><?php esc_html_e('Destination Country', 'visafax'); ?></span>
                    </div>

                    <div class="custom_dropdown">
                        <?php foreach ($countries as $country) : 
                            $country_image = plugin_dir_url(__DIR__) . 'assets/flags/' . esc_attr($country->slug) . '.png';
                        ?>
                            <div data-value="<?php echo esc_attr($country->term_id); ?>" data-image="<?php echo esc_attr($country_image); ?>">
                                <img src="<?php echo esc_attr($country_image); ?>" alt="">
                                <?php echo esc_html($country->name); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Visa Category Selection -->
            <div class="select-box">
                <label><?php esc_html_e('Find Visa', 'visafax'); ?></label>
                <div class="custom_select">
                    <select id="visa_category" name="visa_category" class="noflag_select hide-select">
                        <option value=""><?php esc_html_e('--Select Your Visa--', 'visafax'); ?></option>
                        <?php
                        $categories = get_terms(array('taxonomy' => 'visa_category', 'hide_empty' => false));
                        foreach ($categories as $category) {
                            echo '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
                        }
                        ?>
                    </select>

                    <!-- Custom Dropdown (Visa Category) -->
                    <div class="select_option" data-select="visa_category">
                        <span><?php esc_html_e('--Select Your Visa--', 'visafax'); ?></span>
                    </div>

                    <div class="custom_dropdown">
                        <?php foreach ($categories as $category) : ?>
                            <div data-value="<?php echo esc_attr($category->term_id); ?>">
                                <?php echo esc_html($category->name); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="thm-btn submit__btn btn-primary"><?php esc_html_e('Check Details', 'visafax'); ?></button>
        </form>
        
        <br>
        
        <!-- Error and Results Section -->
        <div id="error" style="color: red;"></div>
        <div id="results" class="results"></div>
    </div>
    <?php
    return ob_get_clean();
}
