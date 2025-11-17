<!DOCTYPE html>
<html>
<head>
    <title>Test Error Pages</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .error-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .error-btn {
            padding: 15px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .error-btn:hover { background: #764ba2; }
    </style>
</head>
<body>
    <h1>🔧 Test Custom Error Pages</h1>

    <div class="error-grid">
        <a href="{{ url('/test-error/401') }}" class="error-btn">🚀 Test 401 Unauthorized</a>
        <a href="{{ url('/test-error/403') }}" class="error-btn">💻 Test 403 Forbidden</a>
        <a href="{{ url('/test-error/419') }}" class="error-btn">⏰ Test 419 Page Expired</a>
        <a href="{{ url('/test-error/429') }}" class="error-btn">🚦 Test 429 Too Many Requests</a>
        <a href="{{ url('/test-error/500') }}" class="error-btn">🖥️ Test 500 Server Error</a>
        <a href="{{ url('/test-error/503') }}" class="error-btn">🔧 Test 503 Maintenance</a>
    </div>
</body>
</html>
