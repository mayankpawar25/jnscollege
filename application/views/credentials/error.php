<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Unavailable</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background: #f4f6fb;
            color: #1a2238;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(20, 30, 50, 0.08);
            width: 100%;
            max-width: 420px;
            padding: 32px 28px;
            text-align: center;
        }
        .school-name {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        h1 {
            font-size: 20px;
            margin: 0 0 12px;
        }
        p {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
        }
        .icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 14px;
            border-radius: 50%;
            background: #fff3cd;
            color: #b45309;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="card">
        <?php if (!empty($school) && !empty($school->name)) { ?>
            <div class="school-name"><?php echo htmlspecialchars($school->name, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php } ?>
        <div class="icon">!</div>
        <h1>Link Unavailable</h1>
        <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
</body>
</html>
