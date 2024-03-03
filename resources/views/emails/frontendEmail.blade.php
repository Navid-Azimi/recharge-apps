<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset</title>
</head>
<body>
    <table class="reset-password" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center">
                            <h1>Password Reset</h1>
                            <p>You are receiving this email because we received a password reset request for your account.</p>
                            <p>Click the button below to reset your password:</p>
                            <table class="action" align="center" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $resetLink }}" class="button">Reset Password</a>
                                    </td>
                                </tr>
                            </table>
                            <p>If you did not request a password reset, no further action is required.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
