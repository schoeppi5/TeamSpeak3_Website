function queryFooter(){
  $.ajax({
    url: "/script/php/query_footer_info.php",
    success: function(response){
      try{
        response = $.parseJSON(response);
        $('#site-title').html(response.footerinfo.name);
        $('#author').html("&copy;" + response.footerinfo.author);
        (response.footerinfo.editor !== null ? $('#editor').html("Edited by: " + response.footerinfo.editor) : "");
        $('#version').html("Version: " + response.footerinfo.version);
      }
      catch(e){
        console.error(e.message);
      }
    }
  })
}
