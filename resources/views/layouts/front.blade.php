<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/front.css')}}">
    <title>Title</title>

</head>
<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-8">

            
        <div class="header">
            <div class="row d-flex justify-content-between">
                <div class="col-3">
                    <div class="header-left"><a href="{{ route('main') }}">Uğur Bölge</a></div>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    <div class="header-right">
                        <img width="30" src="/images/mail.svg" alt="Mail">
                        <img width="30" src="/images/behance.svg" alt="Behance">
                        <img width="30" src="/images/dribbble.svg" alt="Dribbble">
                        <img width="30" src="/images/linkedin.svg" alt="Linkedin">
                        <img width="30" src="/images/twitter.svg" alt="Twitter">
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            @yield('content')
        </div>

        <div class="footer d-flex justify-content-center">
            <div>(c) 2018 | ugurbolge.com | dribble | email</div>
        </div>

    </div>
</div>
    </div>
    
</body>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

</html>