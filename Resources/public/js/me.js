/**
 * Created by developper on 15/05/17.
 */
function getFormattedDate(tmp) {
    if(tmp == null) return '--/--/----';
    return moment(tmp).format('DD/MM/YYYY H:mm:ss');
    var date = new Date(tmp);
    var year = date.getFullYear();
    var month = (1 + date.getMonth()).toString();
    month = month.length > 1 ? month : '0' + month;
    var day = date.getDate().toString();
    day = day.length > 1 ? day : '0' + day;
    return year + '-' + month + '-' + day;
    //return day + '/' + month + '/' + year;
}

$('.btn-form_action_delete').click(function (event) {
    event.preventDefault();

    swal({
            title: "Are you sure?",
            text: "You will not be able to recover this !",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                $('.form_action_delete').submit();
            } else {
                swal({
                    title: "Cancelled",
                    text: "Your in safe :)",
                    type: "error",
                    confirmButtonClass: "btn-danger"
                });
            }
        });

});

// fix check-toggle
$('.checkbox-toggle.-extra-large').parent().find('.form-control-static').remove();