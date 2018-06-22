<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/front.css')}}">
    @isset($title)
        <title>{{$title}}</title>
    @else 
        <title>{{$variables->where('key', 'site-title')->first()->value ?? ''}}</title>
    @endif

</head>
<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-8">

            
        <div class="header">
            <div class="row d-flex justify-content-between">
                <div class="col-5">
                    <div class="header-left"><a href="{{ route('main') }}">{{$variables->where('key', 'site-brand')->first()->value ?? ''}}</a>
                        <p class="laravel-developer-header"><a href="{{ route('main') }}">{{$variables->where('key', 'site-sub-title')->first()->value ?? ''}}</a></p>
                        <div style="font-size:15px;">
                            @forelse($skills as $skill)
                                <span class="badge badge-secondary">{{$skill->skill}}</span> 
                            @empty
                                &nbsp;
                            @endforelse

                        </div>
                    </div>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    <div class="header-right">
                        @php 
                            $email    = $variables->where('key', 'email')->first()->value ?? '';
                            $behance  = $variables->where('key', 'behance')->first()->value ?? '';
                            $dribbble = $variables->where('key', 'dribbble')->first()->value ?? '';
                            $linkedin = $variables->where('key', 'linkedin')->first()->value ?? '';
                            $twitter  = $variables->where('key', 'twitter')->first()->value ?? '';
                            $github   = $variables->where('key', 'github')->first()->value ?? '';
                        @endphp
                        @if(!empty($email))
                            <a href="{{$email}}">
                                    <img width="30" src="/images/mail.svg" alt="Mail">
                            </a>
                        @endif
                        @if(!empty($github))
                            <a href="{{$github}}">
                                    <img width="30" src="/images/github.svg" alt="Mail">
                            </a>
                        @endif
                        @if(!empty($behance))
                            <a href="{{$behance}}">
                                <img width="30" src="/images/behance.svg" alt="Behance">
                            </a>
                        @endif
                        @if(!empty($dribbble))
                            <a href="{{$dribbble}}">
                                <img width="30" src="/images/dribbble.svg" alt="Dribbble">
                            </a>
                        @endif
                        @if(!empty($linkedin))
                            <a href="{{$linkedin}}">
                                <img width="30" src="/images/linkedin.svg" alt="Linkedin">
                            </a>
                        @endif
                        @if(!empty($twitter))
                            <a href="{{$twitter}}">
                                <img width="30" src="/images/twitter.svg" alt="Twitter">
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            @auth()
                <a href="{{route('admin')}}" class="btn btn-info">Admin Panel</a>
            @endif
            @yield('content')
        </div>

        <div class="footer d-flex justify-content-center">
            <div>{{$variables->where('key', 'footer-text')->first()->value ?? ''}}</div>
        </div>

    </div>
</div>
    </div>
    
</body>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

</html>