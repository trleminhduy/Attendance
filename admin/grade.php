<?php
include('header.php');


?>

<div class="container" style="margin-top:30px">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9">Danh sách lớp</div>
                <div class="col-md-3" align="right">
                    <button type="button" id="add_button" class="btn btn-info btn-sm">Thêm lớp mới</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <span id="message_operation"></span>
                <table class="table table-striped table-bordered" id="grade_table">
                    <thead>
                        <tr>
                            <th>Tên lớp</th>
                            <th>Chỉnh sửa</th>
                            <th>Xoá</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>

</html>

<div class="modal" id="formModal">
    <div class="modal-dialog">
        <form method="post" id="grade_form">
            <div class="modal-content">
                <!-- modal header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title">Thêm lớp mới</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <label for="" class="col-md-4 text-right">TÊN LỚP <span class="text-danger">*</span>

                            </label>
                            <div class="col-md-8">
                                <input type="text" name="grade_name" id="grade_name" class="form-control">
                                <span id="error_grade_name" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="grade_id" id="grade_id">
                    <input type="hidden" name="action" id="action" value="Add">

                    <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm"
                        value="Add">



                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ĐÓNG</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        var dataTable = $('#grade_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "grade_action.php",
                type: "POST",
                data: { action: 'fetch' }
            }
        });

        $('#add_button').click(function () {
            $('#modal-title').text('Thêm lớp mới');
            $('#button_action').val('THÊM');
            $('#action').val('Add');
            $('#formModal').modal('show');
            clear_field();
        });

        $('#grade_form').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                url: "grade_action.php",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        $('#formModal').modal('hide');
                        dataTable.ajax.reload();
                        $('#message_operation').html('<div class="alert alert-success">' + data.success + '</div>');
                    }
                    if (data.error) {
                        if (data.error_grade_name != '') {
                            $('#error_grade_name').text(data.error_grade_name);
                        } else {
                            $('#error_grade_name').text('');
                        }
                    }
                }
            });
        });
        var grade_id = '';

        $(document).on('click', '.edit_grade', function () {
            grade_id = $(this).attr('id');

            $.ajax({
                url: "grade_action.php",
                method: "POST",
                data: { action: 'edit_fetch', grade_id: grade_id },
                dataType: "json",
                success: function (data) {
                    $('#grade_name').val(data.grade_name);
                    $('#grade_id').val(data.grade_id);
                    $('#modal-title').text("Edit Grade");
                    $('#button_action').val('Edit');
                    $('#action').val('Edit');
                    $('#formModal').modal('show');
                }
            });
        });

    });



</script>