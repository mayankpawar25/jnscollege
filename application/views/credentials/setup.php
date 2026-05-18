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
            --danger: #dc3545;
            --danger-bg: #fdecea;
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
        .field { margin-bottom: 16px; }
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
        .input-wrap input:focus { background: #fff; }
        .input-wrap button {
            border: none;
            background: transparent;
            padding: 0 12px;
            cursor: pointer;
            color: var(--primary);
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }
        .input-wrap button:hover { color: var(--primary-dark); }
        .hint {
            font-size: 12px;
            color: var(--muted);
            margin-top: 6px;
        }
        .submit-btn {
            display: block;
            width: 100%;
            margin-top: 8px;
            padding: 12px 16px;
            background: var(--primary);
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.15s;
        }
        .submit-btn:hover { background: var(--primary-dark); }
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
        }
        .login-btn:hover { background: var(--primary-dark); }
        .notice {
            margin-top: 18px;
            font-size: 12px;
            color: var(--muted);
            text-align: center;
            line-height: 1.5;
        }
        .alert {
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 14px;
            margin-bottom: 16px;
        }
        .alert-error {
            background: var(--danger-bg);
            color: var(--danger);
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background: #e8f5ee;
            color: var(--success);
            border: 1px solid #b7dfc4;
        }
        .alert ul { margin: 4px 0 0 18px; padding: 0; }
    </style>
</head>
<body>
    <div class="card">
        <?php if (!empty($school) && !empty($school->name)) { ?>
            <div class="school-name"><?php echo htmlspecialchars($school->name, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php } ?>
        <h1><?php echo htmlspecialchars($heading, ENT_QUOTES, 'UTF-8'); ?></h1>

        <?php if (!empty($success)) { ?>
            <p class="subtitle">Your password has been set.</p>
            <div class="alert alert-success">You can now sign in with the username shown below and the password you just chose.</div>
            <div class="field">
                <label for="cred-username">Username</label>
                <div class="input-wrap">
                    <input id="cred-username" type="text" readonly value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>">
                    <button type="button" data-copy="#cred-username">Copy</button>
                </div>
            </div>
            <a class="login-btn" href="<?php echo htmlspecialchars($login_url, ENT_QUOTES, 'UTF-8'); ?>">Go to Login</a>
            <p class="notice">This link cannot be used again. Keep your password safe.</p>
        <?php } else { ?>
            <p class="subtitle">Your username is shown below. Choose a password to finish setting up your account.</p>

            <?php if (!empty($errors)) { ?>
                <div class="alert alert-error">
                    Please fix the following:
                    <ul>
                        <?php foreach ($errors as $err) { ?>
                            <li><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

            <form method="post" autocomplete="off">
                <div class="field">
                    <label for="cred-username">Username</label>
                    <div class="input-wrap">
                        <input id="cred-username" type="text" readonly value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>">
                        <button type="button" data-copy="#cred-username">Copy</button>
                    </div>
                </div>
                <div class="field">
                    <label for="password">New password</label>
                    <div class="input-wrap">
                        <input id="password" name="password" type="password" required minlength="8" autocomplete="new-password">
                        <button type="button" id="toggle-password">Show</button>
                    </div>
                    <div class="hint">At least 8 characters.</div>
                </div>
                <div class="field">
                    <label for="password_confirm">Confirm password</label>
                    <div class="input-wrap">
                        <input id="password_confirm" name="password_confirm" type="password" required minlength="8" autocomplete="new-password">
                    </div>
                </div>
                <button type="submit" class="submit-btn">Set Password</button>
            </form>

            <p class="notice">This link can be used only once and expires within 48 hours.</p>
        <?php } ?>
    </div>

    <div id="toast" style="position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#198754;color:#fff;padding:10px 18px;border-radius:6px;font-size:14px;opacity:0;pointer-events:none;transition:opacity 0.2s;">Copied</div>

    <script>
        (function () {
            var toggle = document.getElementById('toggle-password');
            if (toggle) {
                var pwd = document.getElementById('password');
                toggle.addEventListener('click', function () {
                    if (pwd.type === 'password') {
                        pwd.type = 'text';
                        toggle.textContent = 'Hide';
                    } else {
                        pwd.type = 'password';
                        toggle.textContent = 'Show';
                    }
                });
            }

            var toast = document.getElementById('toast');
            function showToast() {
                toast.style.opacity = '1';
                setTimeout(function () { toast.style.opacity = '0'; }, 1400);
            }

            document.querySelectorAll('[data-copy]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var target = document.querySelector(btn.getAttribute('data-copy'));
                    if (!target) return;
                    target.select();
                    target.setSelectionRange(0, 99999);
                    try {
                        document.execCommand('copy');
                        showToast();
                    } catch (e) {}
                    target.blur();
                });
            });
        })();
    </script>
</body>
</html>
