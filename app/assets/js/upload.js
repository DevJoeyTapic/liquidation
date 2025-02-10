$(document).ready(function () {
    let $table = $("table");
    let $tbody = $table.find("tbody");

    if ($tbody.children().length === 0) {
        $table.find("thead").hide();
    }

    // Spinner
    $("#uploadForm").on("submit", function () {
        $("#spinner").show(); // Show spinner when form is submitted
        $("input[type='submit']").prop("disabled", true); // Disable button to prevent multiple clicks
    });

    //Flast Message time out
    setTimeout(function () {
        $(".flash_message").fadeOut(500);
    }, 3000);

    // Close button for flash messages
    $(".close_btn").on("click", function () {
        $(this).parent().fadeOut(500);
    });

    function showFlashMessage(message, type) {
        if (type === "error") {
            var flashMessage = $("#flash-message");
            flashMessage
                .html(message)
                .removeClass()
                .addClass("flash-message flash-" + type)
                .fadeIn();

            setTimeout(function () {
                flashMessage.fadeOut();
            }, 3000);
        }
    }

    // Load PDF previews
    $(".preview-pdf").each(function () {
        var canvas = this;
        var pdfUrl = $(canvas).attr("data-src");

        pdfjsLib.getDocument(pdfUrl).promise.then(function (pdf) {
            pdf.getPage(1).then(function (page) {
                var scale = 0.2;
                var viewport = page.getViewport({ scale: scale });
                var context = canvas.getContext("2d");

                canvas.width = viewport.width;
                canvas.height = viewport.height;

                var renderContext = {
                    canvasContext: context,
                    viewport: viewport,
                };

                page.render(renderContext);
            });
        });
    });

    // Image Modal Functionality
    $(document).on("click", ".preview_image", function () {
        var imgSrc = $(this).attr("data-src");
        $("#modal-img").attr("src", imgSrc).show();
        $("#modal-pdf").hide();
        $("#file-modal").fadeIn();
    });

    $(document).on("click", ".preview-pdf", function (e) {
        e.preventDefault();
        var pdfSrc = $(this).attr("data-src");
        $("#modal-pdf").attr("src", pdfSrc).show();
        $("#modal-img").hide();
        $("#file-modal").fadeIn();
    });

    // Close modal on click
    $(".close, #file-modal").on("click", function () {
        $("#file-modal").fadeOut();
    });

    // Make description editable on click
    $(document).on("click", ".file-desc", function () {
        var span = $(this);
        var input = span.siblings(".edit-desc");

        span.hide();
        input.show().focus();
    });

    function reloadFlashMessage() {
        $("#flash-message-container").load("<?= base_url('fileuploads/flash_messages') ?>");
    }

    function reloadUploadedFiles() {
        $("#uploaded-files-container").load(
            "<?= base_url('fileuploads/refresh_uploaded_files') ?>"
        );
    }
});
