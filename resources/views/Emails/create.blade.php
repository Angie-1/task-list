@extends("Layout.master")
@section("page-title","Send Email")

@section("content")

<form action="{{url("/email")}}" method="post">
        @csrf
        <div class="row">
        <div class="col-sm-12">
                <!-- <div class="form-group">
                    <label>Email To</label>
                    <select name="email_to" id="" class="form-control">
                    <option value="0" selected disabled>Select User</option>
                    @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                    </select>
                </div> -->
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Subject</label>
                    <input name="subject" class="form-control" required placeholder="Enter Subject">
                </div>
            </div>
            <!-- <div class="col-sm-12">
                <div class="form-group">
                    <label>Tasks</label>
                    <textarea class="form-control" name="tasks" id="" cols="30" rows="10"></textarea>
                </div> -->
                <div class="form-group">
                    <label>Tasks</label>
                    <select name="tasks" id="" class="form-control">
                    <option value="0" selected disabled>Select Task</option>
                    @foreach($tasks as $task)
                    <option value="{{$task->id}}">{{$task->title}}</option>
                    @endforeach
                    </select>
            </div>
            <div class="col-sm-12">
                <div class="form-group float-end m-2">
                    <button id="btnSendEmail"  type="submit" class="btn btn-outline-info float-right">Send</button>
                </div>
            </div>
        </div>
    </form>

@endsection