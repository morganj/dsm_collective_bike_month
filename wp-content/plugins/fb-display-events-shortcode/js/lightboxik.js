jQuery(document).ready(function($) {
    $("#lightboxik a").each(
   function()
   {
      $(this).tosrus({
         buttons : false
      });
	  //remove all unnesessary clasess added to lightboxik <a> from diffrent plugins
	  $(this).removeAttr("class");
	  $(this).removeAttr("rel");
   }
	);
});
