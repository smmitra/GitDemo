<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Renuka Rice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3a6a4c;
            --secondary-color: #e9dcc9;
            --accent-color: #8a6d3b;
            --light-color: #f8f9fa;
            --dark-color: #2c3e50;
        }
        
        body {
            background-color: var(--light-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
           
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
        
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(to bottom, var(--primary-color), #2c5440);
            color: white;
            padding: 25px 20px 15px;
            text-align: center;
            position: relative;
        }
        
        .logo-container {
            position: relative;
            margin: 0 auto 15px;
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-background {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: white;
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-img {
            max-width: 100px;
            max-height: 100px;
            border-radius: 50%;
            z-index: 2;
            position: relative;
        }
        
        .login-header h2 {
            margin: 15px 0 5px;
            font-weight: 700;
            font-size: 28px;
        }
        
        .login-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 16px;
        }
        
        .login-body {
            padding: 25px;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(58, 106, 76, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: #2c5440;
            border-color: #2c5440;
        }
        
        .input-group-text {
            background-color: white;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }
        
        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #ddd;
        }
        
        .divider span {
            padding: 0 10px;
            color: #777;
            font-size: 14px;
        }
        
        .footer-links {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        
        .footer-links a {
            color: var(--accent-color);
            text-decoration: none;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
        
        .copyright {
            text-align: center;
            margin-top: 20px;
            color: #777;
            font-size: 13px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-container {
                padding: 0 15px;
            }
            
            .login-card {
                border-radius: 10px;
            }
            
            .logo-container {
                width: 100px;
                height: 100px;
            }
            
            .logo-img {
                max-width: 80px;
                max-height: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-container">
                    <div class="logo-background"></div>
                    <img src="https://renukarice.com/assets/images/main-logo.png" alt="Renuka Rice Logo" class="logo-img">
                </div>
                <h2>Renuka Rice</h2>
                <p>Login to your account</p>
            </div>
            
            <div class="login-body">
                <form method="POST" action="{{ route('login_submit') }}">
                @csrf    
                    <div class="mb-3">
                        <label for="al_user_name" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="al_user_name" name="al_user_name" class="form-control" id="al_user_name" placeholder="Enter your email">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="al_password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="al_password" class="form-control" id="al_password" placeholder="Enter your password">
                        </div>
                    </div>
                    
                 
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
                
               
            </div>
        </div>
        
        <div class="copyright">
            &copy; 2025 Renuka Rice. All rights reserved.
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>