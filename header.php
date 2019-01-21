<!-- Header -->
<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="top-header">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <ul class="topbar-left">
                            <li><i class="fa fa-phone" aria-hidden="true"></i><a href="tel:01202582956">Hotline:
                                    01202582956</a></li>
                            <li class="hidden-xs"><i class="fa fa-facebook-square" aria-hidden="true"></i> <a
                                        target="_blank" href="https://www.facebook.com/takagarden/">www.facebook.com/takagarden</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <ul class="topbar-right">
                            <?php

                            if (!Context::isLogged()) {
                                ?>
                                <li><i class="fa fa-user" aria-hidden="true"></i><a
                                            href="cart.php"><?php echo CartProcessing::countQuantity(); ?> Sản phẩm</a>
                                </li>
                                <li><i class="fa fa-user" aria-hidden="true"></i><a href="login.php">Đăng nhập</a></li>
                                <li style="margin-right: 0;"><i class="fa fa-lock" aria-hidden="true"></i><a
                                            href="register.php">Đăng ký</a></li>
                                <!-- <a href="login.php" class="ucmd">Đăng nhập</a> <span style="float:left;">|</span> <a href="register.php" class="ucmd">Đăng ký</a> -->
                                <?php
                            } else {
                                ?>
                                <li><i class="fa fa-user" aria-hidden="true"></i><a
                                            href="cart.php"><?php echo CartProcessing::countQuantity(); ?> Sản phẩm</a>
                                </li>
                                <li><i class="fa fa-user" aria-hidden="true"></i><a
                                            href="profile.php">Chào, <?php echo $_SESSION["CurrentUser"]; ?>!</a></li>
                                <li><i class="fa fa-user" aria-hidden="true"></i><a href="logout.php">Thoát</a></li>
                                <!-- <a href="cart.php" class="ucmd"><?php echo CartProcessing::countQuantity(); ?> Sản phẩm</a> <span style="float:left;">|</span> <a href="profile.php" class="ucmd">Hi, <?php echo $_SESSION["CurrentUser"]; ?>!</a> <span style="float:left;">|</span> <a href="logout.php" class="ucmd">Thoát</a> -->
                                <?php
                            }
                            ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-logo">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-5">
                    <div class="logo"><a href="index.php"><abbr title="Logo"><img src="img/logo-small.png"/></abbr></a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="search">
                        <form id="frSearch" name="frSearch" class="search-form" action="" method="post">
                            <input class="s-input" name="txtSearch" type="text" id="txtSearch"
                                   placeholder="Tìm kiếm sản phẩm..."/>
                            <button id="btnSearch" name="btnSearch" class="btn-search" type="submit">
                                <span>Tìm kiếm</span>
                            </button>
                            <input name="selectHSX" type="text" value='0' class="hidden" id="selectHSX">
                            <input name="selectGia" type="text" value='100000000' class="hidden" id="selectGia">
                        </form>
                    </div>
                </div>
                <div class="col-md-4 col-sm-3 hidden-xs">
                    <div class="box-cart">
                        <ul>
                            <li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i>Yêu thích</a></li>
                            <li><a href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Giỏ hàng</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-menu hidden-xs">
        <div class="container">
            <nav class="main-navigation">
                <ul>
                    <li>
                        <a href="index.php">
                            <span class="nav-caption">Trang chủ</span>
                        </a>
                    </li>
                    <li>
                        <a href="info.php">
                            <span class="nav-caption">Giới thiệu</span>
                        </a>
                    </li>
                    <li class="submenu">
                        <a href="search.php?nsx=0&value=&gia=100000000" id="idMenu">
                            <span class="nav-caption">Sản phẩm</span>
                        </a>
                        <ul class="sub_menu">

                            <?php
                            for ($i = 0, $n = count($categories); $i < $n; $i++) {
                                $name = $categories[$i]->getCatName();
                                $id = $categories[$i]->getCatId();
                                ?>
                                <li><a href="productsByCat.php?catId=<?php echo $id; ?>"><?php echo $name; ?></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <li>
                        <a href="blog.php">
                            <span class="nav-caption">Tin tức</span>
                        </a>
                    </li>
                    <li>
                        <a href="blog.php">
                            <span class="nav-caption">Khuyến mãi</span>
                        </a>
                    </li>
                    <li>
                        <a href="contact.php">
                            <span class="nav-caption">Liên hệ</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<!-- /Header -->