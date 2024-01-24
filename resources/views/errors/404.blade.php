@extends('layouts.app')
@section('content')
<title>Página no encontrada</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 8em;
            margin: 0;
        }

        p {
            color: #666;
            font-size: 1.2em;
            margin-top: 0.5em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <p>Lo sentimos, la página que estás buscando no se pudo encontrar.</p>
    </div>
</body>

@endsection
