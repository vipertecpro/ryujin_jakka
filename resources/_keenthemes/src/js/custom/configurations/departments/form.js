"use strict";


var KTForm = function () {

    var form;
    var submitButton;
    var validator;


    var handleValidation = function (e) {

        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'name': {
                        validators: {
                            notEmpty: {
                                message: 'Email address is required'
                            }
                        }
                    },
                    'status': {
                        validators: {
                            notEmpty: {
                                message: 'The status is required'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );
    }

    var handleSubmitAjax = function (e) {
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;
                    axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form)).then(function (response) {
                        form.reset();
                        Swal.fire({
                            text: response.data.message,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            },
                            allowOutsideClick: false
                        }).then(function (result) {
                            const redirectUrl = response.data.redirectTo;
                            if (redirectUrl) {
                                location.href = redirectUrl;
                            }
                        });
                    }).catch(function (error) {
                        Swal.fire({
                            text: error.response.data.message,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }).then(() => {

                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;
                    });
                } else {
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        });
    }

    return {
        init: function () {
            form = document.querySelector('#kt_form');
            submitButton = document.querySelector('#kt_form_submit');
            handleValidation();
            handleSubmitAjax();
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KTForm.init();
});
