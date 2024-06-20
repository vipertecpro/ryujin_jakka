"use strict";
var KTForm = function () {
    var form;
    var submitButton;
    var validator;
    const conditionTableForm = document.getElementById('kt_conditionTable');
    const addConditionButton = document.getElementById('addCondition');
    const dummyTemplate = '<tr id="dummyTemplate">' +
        '   <td colspan="3" class="w-100">' +
        '           <h1 class="text-muted text-center py-20">No condition added yet</h1>' +
        '    </td>' +
        '</tr>';
    if (!conditionTableForm.querySelector('tbody tr')) {
        const tbody = conditionTableForm.querySelector('tbody');
        tbody.innerHTML = dummyTemplate;
    }
    var handleConditionTable = function () {
        if (conditionTableForm) {
            addConditionButton.addEventListener('click', function (e) {
                e.preventDefault();
                if (conditionTableForm.querySelector('#dummyTemplate')) {
                    conditionTableForm.querySelector('#dummyTemplate').remove();
                }
                const tbody = conditionTableForm.querySelector('tbody');
                const tr = document.createElement('tr');
                tr.innerHTML = '<td>' +
                        '<input type="text" name="conditions[conditionType][]" class="form-control form-control-sm" placeholder="Enter condition type" />' +
                    '</td>' +
                    '<td>' +
                        '<input type="text" name="conditions[conditionDescriptions][]" class="form-control form-control-sm" placeholder="Enter condition description" />' +
                    '</td>' +
                    '<td>' +
                        '<a href="#" class="btn btn-sm btn-danger removeCondition"><i class="fa fa-minus-circle z-0 removeCondition"></i></a>' +
                    '</td>';
                tbody.appendChild(tr);
            });
            conditionTableForm.addEventListener('click', function (e) {
                if (e.target.classList.contains('removeCondition')) {
                    e.preventDefault();
                    e.target.closest('tr').remove();
                }
                if (conditionTableForm.querySelectorAll('tbody tr').length === 0) {
                    const tbody = conditionTableForm.querySelector('tbody');
                    tbody.innerHTML = dummyTemplate;
                }
            });
        }
    }


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
                    'total_days': {
                        validators: {
                            notEmpty: {
                                message: 'Status is required'
                            }
                        }
                    },
                    'type': {
                        validators: {
                            notEmpty: {
                                message: 'Status is required'
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
            handleConditionTable();
        }
    };
}();
KTUtil.onDOMContentLoaded(function () {
    KTForm.init();
});
