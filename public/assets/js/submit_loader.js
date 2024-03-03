$(document).ready(function () {
    // Submit form function
    $('.submtting_pack').on('click', function () {
        // Show loader overlay
        $('#loader-overlay').show();

        // Show loader
        $('#loader').show();

        // Submit the form
        $('form').submit();
    });
});
