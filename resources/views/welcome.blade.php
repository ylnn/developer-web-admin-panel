@extends('layouts.master')


@section('content')
    <div id="app">
        
        <input type="hidden" name="token" value="{{$token}}">

        <ul class="nav nav-pills" style="padding:15px;">
            <li class="nav-item">
                <router-link class="nav-link" tag="a" to="/" exact>
                    Home
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" tag="a" to="/variables/index">
                    Variables
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" tag="a" to="/skills/index">
                    Skills
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" tag="a" to="/portfolios/index">
                    Portfolios
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" tag="a" to="/articles/index">
                    Articles
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" tag="a" to="/images/index">
                    Images
                </router-link>
            </li>

            <li class="nav-item">
                {{-- <a href="{{@route('logout')}}" class="nav-link">Logout</a> --}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                        @csrf
                        <button class="btn btn-secondary" type="submit" class="nav-link">Logout</button>
                    </form>
            </li>
        </ul>
        {{-- Content View --}}
        <router-view></router-view>
    </div>
@endsection