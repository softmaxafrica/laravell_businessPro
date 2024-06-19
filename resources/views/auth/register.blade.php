<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .register-container h2 {
            margin-bottom: 20px;
        }
        .register-container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .register-container label, .register-container input {
            margin-bottom: 10px;
        }
        .register-container input {
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .register-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .register-container button:hover {
            background-color: #0056b3;
        }
        .register-container p {
            margin-top: 10px;
            font-size: 14px;
        }
        .register-container a {
            color: #007bff;
            text-decoration: none;
        }
        .register-container a:hover {
            text-decoration: underline;
        }
        .error-container {
            background-color: #ffcccc;
            color: #cc0000;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
        }
        .error-container ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .error-container li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        @if($errors->any())
            <div class="error-container">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            <br>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
    </div>
</body>
</html>
