<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | C.R.C.</title>
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
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
        }

        .container {
            max-width: 600px;
            padding: 40px 20px;
        }

        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #2c3e50;
            line-height: 1;
            margin-bottom: 10px;
        }

        .error-code span {
            color: #3498db;
        }

        h1 {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        p {
            color: #7f8c8d;
            font-size: 16px;
            margin-bottom: 35px;
            line-height: 1.6;
        }

        .btn-home {
            background: #3498db;
            color: white;
            padding: 14px 35px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
            margin-right: 10px;
        }

        .btn-home:hover {
            background: #2980b9;
        }

        .btn-back {
            background: #7f8c8d;
            color: white;
            padding: 14px 35px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-back:hover {
            background: #6c7a7d;
        }

        .brand {
            margin-bottom: 40px;
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
        }

        .car-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="brand">🚗 C.R.C. Car Replacement Care</div>

        <div class="car-icon">🔍</div>

        <div class="error-code">4<span>0</span>4</div>

        <h1>Page Not Found</h1>

        <p>
            Looks like this page took a wrong turn.<br>
            The page you're looking for doesn't exist or has been moved.
        </p>

        <a href="/pages/auth/login.php" class="btn-home">Go to Login</a>
        <a href="javascript:history.back()" class="btn-back">← Go Back</a>
    </div>

</body>
</html>