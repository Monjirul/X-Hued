<html>
   <head>
      <title>Ajax Example</title>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <script src="/assets/mk/jquery-3.3.1.js"></script>
      </script>
      
   
   </head>
   
   <body>
      <div id = 'msg'>This message will be replaced using Ajax. 
         Click the button to replace the message.</div>
         <button value="Change Color" id="btn"  onclick="getMessage()">Change Color</button>
      



         <script>
         function getMessage() {
            $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
          var msg=document.getElementById('msg').innerHTML;
            alert(msg);
            $.ajax({
               type:'POST',
               url:'/getmsg',
               data:{'msg': msg},
               success:function(data) {

               //alert(data.msg);
                  $("#msg").html(data.msg);
                    $("#btn").html("loll");
               }
            });
         }
      </script>
   </body>

</html>