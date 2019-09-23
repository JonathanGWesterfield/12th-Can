<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <title>{{ config('app.name', 'Gabriel') }} </title>
    </head>

    <body>
        @yield('content')

        <footer>
            <p>CSCE 431</p>
            <p>Team: The 12th Yam</p>
            <p>Members: Jonathan Westerfield, Ismael Rodriguez, Abdul Campos, Aaron Todd, Daniel Patlovany, Mannan Mendiratta</p>
            <p>Contact information: <a href="mailto:jgwesterfield@gmail.com"> <!-- Send that shit to me to make it right -->
                    jgwesterfield@gmail.com</a>.</p>
        </footer>
    </body>
</html>

