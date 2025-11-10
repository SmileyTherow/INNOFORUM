<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Balasan dari INNOFORUM</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        .content { background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="content">
        <h2>Balasan dari INNOFORUM untuk: {{ $messageModel->title }}</h2>

        <p>Hai {{ $messageModel->name }},</p>

        <p>Admin membalas pesan Anda:</p>

        <div style="padding:12px;border:1px solid #eee;background:#fafafa;">
            {!! nl2br(e($reply->body)) !!}
        </div>

        <hr>
        <p>Pesan asli Anda:</p>
        <p><strong>{{ $messageModel->title }}</strong></p>
        <p>{!! nl2br(e($messageModel->body)) !!}</p>

        <p>Terima kasih,<br><strong>INNOFORUM</strong></p>
    </div>
</body>
</html>
