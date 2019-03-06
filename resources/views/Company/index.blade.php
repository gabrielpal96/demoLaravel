@extends('layouts.main')

@section('title', 'company list')

@section('sidebar')
@parent
<h1>ccompany</h1>
@endsection

@section('content')

<?php
?>
@include('layouts._partials.search', ['action' => 'company','params'=>['name'=>trans('company.name'),'address'=>trans('company.address'),'bulstat'=>trans('company.bulstat')]])
<button class="btn" id="buttonDown">Множествени операции<span class="glyphicon glyphicon-arrow-down"></span> </button>
<br><br>
<div  id="chevron-down" style="display: none;">
    @can('company_delete',\App\Models\CompanyModel::class)
    <input type="button" value="изтрийте избраните компании" id="buttonClass" class="btn">
    @endcan
</div>
<table class="table" id="company">
    <thead>
    <th><input type="checkbox"  id="checkAll" style="display: none;"></th>
    <th><a href="/company/?ORDER=id" >{{trans('company.id')}}</a></th>
    <th><a href="/company/?ORDER=name" >{{trans('company.name')}}</a></th>
    <th><a href="/company/?ORDER=address">{{trans('company.address')}}</a></th>
    <th><a href="/company/?ORDER=bulstat">{{trans('company.bulstat')}}</a></th>
    <th><a >{{trans('company.category')}}</a></th>
    <th><a href="/company/?ORDER=note">{{trans('company.note')}}</a></th>
    <th><a href="/company/?ORDER=date_create">{{trans('company.date')}}</a></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
</thead>
<tbody >

    @foreach ($company as $c)
    <tr>
        <td><input type="checkbox" class="checkItem" id="checkItem" value="{{$c->id}}" name="{{$c->id}}" style="display: none;"></td>
        <td>{{$c->id}}</td>
        <td>{{$c->name}}</td>
        <td>{{$c->address}}</td>
        <td>{{$c->bulstat}}</td>
        <td>{{$c->category}}</td>
        <td>{{$c->note}}</td>
        <td>{{$c->date_create}}</td>
        <td style="visibility:hidden">{{$c->categoryId}}</td>
        <td><a href="{{route('show',['id'=>$c->id])}}" class="btn btn-success"><span class="glyphicon glyphicon-info-sign"> </span> </a></td>
        <td><a href="/person?id={{$c->id}}" class="btn btn-info"><span class="glyphicon glyphicon-user"></span><!-- {{trans('company.person')}}--></a></td>
        @can('company_edit',$c)
        <td><a href="{{route('edit',['id'=>$c->id])}}" class="btn btn-warning"> <span class="glyphicon glyphicon-edit"> </span></a></td>
        @endcan
        @can('company_delete', $c)
        <td>
            <a href="{{route('delete',['id'=>$c->id])}}" class="btn btn-danger delete-company" onclick="return  confirm('Сигурни ли сте, че искате да изтриете компанията?')">
                <span class="glyphicon glyphicon-trash"> </span>
            </a>
        </td>
        @endcan

    </tr>
    @endforeach

</tbody>
</table>       
<p>общо намерени:<b> {{$company->total()}}</b></p>
{{ $company->links() }}

@include('layouts._partials.perPage', ['action' => 'company'])

<script>
    $(document).ready(function () {
        $(document).ready(function () {
            $("#buttonDown").on("click", function () {
                $("#chevron-down").toggle();
                $("#checkAll").toggle();
                $(".checkItem").toggle();
            });
        });
        $('#checkAll').click(function () {
            $('input:checkbox').prop('checked', this.checked);
        });
        $(document).ready(function () {
            /* Get the checkboxes values based on the class attached to each check box */
            $("#buttonClass").click(function () {
                deleteMenyCompany();
            });

        });
        function deleteMenyCompany() {

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
                if (confirm("Are you sure you want to delete this?")) {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        type: 'POST',
                        url: '/company/deleteMenyCompany',
                        data: {id: chkArray, _token: _token},
                        success: function (data) {
                            location.reload();
                        },
                    })
                }

            } else {
                alert("Please at least check one of the checkbox");
            }
        }
//    console.dir($('table#company').find('td:nth-child(5)'));

        $.each($('table#company').find('td:nth-child(9)'), function (key, td) {
            if ($(td).html() == 1) {
                $(td).parent().addClass('category1')
            }
            if ($(td).html() == 2) {
                $(td).parent().addClass('category2')
            }
            if ($(td).html() == 3) {
                $(td).parent().addClass('category3')
            }
        });
    });
</script>
<style >
    .category1{
        background-color: #E0F2BE;
    }
    .category2{
        background-color: #00CC00;
    }
    .category3{
        background-color: #46b8da;
    }
</style>
@endsection

