@extends('index')
@section('title') Welcome Ticket Project @endsection
@section('content')
<div class="registerdiv">
    <form action="{{ route('register') }}" method="POST" class="form">
        @csrf
        <p class="title">Register </p>
        <label>
            <input class="input" type="text" name="name" placeholder="" required>
            <span>Full Name</span>
        </label>
                
        <label>
            <input class="input" type="email" name="email" placeholder="" required>
            <span>E-Mail</span>
        </label> 
            
        <label>
            <input class="input" type="password" name="password" placeholder="" required>
            <span>Password</span>
        </label>
        <label>
            <input class="input" type="password" name="password_confirmation" placeholder="" required>
            <span>Confirm password</span>
        </label>
        <button class="submit">Register</button>
        <p class="signin">Already have an acount ? <a href="{{ route('filament.admin.auth.login') }}">Signin</a> </p>



        <!--
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
        -->
    </form>
</div>
@endsection