<!--begin::Page loading(append to body)-->
<div class="page-loader d-none flex-column bg-dark bg-opacity-25 d-flex justify-content-center align-items-center position-fixed top-0 left-0 w-100 h-100">
    <div class="spinner-border spinner-border text-primary" role="status">
    <span class="visually-hidden">Loading...</span>
    </div>
    <p class="text-gray-800 fs-6 fw-semibold mt-2 text-center">Fetching data, please wait...<br>This may take a while.</p>
</div>
<!--end::Page loading-->
<script>
    $(document).ready(function() {
        $('#refreshData').click(function() {
            location.reload();
            $('.page-loader').removeClass('d-none');
            setTimeout(function() {
                $('.page-loader').addClass('d-none');
            }, 10000);
        });
    });
</script>
