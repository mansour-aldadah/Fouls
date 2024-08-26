<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختر النظام</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 100px
        }

        h1 {
            margin-bottom: 30px;
            font-size: 30px;
            color: #333;
            font-weight: 900;
        }

        a {
            padding: 15px 25px;
            margin: 10px;
            width: 150px;
            font-size: 20px;
            display: inline-block;
            font-weight: bold;
            text-decoration: none;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        a:hover {
            background-color: #007bff;
            color: #fff;
            transform: scale(1.05);
        }

        .system1 {
            background-color: #28a745;
            color: white;
        }

        .system2 {
            background-color: #17a2b8;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>اختر النظام</h1>
        <a class="button system1" href="{{ route('dashboard') }}">المحروقات</a>
        <a class="button system2" href="{{ route('dashboard') }}">الأرشيف</a>
    </div>
</body>

</html>
