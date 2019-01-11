<?php
require_once DOCUMENT_ROOT . '/taka_garden/admin/entities/User.php';
$list = Users::loadUserName();
echo count($list);
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <small>List Users</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">List Users</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Permission</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($list)) { ?>
                        <?php for ($i = 0; $i < count($list); $i++) { ?>
                            <tr>
                                <td><?php echo $list[$i]->getId(); ?></td>
                                <td><?php echo $list[$i]->getUsername(); ?></td>
                                <td> <?php echo $list[$i]->getName(); ?></td>
                                <td><?php echo $list[$i]->getEmail(); ?></td>
                                <td><?php if($list[$i]->getPermission() == 0) echo 'User';   else echo 'Admin'; ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>


<script type="text/javascript">
    function confirm_click()
    {
        return confirm("Are you sure ?");
    }

</script>
