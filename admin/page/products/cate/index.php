<?php
require_once DOCUMENT_ROOT . '/entities/categories.php';
$list = categories::loadAll();
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <small>Dashboard</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Name</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($list)) { ?>
                        <?php for ($i = 0; $i < count($list); $i++) { ?>
                            <tr>
                                <td><?php echo $list[$i]->getCatId(); ?></td>
                                <td><?php echo $list[$i]->getCatName(); ?></td>
                                <td class="text-center">
                                    <a role="button" class="btn btn-success btn-xs"><i class="fa fa-fw fa-edit"></i></a>
                                    <a role="button" class="btn btn-danger btn-xs"><i
                                                class="fa fa-fw fa-trash-o"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>



