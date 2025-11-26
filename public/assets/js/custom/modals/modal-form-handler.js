"use strict";

/**
 * Universal Modal Form Handler
 * Pattern inspired by Metronic modals but with universal approach
 * Handles all modals with data-modal-form attribute
 */
var KTModalFormHandler = function () {
    
    var initModal = function(modalEl) {
        var modal = new bootstrap.Modal(modalEl);
        var form = modalEl.querySelector('form');
        var submitButton = modalEl.querySelector('[data-modal-action="submit"]');
        var cancelButton = modalEl.querySelector('[data-modal-action="cancel"]');
        
        if (!form || !submitButton) return;

        // Handle edit modals with data population
        if (modalEl.hasAttribute('data-modal-edit')) {
            modalEl.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                
                if (button) {
                    // Auto-populate form fields from button data attributes
                    var inputs = form.querySelectorAll('input[name], select[name], textarea[name]');
                    inputs.forEach(function(input) {
                        var fieldName = input.getAttribute('name');
                        // Skip CSRF and method fields
                        if (fieldName !== '_token' && fieldName !== '_method') {
                            var dataValue = button.getAttribute('data-' + fieldName);
                            if (dataValue !== null) {
                                input.value = dataValue;
                            }
                        }
                    });
                    
                    // Set dynamic form action URL
                    var id = button.getAttribute('data-id');
                    if (id && form.hasAttribute('data-action-template')) {
                        var actionTemplate = form.getAttribute('data-action-template');
                        form.action = actionTemplate.replace(':id', id);
                    }
                }
            });
        }

        // Get validation config from data attributes
        var validationFields = {};
        var inputs = form.querySelectorAll('[data-validate]');
        
        inputs.forEach(function(input) {
            try {
                var rules = JSON.parse(input.getAttribute('data-validate') || '{}');
                if (Object.keys(rules).length > 0) {
                    validationFields[input.name] = { validators: rules };
                }
            } catch(e) {
                console.error('Invalid validation JSON for field:', input.name, e);
            }
        });

        // Init tooltips
        var tooltips = [].slice.call(modalEl.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltips.map(function (el) {
            return new bootstrap.Tooltip(el);
        });

        // Init form validation if fields exist
        var validator = null;
        if (Object.keys(validationFields).length > 0) {
            validator = FormValidation.formValidation(form, {
                fields: validationFields,
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            });
        }

        // Handle submit button - Pattern dari new-target.js
        submitButton.addEventListener('click', (function (e) {
            e.preventDefault();
            
            if (validator) {
                validator.validate().then((function (status) {
                    if ('Valid' == status) {
                        // Show loading indicator
                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;
                        
                        // Submit form to server
                        form.submit();
                    } else {
                        // Show error message
                        var errorText = modalEl.getAttribute('data-error-text') || "Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi.";
                        Swal.fire({
                            text: errorText,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, saya mengerti!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                }));
            } else {
                // No validation, submit directly with loading
                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;
                form.submit();
            }
        }));

        // Handle cancel button - Pattern dari new-target.js
        if (cancelButton) {
            cancelButton.addEventListener('click', (function (e) {
                e.preventDefault();
                
                var cancelText = modalEl.getAttribute('data-cancel-text') || "Apakah Anda yakin ingin membatalkan?";
                
                Swal.fire({
                    text: cancelText,
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Ya, batalkan!",
                    cancelButtonText: "Tidak, kembali",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light"
                    }
                }).then((function (result) {
                    if (result.value) {
                        form.reset();
                        modal.hide();
                    } else if ('cancel' === result.dismiss) {
                        Swal.fire({
                            text: "Form Anda tidak dibatalkan!",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, saya mengerti!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                }));
            }));
        }

        // Auto show modal if there are validation errors
        var alertError = modalEl.querySelector('.alert-danger');
        if (alertError) {
            modal.show();
        }
        
        // For edit modals, also check if it's an edit error (check for PUT method in old input)
        if (modalEl.hasAttribute('data-modal-edit')) {
            // Check if there's a form with PUT method error
            var putMethodInput = form.querySelector('input[name="_method"][value="PUT"]');
            if (putMethodInput && alertError) {
                modal.show();
            }
        }

        // Reset form on modal hidden
        modalEl.addEventListener('hidden.bs.modal', function () {
            if (validator) {
                validator.resetForm();
            }
            form.reset();
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
        });
    };

    return {
        init: function () {
            // Find all modals with data-modal-form attribute
            var modals = document.querySelectorAll('[data-modal-form]');
            
            if (modals.length === 0) return;
            
            modals.forEach(function(modalEl) {
                initModal(modalEl);
            });
        }
    };
}();

// On document ready - Pattern dari new-target.js
KTUtil.onDOMContentLoaded((function () {
    KTModalFormHandler.init();
}));

