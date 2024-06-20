"use strict";
var KTDetailsPage = function () {
    let approveFormValidator;
    let rejectFormValidator;
    const handleApproveFormSubmit = function (event) {
        let approveFormSubmitBtn = document.querySelector('#kt_approve_form_submit');
        let form = document.querySelector('#kt_approve_form');
        approveFormValidator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'approved_remarks': {
                        validators: {
                            notEmpty: {
                                message: 'Remarks is required'
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
        approveFormSubmitBtn.addEventListener('click', function (e) {
            e.preventDefault();
            approveFormValidator.validate().then(function (status) {
                if (status === 'Valid') {
                    approveFormSubmitBtn.setAttribute('data-kt-indicator', 'on');
                    approveFormSubmitBtn.disabled = true;
                    axios.post(form.getAttribute('action'), new FormData(form)).then(function (response) {
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
                        approveFormSubmitBtn.removeAttribute('data-kt-indicator');
                        approveFormSubmitBtn.disabled = false;
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
    };
    const handleRejectFormSubmit = function (event) {
        let rejectFormSubmitBtn = document.querySelector('#kt_reject_form_submit');
        let form = document.querySelector('#kt_reject_form');
        rejectFormValidator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'rejected_reason': {
                        validators: {
                            notEmpty: {
                                message: 'Remarks is required'
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
        rejectFormSubmitBtn.addEventListener('click', function (e) {
            e.preventDefault();
            rejectFormValidator.validate().then(function (status) {
                if (status === 'Valid') {
                    rejectFormSubmitBtn.setAttribute('data-kt-indicator', 'on');
                    rejectFormSubmitBtn.disabled = true;
                    axios.post(form.getAttribute('action'), new FormData(form)).then(function (response) {
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
                        rejectFormSubmitBtn.removeAttribute('data-kt-indicator');
                        rejectFormSubmitBtn.disabled = false;
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
    };

    return {
        init: function () {
            const leaveApproveModal = document.getElementById('approveLeaveRequestModal')
            leaveApproveModal.addEventListener('shown.bs.modal', event => {
                handleApproveFormSubmit(event);
            })
            const leaveRejectModal = document.getElementById('rejectLeaveRequestModal')
            leaveRejectModal.addEventListener('shown.bs.modal', event => {
                handleRejectFormSubmit(event);
            })
        }
    };
}();
KTUtil.onDOMContentLoaded(function () {
    KTDetailsPage.init();
});
