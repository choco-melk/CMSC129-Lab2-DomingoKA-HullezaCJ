<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Project Manager')</title>
    <style>
        body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 16px; background: #f2f2f2; color: #1f2937; }
        .container { max-width: 840px; margin: 0 auto; background: #ffffff; padding: 24px; border: 1px solid #d1d5db; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .project { border: 1px solid #d1d5db; background: #ffffff; padding: 16px; margin-bottom: 14px; }
        .project img { max-height: 110px; max-width: 170px; margin-top: 8px; border: 1px solid #d1d5db; }
        .actions form { display: inline; }
        .message { background: #f0fdf4; border: 1px solid #86efac; color: #166534; margin-bottom: 16px; padding: 10px; }
        .error { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; margin-bottom: 16px; padding: 10px; }
        a.button, button, a.button.secondary, button.secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 74px;
            height: 34px;
            white-space: nowrap;
            box-sizing: border-box;
            text-decoration: none;
            padding: 0 12px;
            border-radius: 3px;
            border-width: 1px;
            border-style: solid;
            font-size: 0.875rem;
            line-height: 1.25rem;
            cursor: pointer;
        }

        a.button, button {
            border-color: #111827;
            background: #111827;
            color: #ffffff;
        }

        a.button.secondary, button.secondary {
            border-color: #9ca3af;
            background: #ffffff;
            color: #4b5563;
        }

        a.button:hover, button:hover {
            background: #0f172a;
            color: #ffffff;
        }

        a.button.secondary:hover, button.secondary:hover {
            background: #f3f4f6;
            color: #1f2937;
        }
        .form-wrapper { margin-top: 20px; }
        .field-group { margin-bottom: 16px; }
        .field-group label { margin-bottom: 6px; }
        input[type=text], textarea, input[type=file] { width: 100%; border: 1px solid #d1d5db; padding: 10px; border-radius: 4px; box-sizing: border-box; }
        label { font-weight: 600; display: block; margin-bottom: 6px; }
        .button, .button.secondary { min-width: 90px; height: 34px; }
        .button + .button { margin-left: 8px; }
        .actions .button, .actions button { min-width: 80px; height: 32px; }
        .actions .button + .button, .actions button + .button { margin-left: 8px; }
    </style>
</head>
<body>
<div class="container">
    @yield('content')
</div>
</body>
</html>
