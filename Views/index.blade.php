@extends('base')

@section('content')

<div class="container">

   <div class="row mt-5">

       <div class="col-md"></div>

       <div class="col-md-8 bg-light align-items-center" style="height: 300px">
           <form action="/start" method="GET">

               <div class="form-group">
                   <label for="inputName">输入昵称，加入聊天室：</label>
                   <input type="text" class="form-control" name="user_name" id="inputName" aria-describedby="emailHelp">
               </div>

               <button type="submit" class="btn btn-primary">开始骚聊</button>
           </form>
       </div>

       <div class="col-md"></div>

   </div>
</div>

@endsection
