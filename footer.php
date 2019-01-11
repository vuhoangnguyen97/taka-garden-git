<!-- Footer -->
<footer id="footer" class="container">
    <div id="main-footer">
        <div class="row">
            <!-- Contact Us -->
            <div class="col-lg-3 col-md-4 col-sm-6 contact-footer-info">
                <h4><i class="fa fa-pagelines" aria-hidden="true"></i>Về chúng tôi</h4>
                <ul class="list-menu info">
                    <li><i class="fa fa-map-marker" aria-hidden="true"></i>371 Nguyễn Kiệm, TP.HCM</li>
                    <li><i class="fa fa-phone" aria-hidden="true"></i>01202582956</li>
                    <li><i class="fa fa-envelope-o" aria-hidden="true"></i>takagraden@gmail.com</li>
                    <li><i class="fa fa-skype" aria-hidden="true"></i>takagraden</li>
                </ul>
            </div>
            <!-- /Contact Us -->

            <!-- Information -->
            <div class="col-lg-3 col-md-2 col-sm-6">
                <h4><i class="fa fa-pagelines" aria-hidden="true"></i>Tài khoản</h4>
                <ul class="list-menu">
                    <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Đơn hàng </a></li>
                    <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Sản phẩm yêu thích</a></li>
                    <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Đăng nhập tài khoản</a></li>
                    <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Tìm kiếm sản phẩm</a></li>
                </ul>
            </div>
            <!-- /Information -->


            <div class="col-lg-3 col-md-3 col-sm-6">
                <h4><i class="fa fa-pagelines" aria-hidden="true"></i>Hỗ trợ khách hàng</h4>
                <ul class="list-menu">
                    <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Hướng dẫn đặt hàng</a></li>
                    <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Hướng dẫn thanh toán</a></li>
                    <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Chính sách vận chuyển</a></li>
                    <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> Chính sách đổi trả</a></li>
                </ul>
            </div>

            <!-- Like us on Social -->
            <div class="col-lg-3 col-md-3 col-sm-6 facebook-iframe">
                <h4><i class="fa fa-pagelines" aria-hidden="true"></i>Hình thức thanh toán</h4>
                <ul class="list-menu">
                    <img src="img/payment.png"/>
                </ul>
                <h4><i class="fa fa-pagelines" aria-hidden="true"></i>Mạng xã hội</h4>
                <ul class="footer-social">
                    <li class="fb">
                        <a href="#" target="_blank">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="tt">
                        <a href="#" target="_blank">
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="ins">
                        <a href="#" target="_blank">
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="yt">
                        <a href="#" target="_blank">
                            <i class="fa fa-youtube" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="gp">
                        <a href="#" target="_blank">
                            <i class="fa fa-google-plus" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /Like us on Social -->

        </div>
        <form id="form1" name="form1" method="post" action="">
            <input type="hidden" id="txtMaSP" name="txtMaSP"/>
        </form>
    </div>
    <div id="copyright">&copy; Bản quyền thuộc về <b>Taka Graden</b></div>
    <script>
        (function () {
            let appCode = '2995246781b60bdead8f670eba573880';
            let ws_host = 'wss://bot.fpt.ai/ws/livechat'
            let appCodeHash = window.location.hash.substr(1);
            let objLiveChat = {
                appCode: '2995246781b60bdead8f670eba573880',
                appName: 'Taka Garden'
            };
            if (appCodeHash.length == 32) {
                objLiveChat.appCode = appCodeHash;
            }

            var baseUrl = 'https://static.fpt.ai/v3/src';
            var r = document.createElement("script");
            r.src = baseUrl + "/livechat.js";
            var c = document.getElementsByTagName("body")[0];
            c.appendChild(r);
            r.onload = function () {
                new FPTAI_LiveChat(objLiveChat, baseUrl, ws_host);
            };

        })()
    </script>
</footer>
<!-- /Footer -->
