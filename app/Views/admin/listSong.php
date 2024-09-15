<?php
echo view('admin/header');

?>

<div class="content text-center">
    <div class="container">
        <div class="row">
            <h2>Song Management</h2>
            <div class="col-md-12 mt-5">
                <div class="text-end mt-3">
                    <a class="btn btn-success" href="<?php echo base_url(); ?>admin/addSong">Add New Song</a>
                </div>
                <table id="song_table">

                </table>
            </div>
        </div>
    </div>
</div>

<?php
echo view('admin/footer');

?>