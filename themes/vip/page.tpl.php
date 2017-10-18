<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/><!--Bật Responsive-->

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

<!---Insert CSS-->
<link rel="stylesheet" href="{URL_THEME}css/vendor/normalize.min.css" /> <!--Reset CSS-->
<link rel="stylesheet" href="{URL_THEME}css/vendor/bootstrap.css" />

<link rel="stylesheet" href="{URL_THEME}css/vendor/royalslider.css" />
<link rel="stylesheet" href="{URL_THEME}css/vendor/rs-default.css?v=1.0.4" />
<link rel="stylesheet" href="{URL_THEME}css/vendor/royalcustom.css" />

<link rel="stylesheet" href="{URL_THEME}css/vendor/jquery.mmenu.css" />
<!--Enable Responsive for IE9-->
<!--[if lt IE 9]>
    <script src="js/vendor/html5-3.6-respond-1.1.0.min.js"></script>
<![endif]-->
{INC}


<script type="text/javascript" src="{URL_THEME}js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="{URL_THEME}js/sbn.js"></script>
<script type="text/javascript" src="{URL_THEME}js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="{URL_THEME}js/lightbox.min.js"></script>

</head>
<div id="page">
    <!-- Navigation for mobile -->
    <nav id="menu" class="mm-menu mm-horizontal mm-ismenu mm-light custom-mmenu">
        <ul id="menu-mobile" class="mm-list mm-panel mm-opened mm-current">
            <li><a href="/big/" class="active">Home</a></li>
            <li><a href="/big/about/">About us</a></li>
            <li><a href="/big/service/">Service</a></li>
            <li><a href="/big/products/">Products</a></li>
            <li><a href="/big/contact/">Contact us</a></li>
        </ul>
    </nav>
    <!-- End -->
    <div class="container">
        <!-- Header Mobile -->
        <div class="mobile-bar visible-xs">
            <a href="#menu" id="btn-menu"></a>
        </div>
        <!-- Header Desktop -->
        <header>
            <div class="header-wp clearfix">
              {HDR}
            </div>
        </header>

        <!-- End header -->

        <!-- Main content -->
        <div id="main-content">
            <div class="bluebar">
              {P01}
            </div>
            <div class="content">
                {P02}
                <!-- IF P10 || P11 -->
                <div class="page-wp row">
                    <div class="page-img col-md-8 col-sm-12">
                        {P10}
                        {P11}
                    </div>
                    <div class="page-text col-md-4 col-sm-12">
                        {CTN}
                    </div>
                </div>
                <!-- ELSE -->
                {CTN}
                <!-- ENDIF -->

                <!-- IF P03 || P04 -->
                <div class="product-wp">
                    <div class="product-text">{P03}</div>
                    <div class="product-list row">{P04}</div>
                </div>
                <!-- ENDIF -->
            </div>
        </div>
        <div class="shadow"></div>


        <!-- IF P07 -->
        <div class="service-wp">
            <div class="service">
                <div class="row">{P07}</div>
            </div>
        </div>
        <div class="shadow"></div>
        <!-- ENDIF -->

        <!-- End main content -->
        <!-- Footer -->
        <footer>
            <div class="copyright">{P08}</div>
            <div class="footernavi">{P09}</div>
        </footer>
        <!-- End footer -->
    </div>
</div>


<!-- For royalslider -->
  <script src="{URL_THEME}js/vendor/jquery.royalslider.min.js"></script>
<!--End jQuery-->
  <script src="{URL_THEME}js/vendor/jquery.mmenu.js"></script>

<!--Insert custom javascript-->
  <script src="{URL_THEME}js/vendor/bootstrap.js"></script>
  <script src="{URL_THEME}js/main.js"></script>



  <script type="text/javascript">

      function showDetail(id) {
        //Get data
        var $tag_data = $("#product-list a[data-id='"+id+"']").first();
        var data_img = createDataImg($tag_data.attr('data-img'));
        $("#pd-detail-desc").html($tag_data.find(".datadesc").first().html());
        var html = createHtmlThumbnail(data_img);
        $("#pd-detail-thumb-xs").html(html);
        $("#pd-detail-thumb-md").html(html);
        loadImage(data_img[0]);
        //Show
        $("#product-detail").show();
        $("#product-list").hide();
      }
      function showList() {
        $("#product-detail").hide();
        $("#product-list").show();
      }

      function loadImage(src) {
        $("#pd-detail-img").attr('src', src);
      }


      function createHtmlThumbnail(imgs) {
        var html = '<div class="row pd-thm-list">';
        html += '<div class="col-sm-1 visible-sm"></div>';
        for(var i in imgs) {
            html += '<div class="col-md-part-5 col-xs-part-5 col-sm-2 pd-thm-wp" onclick="loadImage(\''+imgs[i]+'\')">';
            html += '<div class="pd-detail-thm">';
            html += '<img s'+'rc="'+imgs[i]+'"/>';
            html += '</div>';
            html += '</div>';
        }
        html += '<div class="col-sm-1 visible-sm"></div>';
        html += "</div>";
        return html;
      }

      function createDataImg(text_img) {
        var arr = text_img.split("][");
        var result = [];
        for (var i in arr) {
            if( ! arr[i].endsWith('images/'))
                result.push(arr[i]);
        }
        return result;
      }

    </script>
</body>
</html>
