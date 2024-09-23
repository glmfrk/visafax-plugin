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