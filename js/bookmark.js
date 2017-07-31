var u=document.location.href;
var t=document.title;
document.write('<span id="bookmark">'
+'<a href="javascript:addToFavorites();" title="Add to favorites" class="favorite"><img src="http://www.xitrum.org/images/blank.gif" /></a>'
+'<a href="http://del.icio.us/post?url='+u+'&title='+t+'" title="Del.icio.us" class="delicious"><img src="http://www.xitrum.org/images/blank.gif" /></a>'
+'<a href="http://digg.com/submit?phase=2&url='+u+'&title='+t+'" title="Digg" class="digg"><img src="http://www.xitrum.org/images/blank.gif" /></a>'
+'<a href="http://www.facebook.com/sharer.php?u='+u+'" title="Facebook" class="facebook"><img src="http://www.xitrum.org/images/blank.gif" /></a>'
+'<a href="http://www.myspace.com/Modules/PostTo/Pages/?u='+u+'&t='+t+'" title="Myspace" class="myspace"><img src="http://www.xitrum.org/images/blank.gif" /></a>'
+'<a href="http://reddit.com/submit?url='+u+'&title='+t+'" title="Reddit" class="reddit"><img src="http://www.xitrum.org/images/blank.gif" /></a>'
+'<a href="http://www.stumbleupon.com/submit?url='+u+'&title='+t+'" title="StumbleUpon" class="stumpleupon"><img src="http://www.xitrum.org/images/blank.gif" /></a>'
+'<a href="http://technorati.com/faves?add='+u+'" class="technorati"><img src="http://www.xitrum.org/images/blank.gif" /></a>'
+'<a href="http://twitter.com/home?status='+t+' '+u+'" title="Twitter" class="twitter"><img src="http://www.xitrum.org/images/blank.gif" /></a>'
+'</span>');

function addToFavorites() {
if (window.external) {
window.external.AddFavorite(u, t);
}
}