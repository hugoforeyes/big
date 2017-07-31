<?php defined('V_LIFE') or die('v'); ?>
<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<!--[if IE]><meta content='IE=8' http-equiv='X-UA-Compatible'/><![endif]-->
<meta content="width=device-width, initial-scale=1.0, maximum-scale=3.0, user-scalable=yes" name="viewport">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="cache-control" content="no-cache">
<meta name="robots" content="noindex, nofollow">
<meta name="robots" content="noarchive">
<link rel="shortcut icon" href="{URL_CP_THEME}img/favicon.ico" />
<script type="text/javascript" src="{URL_JS}jquery.js"></script>
<link rel="stylesheet" href="{URL_JS}ms/multiSelect.css" type="text/css" />
<script type="text/javascript" src="{URL_JS}ms/multiSelect.js"></script>
{INC}
<!--[if lt IE 8]><link rel="stylesheet" href="{URL_CP_THEME}ie7.css" type="text/css" /><![endif]-->
<!--[if IE]><script type="text/javascript" src="{URL_CP_THEME}js/scroll.js"></script><![endif]-->

<script type="text/javascript" src="{URL_CP_THEME}js/script.js"></script>

<link rel="stylesheet" href="{URL_CP_THEME}ui/ui.css" type="text/css" />
<script type="text/javascript" src="{URL_CP_THEME}ui/ui.js"></script>
</head>
<body>

<!-- IF MENU -->
<div id="t_bar">
	<a href="{URL_CP}" id="logo"></a>
    {MENU}
</div><!-- end topbar -->
<div id="toppag"></div>
<!-- ENDIF -->

<div id="main"{_CLS}>
<!-- IF MSG -->{MSG}<!-- ENDIF -->
  <div id="brd">{NAV}<!-- IF COUNT --><span class="nav_count">({COUNT})</span><!-- ENDIF --></div>

  <div class="clr"></div>

  <div id="wra">
  	<div id="inner_wra">
      	<!-- IF FILTER --><div id="filter">
          <div class="filters">
              <form action="{S_FILTER}" method="post" name="filter_form" id="filters_form">{FILTER}</form></div>
          </div><!-- ENDIF -->

          <!-- IF CMD || PAGINATION || FILTER -->
          <div id="vf_top">
              <div id="cmd">{CMD}</div><!-- end cmd -->
              {PAGINATION}
          </div><!-- end scroll top -->
          <!-- ENDIF -->
          {CTN}
          <div class="clr"></div>
      </div><!-- end inner wrapper -->
  </div><!-- end wrapper -->
</div><!-- end main -->

{HTML}

<p id="legal">{L_LEGAL}</p>
<p id="browsers"></p>
</body>
</html>
