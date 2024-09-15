<?php include('header.php'); ?>

<div class="content text-center me-5 ms-5">
    <h2>Song List</h2>
    <table id="song_table" class="display">

    </table>
</div>


<script>
    $(document).ready(function() {
        var table = $('#song_table').DataTable({
            "processing": true,
            lengthMenu: [5, 10, 25, 50],
            paging: true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>home/listSong",
                "type": "POST",
                "data": function(d) {}
            },
            columns: [
                {
                    "data": "sr_no",
                    title: 'Sr No'
                },
                {
                    "data": "song_name",
                    title: 'Song Name'
                },
                {
                    "data": "song_link",
                    title: 'Song Link',
                    render : function(data,type, row){
                        return '<a href="<?php echo base_url(); ?>home/songDetail?id='+row.song_id+'">'+data+'</a>';
                    }
                },
                {
                    "data": "song_document",
                    title: 'Song Audio',
                    render: function(data, row) {
                        return '<audio controls><source src="' + data + '" type="audio/mp3" >Your Browser does not support mp3</audio>';
                    }
                },
            ]
        });
    })
</script>
<?php include('footer.php'); ?>