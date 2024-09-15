<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>User List</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='//cdn.datatables.net/2.1.5/css/dataTables.dataTables.min.css'>
    
    <script src='//cdn.datatables.net/2.1.5/js/dataTables.min.js'></script>
</head>
<body>
    <div class="row">
        
        <table id="user_table">

        </table>
    </div>
</body>
<script>
    $(document).ready(function(){
        var datatable = $("#user_table").DataTable({
            "processing": true,
            lengthMenu:[5,10,25,50],
            paging:true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>home/userList",
                "type": "POST",
                "data": function (d) {
                    d.last_name = $("#last_name").val();
                }
            },
            columns:[
                { "data": "first_name", title:'First Name' },
                { "data": "last_name", title:'Last Name' },
            ]
        });

        $('#last_name').on('keyup change', function () {
            datatable.draw();
        });
    })
</script>
</html>