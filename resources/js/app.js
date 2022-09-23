const { default: axios } = require('axios');
const { fromPairs } = require('lodash');

require('./bootstrap');

$(document).ready(function () {
  $(".li-status").removeClass('online');
  $(".li-status").addClass('away');
  $(".user-status").text("offline");

    $.ajax({
      type: 'get',
      url: '/spectator',
    })
})

var channel = Echo.channel('chat');

if (localStorage.getItem('user') && localStorage.getItem('selected')) {
  let i = 0;
  const div = document.getElementById("msg_dis");

  const susername = document.getElementById("sname");

  if (Notification.permission !== 'denied' && Notification.permission === "default") {
    Notification.requestPermission()
  }

  const username = document.getElementById("name");

  //     $("#form").on('submit', function(e)
  //     {

  //      e.preventDefault();
  //      axios.post('/chat', {
  //         name: username.value,
  //         msg: message.value,
  //         reciver: reciver.value
  //       });
  //       message.value = "";
  // });



  $("#form").on('submit', (function (e) {
    e.preventDefault();
    $("#preview>").remove();
    $("#replyhint").remove();
    console.log(localStorage.getItem('imageref'))
    URL.revokeObjectURL(localStorage.getItem('imageref'))

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "/chat",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
    });
    document.getElementById('formreply').value = '';
    document.getElementById('msg').value = '';
    document.getElementById('doc').value = '';
    $('#previewemoji').addClass('d-none');
  }));

  var channel3 = Echo.channel('Tick');

  channel3.listen('.tick', function (data) {

    $("." + data.myid + data.oid + " span i").removeClass('fa-check');
    $("." + data.myid + data.oid + " span i").addClass('fa-check-double');

  });

  var channel2 = Echo.channel('status');

  channel2.listen('.check', function (data) {
    if (data.status == 'online') {
      $("li#" + data.id).removeClass('away');
      $("li#" + data.id).addClass('online');
      $("#ch" + data.id).text("online");
    }
    else if (data.status == 'away') {
      $("li#" + data.id).removeClass('online');
      $("li#" + data.id).addClass('away');
      $("#ch" + data.id).text("offline");
    }
    else if (data.status == "typing") {
      $("#ch" + data.id).text("typing...");
    }
    else {
      $("#ch" + data.id).text("online");
    }

  });

  var channell = Echo.channel('delmsg');

  channell.listen('.delete', function (data) {
    $("#msg" + data.id).remove();
    $(".recent" + data.id).html("Message Deleted");
    const grecent = $("#recentg" + localStorage.getItem('selected').replace(" ", '')).attr('class');
    $("#" + data.id).remove();
    if (grecent.match('recent' + (data.id).replace('g', ''))) {
      $("#recentg" + localStorage.getItem('selected').replace(" ", '')).html("Message Deleted");
    }
  });


  var channel = Echo.channel('chat');

  channel.listen('.msg', function (data) {
    if (data.group_name) {
      let notification = new Notification("From: " + data.group_name, {

        body: "\nuser: " + data.sender + "\n" + "message: " + data.message,

      })
      notification.onclick = () => {
        location.href = "/group/" + data.gid;
      }
    }
    if (data.group_name == localStorage.getItem('selected')) {
      const gele = document.getElementById("recentg" + (data.group_name).replace(" ", ''));
      gele.className = 'text-truncate text-gray grecent' + data.id;

      if ((data.message).match('<img'))
        gele.innerHTML = '<img src="/icons/img.png" alt="image">';
      else if ((data.message).match('<video'))
        gele.innerHTML = '<img src="/icons/video.png" alt="video">';
      else if ((data.message).match('<audio'))
        gele.innerHTML = '<img src="/icons/audio.png" alt="audio">';
      else
        gele.innerHTML = data.message;

      if (data.sender == susername.value) {
        if (data.reply == '') {
          div.innerHTML += '<li id="g' + data.id + '" class="d-flex message right">' +
            '<div class="message-body">' +
            '<div class="message-row d-flex align-items-center justify-content-end">' +
            '<div class="dropdown">' +
            '<a class="text-primary me-1 p-2" href="/addpin/g' + data.id + '"><i class="ti-pin-alt"></i></a>' +
            '<a class="text-dark me-1 p-2" onclick="shareMsg(`g' + data.id + '`)">' +
            '<i class="fa-solid fa-share" ></i></a>' +
            '<a class="me-1 p-2 text-danger" onclick="gdelmsg(' + data.id + ')"><i class="fas fa-trash"></i></a>' +
            '</div>' +
            '<div ondblclick="dbreply(this)" class="message-content border p-3 fs-small bg-primary text-white" data-help="g' + data.id + '">' + data.message +
            '</div>' +
            '</div>' +
            '<span class="date-time text-muted">' + data.time + '<i class="fas fa-check text-primary px-1"></i></span>' +
            '</div>' +
            '</li>';
        }
        else {
          div.innerHTML += '<li id="g' + data.id + '" class="d-flex message right">' +
            '<div class="message-body">' +
            '<div class="message-row d-flex align-items-center justify-content-end">' +
            '<div class="dropdown">' +
            '<a class="text-primary me-1 p-2" href="/addpin/g' + data.id + '"><i class="ti-pin-alt"></i></a>' +
            '<a class="text-dark me-1 p-2" onclick="shareMsg(`g' + data.id + '`)">' +
            '<i class="fa-solid fa-share" ></i></a>' +
            '<a class="text-danger me-1 p-2" onclick="gdelmsg(' + data.id + ')"><i class="fas fa-trash"></i></a>' +
            '</div>' +
            '<div ondblclick="dbreply(this)" class="message-content border p-3 fs-5 bg-primary text-white" data-help="g' + data.id + '">' +
            '<div>' +
            '<div class="reply my-2">' +
            '<a href="#g' + data.rid + '" onclick="resultClear(`#g' + data.rid + '`)">' +
            '<div class="text-gray">' +
            '<span class=""> ' + data.sender + ': </span>' + data.reply +
            '</div>' +
            '</a>' +
            '</div>' +
            '<div>' + data.message + '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<span class="date-time text-muted">' + data.time + '<i class="fas fa-check text-primary px-1"></i></span>' +
            '</div>' +
            '</li>';
        }
        var myDiv = document.getElementById("chat");
        myDiv.scrollTop = myDiv.scrollHeight;
      }
      else {
        const audio = new Audio("http://chat.thesiliconreview.org/notySound/Message%20notification.mp3");
        audio.play();
        if (data.reply == '') {
          div.innerHTML += '<li id="g' + data.id + '" class="d-flex message">' +
            '<div class="message-body">' +
            '<span class="date-time text-muted">' + data.fname + ' | ' + data.time + '</span>' +
            '<div class="message-row d-flex align-items-center">' +
            '<div ondblclick="dbreply(this)" class="message-content p-3 fs-5" data-help="g' + data.id + '">' + data.message +
            '</div>' +
            '<div class="dropdown">' +
            '<a class="text-dark me-1 p-2" onclick="shareMsg(`g' + data.id + '`)">' +
            '<i class="fa-solid fa-share" ></i></a>' +
            '<a class="text-primary me-1 p-2" href="/addpin/g' + data.id + '"><i class="ti-pin-alt"></i></a>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</li>';

        }
        else {
          div.innerHTML += '<li id="g' + data.id + '" class="d-flex message">' +
            '<div class="message-body">' +
            '<span class="date-time text-muted">' + data.fname + ' | ' + data.time + '</span>' +
            '<div class="message-row d-flex align-items-center">' +
            '<div ondblclick="dbreply(this)" class="message-content p-2 fs-small" data-help="g' + data.id + '">' +
            '<div>' +
            '<div class="reply border-primary my-2">' +
            '<a href="#g' + data.rid + '" onclick="resultClear(`#g' + data.rid + '`)">' +
            '<div class="text-secondary">' +
            '<span class="text-secondary"> ' + data.sender + ': </span>' + data.reply +
            '</div>' +
            '</a>' +
            '</div>' +
            '<div>' + data.message +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="dropdown">' +
            '<a class="text-danger me-1 p-2" onclick="shareMsg(`g' + data.id + '`)">' +
            '<i class="fa-solid fa-share" ></i></a>' +
            '<a class="text-primary me-1 p-2" href="/addpin/g' + data.id + '"><i class="ti-pin-alt"></i></a>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</li>';
        }
        var myDiv = document.getElementById("chat");
        myDiv.scrollTop = myDiv.scrollHeight;
      }
    }
    else {
      if (data.reciver == localStorage.getItem('user') || data.sender == localStorage.getItem('user'))
      {
            if (document.getElementById("recent" + (data.sender).replace(" ", ''))) {
          const elem = document.getElementById("recent" + (data.sender).replace(" ", ''));
          elem.className = 'text-truncate text-gray recent' + data.id;
          if ((data.msg).match('<img'))
            elem.innerHTML = '<img src="/icons/img.png" alt="image">';
          else if ((data.msg).match('<video'))
            elem.innerHTML = '<img src="/icons/video.png" alt="video">';
          else if ((data.msg).match('<audio'))
            elem.innerHTML = '<img src="/icons/audio.png" alt="audio">';
          else
            elem.innerHTML = data.msg;
        }
        if (document.getElementById("recent" + (data.reciver).replace(" ", ''))) {
          const elem = document.getElementById("recent" + (data.reciver).replace(" ", ''));
          elem.className = 'text-truncate text-gray recent' + data.id;
          if ((data.msg).match('<img'))
            elem.innerHTML = '<img src="/icons/img.png" alt="image">';
          else if ((data.msg).match('<video'))
            elem.innerHTML = '<img src="/icons/video.png" alt="video">';
          else if ((data.msg).match('<audio'))
            elem.innerHTML = '<img src="/icons/audio.png" alt="audio">';
          else
            elem.innerHTML = data.msg;
        }
        }
      if (data.reciver == localStorage.getItem('user')) {
        const audio = new Audio("http://chat.thesiliconreview.org/notySound/Message%20notification.mp3");
        audio.play();
  
        if (localStorage.getItem('selected') != data.sender) {
          // document.getElementById("toast"+data.reciver).innerHTML += '<div id="cut'+ data.reciver+i+'" class="m-3 show toast bg-noty" role="alert" aria-live="assertive" aria-atomic="true"> '+
          // '<div class="toast-header">'+
          // '<a href="/select/'+data.user_id+'"><strong class="me-auto">New Message From '+ data.sender +'</strong></a>'+
          // '<small class="text-muted">'+data.time+'</small>'+
          // '<button type="button" onclick=cut("'+data.reciver+i+'") class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>'+
          // '</div>'+
          // '<div class="toast-body">'+ data.msg +
          // '</div>'+
          // '</div>';
          // i++;
          let notification = new Notification("From: " + data.fname, {

            body: "message: " + data.msg,

          })
          notification.onclick = () => {
            location.href = "/select/" + data.user_id;
          }
          var unseen = $("#unseen" + (data.sender).replace(" ", '')).attr('data-count');
          $("#unseen" + (data.sender).replace(" ", '')).removeClass('d-none');
          $("#unseen" + (data.sender).replace(" ", '')).text(++unseen);
          $("#unseen" + (data.sender).replace(" ", '')).attr('data-count', unseen);
        }
      }
      if (data.reciver == localStorage.getItem('selected') && data.sender == username.value) {

        if (data.reply == '') {
          div.innerHTML += '<li id="msg' + data.id + '" class="d-flex message right">' +
            '<div class="message-body">' +
            '<div class="message-row d-flex align-items-center justify-content-end">' +
            '<div class="dropdown">' +
            '<a class="text-primary me-1 p-2" href="/addpin/u' + data.id + '"><i class="ti-pin-alt"></i></a>' +
            '<a class="text-dark me-1 p-2" onclick=shareMsg(`u' + data.id + '`)>' +
            '<i class="fa-solid fa-share" ></i></a >' +
            '<a class="text-danger me-1 p-2" onclick="delmsg(' + data.id + ')"><i class="fas fa-trash"></i></a>' +
            '</div>' +
            '<div ondblclick="dbreply(this)" data-help="msg' + data.id + '" class="message-content border p-3 fs-small bg-primary text-white">' + data.msg +
            '</div>' +
            '</div>' +
            '<span class="date-time text-muted">' + data.time + '<i class="fas fa-check text-primary px-1"></i></span>' +
            '</div>' +
            '</li>';

        }
        else {
          if (data.sender == localStorage.getItem('user'))

            div.innerHTML += '<li id="msg' + data.id + '" class="d-flex message right">' +
              '<div class="message-body">' +
              '<div class="message-row d-flex align-items-center justify-content-end">' +
              '<div class="dropdown">' +
              '<a class="text-primary me-1 p-2" href="/addpin/u' + data.id + '"><i class="ti-pin-alt"></i></a>' +
              '<a class="text-dark me-1 p-2" onclick=shareMsg(`u' + data.id + '`)>' +
              '<i class="fa-solid fa-share" ></i></a >' +
              '<a class="text-danger me-1 p-2" onclick="delmsg(' + data.id + ')"><i class="fas fa-trash"></i></a>' +
              '</div>' +
              '<div ondblclick="dbreply(this)" data-help="msg' + data.id + '" class="message-content border p-3 fs-small bg-primary text-white">' +
              '<div>' +
              '<div class="reply my-2">' +
              '<a href="#msg' + data.rid + '" onclick="resultClear(`#msg' + data.rid + '`)">' +
              '<div class="text-gray">' +
              '<span class="">' +
              data.sender + ': </span>' +
              data.reply +
              '</div>' +
              '</a>' +
              '</div>' +
              '<div>' +
              data.msg +
              '</div>' +
              '</div>' +
              '</div>' +
              '</div>' +
              '<span class="date-time text-muted">' + data.time + '<i class="fas fa-check text-primary px-1"></i></span>' +
              '</div>' +
              '</li>';
        }

        var myDiv = document.getElementById("chat");
        myDiv.scrollTop = myDiv.scrollHeight;
      }
      else if (data.reciver == username.value && data.sender == localStorage.getItem('selected')) {
      
        if (data.reply == '') {
          div.innerHTML += '<li id="msg' + data.id + '" class="d-flex message">' +
            '<div class="message-body">' +
            '<span class="date-time text-muted">' + data.sender + ' | ' + data.time + '</span>' +
            '<div class="message-row d-flex align-items-center">' +
            '<div ondblclick="dbreply(this)" data-help="msg' + data.id + '" class="message-content p-3 fs-5">' + data.msg +
            '</div>' +
            '<div class="dropdown">' +
            '<a class="text-dark me-1 p-2" onclick=shareMsg(`u' + data.id + '`)>' +
            '<i class="fa-solid fa-share" ></i></a>' +
            '<a class="text-primary me-1 p-2" href="/addpin/u' + data.id + '"><i class="ti-pin-alt"></i></a>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</li>';
        }
        else {
          div.innerHTML += '<li id="msg' + data.id + '" class="d-flex message">' +
            '<div class="message-body">' +
            '<span class="date-time text-muted">' + data.sender + ' | ' + data.time + '</span>' +
            '<div class="message-row d-flex align-items-center">' +
            '<div ondblclick="dbreply(this)" data-help="msg' + data.id + '" class="message-content p-3 fs-5">' +
            '<div>' +
            '<div class="reply my-2 text-secondary border-primary">' +
            '<a href="#msg' + data.rid + '" onclick="resultClear(`#msg' + data.rid + '`)">' +
            '<div class="text-secondary">' +
            '<span class="">' + data.sender + ': </span>' + data.reply +
            '</div>' +
            '</a>' +
            '</div>' +
            '<div>' + data.msg + '</div>' +
            '</div>' +
            '</div>' +
            '<div class="dropdown">' +
            '<a class="text-dark me-1 p-2" onclick=shareMsg(`u' + data.id + '`)>' +
            '<i class="fa-solid fa-share" ></i></a>' +
            '<a class="text-primary me-1 p-2" href="/addpin/u' + data.id + '"><i class="ti-pin-alt"></i></a>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</li>';
        }
        var myDiv = document.getElementById("chat");
        myDiv.scrollTop = myDiv.scrollHeight;
      }
    }

  });

}
else {
  channel.listen('.msg', function (data) {

    if (localStorage.getItem('user') == data.reciver) {
      let notification = new Notification("From: " + data.sender, {

        body: "message: " + data.msg,

      })
      notification.onclick = () => {
        location.href = "/select/" + data.user_id;
      }
    }
  });
}