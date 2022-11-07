

$("#Produk_ID").change(function(){
    var Produk_ID = $(this).val();
    $.ajax({
      type:"GET",
      url : "/createMPS/fetch",
      data: Produk_ID,
      cache: false,
      success: function(data){
        console.log($data);
      } 
    });
  });