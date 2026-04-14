$(document).ready(function () {

    // ---- LOGIN ----
    $('#login-btn').click(function () {
        var email    = $('#email').val().trim();
        var password = $('#password').val().trim();

        if (email === '' || password === '') {
            showMessage('#login-message', 'Please fill in all fields', 'error');
            return;
        }

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showMessage('#login-message', 'Please enter a valid email', 'error');
            return;
        }

        $.ajax({
            url: '<?php echo BASE_URL; ?>/pages/auth/login-save.php',
            method: 'POST',
            data: {
                email:    email,
                password: password
            },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    showMessage('#login-message', result.message, 'success');
                    setTimeout(function () {
                        window.location.href = result.redirect;
                    }, 1000);
                } else {
                    showMessage('#login-message', result.message, 'error');
                }
            },
            error: function () {
                showMessage('#login-message', 'Something went wrong. Please try again.', 'error');
            }
        });
    });

    // ---- REGISTER ----
    $('#register-btn').click(function () {

        // --- FRONTEND VALIDATION ---
        var name            = $('#name').val().trim();
        var email           = $('#email').val().trim();
        var password        = $('#password').val().trim();
        var passwordConfirm = $('#password-confirm').val().trim();

        if (name === '' || email === '' || password === '' || passwordConfirm === '') {
            showMessage('#register-message', 'Please fill in all fields', 'error');
            return;
        }

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showMessage('#register-message', 'Please enter a valid email', 'error');
            return;
        }

        if (password.length < 6) {
            showMessage('#register-message', 'Password must be at least 6 characters', 'error');
            return;
        }

        if (password !== passwordConfirm) {
            showMessage('#register-message', 'Passwords do not match', 'error');
            return;
        }

        // --- SEND TO SERVER VIA AJAX ---
        $.ajax({
            url: '<?php echo BASE_URL; ?>/pages/auth/register-save.php',
            method: 'POST',
            data: {
                name:             name,
                email:            email,
                password:         password,
                password_confirm: passwordConfirm
            },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    showMessage('#register-message', result.message, 'success');
                    setTimeout(function () {
                        window.location.href = result.redirect;
                    }, 1000);
                } else {
                    showMessage('#register-message', result.message, 'error');
                }
            },
            error: function () {
                showMessage('#register-message', 'Something went wrong. Please try again.', 'error');
            }
        });
    });

    // ---- CREATE CLAIM ----
    $('#create-claim-btn').click(function () {

        // --- FRONTEND VALIDATION ---
        var claimantName     = $('#claimant_name').val().trim();
        var claimantPhone    = $('#claimant_phone').val().trim();
        var claimantEmail    = $('#claimant_email').val().trim();
        var accidentDate     = $('#accident_date').val().trim();
        var accidentLocation = $('#accident_location').val().trim();
        var atFaultDriver    = $('#at_fault_driver').val().trim();
        var atFaultInsurer   = $('#at_fault_insurer').val().trim();
        var vehicleId        = $('#vehicle_id').val();
        var status           = $('#status').val();

        if (
            claimantName     === '' ||
            claimantPhone    === '' ||
            claimantEmail    === '' ||
            accidentDate     === '' ||
            accidentLocation === '' ||
            atFaultDriver    === '' ||
            atFaultInsurer   === ''
        ) {
            showMessage('#claim-message', 'Please fill in all required fields', 'error');
            return;
        }

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(claimantEmail)) {
            showMessage('#claim-message', 'Please enter a valid email', 'error');
            return;
        }

        // --- SEND TO SERVER VIA AJAX ---
        $.ajax({
            url: '<?php echo BASE_URL; ?>/pages/claims/create-save.php',
            method: 'POST',
            data: {
                claimant_name:     claimantName,
                claimant_phone:    claimantPhone,
                claimant_email:    claimantEmail,
                accident_date:     accidentDate,
                accident_location: accidentLocation,
                at_fault_driver:   atFaultDriver,
                at_fault_insurer:  atFaultInsurer,
                vehicle_id:        vehicleId,
                status:            status
            },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    showMessage('#claim-message', result.message, 'success');
                    setTimeout(function () {
                        window.location.href = result.redirect;
                    }, 1000);
                } else {
                    showMessage('#claim-message', result.message, 'error');
                }
            },
            error: function () {
                showMessage('#claim-message', 'Something went wrong. Please try again.', 'error');
            }
        });
    });

    // ---- EDIT CLAIM ----
    $('#edit-claim-btn').click(function () {

        // --- FRONTEND VALIDATION ---
        var claimId          = $('#claim_id').val();
        var claimantName     = $('#claimant_name').val().trim();
        var claimantPhone    = $('#claimant_phone').val().trim();
        var claimantEmail    = $('#claimant_email').val().trim();
        var accidentDate     = $('#accident_date').val().trim();
        var accidentLocation = $('#accident_location').val().trim();
        var atFaultDriver    = $('#at_fault_driver').val().trim();
        var atFaultInsurer   = $('#at_fault_insurer').val().trim();
        var vehicleId        = $('#vehicle_id').val();
        var status           = $('#status').val();

        if (
            claimantName     === '' ||
            claimantPhone    === '' ||
            claimantEmail    === '' ||
            accidentDate     === '' ||
            accidentLocation === '' ||
            atFaultDriver    === '' ||
            atFaultInsurer   === ''
        ) {
            showMessage('#claim-message', 'Please fill in all required fields', 'error');
            return;
        }

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(claimantEmail)) {
            showMessage('#claim-message', 'Please enter a valid email', 'error');
            return;
        }

        // --- SEND TO SERVER VIA AJAX ---
        $.ajax({
            url: '<?php echo BASE_URL; ?>/pages/claims/edit-save.php',
            method: 'POST',
            data: {
                claim_id:          claimId,
                claimant_name:     claimantName,
                claimant_phone:    claimantPhone,
                claimant_email:    claimantEmail,
                accident_date:     accidentDate,
                accident_location: accidentLocation,
                at_fault_driver:   atFaultDriver,
                at_fault_insurer:  atFaultInsurer,
                vehicle_id:        vehicleId,
                status:            status
            },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    showMessage('#claim-message', result.message, 'success');
                    setTimeout(function () {
                        window.location.href = result.redirect;
                    }, 1000);
                } else {
                    showMessage('#claim-message', result.message, 'error');
                }
            },
            error: function () {
                showMessage('#claim-message', 'Something went wrong. Please try again.', 'error');
            }
        });
    });

    // ---- DELETE CLAIM ----
    $('.delete-link').click(function (e) {
        e.preventDefault(); // Stop the link from navigating immediately

        var claimId = $(this).data('id');
        var confirmDelete = confirm('Are you sure you want to delete claim #' + claimId + '? This cannot be undone.');

        if (confirmDelete) {
            window.location.href = '<?php echo BASE_URL; ?>/pages/claims/delete.php?id=' + claimId;
        }
    });

    // ---- CREATE VEHICLE ----
    $('#create-vehicle-btn').click(function () {

        var make         = $('#make').val().trim();
        var model        = $('#model').val().trim();
        var year         = $('#year').val().trim();
        var registration = $('#registration').val().trim();
        var category     = $('#category').val();
        var status       = $('#status').val();

        if (make === '' || model === '' || year === '' || registration === '') {
            showMessage('#vehicle-message', 'Please fill in all required fields', 'error');
            return;
        }

        if (year < 2000 || year > 2026) {
            showMessage('#vehicle-message', 'Please enter a valid year between 2000 and 2026', 'error');
            return;
        }

        $.ajax({
            url: '<?php echo BASE_URL; ?>/pages/vehicles/create-save.php',
            method: 'POST',
            data: {
                make:         make,
                model:        model,
                year:         year,
                registration: registration,
                category:     category,
                status:       status
            },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    showMessage('#vehicle-message', result.message, 'success');
                    setTimeout(function () {
                        window.location.href = result.redirect;
                    }, 1000);
                } else {
                    showMessage('#vehicle-message', result.message, 'error');
                }
            },
            error: function () {
                showMessage('#vehicle-message', 'Something went wrong. Please try again.', 'error');
            }
        });
    });

    // ---- EDIT VEHICLE ----
    $('#edit-vehicle-btn').click(function () {

        var vehicleId    = $('#vehicle_id').val();
        var make         = $('#make').val().trim();
        var model        = $('#model').val().trim();
        var year         = $('#year').val().trim();
        var registration = $('#registration').val().trim();
        var category     = $('#category').val();
        var status       = $('#status').val();

        if (make === '' || model === '' || year === '' || registration === '') {
            showMessage('#vehicle-message', 'Please fill in all required fields', 'error');
            return;
        }

        if (year < 2000 || year > 2026) {
            showMessage('#vehicle-message', 'Please enter a valid year between 2000 and 2026', 'error');
            return;
        }

        $.ajax({
            url: '<?php echo BASE_URL; ?>/pages/vehicles/edit-save.php',
            method: 'POST',
            data: {
                vehicle_id:   vehicleId,
                make:         make,
                model:        model,
                year:         year,
                registration: registration,
                category:     category,
                status:       status
            },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    showMessage('#vehicle-message', result.message, 'success');
                    setTimeout(function () {
                        window.location.href = result.redirect;
                    }, 1000);
                } else {
                    showMessage('#vehicle-message', result.message, 'error');
                }
            },
            error: function () {
                showMessage('#vehicle-message', 'Something went wrong. Please try again.', 'error');
            }
        });
    });

    // ---- DELETE VEHICLE ----
    $('.delete-vehicle-link').click(function (e) {
        e.preventDefault();

        var vehicleId     = $(this).data('id');
        var confirmDelete = confirm('Are you sure you want to delete vehicle #' + vehicleId + '? This cannot be undone.');

        if (confirmDelete) {
            window.location.href = '<?php echo BASE_URL; ?>/pages/vehicles/delete.php?id=' + vehicleId;
        }
    });

    // ---- HELPER FUNCTION ----
    function showMessage(target, message, type) {
        var cssClass = type === 'success' ? 'message-success' : 'message-error';
        $(target).html('<div class="' + cssClass + '">' + message + '</div>');
    }

});