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
    getMessages(room_uid, null, 10).then((res) => {
        res.forEach(item => {
            prependMessage(item.user_uid, item.message)
        })
    })
}

function appendMessage(user_uid, message){
    getUserInfo(user_uid).then(result => {
        console.log(result)
        $("#chat-container").append(`<div class="message-item"><p class="username">${result.username}</p> <p class="text">${message}</p> </div><hr class="message-split"/>`);
        scrollToBottom()
    })
}

function scrollToBottom(){
    console.log('scroll bottom')
    $("#chat-container").scrollTop($("#chat-container")[0].scrollHeight);
}

function prependMessage(user_uid, message){
    getUserInfo(user_uid).then(result => {
        $("#chat-container").prepend(`<div class="message-item"><p class="username">${result.username}</p> <p class="text">${message}</p> </div> </div><hr class="message-split"/>`);
        scrollToBottom()
    })
}

function clearChat(){
    $("#chat-container").empty();
}

function addMessageToDb(message, user_uid, room_uid){
    return new Promise(resolve => {
        $.ajax({
            url: "send_message.php",
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
            url: "get_messages.php",
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
            url: "get_unread_messages.php",
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
            url: "get_message.php",
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
        url: "add_to_unread.php",
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
            url: "get_user_info.php",
            type: "get",
            data: {"user_uid": user_uid},
            success: (response) => {
                resolve(JSON.parse(response));
            }
        })
    })
}

/*

function getMessages(){
    return new Promise(resolve => {
        $.ajax({
            url: "get_messages.php",
            type: "get",
            data: {"uid" :getCookie('uid')},
            success: function (response) {
            console.log(response);
            resolve(response)
               // You will get response from your PHP page (what you echo or print)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                document.getElementById("chat-container").innerHTML += errorThrown;
               console.log(textStatus, errorThrown);
            }
        })
    })
}*/


function tryLogin(username, password){
    console.log(username, password)
    return new Promise(resolve => {
        $.ajax({
            url: "login.php",
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
            url: "register.php",
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
            url: "check_user_exists.php",
            type: "get",
            data: {"username": username},
            success: (response) => {
                resolve(JSON.parse(response))
            }
        })
    })
}


function getCookieData(user_uid){
    console.log('cookie uid' + user_uid)
    return new Promise(resolve => {
        $.ajax({
            url: "get_cookie_data.php",
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
            url: "set_cookies.php",
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
            url: "get_room_members.php",
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

function subscribeToRoom(roomUid){
    return new Promise(resolve => {
        $.ajax({
            url: "subscribe_to_room.php",
            type: "POST",
            data: {"room_uid": roomUid},
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
            url: "create_room.php",
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

function get_subscribed_rooms(user_uid){
    return new Promise(resolve => {
        $.ajax({
            url: "get_subscribed_rooms.php",
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
            url: "get_room_info.php",
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
            getRoomInfo(room.room_uid).then((result) => {
                document.getElementById("sidebar-container").innerHTML += `<div class="sidebar-item" onclick=changeRoom('${result.room_uid}')><p>${result.room_name}</p></div>`;
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