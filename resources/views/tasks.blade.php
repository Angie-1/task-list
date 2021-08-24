<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>tasks</title>
</head>
<body>
<div class="">
<h3 class="text-center fw-bold text-decoration-underline">TASK DETAILS</h3> <a href="/add-task" class="btn btn-secondary float-right">Create New Task</a><br>
</div>
@if(Session::has('task_deleted'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
      <span class="text-success"><h5>{{session()->get('task_deleted')}}</h5></span>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
@endif


@if(Session::has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      <span class="text-success"><h5>{{session()->get('success')}}</h5></span>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      </button>
  </div>
<!-- <div class="alert alert-success" role="alert">
    {{Session::get('success')}}
</div> -->
@endif
<table class="table table-hover">

    <thead>
      <tr>
      <th>Task Number </th>
        <th>Task Title </th>
        <th>Task Description</th>
         <th>Task Date</th>
        <th class="text-center">Action</th>
      </tr>
    </thead> 
    <tbody>
    @foreach ($tasks as $task)
      <tr>
       <td>{{$task->id}}</td>
        <td>{{$task->title}}</td>
        <td><p>{{$task->body}}</p></td>
        <td><p>{{$task->datetime}}</p></td>
        <td> <a href="/delete-task/{{$task->id}}" class="btn btn-danger">delete</a></td>
        <td><a href="/edit-task/{{$task->id}}" class="btn btn-info">edit</a></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  
</div>

<div  style="text-align:center">
  <a href="{{route ('auth.logout') }}">logout</a>
</div>
  <br>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>  
</body>
</html>