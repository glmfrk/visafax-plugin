jQuery(document).ready(function($) {
    $('#myVisaSelectForm').on('submit', function(event) {
        event.preventDefault();
        var citizen_country = $('#citizen_country').val();
        var travel_country = $('#travel_country').val();
        var visa_category = $('#visa_category').val();
        var errorDiv = $('#error');
        var resultsDiv = $('#results');

        errorDiv.html('');
        resultsDiv.html('');

        if (!citizen_country || !travel_country || !visa_category) {
            errorDiv.html('Please select all options.');
            return false;
        }

        var data = {
            'action': 'visa_partner_search',
            'citizen_country': citizen_country,
            'travel_country': travel_country,
            'visa_category': visa_category
        };

        $.post(visafax_api.ajax_url, data, function(response) {
            if (response.success) {
                var posts = response.data.posts;
                console.log(posts);
                var html = '';
                posts.forEach(function(post) {
                    window.location.href = post.url;
                });
                resultsDiv.html(html);

            } else {
                errorDiv.html(response.data.message);
            }
        });

        return false;
    });



});


    // country flags custom select options 
    const customSelects = document.querySelectorAll('.select_option');

    customSelects.forEach(selectOption => {
        selectOption.addEventListener('click', function () {
            const dropdown = this.nextElementSibling; // Assuming dropdown is next to the selected option

            // Toggle dropdown visibility
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                dropdown.style.display = 'block';
            }

            // Handle the option selection
            dropdown.querySelectorAll('div').forEach(option => {
                option.addEventListener('click', function () {
                    const selectElement = document.getElementById(selectOption.dataset.select);

                    // Update the hidden select element value
                    selectElement.value = this.dataset.value;

                    // Update the displayed value
                    const img = selectOption.querySelector('img');
                    const span = selectOption.querySelector('span');

                    if (img) {
                        img.src = this.dataset.image || '';
                    }
                    if (span) {
                        span.textContent = this.textContent;
                    }

                    // Hide the dropdown
                    dropdown.style.display = 'none';
                });
            });
        });
    });