"use strict";

var KTListingPage = function () {


    var tableElement;
    // Search Datatable
    document.getElementById('dt-search').addEventListener('keyup', function () {
        tableElement.search(this.value).draw();
    });
    // Add click event listener to delete buttons
    if($('[data-kt-action="delete_row"]').length !== 0) {
        document.querySelectorAll('[data-kt-action="delete_row"]').forEach(function (element) {
            element.addEventListener('click', function () {
                Swal.fire({
                    text: 'Are you sure you want to remove?',
                    icon: 'warning',
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $(this).data('kt-remove-url'),
                            type: 'DELETE',
                            dataType: 'json',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        text: response.message,
                                        icon: 'success',
                                        buttonsStyling: false,
                                        confirmButtonText: 'Ok',
                                        customClass: {
                                            confirmButton: 'btn btn-primary',
                                        }
                                    }).then(function () {
                                        tableElement.draw();
                                    });
                                } else {
                                    Swal.fire({
                                        text: response.message,
                                        icon: 'error',
                                        buttonsStyling: false,
                                        confirmButtonText: 'Ok',
                                        customClass: {
                                            confirmButton: 'btn btn-primary',
                                        }
                                    });
                                }
                            },
                            error: function (xhr, status, error) {
                                Swal.fire({
                                    text: xhr.responseJSON.message,
                                    icon: 'error',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok',
                                    customClass: {
                                        confirmButton: 'btn btn-primary',
                                    }
                                });
                            }
                        })
                    }
                });
            });
        });
    }
    // Add click event listener to import button
    if($('[data-kt-action="import"]').length !== 0) {
        document.querySelector('[data-kt-action="import"]').addEventListener('click', function () {
            document.querySelector('[data-kt-action="import-file"]').click();
        });
        document.querySelector('[data-kt-action="import-file"]').addEventListener('change', function () {
            if (!this.files.length) {
                return;
            }
            var formData = new FormData();
            formData.append('file', this.files[0]);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            $.ajax({
                url: $(this).data('kt-import-url'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            text: response.message,
                            icon: 'success',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                            }
                        }).then(function () {
                            tableElement.draw();
                        });
                    } else {
                        Swal.fire({
                            text: response.message,
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok',
                            customClass: {
                                confirmButton: 'btn btn-primary',
                            }
                        });
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                        }
                    });
                }
            });
        });
    }
    // Add click event listener to remove all
    if($('[data-kt-action="remove-all"]').length !== 0) {
        document.querySelector('[data-kt-action="remove-all"]').addEventListener('click', function () {
            Swal.fire({
                text: 'Are you sure you want to remove all data?',
                icon: 'warning',
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(this).data('kt-remove-all-url'),
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    text: response.message,
                                    icon: 'success',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok',
                                    customClass: {
                                        confirmButton: 'btn btn-primary',
                                    }
                                }).then(function () {
                                    tableElement.draw();
                                });
                            } else {
                                Swal.fire({
                                    text: response.message,
                                    icon: 'error',
                                    buttonsStyling: false,
                                    confirmButtonText: 'Ok',
                                    customClass: {
                                        confirmButton: 'btn btn-primary',
                                    }
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr);
                            Swal.fire({
                                text: xhr.responseJSON.message,
                                icon: 'error',
                                buttonsStyling: false,
                                confirmButtonText: 'Ok',
                                customClass: {
                                    confirmButton: 'btn btn-primary',
                                }
                            });
                        }
                    })
                }
            });
        });
    }

    return {
        init: function () {
            //initTyped();
            tableElement = window.LaravelDataTables['leaveTypes-table'];
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTMenu.init();
    KTListingPage.init();
});
