
function select(name, id) {
    localStorage.setItem('selected', name);
    location.href = "/select/" + id;
}
function gselect(name, id) {
    localStorage.setItem('selected', name);
    location.href = "/group/" + id;
}

$('document').ready(function () {
    var myDiv = document.getElementById("chat");
    myDiv.scrollTop = myDiv.scrollHeight;
    $('#g').click(function () {
        $("*#chat").hide();
        $("*#gchat").show();
    });
    $('#c').click(function () {
        $("*#gchat").hide();
        $("*#chat").show();
    })
});

$('#gform').on('submit', function (e) {
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
    $('#emojiselect').addClass('d-none');
    
});
function delmsg(id) {
    if (confirm("Are you sure ?"))
    {
        $("#" + id).remove();
        $.ajax({
            type: "GET",
            url: '/msgdel/' + id,
            success: function (msg) {

            }
        });
    }
    else
        false
}
function gdelmsg(id) {
    if (confirm("Are you sure ?")) {
        $("#g" + id).remove();
        $.ajax({
            type: "GET",
            url: '/gmsgdel/' + id,
            success: function (msg) {

            }
        });
    }
    else
        false
}

function online(id) {
    $.ajax({
        type: "GET",
        url: '/notyping/' + id,
    });
}

function myFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

function myFunction6() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput6");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL6");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

function myFunction1() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput1");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL1");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

function myFunction2() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput2");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL2");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}
function cut(x) {
    $("#cut" + x).remove();
}
function setuser(id) {
    alert(id)
}
function closeImg() {
    document.getElementById('doc').value = "";
    $('#preview>').remove();
}
function shareMsg(id) {
    $("#msg_id").val(id);
    $("#forward").addClass('show d-block')
}
$('#forward .close').click(function () {
    $("#forward").removeClass('show d-block')
})

var loadFile = function (event) {
    var preview = document.getElementById('preview');
    const type = (event.target.files[0]['type']).split("/");
    const url = URL.createObjectURL(event.target.files[0]);
    if (type[0] == "image") {

        preview.innerHTML = "<div><button onclick='closeImg()' type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div><img id='pre' class='w-100' src='" + url + "' alt='" + event.target.files[0]['name'] + "'><br><span>" + event.target.files[0]['name'] + "</span>";
        localStorage.setItem('imageref', url);
    }
    else if (type[0] == "video") {
        preview.innerHTML = "<div><button onclick='closeImg()' type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div><video class='w-100' controls> <source id='pre' src='" + url + "' alt='" + event.target.files[0]['name'] + "'/></video><br><span>" + event.target.files[0]['name'] + "</span>";

    }
    else if (type[0] == "audio") {
        preview.innerHTML = "<div><button onclick='closeImg()' type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div><audio class='w-100' controls> <source id='pre' src='" + url + "' alt='" + event.target.files[0]['name'] + "'/></audio><br><span>" + event.target.files[0]['name'] + "</span>";

    }
    else {
        preview.innerHTML = "<div><button onclick='closeImg()' type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div><img id='pre' width='100%' src='/icons/doc.png' alt='" + event.target.files[0]['name'] + "'><br><span>" + event.target.files[0]['name'] + "</span>";

    }


};

$("#emoji").click(function () {
    $("#previewemoji").toggleClass('d-none');
    $("#emojiselect").toggleClass('d-none');
})
$(".selectedemoji").click(function () {
    document.getElementById("msg").value += $(this).val();
})
function changeEmoji(ele, data)
{
    $('.groups').removeClass('bg-secondary')
    $(ele).addClass('bg-secondary')
    $(".emojis").removeClass('d-none')
    $(".emojis").addClass('d-none')
    $("[data-groups="+data+"]").removeClass('d-none')
}

function confirmNoteDel(id) {
    if (confirm("Are You Sure?"))
        $("#noteForm" + id).submit();
    else
        false;
}
function filter() {
    $("#search-result ol>").remove();
    const filterMsg = document.getElementsByClassName("message-content");
    for (var i = 0; i < filterMsg.length; i++) {
        if ((filterMsg[i].innerHTML).match($("#myInput5").val())) {
            $("#search-result ol").prepend("<li class='p-2 result fw-bold d-flex justify-content-between my-1'><a class='text-dark h6 fw-bold' onclick='resultClear(" + filterMsg[i].getAttribute('data-help') + ")' href='#" + filterMsg[i].getAttribute('data-help') + "'>" + filterMsg[i].innerHTML + "</a><span><a class='text-dark h6 fw-bold' onclick='resultClear(" + filterMsg[i].getAttribute('data-help') + ")' href='#" + filterMsg[i].getAttribute('data-help') + "'>" + $($(".date-time")[i]).html() + "</a></span></li>")
        }
    }
}
function resultClear(id) {
    $("#search-result ol>").remove();
    $("#myInput5").val("")
   
    setTimeout(function () {
        $(id).css({
            "background": "wheat",
            "border-bottom-left-radius": "3em"
        })
    }, 0)
    setTimeout(function () {
        $(id).css({
            "background": "transparent"
        })
    }, 2000)
}

function dbreply(ele) {
    $('div#replyhint i.fa-solid.fa-eye').css("display","none");
    var id = ($(ele).attr('data-help')).replace('msg', '');
    id = id.replace('g', '');

    const msg = $(ele).html();
    $("#formreply").val(id);
    $("#prereply").html("<div id='replyhint' class='px-4 py-2 d-flex align-items-center justify-content-between'><span class=''>Reply to: <span class='h6'> " + msg + "</span></span> <span onclick='xclose()'><i class='fa-solid fa-xmark'></i></span></div>")
}

function xclose() {
    $("#replyhint").remove();
    document.getElementById('formreply').value = '';
}

