<?php
echo view('header');
?>

<div class="content">
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <h1>Song Details</h1>
            <form>
                <div class="mb-3">
                    <label for="" class="form-label">Song Name</label>
                    <input type="text" name="song_name" readonly class="form-control" id="" placeholder="Song Name" value="<?php echo (!empty($song_data['song_name']) ? $song_data['song_name'] : ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Song Link</label>
                    <input type="text" name="song_link" readonly class="form-control" id="" placeholder="Song Link" value="<?php echo (!empty($song_data['song_link']) ? $song_data['song_link'] : ''); ?>" required>
                </div>
                <div class="mb-3">
                    <span>Previous Song: <?php echo (!empty($song_data['song_document']) ? $song_data['song_document'] : ''); ?></span>
                </div>

                
            </form>
        </div>
        <div class="col-md-3">

        </div>
    </div>
</div>

<?php
echo view('footer');

?>