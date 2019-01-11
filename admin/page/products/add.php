<?php
require_once DOCUMENT_ROOT . '/entities/Products.php';
require_once DOCUMENT_ROOT . '/entities/categories.php';
$cate = categories::loadAll();
if (isset($_POST['type']) && !empty($_POST['type']) && $_POST['type'] == 'add') {
   
    
    $param = [
        'ProName' => $_POST['ProName'],
        'CatID' => $_POST['CatID'],
        'Price' => $_POST['Price'],
        'TinyDes' => '',
        'FullDes' => $_POST['FullDes'],
        'Quantity' => $_POST['Quantity'],
        'onsale' => isset($_POST['onsale']) ? 1 : 0,
        'salesprice' => $_POST['salesprice'],
    ];
    $pro_id = Products::saveProducts($param);
    if( isset($_FILES['file']) && $_FILES['file']['name'] != '' && $pro_id > 0 ){
        $path = $_FILES['file']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = '1.'.$ext;
        $product_id = $pro_id;
        $file = $_FILES['file']['tmp_name'];
        if (!file_exists("../imgs/products/".$product_id)) {
            mkdir("../imgs/products/".$product_id, 0777, true);
        }
        $path = "../imgs/products/".$product_id."/".$file_name;
        if(move_uploaded_file($file, $path)){
            echo "Tải tập tin thành công";
        }else{
            echo "Tải tập tin thất bại";
        }
    }
    header("Location: /admin/?act=products&type=edit&id=".$pro_id);
    die();
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <small>Dashboard</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Add</li>
        </ol>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label>ProName</label>
                            <input type="text" name="ProName" class="form-control">
                            <input type="hidden" name="type" class="form-control" value="add">
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" name="Quantity" class="form-control" value="1">
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" name="Price" class="form-control" value="1">
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    Flash Sale : <input type="checkbox" id="onsale" name="onsale"  >
                                </div>

                                <div id="datetimepicker" class="col-md-3 input-append date">
                                    <form action="" >
                                        <input name="timeExpire" type="text"/>
<!--                                        <span class="add-on">-->
<!--                                            <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>-->
<!--                                        </span>-->
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Sales Price</label>
                            <input type="number" name="salesprice" class="form-control" value="0">
                        </div>
                        <div class="form-group hidden">
                            <label>TinyDes</label>
                            <textarea id="editor1" name="TinyDes" rows="10" cols="80"></textarea>
                        </div>
                        <div class="form-group">
                            <label>FullDes</label>
                            <textarea id="editor2" name="FullDes" rows="10" cols="80"></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Categories</label>
                            <select class="form-control" name="CatID">
                                <?php if (isset($cate)) { ?>
                                    <?php for ($i = 0; $i < count($cate); $i++) { ?>
                                        <option value="<?php echo $cate[$i]->getCatId(); ?>">
                                            -- <?php echo $cate[$i]->getCatName(); ?></option>
                                    <?php } ?>
                                <?php } else { ?>
                                    <option value="0">NULL</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="file" id="file">
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">SAVE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>



