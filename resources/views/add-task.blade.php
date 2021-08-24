<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    
    <title>add-task</title>
</head>
<body>
<br>
<div class="container">

  <div class="card">
    <div class="card-header  bg-secondary text-white"><h3>ADD NEW TASK</h3></div>
    <div class="card-body">
    
    @if(Session::has('task_created'))
    <div class="alert alert-success" role="alert">
        {{Session::get('task_created')}}
        </div>
    @endif

    <form method="post" action="{{route('tasks.addTaskSubmit')}}">
        @csrf
    <div class="mb-3">
    <label for="title" class="form-label"><b>Task title</b></label>
    <input type="text" name="title" class="form-control" placeholder="enter task title"/>
    </div>
    <div>
    <label for="body"><b>Task description</b></label> 
        <textarea class="form-control" name="body" rows="3"></textarea><br>
        </div>
     <div>
       <label for="datetime" class="form-label"><b>Task to be done On:</b></label>
       <input type="datetime-local" name="datetime" class="form-control"><br>
     </div>   
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
    
    
    
    
    
    </div> 
    <div class="card-footer  bg-secondary text-white "><a href="/tasks" class="btn btn-light float-right">view tasks</a></td></div>
  </div>
  
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>  
  
</body>
</html>