//path for remove_line.php is wrong from other path

function ask_delete_line(obj, line, func_path){
  line += 1
  var warning = "Etes vous sur de vouloir faire ça ?"
  if (confirm(warning)){
    var table = obj.parentNode.parentNode.parentNode
    var csvpath = table.dataset.csvpath
    xhttp = new XMLHttpRequest()
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200){
        if (this.responseText == 1){
          obj.parentNode.parentNode.removeChild(obj.parentNode)
          children = obj.parentNode.parentNode.children
          for (let i = 0; i < children.length; i++){
            children[i].dataset.onclick = "ask_delete_line(this, " + new_line + ", " + func_path + ")"
          }
        }else{
          alert('erreur lors de la suppression de la ligne\nCela peut etre liée a votre rang utilisateur ou a une erreur de communication avec le serveur')
        }
      }
    }
    xhttp.open("GET", func_path + "remove_line.php?csv_path=" + csvpath + "&line=" + (line), true)
    xhttp.send()
  }else{

  }
}