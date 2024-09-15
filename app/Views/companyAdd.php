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
</style>

<div class="content  me-5 ms-5">
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <h1>Add Company Details</h1>
            <form id="company_frm" action="<?php echo base_url(); ?>home/companySave" method="POST">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Company Name</label>
                    <input type="text" name="company_name" class="form-control" id="exampleFormControlInput1" placeholder="Company Name" oninput="validateAlphabetInput(this)" value="<?php echo (!empty($company_data['company_name']) ? $company_data['company_name'] : ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Company Email</label>
                    <input type="email" class="form-control" name="company_email" placeholder="company@example.com" value="<?php echo (!empty($company_data['company_email']) ? $company_data['company_email'] : ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Company Telephone</label>
                    <input type="text" name="company_telephone" class="form-control" onkeyup="validateNumberInput(this);" placeholder="Company Telephone" maxlength="10" value="<?php echo (!empty($company_data['company_telephone']) ? $company_data['company_telephone'] : ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Company Address</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" placeholder="Company Address" name="company_address" required><?php echo (!empty($company_data['company_address']) ? $company_data['company_address'] : ''); ?></textarea>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="user_id" value="<?php echo (!empty($_SESSION['user_id']) ? $_SESSION['user_id'] : ''); ?>" />
                    <input type="submit" class="btn btn-primary" id="company_btn" value="Save" />
                </div>
            </form>
        </div>
        <div class="col-md-3">

        </div>
    </div>

</div>
<?php include('footer.php') ?>