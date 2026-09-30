<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Crypto Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #1a1a2e;
            color: #e0e0e0;
        }
        h1 { color: #f5c542; }
        a { color: #f5c542; }
        form {
            background-color: #16213e;
            padding: 30px;
            border-radius: 10px;
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #f5c542;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #333;
            border-radius: 5px;
            background-color: #1a1a2e;
            color: #e0e0e0;
            font-size: 16px;
            box-sizing: border-box;
        }
        textarea {
            height: 150px;
            resize: vertical;
        }
        button {
            background-color: #f5c542;
            color: #1a1a2e;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #d4a937;
        }
        .error {
            color: #ff1744;
            font-size: 14px;
            margin-top: -15px;
            margin-bottom: 15px;
        }
        .success {
            background-color: #1b5e20;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav style="margin-bottom: 20px;">
        <a href="/coins" style="color: #e0e0e0; margin-right: 15px;">Dashboard</a>
        <a href="/contact" style="color: #f5c542;">Contact</a>
    </nav>
    <h1>Contact</h1>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/contact">
        @csrf

        <label for="name">Naam</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}">
        @error('name')
            <p class="error">{{ $message }}</p>
        @enderror

        <label for="email">E-mailadres</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}">
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror

        <label for="subject">Onderwerp</label>
        <input type="text" id="subject" name="subject" value="{{ old('subject') }}">
        @error('subject')
            <p class="error">{{ $message }}</p>
        @enderror

        <label for="message">Bericht</label>
        <textarea id="message" name="message">{{ old('message') }}</textarea>
        @error('message')
            <p class="error">{{ $message }}</p>
        @enderror

        <button type="submit">Verstuur bericht</button>
    </form>
</body>
</html>