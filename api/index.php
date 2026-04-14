<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Accident Claim</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            color: #333;
        }

        .hero {
            background: #2c3e50;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        .hero h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .hero p {
            color: #bdc3c7;
            font-size: 16px;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .form-card {
            background: white;
            padding: 35px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .form-card h2 {
            color: #2c3e50;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3498db;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #2980b9;
        }

        .message-success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }

        .message-error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
            text-align: center;
        }

        .step {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .step-number {
            width: 40px;
            height: 40px;
            background: #3498db;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: bold;
        }

        .step h3 {
            font-size: 14px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .step p {
            font-size: 12px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>

    <div class="hero">
        <h1>C.R.C. Car Replacement Care</h1>
        <p>Not at fault? Get back on the road fast at no cost to you.</p>
    </div>

    <div class="container">

        <!-- HOW IT WORKS STEPS -->
        <div class="steps">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Submit Your Claim</h3>
                <p>Fill in your accident details below</p>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <h3>We Verify</h3>
                <p>Our team contacts you within the hour</p>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <h3>Get Your Car</h3>
                <p>Replacement vehicle delivered to you</p>
            </div>
        </div>

        <!-- CLAIM FORM -->
        <div class="form-card">
            <h2>📋 Submit Your Accident Claim</h2>

            <div id="form-message"></div>

            <div class="form-row">
                <div class="form-group">
                    <label>First Name *</label>
                    <input type="text" id="first_name" placeholder="Enter your first name">
                </div>
                <div class="form-group">
                    <label>Last Name *</label>
                    <input type="text" id="last_name" placeholder="Enter your last name">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Phone *</label>
                    <input type="text" id="phone" placeholder="e.g. 0412 345 678">
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" id="email" placeholder="Enter your email">
                </div>
            </div>

            <div class="form-group">
                <label>State *</label>
                <select id="state">
                    <option value="">-- Select your state --</option>
                    <option value="NSW">New South Wales</option>
                    <option value="VIC">Victoria</option>
                    <option value="QLD">Queensland</option>
                    <option value="WA">Western Australia</option>
                    <option value="SA">South Australia</option>
                    <option value="TAS">Tasmania</option>
                    <option value="ACT">Australian Capital Territory</option>
                    <option value="NT">Northern Territory</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Accident Date *</label>
                    <input type="date" id="accident_date">
                </div>
                <div class="form-group">
                    <label>Accident Location *</label>
                    <input type="text" id="accident_location" 
                        placeholder="e.g. George St, Sydney NSW">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>At Fault Driver *</label>
                    <input type="text" id="at_fault_driver" 
                        placeholder="At fault driver full name">
                </div>
                <div class="form-group">
                    <label>At Fault Insurer *</label>
                    <input type="text" id="at_fault_insurer" 
                        placeholder="e.g. AAMI, Allianz, NRMA">
                </div>
            </div>

            <button id="submit-claim-btn">Submit My Claim →</button>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
    $(document).ready(function () {

        $('#submit-claim-btn').click(function () {

            // --- FRONTEND VALIDATION ---
            var firstName       = $('#first_name').val().trim();
            var lastName        = $('#last_name').val().trim();
            var phone           = $('#phone').val().trim();
            var email           = $('#email').val().trim();
            var state           = $('#state').val();
            var accidentDate    = $('#accident_date').val().trim();
            var accidentLocation = $('#accident_location').val().trim();
            var atFaultDriver   = $('#at_fault_driver').val().trim();
            var atFaultInsurer  = $('#at_fault_insurer').val().trim();

            if (
                firstName        === '' ||
                lastName         === '' ||
                phone            === '' ||
                email            === '' ||
                state            === '' ||
                accidentDate     === '' ||
                accidentLocation === '' ||
                atFaultDriver    === '' ||
                atFaultInsurer   === ''
            ) {
                showMessage('Please fill in all required fields', 'error');
                return;
            }

            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showMessage('Please enter a valid email address', 'error');
                return;
            }

            // --- SEND TO API ---
            $.ajax({
                url: 'claim.php',
                method: 'POST',
                data: {
                    first_name:       firstName,
                    last_name:        lastName,
                    phone:            phone,
                    email:            email,
                    state:            state,
                    accident_date:    accidentDate,
                    accident_location: accidentLocation,
                    at_fault_driver:  atFaultDriver,
                    at_fault_insurer: atFaultInsurer
                },
                success: function (result) {
                    if (result.success) {
                        // Hide the form and show success
                        $('.form-card').html(
                            '<div class="message-success">' +
                            '<h2>✅ Claim Submitted!</h2>' +
                            '<p>' + result.message + '</p>' +
                            '<p><strong>Your claim number: #' + result.claim_id + '</strong></p>' +
                            '</div>'
                        );
                    } else {
                        showMessage(result.message, 'error');
                    }
                },
                error: function () {
                    showMessage('Something went wrong. Please try again.', 'error');
                }
            });
        });

        function showMessage(message, type) {
            var cssClass = type === 'success' ? 'message-success' : 'message-error';
            $('#form-message').html('<div class="' + cssClass + '">' + message + '</div>');
        }

    });
    </script>

</body>
</html>