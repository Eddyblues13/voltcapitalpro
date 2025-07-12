<div class="loaderbody hide" id="loaderbody">
    <div class="loadercircle"></div>
</div>

<!-- JavaScript Libraries -->
<script src="{{ asset('account/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('account/vendors/js/vendor.bundle.addons.js') }}"></script>
<script src="{{ asset('account/js/dashboard.js') }}"></script>
<script src="{{ asset('account/js/template.js') }}"></script>
<script src="{{ asset('account/js/data-table.js') }}"></script>
<script src="{{ asset('account/vendors/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('account/vendors/tinymce/themes/modern/theme.js') }}"></script>
<script src="{{ asset('account/vendors/summernote/dist/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('account/js/editorDemo.js') }}"></script>
<script src="{{ asset('asset2/js/sweetalert.js') }}"></script>
<script src="{{ asset('JavaScript.js') }}"></script>
<script src="{{ asset('_content/AspNetCoreHero.ToastNotification/notyf.min.js') }}"></script>

<script>
    // Toast Notification Setup
        const notyf = new Notyf({
            duration: 10000,
            position: {
                x: "right",
                y: "top"
            },
            dismissible: true,
            ripple: true,
            types: [
                {
                    type: "success",
                    background: "#28a745"
                },
                {
                    type: "error",
                    background: "#dc3545"
                },
                {
                    type: "warning",
                    background: "orange",
                    className: "text-dark",
                    icon: {
                        className: "fa fa-warning text-dark",
                        tagName: "i"
                    }
                },
                {
                    type: "info",
                    background: "#17a2b8",
                    icon: {
                        className: "fa fa-info text-white",
                        tagName: "i"
                    }
                },
                {
                    type: "custom",
                    background: "black"
                }
            ]
        });

        // AJAX Functions
        function Delete(url) {
            if (confirm("Are you sure to delete this record ?") == true) {
                $("#loaderbody").removeClass("hide");
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $("#loaderbody").addClass("hide");
                        notyf.success(response.message);
                        refreshPage();
                    },
                    error: function(xhr) {
                        $("#loaderbody").addClass("hide");
                        notyf.error(xhr.responseJSON.message || "An error occurred");
                    }
                });
            }
        }

        function Verify(url) {
            if (confirm("Are you sure to Verify this User ?") == true) {
                $("#loaderbody").removeClass("hide");
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $("#loaderbody").removeClass("hide");
                        notyf.success(response.message);
                        refreshPage();
                    },
                    error: function(xhr) {
                        $("#loaderbody").addClass("hide");
                        notyf.error(xhr.responseJSON.message || "An error occurred");
                    }
                });
            }
        }

        function MemberVerify(url) {
            if (confirm("Are you sure to verify this user's membership ?") == true) {
                $("#loaderbody").removeClass("hide");
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $("#loaderbody").removeClass("hide");
                        notyf.success(response.message);
                        refreshPage();
                    },
                    error: function(xhr) {
                        $("#loaderbody").addClass("hide");
                        notyf.error(xhr.responseJSON.message || "An error occurred");
                    }
                });
            }
        }

        function PaidCF(url) {
            if (confirm("Are you sure this user has paid his Commission Fees ?") == true) {
                $("#loaderbody").removeClass("hide");
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $("#loaderbody").removeClass("hide");
                        notyf.success(response.message);
                        refreshPage();
                    },
                    error: function(xhr) {
                        $("#loaderbody").addClass("hide");
                        notyf.error(xhr.responseJSON.message || "An error occurred");
                    }
                });
            }
        }

        function Deactivate(url) {
            if (confirm("Are you sure to deactivate this account ?") == true) {
                $("#loaderbody").removeClass("hide");
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $("#loaderbody").removeClass("hide");
                        notyf.success(response.message);
                        refreshPage();
                    },
                    error: function(xhr) {
                        $("#loaderbody").addClass("hide");
                        notyf.error(xhr.responseJSON.message || "An error occurred");
                    }
                });
            }
        }

        function refreshPage() {
            location.reload(true);
        }

        // Initialize DataTable
        $(document).ready(function() {
            $('#order-listing').DataTable();
        });
</script>
</body>

</html>