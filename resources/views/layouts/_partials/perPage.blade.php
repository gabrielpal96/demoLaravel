<div class="panel panel-body">по 
    <form action="/{{ $action }}">
        <select name="list">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="50">50</option>
        </select>
        на страница
        <input type="submit" value="{{trans('buttons.submit')}}">
    </form>
</div>