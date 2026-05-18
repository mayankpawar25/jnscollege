<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($heading, ENT_QUOTES, 'UTF-8'); ?></title>
    <style>
        :root {
            --primary: #2c7be5;
            --primary-dark: #1f5fb8;
            --bg: #f4f6fb;
            --card: #ffffff;
            --text: #1a2238;
            --muted: #6b7280;
            --border: #e3e8ef;
            --success: #198754;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .card {
            background: var(--card);
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(20, 30, 50, 0.08);
            width: 100%;
            max-width: 440px;
            padding: 32px 28px;
        }
        .school-name {
            font-size: 14px;
            color: var(--muted);
            text-align: center;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }
        h1 {
            font-size: 22px;
            text-align: center;
            margin: 0 0 6px;
        }
        .subtitle {
            text-align: center;
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 24px;
        }
        .field {
            margin-bottom: 16px;
        }
        .field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
            background: #f7f9fc;
            border: 1px solid var(--border);
            border-radius: 8px;
            overflow: hidden;
        }
        .input-wrap input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 12px 14px;
            font-size: 15px;
            color: var(--text);
            font-family: "SFMono-Regular", Menlo, Consolas, monospace;
            outline: none;
        }
        .input-wrap button {
            border: none;
            background: transparent;
            padding: 0 12px;
            height: 100%;
            cursor: pointer;
            color: var(--primary);
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }
        .input-wrap button:hover { color: var(--primary-dark); }
        .input-wrap button + button {
            border-left: 1px solid var(--border);
        }
        .login-btn {
            display: block;
            width: 100%;
            margin-top: 8px;
            padding: 12px 16px;
            background: var(--primary);
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: background 0.15s;
        }
        .login-btn:hover { background: var(--primary-dark); }
        .notice {
            margin-top: 18px;
            font-size: 12px;
            color: var(--muted);
            text-align: center;
            line-height: 1.5;
        }
        .toast {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--success);
            color: #fff;
            padding: 10px 18px;
            border-radius: 6px;
            font-size: 14px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }
        .toast.visible { opacity: 1; }
    </style>
</head>
<body>
    <div class="card">
        <?php if (!empty($school) && !empty($school->name)) { ?>
            <div class="school-name"><?php echo htmlspecialchars($school->name, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php } ?>
        <h1><?php echo htmlspecialchars($heading, ENT_QUOTES, 'UTF-8'); ?></h1>
        <p class="subtitle">Use the credentials below to sign in.</p>

        <div class="field">
            <label for="cred-username">Username</label>
            <div class="input-wrap">
                <input id="cred-username" type="text" readonly value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>">
                <button type="button" data-copy="#cred-username">Copy</button>
            </div>
        </div>

        <div class="field">
            <label for="cred-password">Password</label>
            <div class="input-wrap">
                <input id="cred-password" type="password" readonly value="<?php echo htmlspecialchars($password, ENT_QUOTES, 'UTF-8'); ?>">
                <button type="button" id="toggle-password">Show</button>
                <button type="button" data-copy="#cred-password">Copy</button>
            </div>
        </div>

        <a class="login-btn" href="<?php echo htmlspecialchars($login_url, ENT_QUOTES, 'UTF-8'); ?>">Go to Login</a>

        <p class="notice">Please keep these credentials safe. Do not share them with anyone.</p>
    </div>

    <div class="toast" id="toast">Copied</div>

    <script>
        (function () {
            var toggle = document.getElementById('toggle-password');
            var pwd = document.getElementById('cred-password');
            toggle.addEventListener('click', function () {
                if (pwd.type === 'password') {
                    pwd.type = 'text';
                    toggle.textContent = 'Hide';
                } else {
                    pwd.type = 'password';
                    toggle.textContent = 'Show';
                }
            });

            var toast = document.getElementById('toast');
            function showToast() {
                toast.classList.add('visible');
                setTimeout(function () { toast.classList.remove('visible'); }, 1400);
            }

            document.querySelectorAll('[data-copy]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var target = document.querySelector(btn.getAttribute('data-copy'));
                    if (!target) return;
                    var prevType = target.type;
                    target.type = 'text';
                    target.select();
                    target.setSelectionRange(0, 99999);
                    try {
                        document.execCommand('copy');
                        showToast();
                    } catch (e) {}
                    target.type = prevType;
                    target.blur();
                });
            });
        })();
    </script>
</body>
</html>
