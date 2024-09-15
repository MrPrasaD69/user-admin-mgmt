<?php
echo view('admin/header');
?>

<div class="content">
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <h1>User Details</h1>
            <form id="user_frm" action="<?php echo base_url(); ?>admin/userSave" method="POST">
                <div class="mb-3">
                    <label for="" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="" placeholder="Username" oninput="validateAlphabetInput(this)" value="<?php echo (!empty($user_data['username']) ? $user_data['username'] : ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <?php if (!empty($_REQUEST['id'])) { ?>
                        <input type="password" name="password" class="form-control" id="" placeholder="New Password will Update" minlength="8" value="">
                    <?php } else {
                    ?>
                        <input type="password" name="password" class="form-control" id="" placeholder="Password" minlength="8"  required>
                    <?php
                    } ?>
                </div>
                <div class="input-group">
                    <div class="col-md-3 mb-3 me-5">
                        <label for="" class="form-label">Profile <Picture></Picture></label>
                        <input type="file" name="profile_pic" class="form-control" id="" <?php echo (empty($_REQUEST['id']) ? 'required' : ''); ?> >
                    </div>
                    <?php if (!empty($_REQUEST['id'])) { ?>
                        <div class="col-md-3 ms-5 mb-3 mt-5">
                            <img src="<?php echo base_url(); ?>upload/profile_pic/<?php echo (!empty($user_data['profile_pic']) ? $user_data['profile_pic'] : ''); ?>" height="50" width="50"  alt="Profile Pic" />
                        </div>
                    <?php } ?>
                </div>
                <div class="mb-3">
                    <div class="mb-3">
                        <label>User Status</label>
                        <select class="form-control" name="user_status">
                            <option value="">Select</option>
                            <option <?php if(!empty($user_data) && $user_data['status']=="1"){ echo "selected";} ?> value="1">Active</option>
                            <option <?php if(!empty($user_data) && $user_data['status']=="0"){ echo "selected";} ?> value="0">Soft Deleted</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="user_id" value="<?php echo (!empty($_REQUEST['id']) ? $_REQUEST['id'] : ''); ?>" />
                    <input type="submit" class="btn btn-primary" id="user_btn" value="Save" />
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