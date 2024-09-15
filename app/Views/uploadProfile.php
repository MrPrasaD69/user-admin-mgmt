<?php include('header.php'); ?>

<style>
    body {
        margin: 0;
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
    }

    .container {
        display: flex;
        height: 100vh;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        background-color: #655fa1;
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px 0;
    }

    .sidebar h2 {
        margin-bottom: 30px;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
        width: 100%;
    }

    .sidebar ul li {
        width: 100%;
    }

    .sidebar ul li a {
        color: #fff;
        display: flex;
        align-items: center;
        padding: 15px 20px;
        text-decoration: none;
        width: 100%;
        transition: background-color 0.3s;
    }

    .sidebar ul li a:hover {
        background-color: #303f9f;
    }

    .sidebar ul li a i {
        margin-right: 10px;
    }

    /* Main Content */
    .main-content {
        flex: 1;
        padding: 20px;
        position: relative;
    }

    .topbar {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 10px 0;
    }

    /* Profile Picture Icon */
    .profile-container {
        position: relative;
    }

    .profile-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
    }

    /* Tooltip/Popup for Logout */
    .logout-popup {
        display: none;
        position: absolute;
        right: 0;
        top: 50px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 10px;
        z-index: 10;
        width: 150px;
    }

    .logout-popup a {
        text-decoration: none;
        color: #333;
        display: block;
        padding: 5px 10px;
    }

    .logout-popup a:hover {
        background-color: #f4f4f4;
    }

    /* Content */
    .content {
        margin-top: 20px;
    }

    .upload__submit {
        background: #fff;
        font-size: 14px;
        margin-top: 30px;
        padding: 16px 20px;
        border-radius: 26px;
        border: 1px solid #D4D3E8;
        text-transform: uppercase;
        font-weight: 700;
        display: flex;
        align-items: center;
        width: 100px;
        color: #4C489D;
        box-shadow: 0px 2px 2px #5C5696;
        cursor: pointer;
        transition: .2s;
    }

    .upload__submit:active,
    .upload__submit:focus,
    .upload__submit:hover {
        border-color: #6A679E;
        outline: none;
    }
</style>

<div class="content text-center me-5 ms-5">
    <h1>Upload Your Profile Picture</h1>
    <div class="mb-3 row">
        <div class="col-md-4">
        </div>

        <div class="col-md-4">
            <form id="frm" action="<?php echo base_url(); ?>home/uploadProfilePicture" method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <div class="col-md-6">
                        <input type="file" class="form-control" id="profile_pic" name="profile_pic" required>
                    </div>
                    <?php if(!empty($user_data['profile_pic'])){ ?>
                    <div class="col-md-6">
                        <span>Current Profile Picture: </span>
                        <img src="<?php echo (!empty($user_data['profile_pic']) ? base_url().'upload/profile_pic/'.$user_data['profile_pic'] : '');?>" alt="Profile Pic" height="50" width="50"/>
                    </div>
                    <?php } ?>
                </div>
                <button type="submit" id="btn" class="button upload__submit">
                    <span class="button__text">Upload</span>
                    <i class="button__icon fas fa-chevron-right"></i>
                </button>
            </form>
        </div>
        <div class="col-md-4">

        </div>
    </div>
</div>

<script>
    function toggleLogoutPopup() {
        const popup = document.getElementById('logoutPopup');
        if (popup.style.display === 'block') {
            popup.style.display = 'none';
        } else {
            popup.style.display = 'block';
        }
    }

    // Close the popup when clicking outside
    document.addEventListener('click', function(event) {
        const popup = document.getElementById('logoutPopup');
        const profileIcon = document.querySelector('.profile-icon');

        if (!popup.contains(event.target) && !profileIcon.contains(event.target)) {
            popup.style.display = 'none';
        }
    });

    $(document).ready(function() {
        var frm = $("#frm");
        var btn = $("#btn");

        btn.click(function() {
            frm.ajaxForm({
                beforeSend: function() {
                    btn.prop('disabled', true);
                },
                success: function(data) {
                    btn.prop('disabled', false);
                    var resp = data.split('::');

                    if (resp[0] == 200) {
                        Swal.fire({
                            title: "Good job!",
                            text: resp[1],
                            icon: "success"
                        }).then(() => {
                            window.location.reload();
                        })
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: resp[1],
                        }).then(() => {
                            window.location.reload();
                        })
                    }
                },
                error: function(err) {
                    btn.prop('disabled', false);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                    }).then(() => {
                        window.location.reload();
                    })
                }
            })
        });
    });
</script>
<?php include('footer.php'); ?>