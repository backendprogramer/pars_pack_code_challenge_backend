<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME', 'App Store') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css"
          integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <style>
        .email-card {
            width: 90%;
            margin: 0 auto;
            display: table;
            text-align: center;
            border: 2px solid #eee;
            border-radius: 5px;
            overflow: hidden;
        }

        .email-card .card-body {
            padding: 30px;
        }

        .btn {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }

        .email-card {
            width: 90%;
            margin: 0 auto;
            display: table;
            text-align: center;
            border: 2px solid #eee;
            border-radius: 5px;
            overflow: hidden;
        }

        .email-card .card-body {
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
        }



    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card email-card" style="background:#f2f2f2;">
                <div class="card-header" style="font-family:tahoma;margin:30px 0 0;font-size: 18px;color: #012d63;">{{$header}}</div>

                <div class="card-body" style="background: #fff;width: 90%;display: table;margin: 20px auto;padding: 30px;">
                    <span style="font-family: tahoma;padding: 20px 20px 0;direction: rtl;display: block;margin-bottom:3px;">
                        <p style="text-align: right !important;font-family:tahoma;margin-bottom: 30px;font-size:14px;">{{$body}}</p>
                    </span>
                </div>
                <span style="display:block;margin:18px 0; direction:ltr;">© 2023 App Store. All rights reserved.</span>
            </div>
        </div>
    </div>
</div>
</body>
</html>
