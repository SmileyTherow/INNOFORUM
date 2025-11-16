<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Balasan dari INNOFORUM</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            padding: 20px;
            margin: 0;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #4a6ee0 0%, #6a11cb 100%);
            color: white;
            padding: 25px 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .content {
            padding: 30px;
        }

        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #555;
        }

        .reply-section {
            margin: 25px 0;
        }

        .section-title {
            font-weight: 600;
            color: #4a6ee0;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .admin-reply {
            background: #f8f9ff;
            border-left: 4px solid #4a6ee0;
            padding: 18px;
            border-radius: 8px;
            margin: 15px 0;
            line-height: 1.7;
        }

        .original-message {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            margin-top: 25px;
            border: 1px solid #f0f0f0;
        }

        .message-title {
            font-weight: 600;
            color: #4a6ee0;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .message-body {
            background: white;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #eee;
            margin-top: 10px;
            line-height: 1.7;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e0e0e0, transparent);
            margin: 25px 0;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
            text-align: center;
            color: #666;
        }

        .signature {
            font-weight: 600;
            color: #4a6ee0;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Balasan dari INNOFORUM</h1>
        </div>

        <div class="content">
            <div class="greeting">
                <p>Hai {{ $messageModel->name }},</p>
                <p>Admin membalas pesan Anda:</p>
            </div>

            <div class="reply-section">
                <div class="section-title">Balasan Admin:</div>
                <div class="admin-reply">
                    {!! nl2br(e($reply->body)) !!}
                </div>
            </div>

            <div class="divider"></div>

            <div class="original-message">
                <div class="section-title">Pesan Asli Anda:</div>
                <p class="message-title">{{ $messageModel->title }}</p>
                <div class="message-body">
                    {!! nl2br(e($messageModel->body)) !!}
                </div>
            </div>

            <div class="footer">
                <p>Terima kasih,</p>
                <p class="signature">INNOFORUM</p>
            </div>
        </div>
    </div>
</body>
</html>
