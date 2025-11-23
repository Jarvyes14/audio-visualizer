<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Audio Visualizer Screenshot</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 40px 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .message {
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .info-box strong {
            color: #667eea;
            display: block;
            margin-bottom: 10px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            text-align: center;
            margin: 20px 0;
        }
        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #999;
            font-size: 14px;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🎨 Audio Visualizer</h1>
        <p>Your creative moment captured!</p>
    </div>

    <div class="content">
        <div class="greeting">
            Hello, <strong>{{ $user->name }}</strong>! 👋
        </div>

        <div class="message">
            We're excited to share your latest audio visualizer screenshot! Your creative sphere has been captured and is attached to this email.
        </div>

        <div class="info-box">
            <strong>📸 Screenshot Details:</strong>
            <p style="margin: 5px 0; color: #666;">
                <strong>Filename:</strong> {{ $screenshot->filename }}<br>
                <strong>Created:</strong> {{ $screenshot->created_at->format('M d, Y \a\t g:i A') }}<br>
                <strong>Status:</strong> <span style="color: #28a745;">✓ Successfully sent</span>
            </p>
        </div>

        <div class="message">
            Your screenshot is attached to this email. You can download it and share your amazing audio visualization with friends!
        </div>

        <center>
            <a href="{{ config('app.url') }}/screenshots" class="button">
                View All My Screenshots →
            </a>
        </center>

        <div class="message" style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #eee;">
            <p style="color: #999; font-size: 14px;">
                Keep creating amazing visualizations! Visit the visualizer anytime to create more unique audio spheres.
            </p>
        </div>
    </div>

    <div class="footer">
        <p>
            <strong>Audio Visualizer App</strong><br>
            Questions? <a href="mailto:{{ config('mail.from.address') }}">Contact us</a>
        </p>
        <p style="margin-top: 15px;">
            © {{ date('Y') }} Audio Visualizer. All rights reserved.
        </p>
    </div>
</div>
</body>
</html>
