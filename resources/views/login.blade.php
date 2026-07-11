<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to EnglishYa !</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="login-container">
        <div class="card logo-card text-white">
            
            <h1 class="logo-login">
                <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="logo-image-login"/>
            </h1>
            <h1 class="logo-text">
                Welcome to EnglishYa !
            </h1>
            <p class="text-center">Learn English with us and improve your skills.</p>
            @if ($errors->any())
                <div class="alert color-danger" id="error-alert">
                    <button
                        type="button"
                        onclick="dismissError()"
                        class="close-button"
                    >
                        &times;
                    </button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="/auth" method="post" class="login-form">
                @csrf
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required class="form-input">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required class="form-input">
                </div>
                <button type="submit" class="btn color-info">Login</button>
            </form>
        </div>
    </div>

<!-- custom scripts -->
<script>
    function dismissError() {
        document.getElementById('error-alert').style.display = 'none';
    }
</script>
</body>
</html>