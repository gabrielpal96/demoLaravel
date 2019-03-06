$('#myFormSubmitButton').click(function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: '/user/changeEmail',
        data: $('form.tagForm').serialize(),
        success: function (data) {
            Message( data.message,data.alert);

            if (data != 'false') {
                $('#exampleModal').modal('hide');
                document.getElementById("email").innerHTML = data.email;

            }

        },
        error: function (data) {
            alert('Не е валиден емаил. Опитай пак.');
        }
    })
});
$('#exampleModal').on('show.bs.modal', function (event) {
    var return_first = function () {
        var tmp = null;
        $.ajax({
            'async': false,
            'type': "get",
            'global': false,
            'dataType': 'json',
            'url': "/user/getEmail",

            'success': function (data) {
                tmp = data;

            }
        });
        return tmp;
    }();

    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id')
    var modal = $(this)
    modal.find('.modal-title').text('Редактирай имаил: ' + return_first.email)
    modal.find('.modal-body input#recipient-name').val(return_first.email)
    modal.find('.modal-body input#recipient-id').val(id)

});
