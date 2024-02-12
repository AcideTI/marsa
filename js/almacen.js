
//  Buscar el producto en específico por el codigo del producto
$(".stockGlobal").on("click", ".btnBuscarStockGlobal", function(){
  
  var valor = $("#valorbusqueda").val();
  if(valor!== '' )
  {
    window.location = "index.php?ruta=buscarProducto&valor="+valor;
  }
});

//  Buscar el producto en específico por el codigo del producto de Home
$(".stockGlobal").on("click", ".btnBuscarStockGlobalHome", function(){
  
  var valor = $("#valorbusqueda").val();
  if(valor!== '' )
  {
    window.location = "index.php?ruta=home&valor="+valor;
  }
});



