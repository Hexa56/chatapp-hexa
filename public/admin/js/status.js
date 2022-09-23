Pusher.logToConsole = true;
    
    
    var pusher = new Pusher('86f5883d857f571e3cf0', {
      cluster: 'ap2'
    });
    
    var channel = pusher.subscribe('status');
    channel.bind('check', function(data) {
      if(data.status == 'online')
      {
          $("#"+data.id).removeClass("text-danger");
          $("#"+data.id).addClass("text-success");
      }
      else if(data.status == 'away')
      {
          $("#"+data.id).removeClass("text-success");
          $("#"+data.id).addClass("text-danger");
      }
      const online1 = document.querySelectorAll('i.fas.fa-circle.text-success');
      const offline1 = document.querySelectorAll('i.fas.fa-circle.text-danger');
      $(".offline").text(offline1.length)
      $(".online").text(online1.length)
    });
    
    
    const online = document.querySelectorAll('i.fas.fa-circle.text-success');
    const offline = document.querySelectorAll('i.fas.fa-circle.text-danger');
    $(".offline").text(offline.length)
    $(".online").text(online.length)
    
    