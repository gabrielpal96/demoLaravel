<?php ?>
<button class="btn" id="button"><span class="glyphicon glyphicon-search"></span></button>
<br><br>
<div class="well well-sm" id="search" style="display: none;" >
    <b>search:</b>
    <form method="get" action="{{$action}}/"id="form">

        <div class="panel panel-body">
            @foreach($params as $param=>$text)
            <div class="col-md-2">
                <div><b>{{$text}}:</b></div>
                <input type="text" name="search[{{$param}}]" value="{{Request::get('search')["$param"]}}"/>
            </div>
            @endforeach


            <div class="col-md-2">
                <div> <p> </p>  </div>
                <input type="submit" value="Search" class="btn btn-info btn-lg" />
            </div>
        </div>

    </form> 
</div>
<?php
$flag = 0;
if (Request::has('search')) {
    $flag = 1;
}
?>
<script>
    $(document).ready(function () {
    if ({{$flag}}) {
    $('#search').show();
    }

    $("#button").on("click", function () {
    $("#search").toggle();
    });
    });


</script>