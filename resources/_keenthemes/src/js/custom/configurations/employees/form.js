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
                                message: 'Name is required'
                            }
                        }
                    },
                    'email': {
                        validators: {
                            notEmpty: {
                                message: 'Email is required'
                            },
                            emailAddress: {
                                message: 'The value is not a valid email address'
                            }
                        }
                    },
                    'status': {
                        validators: {
                            notEmpty: {
                                message: 'Status is required'
                            }
                        }
                    },
                    'designation': {
                        validators: {
                            notEmpty: {
                                message: 'Designation is required'
                            }
                        }
                    },
                    'department': {
                        validators: {
                            notEmpty: {
                                message: 'Department is required'
                            }
                        }
                    },
                    'branch': {
                        validators: {
                            notEmpty: {
                                message: 'Branch is required'
                            }
                        }
                    },
                    'employee_code': {
                        validators: {
                            notEmpty: {
                                message: 'Employee Code is required'
                            }
                        }
                    },
                    'date_of_joining': {
                        validators: {
                            notEmpty: {
                                message: 'Date of Joining is required'
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
        var method = document.querySelector('input[name="_method"]');
        if (method) {
            method = method.getAttribute('value');
            if (method !== 'PUT') {
                validator.addField('password', {
                    validators: {
                        notEmpty: {
                            message: 'The password is required'
                        }
                    }
                });
            }
        }

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
    var qualificationCounter = 0;

    // Add new qualification
    $('#addQualification').click(function(e) {
        e.preventDefault();
        qualificationCounter++;
        const newRow = `
            <tr>
                <td style="box-shadow: none;">
                    <input type="file" class="form-control form-control-sm" id="qualification_${qualificationCounter}" aria-label="qualification_${qualificationCounter}" aria-describedby="qualification_${qualificationCounter}"  name="attachments[qualifications][qualification_${qualificationCounter}]"/>
                </td>
                <td class="text-center align-items-center" style="box-shadow: none;">
                    <a href="#" class="btn btn-active-icon-danger btn-text-danger border border-1 border-danger py-1 px-3 removeQualification">
                        <i class="fa fa-trash-alt text-danger"></i>
                    </a>
                </td>
            </tr>`;
        $('#qualificationsList').append(newRow);
    });

    // Remove qualification
    $('#qualificationsList').on('click', '.removeQualification', function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });
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
