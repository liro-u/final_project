//path for remove_line.php is wrong from other path
var need_wait_delete = false
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
          root = obj.parentNode.parentNode
          table = root.parentNode
          csv_path = table.dataset.csvpath
          edit_path = table.dataset.edit
          del_path = table.dataset.del
          obj.parentNode.parentNode.removeChild(obj.parentNode)
          children = Array.prototype.slice.call(root.children)
          children.pop()
          children.shift()
          for (let i = 0; i < children.length; i++){
            delete_node = Array.prototype.slice.call(children[i].children).pop()
            delete_node.setAttribute('onclick', "ask_delete_line(this, " + i + ", " + func_path + ")");
            delete_node.previousElementSibling.setAttribute('onclick', "edit_line(this, " + '"' + csv_path + '"' + ", " + i + ", " + '"' + edit_path + '"' + ")");
          }
        }else{
          alert('erreur lors de la suppression de la ligne\nCela peut etre liée a votre rang utilisateur ou a une erreur de communication avec le serveur')
        }
        need_wait_delete = ! need_wait_delete
      }
    }
    xhttp.open("GET", func_path + "remove_line.php?csv_path=" + csvpath + "&line=" + (line), true)
    need_wait_delete = ! need_wait_delete
    xhttp.send()
  }
}
var need_wait_add = false
var need_wait_edit = false
var last_edit = []
function edit_line(obj, csv_path, line, func_path){
  if (! need_wait_edit){
    line++
    if (obj.classList.contains('--conv-edit-line')){
      exit_edit_mode(func_path, csv_path, line)
      need_wait_edit = true
      ask_edit_line(obj, func_path, csv_path, line)
    }else{
      exit_edit_mode(func_path, csv_path, line)
      restor_old_data()
      obj.getElementsByTagName('img')[0].src = "http://simpleicon.com/wp-content/uploads/ok.png"
      obj.classList.add('--conv-edit-line')
      row = Array.prototype.slice.call(obj.parentNode.children)
      row.pop()
      row.pop()
      last_edit = []
      for (let j = 0; j < row.length; j++) {
        cell = row[j]
        last_edit.push([cell, cell.innerHTML])
        cell.innerHTML = "<input class='--grid-input-text' type='text' value='" + cell.innerHTML +"'>"
      }
    }
  }
}

function remove_edit_mode_item(obj){
  obj.getElementsByTagName('img')[0].src = "https://upload.wikimedia.org/wikipedia/commons/thumb/8/8a/OOjs_UI_icon_edit-ltr.svg/1024px-OOjs_UI_icon_edit-ltr.svg.png"
  obj.classList.remove('--conv-edit-line')
}

function restor_old_data(){
  for( let i = 0; i < last_edit.length; i++) {
    data = last_edit[i]
    data[0].innerHTML = data[1]
  }
}

function exit_edit_mode(func_path, csv_path, line){
  item_list = document.getElementsByClassName('--conv-edit-line')
  if (item_list.length){
    item = item_list.item(0)
    remove_edit_mode_item(item)
    row = Array.prototype.slice.call(item.parentNode.children)
    row.pop()
    row.pop()
    for (var j = 0; j < row.length; j++) {
      cell = row[j]
      cell.innerHTML = cell.children.item(0).value
    }
  }
}

function ask_edit_line(obj, func_path, csv_path, line){
  tab = get_line_in_tab(obj)
  xhttp = new XMLHttpRequest()
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200){
      if (this.responseText == "1"){
        last_edit = []
      }else{
        restor_old_data()
      }
      need_wait_edit = ! need_wait_edit
    }
  }
  xhttp.open("GET", func_path + "edit_line.php?csv_path=" + csv_path + "&line=" + line + "&tab=" + tab, true)
  xhttp.send()
}

function get_line_in_tab(obj){
  myline = Array.prototype.slice.call(obj.parentNode.children)
  titleline = Array.prototype.slice.call(obj.parentNode.parentNode.children.item(0).children)
  tab = [[], []]
  for (let i = 0; i < titleline.length; i++){
    tab[0][i] = titleline[i].innerHTML
    tab[1][i] = ((myline[i].innerHTML).replaceAll('&amp;', 'et')).replaceAll(';', ',')
  }
  return JSON.stringify(tab)
}

function add_row(obj, func_path, csv_path){
  if (! need_wait_add){
    xhttp = new XMLHttpRequest()
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200){
        if (this.responseText == "1"){
          create_row(obj)
        }
        need_wait_add = ! need_wait_add
      }
    }
    xhttp.open("GET", func_path + "add_line.php?csv_path=" + csv_path, true)
    need_wait_add = ! need_wait_add
    xhttp.send()
  }
}

function create_row(obj){
  table = obj.parentNode.parentNode.parentNode
  csv_path = table.dataset.csvpath
  edit_path = table.dataset.edit
  del_path = table.dataset.del
  last_line = obj.parentNode
  new_line = document.createElement('tr')
  first_line = last_line.parentNode.children.item(0)
  line = last_line.parentNode.children.length - 2
  nb_collum = Array.prototype.slice.call(first_line.children).length
  for(let i = 0; i < nb_collum; i++){
    new_line.innerHTML += "<td class='--grid-case'></td>"
  }
  new_line.innerHTML += "<td class='--grid-case' onclick='edit_line(this, " + '"' + csv_path + '"' + ", " + line + ", " + '"' + edit_path + '"' + ")'><img class='--grid-icon' src='https://upload.wikimedia.org/wikipedia/commons/thumb/8/8a/OOjs_UI_icon_edit-ltr.svg/1024px-OOjs_UI_icon_edit-ltr.svg.png'></img></td>"
  new_line.innerHTML += "<td class='--grid-case' onclick='ask_delete_line(this, " + line + ", " + '"' + del_path + '"' + ")'><img class='--grid-icon' src='http://cdn.onlinewebfonts.com/svg/img_216917.png'></img></td>"
  last_line.parentNode.insertBefore(new_line, last_line)
}
