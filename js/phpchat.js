

function send_message(event){
    event.preventDefault();
    var message = event.target[0].value;
    event.target[0].value = '';
    var user_uid = getCookie('user_uid');
    var room_uid = getCookie('current_room_uid');
    addMessageToDb(message, user_uid, room_uid).then((message_uid) => {
        getRoomMembers(room_uid).then((result) => {
            result.forEach(user => {
                addToUnread(user.user_uid, room_uid, message_uid);
            })

        })
    })



}

function getRoomMessages(room_uid){
    getMessages(room_uid, null, 50).then((res) => {
        res.forEach(item => {
            prependMessage(item.user_uid, item.message)
        })
    })
}

function appendMessage(user_uid, message){
    getUserInfo(user_uid).then(result => {
        $("#chat-container").append(`<div class="message-item"><p class="username context-menu" id="${result.uid}">${result.username}</p> <p class="text">${message}</p> </div><hr class="message-split"/>`);
        scrollToBottom()
    })
}

function scrollToBottom(){
    console.log('scroll bottom')
    $("#chat-container").scrollTop($("#chat-container")[0].scrollHeight);
}

function prependMessage(user_uid, message){
    getUserInfo(user_uid).then(result => {
        $("#chat-container").prepend(`<div class="message-item"><p class="username context-menu" id="${result.uid}">${result.username}</p> <p class="text">${message}</p> </div> </div><hr class="message-split"/>`);
        scrollToBottom()
    })
}

function clearChat(){
    $("#chat-container").empty();
}

function addMessageToDb(message, user_uid, room_uid){
    return new Promise(resolve => {
        $.ajax({
            url: "php/send_message.php",
            type: "post",
            data:{"message": message, "user_uid": user_uid, "room_uid": room_uid},
            success: function (response) {
                resolve(response)
    
    
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        });
    })
}

function getMessages(room_uid, offset, limit){
    return new Promise(resolve => {
        $.ajax({
            url: "php/get_messages.php",
            type: "get",
            data: {"room_uid": room_uid, "offset": offset, "limit": limit},
            success: (response) => {
                resolve(JSON.parse(response));
            }
        })
    })
}

function getUnreadMessages(user_uid, room_uid){
    return new Promise(resolve => {
        $.ajax({
            url: "php/get_unread_messages.php",
            type: "get",
            data: {"user_uid": user_uid, "room_uid": room_uid},
            success: (response) => {
                resolve(JSON.parse(response));
            }
        })
    })
}

function getMessage(message_uid, user_uid){
    return new Promise(resolve => {
        $.ajax({
            url: "php/get_message.php",
            type: "get",
            data: {"message_uid": message_uid, "user_uid": user_uid},
            success: (response) => {
                resolve(JSON.parse(response))
                console.log(JSON.parse(response))
            }
        })
    })
}


function addToUnread(user_uid, room_uid, message_uid){
    $.ajax({
        url: "php/add_to_unread.php",
        type: "post",
        data: {"user_uid": user_uid, "room_uid": room_uid, "message_uid": message_uid},
        success: (response) => {
            console.log(response)
        }
    })
}

function getUserInfo(user_uid){
    return new Promise(resolve => {
        $.ajax({
            url: "php/get_user_info.php",
            type: "get",
            data: {"user_uid": user_uid},
            success: (response) => {
                resolve(JSON.parse(response));
            }
        })
    })
}


function handleContextMessage(user_uid){
    console.log(user_uid);
    checkPmExists(user_uid, getCookie('user_uid')).then((res) => {
        if(res != false){
            console.log(res);
            changeRoom(res)
        }else{
            console.log('room no exists');
            createPrivateRoom(user_uid, getCookie('user_uid')).then((res) => {
                subscribeToRoom(user_uid, res);
                subscribeToRoom(getCookie('user_uid'), res);
                changeRoom(res);
            })
        }
    })

}


function updateContextContent(clicked, evt, user_uid){
    getUserInfo(user_uid).then((result) => {
        $('#context-menu').html(
            `<div class="user-contextmenu">
                <center><h1>${result.username}</h1></center>
                <div class="contextmenu-item" onclick="handleContextMessage('${result.uid}')">Message</div>
                <div class="contextmenu-item">Report</div>
            </div>
            `
        )
        $('#context-menu').attr('for', clicked.id)
        $('#context-menu').addClass('show')
        $('#context-menu').removeClass('hide')
        $('#context-menu').css("top", mouseY(evt) + 'px')
        $('#context-menu').css("left", mouseX(evt)  + 'px');
    })
}

function setupContextMenu(){
    $('body').click((evt) => {
        var clicked = evt.target;
        var currentClass = clicked.className || "No Class!";
        if(currentClass.indexOf('context-menu') >= 0){
            updateContextContent(clicked, evt, clicked.id);
        }else{
            $('#context-menu').removeClass('show');
            $('#context-menu').addClass('hide');
        }
    })
}

function tryLogin(username, password){
    console.log(username, password)
    return new Promise(resolve => {
        $.ajax({
            url: "php/login.php",
            type: "get",
            data: {"login_username": username, "login_password": password},
            success: (response) => {
                //console.log(JSON.parse(response))
                resolve(JSON.parse(response));
            },
            error: (error) => {
                resolve({"error": error});
            }
        })

    })
}

function tryRegister(username, password){
    return new Promise(resolve => {
        $.ajax({
            url: "php/register.php",
            type: "post",
            data: {"username": username, "password": password},
            success: (res) => {
                console.log(res)
                resolve(JSON.parse(res));
            }
        })
    })
}

function checkUserExists(username){
    return new Promise(resolve =>{
        $.ajax({
            url: "php/check_user_exists.php",
            type: "get",
            data: {"username": username},
            success: (response) => {
                resolve(JSON.parse(response))
            }
        })
    })
}

function checkPmExists(to_uid, from_uid){
    return new Promise(resolve => {
        $.ajax({
            url: "php/check_pm_exists.php",
            type: "get",
            data: {"to_uid": to_uid, "from_uid": from_uid},
            success: (response) => {
                console.log(response)
                resolve(JSON.parse(response));
            }
        })
    })
}

function getCookieData(user_uid){
    console.log('cookie uid' + user_uid)
    return new Promise(resolve => {
        $.ajax({
            url: "php/get_cookie_data.php",
            type: "get",
            data: {"user_uid": user_uid},
            success: (response) => {
                console.log(response);
                resolve(JSON.parse(response));
            }
        })
    })
}

function setCookies(user_uid, user_cookies){
    console.log(user_uid, user_cookies)
    return new Promise(resolve => {
        $.ajax({
            url: "php/set_cookies.php",
            type: "post",
            data: {"user_uid" : user_uid, "user_cookies": user_cookies},
            success: (response) => {
                resolve(JSON.parse(response))
            }
        })
    })
}

function getRoomMembers(roomUid){
    return new Promise(resolve => {
        $.ajax({
            url: "php/get_room_members.php",
            type: "get",
            data: {"room_uid": getCookie("current_room_uid")},
            success: (response) => {
                resolve(JSON.parse(response));
            },
            error: (jqXHR, textStatus, errorThrown) => {
                resolve({"error" : errorThrown});
            }
        })
    })
}

function subscribeToRoom(user_uid, roomUid){
    return new Promise(resolve => {
        $.ajax({
            url: "php/subscribe_to_room.php",
            type: "POST",
            data: {"room_uid": roomUid, "user_uid": user_uid},
            success: (response) => {
                resolve(JSON.parse(response));
            },
            error: (jqXHR, textStatus, errorThrown) => {
                callback({"error" : errorThrown});
            }
        })
    })
}

function createRoom(room_name){
    return new Promise(resolve => {
        $.ajax({
            url: "php/create_room.php",
            type: "POST",
            data: {"room_name": room_name},
            success: (response) => {
                if(!response.error){
                    resolve(true);
                }else{
                    resolve(false);
                }
            }
        })
    })
}

function createPrivateRoom(to_uid, from_uid){
    return new Promise(resolve => {
        $.ajax({
            url: "php/create_private_room.php",
            type: "POST",
            data: {"to_uid": to_uid, "from_uid": from_uid},
            success: (response) => {
                resolve(JSON.parse(response));
            }
        })
    })
}

function get_subscribed_rooms(user_uid){
    return new Promise(resolve => {
        $.ajax({
            url: "php/get_subscribed_rooms.php",
            type: "get",
            data: {"user_uid": user_uid},
            success: (response) => {
                if(response != false){
                    resolve(JSON.parse(response));
                    //resolve(response)
                }
            }
        })

    })
}

function getRoomInfo(room_uid){
    return new Promise(resolve => {
        $.ajax({
            url: "php/get_room_info.php",
            type: "get",
            data: {"room_uid": room_uid},
            success: (response) => {
                if(response != false){
                    resolve(JSON.parse(response));
                }
            }
        })
    })
}

function populateSidebar(){
    get_subscribed_rooms(getCookie("user_uid")).then((resolve) => {
        resolve.forEach(room => {

            console.log(room);

            getRoomInfo(room.room_uid).then((result) => {
                document.getElementById("sidebar-container").innerHTML += `<div class="sidebar-item" onclick=changeRoom('${result.room_uid}')><span class="material-icons">more_vert</span><p>${result.room_name}</p></div>`;
            })
        })
    })
}

function changeRoom(room_uid){
    console.log(room_uid)
    setCookie('current_room_uid', room_uid)
    clearChat();
    getRoomMessages(room_uid);
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function mouseX(evt) {
    if (evt.pageX) {
      return evt.pageX;
    } else if (evt.clientX) {
      return evt.clientX + (document.documentElement.scrollLeft ?
        document.documentElement.scrollLeft :
        document.body.scrollLeft);
    } else {
      return null;
    }
  }
  
  function mouseY(evt) {
    if (evt.pageY) {
      return evt.pageY;
    } else if (evt.clientY) {
      return evt.clientY + (document.documentElement.scrollTop ?
        document.documentElement.scrollTop :
        document.body.scrollTop);
    } else {
      return null;
    }
  }