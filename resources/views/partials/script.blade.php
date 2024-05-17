<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showWarningMessage(message = "No changes were made.") {
        return toastr.warning(message, 'Warning');
    }

    function showSuccessMessage(message) {
        return toastr.success(message, 'Success');
    }

    function showInfoMessage(message) {
        return toastr.info(message, 'Info');
    }

    function showErrorMessage(message = 'An error occurred while processing your request.') {
        return toastr.error(message, 'Error');
    }

    $(document).ready(() => {
        $('.mobile-btn').click(function() {
            $('#mobile-nav').slideToggle();
        });
    });
</script>
