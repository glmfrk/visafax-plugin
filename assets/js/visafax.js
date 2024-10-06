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
document.querySelectorAll('.select_option').forEach(selectOption => {
    selectOption.addEventListener('click', function () {
        const dropdown = this.nextElementSibling; 

        // Toggle dropdown visibility
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';

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



// Hide dropdown when clicking outside of select_option
document.addEventListener('click', function (event) {
    document.querySelectorAll('.select_option').forEach(selectOption => {
        const dropdown = selectOption.nextElementSibling;

        // Check if the clicked element is outside the select_option and dropdown
        if (!selectOption.contains(event.target) && !dropdown.contains(event.target)) {
            // Hide the dropdown if it's visible
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            }
        }
    });
});


// Dropdown search functionality
document.querySelectorAll('.custom_dropdown').forEach(dropdown => {
   const searchInput = dropdown.querySelector('.search_field');
  
   const options = dropdown.querySelectorAll('div');

   searchInput.addEventListener('input', function () {
    const filterValue = this.value.toLowerCase();
    options.forEach(option => {
        const optionText = option.textContent.toLowerCase();
        
        
        // If the option matches the search value, show it; otherwise, hide it
        if (optionText.includes(filterValue)) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    })
   })
});


