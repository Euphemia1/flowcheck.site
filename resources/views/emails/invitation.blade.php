<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f3f4f6; margin: 0; padding: 40px 20px; }
        .container { max-width: 520px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
        .header { background: #1d4ed8; padding: 32px; text-align: center; }
        .header h1 { color: white; font-size: 22px; margin: 0; font-weight: 700; }
        .header p { color: #bfdbfe; font-size: 13px; margin: 4px 0 0; }
        .body { padding: 32px; }
        .body p { color: #374151; font-size: 14px; line-height: 1.6; margin: 0 0 16px; }
        .cta { text-align: center; margin: 28px 0; }
        .cta a { display: inline-block; background: #1d4ed8; color: white; font-size: 14px; font-weight: 600; padding: 12px 28px; border-radius: 8px; text-decoration: none; }
        .meta { background: #f9fafb; border-radius: 8px; padding: 16px; margin: 20px 0; font-size: 12px; color: #6b7280; }
        .meta strong { color: #374151; }
        .footer { text-align: center; padding: 20px 32px; border-top: 1px solid #f3f4f6; font-size: 11px; color: #9ca3af; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>FlowCheck</h1>
        <p>Procurement Management Platform</p>
    </div>
    <div class="body">
        <p>Hello {{ $invitee->name }},</p>
        <p>
            You have been invited to join <strong>{{ $invitee->organisation->name }}</strong> on FlowCheck.
            Click the button below to set up your account and get started.
        </p>
        <div class="cta">
            <a href="{{ $acceptUrl }}">Accept Invitation</a>
        </div>
        <div class="meta">
            <p style="margin:0 0 6px;"><strong>Organisation:</strong> {{ $invitee->organisation->name }}</p>
            <p style="margin:0 0 6px;"><strong>Your Email:</strong> {{ $invitee->email }}</p>
            <p style="margin:0;"><strong>Link Expires:</strong> 7 days from receipt</p>
        </div>
        <p style="font-size:12px; color:#9ca3af;">
            If you didn't expect this invitation, you can safely ignore this email.
            The link will expire automatically.
        </p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} FlowCheck &mdash; Powered by Corelink
    </div>
</div>
</body>
</html>
