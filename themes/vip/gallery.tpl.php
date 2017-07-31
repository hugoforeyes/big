<div class="content_products">

<!-- BLOCK list -->
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
               <td width="310" valign="top" align="left">
                  <div class="products_heading">{list.TITLE}</div>

                  <div id="products_image"><!-- Products image -->
                  </div>

                  <div id="productstext">
                      <div id="productstextheading" class="productstextheading">
                      <!-- Products name -->
                      </div>
                      <div id="contenttext" class="productstextcontent">
                      <!-- Products description -->
                      </div>
                   </div>

               </td>
               <td id="products">
<!-- BLOCK row --><a onmouseover="loadContent(this);" data-lightbox="products" data-title="{list.row.TITLE}" data-desc="{list.row.PREVIEW}" href="{list.row.O_PIC_FULL}"><img src="{list.row.O_PIC_THUMB}"  width="70" height="70" border="0" alt="" /></a><!-- END row -->
               </td>
            </tr>
         </table>

<!-- END list -->

</div>

<script type="text/javascript">
$(document).ready(function () {
  loadContentFirst();
});

function loadContent(e) {
    e = $(e);
	var prod_image = e.prop("href");
	var prod_title= e.data("title");
	var prod_info = e.data("desc");

	$("#products_image").html("<img src='{URL_THEME}img/ajax-loading.gif' />");
	$("#products_image").html("<img src='" + prod_image + "' width='310' height='260' />");

	$("#products_image").hide();
	$("#products_image").fadeIn(200);

	$("#productstextheading").html(prod_title);
	$("#contenttext").html(prod_info);

}

function loadContentFirst() {

    var e = $("#products a:first");
	var prod_image = e.prop("href");
	var prod_title= e.data("title");
	var prod_info = e.data("desc");

	$("#products_image").html("<img src='{URL_THEME}img/ajax-loading.gif' />");
	$("#products_image").html("<img src='" + prod_image + "' width='310' height='260' />");


	$("#products_image").hide();
	$("#products_image").fadeIn(200);

	$("#productstextheading").html(prod_title);
	$("#contenttext").html(prod_info);
}
</script>