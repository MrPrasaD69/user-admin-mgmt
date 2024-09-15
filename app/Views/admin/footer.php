<footer>
    <script>
        $(document).ready(function() {

            //Song Datatable
            var song_table = $("#song_table").DataTable({
                "processing": true,
                lengthMenu: [5, 10, 25, 50],
                paging: true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>admin/listSong",
                    "type": "POST",
                    "data": function(d) {}
                },
                columns: [{
                        "data": "sr_no",
                        title: 'Sr No'
                    },
                    {
                        "data": "song_name",
                        title: 'Song Name'
                    },
                    {
                        "data": "song_link",
                        title: 'Song Link'
                    },
                    {
                        "data": "song_document",
                        title: 'Song Audio',
                        render: function(data, row) {
                            return '<audio controls><source src="' + data + '" type="audio/mp3" >Your Browser does not support mp3</audio>';
                        }
                    },
                    {
                        "data": "song_id",
                        title: 'Action',
                        render: function(data, row) {
                            return '<a class="btn btn-primary" href="<?php echo base_url(); ?>admin/addSong?id=' + data + '">Edit</a> | <button class="btn btn-danger" onclick="deleteSong('+data+')">Delete</button>';
                        }
                    }
                ]
            });

            //Add User
            var user_frm = $("#user_frm");
            var user_btn = $("#user_btn");

            user_btn.click(function() {
                user_frm.ajaxForm({
                    beforeSend: function() {
                        user_btn.prop('disabled', true);
                    },
                    success: function(data) {
                        user_btn.prop('disabled', false);
                        var resp = data.split('::');

                        if (resp[0] == 200) {
                            Swal.fire({
                                title: "Good job!",
                                text: resp[1],
                                icon: "success"
                            }).then(() => {
                                window.location = 'userList';
                            })
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: resp[1],
                            });
                        }
                    },
                    error: function(err) {
                        user_btn.prop('disabled', false);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                        });
                    }
                })
            })

            //Add Song
            var song_frm = $("#song_frm");
            var song_btn = $("#song_btn");

            song_btn.click(function() {
                song_frm.ajaxForm({
                    beforeSend: function() {
                        song_btn.prop('disabled', true);
                    },
                    success: function(data) {
                        song_btn.prop('disabled', false);
                        var resp = data.split('::');

                        if (resp[0] == 200) {
                            Swal.fire({
                                title: "Good job!",
                                text: resp[1],
                                icon: "success"
                            }).then(() => {
                                window.location = 'listSong';
                            })
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: resp[1],
                            });
                        }
                    },
                    error: function(err) {
                        song_btn.prop('disabled', false);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                        });
                    }
                })
            })


        });

        //Delete User
        function deleteUser(id) {
            if (id) {
                Swal.fire({
                    title: "Do you want to Delete User?",
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonText: "Delete",
                    denyButtonText: `Don't Delete`
                }).then((result) => {

                    if (result.isConfirmed) {
                        $.ajax({
                            url:'<?php echo base_url(); ?>admin/deleteUser',
                            data:'user_id='+id,
                            type:'GET',
                            success:function(data){
                                var resp = data.split('::');
                                if(resp[0]==200){
                                    Swal.fire("Deleted!", "", "success").then(()=>{
                                        window.location.reload();
                                    })
                                }
                                else{
                                    Swal.fire("Not Deleted!", "", "error");
                                }
                            },
                            error:function(err){
                                Swal.fire("Something Went Wrong!", "", "error");
                            }
                        })
                        
                    }
                });
            }
        }
    
        //Delete Song
        function deleteSong(id) {
            if (id) {
                Swal.fire({
                    title: "Do you want to Delete Song?",
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonText: "Delete",
                    denyButtonText: `Don't Delete`
                }).then((result) => {

                    if (result.isConfirmed) {
                        $.ajax({
                            url:'<?php echo base_url(); ?>admin/deleteSong',
                            data:'song_id='+id,
                            type:'GET',
                            success:function(data){
                                var resp = data.split('::');
                                if(resp[0]==200){
                                    Swal.fire("Deleted!", "", "success").then(()=>{
                                        window.location.reload();
                                    })
                                }
                                else{
                                    Swal.fire("Not Deleted!", "", "error");
                                }
                            },
                            error:function(err){
                                Swal.fire("Something Went Wrong!", "", "error");
                            }
                        })
                        
                    }
                });
            }
        }
        
    
    </script>
</footer>

</body>

</html>