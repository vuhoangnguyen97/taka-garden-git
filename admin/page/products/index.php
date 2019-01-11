<?php
require_once DOCUMENT_ROOT . '/entities/Products.php';
$list = Products::loadProductsAll();
echo count($list);
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
                        <th class="text-center">Price</th>
                        <th class="text-center">Categories</th>
                        <th class="text-center">Quantity</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($list)) { ?>
                        <?php for ($i = 0; $i < count($list); $i++) { ?>
                            <tr>
                                <td><?php echo $list[$i]->getProID(); ?></td>
                                <td><?php echo $list[$i]->getProName(); ?></td>
                                <td> <?php echo number_format($list[$i]->getPrice()); ?></td>
                                <td><?php echo $list[$i]->getClassify(); ?></td>
                                <td> <?php echo $list[$i]->getQuantity(); ?></td>
                                <td class="text-center">
                                    <a href="/admin/?act=products&type=edit&id=<?php echo $list[$i]->getProID(); ?>"
                                       role="button" class="btn btn-success btn-xs"><i class="fa fa-fw fa-edit"></i></a>
                                    <a href="/admin/?act=products&type=delete&id=<?php echo $list[$i]->getProID(); ?>" class="btn btn-danger btn-xs delete-product" onclick="return confirm_click();"><i
                                                class="fa fa-fw fa-trash-o"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <button id="btnExport" style="float: right;">Export</button>
        </div>
    </section>
</div>


<script type="text/javascript">
function confirm_click()
{
    return confirm("Are you sure ?");
}
$('#btnExport').click(function () {
    alert('a');
});

</script>
