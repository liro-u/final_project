var input_message_text = document.getElementById("--conv-input-message-text")
var message_container = document.getElementsByClassName("--conv-message-container")[0]

var galerie_mode = false;
go_to_bottom()

function getMeta(metaName) {
  var metas = document.getElementsByTagName('meta');

  for (let i = 0; i < metas.length; i++) {
    if (metas[i].getAttribute('name') === metaName) {
      return metas[i].getAttribute('content');
    }
  }

  return '';
}

function go_to_bottom(){
  message_container.scrollTop = message_container.scrollHeight;
}

function toggle_galerie_mode(obj){
  galerie_mode = ! galerie_mode
  if (galerie_mode){
    placeholder_text = "Paste the link of your image here."
    obj.classList.add('--conv-active-galerie-mode')
  }else{
    placeholder_text = "Aa"
    obj.classList.remove('--conv-active-galerie-mode')
  }
  input_message_text.placeholder = placeholder_text
}

function send_message(){
  var new_message = input_message_text.value
  if (new_message.replaceAll(' ', '') != ""){
    new_message = (new_message.replaceAll('&amp;', 'et')).replaceAll(';', ',')
    var conv_data_path = getMeta('csv_path')
    if (galerie_mode){
      content_type = "img"
    }else{
      content_type = "text"
    }
    xhttp = new XMLHttpRequest()
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200){
        console.log(this.responseText)
        input_message_text.value = ""
        data = JSON.parse(this.responseText)
        create_message(new_message, true, content_type, data[0], data[1])
      }
    }
    list_data_path = JSON.stringify(["../../../../data/admin/data.csv", "../../../../data/administration/data.csv", "../../../../data/etudiant/choixEtudiantsParcours1.csv", "../../../../data/etudiant/choixEtudiantsParcours2.csv", "../../../../data/etudiant/choixEtudiantsParcours3.csv"])
    xhttp.open("GET", "conv_php/send_message.php?conv=" + conv_data_path + "&date=" + Date.now() + "&content_type=" + content_type + "&content=" + new_message + "&csv_path_data_list=" + list_data_path, true)
    xhttp.send()
  }
}

function create_message(content, self = true, content_type = "text", pseudo = "profile picture", profile_picture = "https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png"){
  //remove hello no message when there is message
  no_message_node = document.getElementsByClassName("no_message")[0]
  if (no_message_node){
    no_message_node.parentNode.removeChild(no_message_node)
  }
  //add message
  self_wrap_part_class = ""
  self_message_class = ""
  if (self){
    self_wrap_part_class = "--conv-self-wrap-part-conv"
    self_message_class = "--conv-self-message"
  }
  new_message = "<div class='--conv-wrap-part-conv " + self_wrap_part_class + "'>"
  if (self){
    new_message += add_3_point(self)
  }
  new_message += "<div class='--conv-wrap-message " + self_message_class + "'>"
  if (! self){
    new_message += "<img class='--conv-profile-picture' src='" + profile_picture + "' alt='" + pseudo + "'></img>"
    new_message += "<p class='--conv-message-pseudo'>" + pseudo + "</p>"
  }
  if (content_type == "text"){
    new_message += '<p class="--conv-message">' + content + "</p>"
  }else if (content_type == "img"){
    new_message += "<img class='--conv-message-img' src='" + content + "' alt='error loading this image, try delete or modify the link'></img>"
  }
  new_message += '</div>'
  if (! self){
    new_message += add_3_point(self)
  }
  new_message += '</div>'
  message_container.innerHTML += new_message
}

// When the user clicks on div, open the popup
function show_popup_button(obj) {
  var lastPopup = document.getElementsByClassName("show");
  var popup = obj.children.item(1);
  if (lastPopup.length == 2 && lastPopup[1] != popup) {
    lastPopup[1].classList.toggle("show");
    lastPopup[0].classList.toggle("show");
  }
  popup.classList.toggle("show");
  obj.children.item(0).classList.toggle("show");
}

function add_3_point(self){
  wrap_3_point = "<div class='--conv-popup' onclick='show_popup_button(this)'>"
  wrap_3_point += '<img class="--conv-message-button" src="https://cdn-icons-png.flaticon.com/512/64/64576.png" alt="option"></img>'
  wrap_3_point += "<div class='--conv-popuptext"
  if (self){
    wrap_3_point += " --conv-self-popuptext"
  }
  wrap_3_point += "'><div class='--conv-popup'>"
  if (! self){
    wrap_3_point += "<p class='--conv-button-popup-text'>bloquer</p>"
    wrap_3_point += "<p class='--conv-button-popup-text'>signaler message </p>"
  }else{
    wrap_3_point += "<p class='--conv-button-popup-text'>supprimer</p>"
    wrap_3_point += "<p class='--conv-button-popup-text'>modifier</p>"
  }
  wrap_3_point += "</div></div>"
  wrap_3_point += "</div>"
  return wrap_3_point
}