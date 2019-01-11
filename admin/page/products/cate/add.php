<?php
require_once DOCUMENT_ROOT . '/entities/categories.php';
$cate = categories::loadAll();
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
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
                <form role="form">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label>ProName</label>
                            <input type="text" name="ProName" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" name="Quantity" class="form-control" value="1">
                        </div>
                        <div class="form-group">
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
                            <label>Cate</label>
                            <select class="form-control" name="">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>



