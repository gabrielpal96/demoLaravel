@extends('layouts.main')

@section('title', 'person list')

@section('sidebar')
@parent
<h1>ccompany</h1>
@endsection

@section('content')

<?php
//echo"<pre>";
//print_r($position);
//echo"</pre>";
?>
@if($person->total()!=0)
<div >
    @include('layouts._partials.search', ['action' => 'person','params'=>['name'=>trans('persons.name'),'EGN'=>trans('persons.EGN')]])

</div>
<button class="btn" id="buttonDown">Множествени операции<span class="glyphicon glyphicon-arrow-down"></span> </button>
<br><br>
<div  id="chevron-down" style="display: none;">
    @can('person_delete',\App\Models\PersonModel::class)
    <input type="button" value="изтрийте избраните служители" id="buttonClass" class="btn">
    @endcan
    <input type="button" value="променете позицията на избраните служители" id="buttonPosition" class="btn " data-toggle="modal" data-target="#exampleModal">
</div>
<table class="table" id="table1">
    <thead>
    <th><input type="checkbox"  id="checkAll" style="display: none;"></th>
    <th><a href="/person/?ORDER=id">{{trans('persons.id')}}</a></th>
    <th><a href="/person/?ORDER=name" >{{trans('persons.name')}}</a></th>
    <th><a href="/person/?ORDER=EGN">{{trans('persons.EGN')}}</a></th>
    <th><a href="/person/?ORDER=birthDate"> дата на раждане</a></th>
    <th><a href="/person/?ORDER=position">{{trans('persons.position')}}</a></th>
    <th><a href="/person/?ORDER=company" >{{trans('persons.company')}}</a></th>
    <th><a href="/person/?ORDER=email">{{trans('persons.email')}}</a></th>
    <th><a href="/person/?ORDER=city">Град</a></th>
    <th></th>
    <th></th>

</thead>
<tbody >
    @foreach ($person as $p)
    <tr>
        <td><input type="checkbox" class="checkItem" id="checkItem" value="{{$p->id}}" name="{{$p->id}}" style="display: none;"></td>
        <td>{{$p->id}}</td>
        <td>{{$p->name}}</td>
        <td>{{$p->EGN}}</td>
        <td>{{$p->birthDate}}</td>
        <td>{{$p->position}}</td>
        <td>{{$p->company}}</td>
        <td>{{$p->email}}</td>
        <td>{{$p->city}}</td>
        @can('person_edit',$p)
        <td><a href="{{route('editPerson',['id'=>$p->id])}}" class="btn btn-warning"><span class="glyphicon glyphicon-edit"> </span></a></td>
        @endcan
        @can('person_delete',$p)
        <td>
            <a href="{{route('deletePerson',['id'=>$p->id])}}" class="btn btn-danger delete-company" onclick="return  confirm('Сигурни ли сте, че искате да изтриете потребителя?')">
                <span class="glyphicon glyphicon-trash"> </span>
            </a>
        </td>
        @endcan


    </tr>
    @endforeach
</tbody>
</table>       
@if(Request::get('id'))
<a href="/company" class="btn btn-success">back</a>
<br><br>
@endif
<p>общо намерени:<b> {{$person->total()}}</b></p>
{{ $person->links() }}
@include('layouts._partials.perPage', ['action' => 'person'])
@else 
<h1>Няма намерен потребител за тая фирма</h1>
<a href="/company" class="btn btn-success">Върни се Обратно</a>
@endif
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
                {{Form::open(['class'=>"tagForm"]) }}
                <div class="form-group">
                    {{Form::label('position', trans('persons.position'))}}
                    {{Form::select('position', $position)}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="myFormSubmitButton" class="btn btn-primary">Запиши</button>
                </div>
                {!! Form::close() !!}

            </div>

        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#table1 tr:even:gt(0)").css("background-color", "#EFF1F1");
            $("#table1 tr:odd").css("background-color", "#abefa7");

            $("#buttonDown").on("click", function () {
                $("#chevron-down").toggle();
                $("#checkAll").toggle();
                $(".checkItem").toggle();
            });

            $('#checkAll').click(function () {
                $('input:checkbox').prop('checked', this.checked);
            });
            $(document).ready(function () {
                /* Get the checkboxes values based on the class attached to each check box */
                $("#buttonClass").click(function () {
                    deleteMenyPerson();
                });
                $("#buttonPosition").click(function () {
                    changePosition();
                });
            });
            function changePosition() {
                /* declare an checkbox array */
                var chkArray = [];
                /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
                /* we join the array separated by the comma */
                var selected;
                selected = chkArray.join(',');
            }
            $('#myFormSubmitButton').click(function (e) {
                console.log(11);
                e.preventDefault();
                var chkArray = [];
                $("#checkItem:checked").each(function () {
                    chkArray.push($(this).val());
                });
                var selected;
                selected = chkArray.join(',');
                if (selected.length > 0) {

                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        type: 'POST',
                        url: '/person/changePosition',
                        data: {
                            position: $('form.tagForm').serializeArray(),
                            personsId: chkArray,
                            _token: _token
                        },
                        success: function (data) {
                            window.location.reload(true);
                        },
                        error: function (data) {
                        }
                    })
                } else {
                    alert("Please at least check one of the checkbox");
                    $('#exampleModal').modal('hide');
                }

            });
            function deleteMenyPerson() {
                /* declare an checkbox array */
                var chkArray = [];
                /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
                $("#checkItem:checked").each(function () {
                    chkArray.push($(this).val());
                });
                /* we join the array separated by the comma */
                var selected;
                selected = chkArray.join(',');
                /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
                if (selected.length > 0) {
                    var _token = $('input[name="_token"]').val();
                    if (confirm("Are you sure you want to delete this?")) {
                        $.ajax({
                            type: 'POST',
                            url: '/person/deleteManyPerson',
                            data: {data: chkArray, _token: _token},
                            success: function (data) {
                                location.reload();
                            },
                        })
                    }
                } else {
                    alert("Please at least check one of the checkbox");
                }
            }
        });
    </script>
    @endsection

