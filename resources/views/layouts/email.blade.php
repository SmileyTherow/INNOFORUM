<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Pesan dari Admin')</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; }
        .content { background: white; padding: 20px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="content">
        @yield('content')
    </div>
</body>
</html>
