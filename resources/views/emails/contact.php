<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body style="font-family: system-ui, -apple-system, sans-serif; background-color: #f5f5f5; padding: 20px; margin: 0;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background-color: #0f766e; padding: 30px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">New Contact Form Message</h1>
        </div>

        <!-- Content -->
        <div style="padding: 30px;">
            <div style="margin-bottom: 20px;">
                <p style="color: #6b7280; font-size: 14px; margin: 0 0 5px 0;">From:</p>
                <p style="color: #1f2937; font-size: 16px; font-weight: 600; margin: 0;">{{ $name }}</p>
                <p style="color: #4b5563; font-size: 14px; margin: 5px 0 0 0;">{{ $email }}</p>
            </div>

            <div style="margin-bottom: 20px;">
                <p style="color: #6b7280; font-size: 14px; margin: 0 0 5px 0;">Subject:</p>
                <p style="color: #1f2937; font-size: 16px; margin: 0;">{{ $subject }}</p>
            </div>

            <div style="border-top: 1px solid #e5e7eb; padding-top: 20px; margin-top: 20px;">
                <p style="color: #6b7280; font-size: 14px; margin: 0 0 10px 0;">Message:</p>
                <div style="background-color: #f9fafb; padding: 20px; border-radius: 8px; border-left: 4px solid #0f766e;">
                    <p style="color: #1f2937; font-size: 15px; line-height: 1.6; margin: 0;">{!! nl2br(e($content)) !!}</p>
                </div>
            </div>

            <div style="margin-top: 30px; text-align: center;">
                <p style="color: #9ca3af; font-size: 13px; margin: 0;">
                    This message was sent via your portfolio contact form.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
            <p style="color: #9ca3af; font-size: 12px; margin: 0;">
                &copy; {{ date('Y') }} Portfolio Builder. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
