var input_message_text = document.getElementById("--conv-input-message-text")

function send_message(){
  var new_message = input_message_text.value
  var conv_data_path = "../../../data/conversation.csv"
  xhttp = new XMLHttpRequest()
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200){
      input_message_text.value = this.responseText
    }
  }
  xhttp.open("GET", "conv_php/send_message.php?conv=" + conv_data_path + "&content_type=" + "text" + "&content=" + new_message, true)
  xhttp.send()
}

