<?php

echo view('admin/header');

?>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    .pagination {
        margin: 20px 0;
    }

    .pagination a {
        margin: 0 5px;
        text-decoration: none;
        padding: 5px 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .pagination a.active {
        background-color: #303f9f;
        color: white;
    }
</style>
<div class="content text-center">
    <div class="container">
        <h2>User Management</h2>

        <div class="row">
            <div class="col-md-12">
                <div class="text-end mb-3">
                    <a href="<?php echo base_url(); ?>/admin/userAdd" class="btn btn-success">Add New User</a>
                </div>
                <table id="user_table" class="table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($result)) {
                            foreach ($result as $key => $user) {
                        ?>
                                <tr>
                                    <td><?php echo $startIndex + $key + 1; ?></td>
                                    <td><?php echo (!empty($user['username']) ? $user['username'] : ''); ?></td>
                                    <td><?php echo (!empty($user['status']) && $user['status'] == 1 ? 'Active' : 'Soft Deleted') ?></td>
                                    <td><a class="btn btn-primary" href="<?php echo base_url(); ?>admin/userAdd?id=<?php echo $user['user_id'] ?>">Edit</a> | <button class="btn btn-danger" onclick="deleteUser(<?php echo $user['user_id'] ?>);">Delete</button></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php echo $pager->links(); ?>
            </div>
        </div>
    </div>
</div>

<?php
echo view('admin/footer');

?>