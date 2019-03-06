@extends('layouts.main')

@section('title', 'permissions')

@section('content')

<?php
?>
<div class="container">
    <center>
        <button type="button" class="btn " data-toggle="modal" data-target="#exampleModal" >нова роля  
            <span class="glyphicon glyphicon-plus" ></span>    
        </button>
    </center>
</div>
<br><br><br>
<div class="container">
    <div class="panel-group" id="accordion">
        @foreach ($roles as $role )

        <center class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#{{$role['name']}}"> <b>{{trans('users.role')}} {{$role['name']}} {{trans('users.permissions')}}:</b></a>
                </h4>
            </div>
            <div id="{{$role['name']}}" class="panel-collapse collapse">
                <div class="panel-body">
                    <center>
                        {!! Form::open(['route' => 'permissionsAction','method' => 'post']) !!}
                        @foreach ($grups as $grup )
                        {{Form::label('grup',$grup['name'])}}
                        @foreach ($permissions as $permission )

                        <?php
                        $flag = 0;
                        foreach ($role['permission'] as $role_permission) {
                            if ($permission['id'] == $role_permission['id']) {
                                $flag = 1;
                                break;
                            }
                        }
                        ?>
                        @if($grup['id']==$permission['perdmissions_grups_id'])
                        <div class="form-group row">
                            {{Form::label('name', $permission['name'])}}
                            {!!Form::checkbox($permission['name'], $permission['id'],$flag) !!}
                        </div>
                        @endif
                        @endforeach

                        @endforeach
                        {{Form::hidden('role_id', $role['id'])}}
                        {{Form::submit(trans('buttons.submit'),['class'=>'form-control btn btn-success'])}}
                        {!! Form::close() !!}
                    </center>
                </div>
            </div>
        </center>


        @endforeach
    </div>
</div>
<br><br>
<a href="/user" class="btn btn-primary btn-lg btn-block">{{trans('buttons.back')}}</a>


<!--bootstrap modal form edit email-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="recipient-name" class="col-form-label">роля:</label>
                        <input type="text" class="form-control" id="recipient-name" name="role">
                    </div>
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
    $('#myFormSubmitButton').click(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/admin/newRole',
            data: $('form.tagForm').serialize(),
            success: function (data) {
                alert(data);
                window.location.reload(true);
            },
            error: function (data) {
                alert(data);
            }
        })
    });
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var role = button.data('role') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('нова роля')


    })
</script>
@endsection

