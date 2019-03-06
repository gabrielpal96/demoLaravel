<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">нова компания</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="tagForm">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">компания:</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">адрес:</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">булстат</label>
                        <input type="text" class="form-control" id="bulstat" name="bulstat">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">бележка</label>
                        <input type="text" class="form-control" id="note" name="note">
                    </div>
                    <div class="form-group row">
                        {{Form::label('category', 'категория')}}
                        {{Form::select('category', $category)}}
                    </div>
                    <input type="hidden"  name="id" id="recipient-id">
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
<script>
    $('#myFormSubmitButton').click(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/company/save',
            data: $('form.tagForm').serialize(),
            success: function (data) {
                alert('добавихте успешно фирмата');
                $('#exampleModal').modal('hide');
            },
            error: function (data) {
                var error = ''
                $.each(data.responseJSON, function (index, value) {
                    error += value[0] + ('\n');
                });
                alert(error);
            }
        })
    });
</script>