<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <title>Creators Space</title>

        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />

        @routes
        <script src="{{ mix('/js/app.js') }}" defer></script>
    </head>
    <body class="h-full">
        @inertia
    </body>
</html>
