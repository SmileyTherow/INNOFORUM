<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .email-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-top: 20px;
        }
        .header {
            background-color: #4a6ee0;
            color: white;
            padding: 15px 20px;
            border-radius: 8px 8px 0 0;
            margin: -25px -25px 20px -25px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .info-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .info-label {
            font-weight: bold;
            color: #4a6ee0;
            display: block;
            margin-bottom: 5px;
        }
        .info-content {
            color: #555;
        }
        .message-content {
            background-color: #f5f7ff;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #4a6ee0;
            margin-top: 10px;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }
        .btn {
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .btn-reply {
            background-color: #4a6ee0;
            color: white;
        }
        .btn-forward {
            background-color: #6c757d;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INNOFORUM</h1>
    </div>

    <div class="email-container">
        <div class="info-item">
            <span class="info-label">Nama Pengirim:</span>
            <span class="info-content">{{ $name }}</span>
        </div>

        <div class="info-item">
            <span class="info-label">Email Pengirim:</span>
            <span class="info-content">{{ $email }}</span>
        </div>

        <div class="info-item">
            <span class="info-label">Judul Pesan:</span>
            <span class="info-content">{{ $title }}</span>
        </div>

        <div class="info-item">
            <span class="info-label">Isi Pesan:</span>
            <div class="message-content">{{ $pesan }}</div>
        </div>
    </div>
</body>
</html>
