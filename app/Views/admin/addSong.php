<?php
echo view('admin/header');
?>

<div class="content">
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <h1>Song Details</h1>
            <form id="song_frm" action="<?php echo base_url(); ?>admin/saveSong" method="POST">
                <div class="mb-3">
                    <label for="" class="form-label">Song Name</label>
                    <input type="text" name="song_name" class="form-control" id="" placeholder="Song Name" value="<?php echo (!empty($song_data['song_name']) ? $song_data['song_name'] : ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Song Link</label>
                    <input type="text" name="song_link" class="form-control" id="" placeholder="Song Link" value="<?php echo (!empty($song_data['song_link']) ? $song_data['song_link'] : ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Song Document</label>
                    <input type="file" name="song_document" class="form-control" <?php echo (!empty($_REQUEST['id']) ? '' : 'required') ?> >
                    <span>Previous Song: <?php echo (!empty($song_data['song_document']) ? $song_data['song_document'] : ''); ?></span>
                </div>

                <div class="mb-3">
                    <input type="hidden" name="song_id" value="<?php echo (!empty($_REQUEST['id']) ? $_REQUEST['id'] : ''); ?>" />
                    <input type="submit" class="btn btn-primary" id="song_btn" value="Save" />
                </div>
            </form>
        </div>
        <div class="col-md-3">

        </div>
    </div>
</div>

<?php
echo view('admin/footer');

?>