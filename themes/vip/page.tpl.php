<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=1080px, user-scalable=yes" />
{INC}
<script type="text/javascript" src="{URL_THEME}js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="{URL_THEME}js/sbn.js"></script>
<script type="text/javascript" src="{URL_THEME}js/jquery.slimscroll.min.js"></script>
<script type="text/javascript" src="{URL_THEME}js/lightbox.min.js"></script>
</head>


<body class="{PAGE}">
<div id="top"><img src="{URL_THEME}img/tran.gif" width="970" height="1" border="0" /><br /></div>

<div id="maincontent">

  <!-- placeholder for header -->
    <div id="header">{HDR}</div>


    <div id="mainbar">

       <div id="bluebar">{P01}</div>

       {P02}

       <!-- IF P03 || P04 -->
       <div class="content_type2b">
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td align="left" valign="middle" colspan="4" style="padding:10px;" class="content_type2_content">{P03}</td>
            </tr>
            {P04}
         </table>
       </div>
       <!-- ENDIF -->

       {CTN}

    </div>

    <!-- IF P07 -->
    <div id="shadow"></div>
    <div id="bottombar"><div id="bottombar_feature">{P07}</div></div>
    <!-- ENDIF -->

    <div id="footer">
        <div id="copyrightstatement">{P08}</div>
        <div id="footernavi">{P09}</div>
    </div>

  </div>

</body>
</html>
