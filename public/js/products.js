var jqxhr = $.post( "example.php", function() {
    alert( "success" );
  })
    .done(function() {
      alert( "second success" );
    })
    .fail(function() {
      alert( "error" );
    })
    .always(function() {
      alert( "finished" );
    });
   
  // Perform other work here ...
   
  // Set another completion function for the request above
  jqxhr.always(function() {
    alert( "second finished" );
});
