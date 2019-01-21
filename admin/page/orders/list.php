<?php
require_once DOCUMENT_ROOT . '/entities/Products.php';
require_once DOCUMENT_ROOT . '/entities/Order.php';
// $list = Products::loadProductsAll();
$list = Order::loadAll();
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
                        <th class="text-center">User</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Date</th>
                        <!--<th class="text-center">Note</th>-->
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($list)) { ?>
                        <?php foreach($list as $item) { ?>
                            <tr >
                                <td><?php echo $item->orderID; ?></td>
                                <td><?php echo $item->userID ?></td>
                                <td> <?php echo number_format($item->total); ?></td>
                                <td><?php echo $item->orderDate; ?></td>
                                <!--<td><?php echo $item->note; ?></td>-->
                                <td> <?php
                                if( $item->status == 0 ){
                                    echo '<span style="color: darkorange; font-weight: bold">Pending</span>';
                                }
                                else if( $item->status == 1 ){
                                    echo '<span style="color: springgreen">Completed</span>';
                                }
                                else if( $item->status == 2 ){
                                    echo '<span style="color: darkred">Cancel</span>';
                                }
                                ?></td>
                                <td class="text-center">
                                    <a href="./index.php?act=orders&type=edit&id=<?php echo $item->orderID; ?>"
                                       role="button" class="btn btn-success btn-xs"><i class="fa fa-fw fa-edit"></i></a>
                                    <a href="./index.php?act=orders&type=delete&id=<?php echo $item->orderID; ?>" class="btn btn-danger btn-xs delete-product" onclick="return confirm_click();"><i
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


<script type="text/javascript">
function confirm_click()
{
    return confirm("Are you sure ?");
}

</script>
