<html>
    <head>
        <title>{{ $title ?? 'Minha App' }}</title>
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
