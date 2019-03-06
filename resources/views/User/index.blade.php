@extends('layouts.main')

@section('title', 'user list')

@section('sidebar')
    @parent
    <h1>ccompany</h1>
@endsection

@section('content')
    <?php
    //echo"<pre>";
    //print_r($role);
    //echo"</pre>";
    foreach ($role as $r) {
        $tmp[$r['id']] = $r['name'];
    }
    $role = $tmp;
    ?>
    <div class="well well-sm">
        <center>
            <a href="{{route('permissions')}}" class="btn btn-success">{{trans('nav.role_permissions')}} </a>
            <a href="{{route('newUser')}}" class="btn btn-success">{{trans('nav.newUser')}}</a>
        </center>
    </div>

    @include('layouts._partials.search', ['action' => 'user','params'=>['username'=>trans('users.username'),'email'=>trans('users.email')]])

    <table class="table" id="users">
        <thead>
        <th><a href="/user/?ORDER=id">{{trans('users.id')}}</a></th>
        <th><a href="/user/?ORDER=avatar">{{trans('users.avatar')}}</a></th>
        <th><a href="/user/?ORDER=username">{{trans('users.username')}}</a></th>
        <th><a href="/user/?ORDER=email">{{trans('users.email')}}</a></th>
        <th><a>{{trans('users.role')}}</a></th>
        <th><a href="/user/?ORDER=active">{{trans('users.status')}}</a></th>

        <th></th>
        <th></th>
        <th></th>

        </thead>
        <tbody>
        @php ($cmt = 1)
        @foreach ($user as $u)
            <tr>
                <td>{{$u->id}}</td>
                <td>
                    @if($u->avatar!=NULL)
                        <a href="{{route('addPhoto',['id'=>$u->id])}}">
                            <img src="upload/user/{{$u->id}}/{{$u->avatar}}" alt="Italian Trulli" width="50" height="50"
                                 style="  border-radius: 50%;">
                        </a>
                    @endif
                </td>
                <td>{{$u->username}}</td>
                <td><span id="email">{{$u->email}}</span>
                    <button type="button" class="btn " data-toggle="modal" data-target="#exampleModal"
                            data-email="{{$u->email}}" data-id="{{$u->id}}">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                </td>
                <td>


                    <select class="test" id="{{$u->id}}" @if(Auth::user()->id==$u->id) disabled @endif>
                        <?php
                        foreach ($role as $key => $value) {
                        ?>
                        <option value="{{$key}}" @if($u->role_id==$key) selected @endif>{{$value}}</option>
                    <?php }
                    ?>
                    <!--                @foreach ($role as $key => $value)
                        <option value="volvo">$key</option>
@endforeach
                            <option value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                            <option value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>-->
                    </select>

                <!--            {{Form::open(['route' =>null,'method' => null,'class' =>'form']) }}
                {{ Form::hidden('user_id',$u->id ) }}
                {{Form::select('role_id',$role,$u->role_id, ['class' =>'test','id'=>$u->id])}}
                        <br>
            
                        {{Form::submit(trans('buttons.submit'),['class'=>'btn btn-success'])}}
                {!! Form::close() !!}-->
                </td>
                <td>
                    @if(Auth::user()->id!=$u->id)
                        @if($u->active==1)
                            <a href="{{route('changeStatus',['id'=>$u->id])}}" class="btn btn-success"><span
                                        class="glyphicon glyphicon-ok"> </span> {{trans('users.active')}}</a>
                        @else
                            <a href="{{route('changeStatus',['id'=>$u->id])}}" class="btn btn-danger"><span
                                        class="glyphicon glyphicon-remove"> </span> {{trans('users.noActive')}}</a>
                        @endif
                    @endif
                </td>

                <td>
                    @if($u->avatar!=NULL)
                        <a href="{{route('photoDelete',['id'=>$u->id])}}" class="btn btn-info"
                           onclick="return  confirm('Сигурни ли сте, че искате да изтриете снимката на потребителя?')">
                            <span class="glyphicon glyphicon-remove"> </span> {{trans('users.deletePhoto')}}
                        </a>
                    @endif
                </td>
                <td>
                    @if($u->avatar!=NULL)
                        <a href="{{route('addPhoto',['id'=>$u->id])}}" class="btn btn-warning"><span
                                    class="glyphicon glyphicon-picture"> </span> {{trans('users.viewPhoto')}}</a>
                    @else
                        <a href="{{route('addPhoto',['id'=>$u->id])}}" class="btn btn-warning"><span
                                    class="glyphicon glyphicon-edit"> </span> {{trans('users.addPhoto')}}</a>
                    @endif
                </td>
                <td>
                    <a href="{{route('deleteUser',['id'=>$u->id])}}" class="btn btn-danger delete-company"
                       onclick="return  confirm('Сигурни ли сте, че искате да изтриете потребителя?')">
                        <span class="glyphicon glyphicon-trash"> </span>
                    </a>
                </td>


            </tr>
        @endforeach
        </tbody>
    </table>
    <p>общо намерени:<b> {{$user->total()}}</b></p>
    {{ $user->links() }}
    @include('layouts._partials.perPage', ['action' => 'user'])

    <!--bootstrap modal form edit email-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="tagForm">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Email:</label>
                            <input type="text" class="form-control" id="recipient-name" name="email">
                        </div>
                        <input type="hidden" name="id" id="recipient-id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="myFormSubmitButton" class="btn btn-primary">Запиши</button>
                </div>
            </div>
            </form>
        </div>

    </div>
    </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#users tr:even:gt(0)").css("background-color", "#EFF1F1");
            $("#users tr:odd").css("background-color", "#abefa7");
            $('#myFormSubmitButton').click(function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '/user/changeEmail',
                    data: $('form.tagForm').serialize(),
                    success: function (data) {
                        window.location.reload(true);
                    },
                    error: function (data) {
                        alert('Не е валиден емаил. Опитай пак.');
                    }
                })
            });
            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var email = button.data('email') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var id = button.data('id')
                var modal = $(this)
                modal.find('.modal-title').text('Редактирай имаил: ' + email)
                modal.find('.modal-body input#recipient-name').val(email)
                modal.find('.modal-body input#recipient-id').val(id)

            })
        });
        var val = 0
        $(".test").click(function (event) {
            val = ($(this).val());
        });
        $(".test").change(function (event) {
            var id = (this.id);

            if (confirm('сифърни ли сте?')) {
                var id_user = event.target.id;
                var role = event.target.value;
                console.log(id_user + '=' + role);
                $.ajax({
                    type: 'get',
                    url: '/user/saveRole',
                    dataType: 'json',
                    data: {user_id: id_user, role_id: role},
                    success: function (data) {

                        Message( data.message,data.alert);
                    },
                    error: function (data) {
                        alert('Не е валиден емаил. Опитай пак.');
                    }
                })
            } else {
                document.getElementById(id).value = val;
            }
        });
    </script>

@endsection

