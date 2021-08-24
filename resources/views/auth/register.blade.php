<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>

<div class="container">
<div class="row" style="margin-top:45px">
<div class="col-md-4 col-md-offset-4">
        <h2>Register</h2><hr>
        <form action="{{ route('auth.save')}}" method="post">
       @if(Session::get('success'))
       <div class="alert alert-success">
       {{Session::get('success')}}
       </div>
       @endif

        @if(Session::get('fail'))
       <div class="alert alert-danger">
       {{Session::get('fail')}}
       </div>
       @endif
       
        @csrf

        <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" placeholder="Enter your full names" value="{{old('name')}}">
        <span class="text-danger">@error('name'){{$message}} @enderror</span>
        </div>
        
        <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" name="email" placeholder="Enter your email address" value="{{old('email')}}">
        <span class="text-danger">@error('email'){{$message}} @enderror</span>
        </div>
        <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Enter your password"><br>
        <span class="text-danger">@error('password'){{$message}} @enderror</span>
        </div>
        <button type="submit" class="btn btn-block btn-primary">sign Up</button>
        <br>
        <a href="{{route('login')}}">i already have an account, sign In</a>
        </form>
</div>

</div>

</div>
    









<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
</body>
</html>