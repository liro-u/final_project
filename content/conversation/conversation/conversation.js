var input_message_text = document.getElementById("--conv-input-message-text")
var message_container = document.getElementsByClassName("--conv-message-container")[0]

function send_message(){
  var new_message = input_message_text.value
  if (new_message.replaceAll(' ', '') != ""){
    var conv_data_path = "../../../../data/conversation.csv"
    xhttp = new XMLHttpRequest()
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200){
        input_message_text.value = this.responseText
        create_message(new_message, false, "text")
      }
    }
    xhttp.open("GET", "conv_php/send_message.php?conv=" + conv_data_path + "&date=" + Date.now() + "&content_type=" + "text" + "&content=" + new_message, true)
    xhttp.send()
  }
}

function create_message(content, is_self, content_type){
  no_message_node = document.getElementsByClassName("no_message")[0]
  if (no_message_node){
    console.log(no_message_node.parentNode)
    no_message_node.parentNode.removeChild(no_message_node)
  }
  self_wrap_part_class = ""
  self_message_class = ""
  if (self){
    self_wrap_part_class = "--conv-self-wrap-part-conv"
    self_message_class = "--conv-self-message"
  }
  new_message = "<div class='--conv-wrap-part-conv "
  + self_wrap_part_class
  + "'>"
  if (self){
    new_message += '<img class="--conv-message-button" src="https://cdn-icons-png.flaticon.com/512/64/64576.png" alt="option"></img>'
  }
  new_message += "<div class='--conv-wrap-message "
  + self_message_class
  + "'>"
  + '<p class="--conv-message">'

  if (content_type == "text"){
    new_message += content
  }

  new_message += '</p></div>'
  if (! self){
    new_message += '<img class="--conv-message-button" src="https://cdn-icons-png.flaticon.com/512/64/64576.png" alt="option"></img>'
  }
  new_message += '</div>'
  message_container.innerHTML += new_message
}
