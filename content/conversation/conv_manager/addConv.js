var conv_popup = document.getElementById("conv_popup")
var group_popup = document.getElementById("group_popup")

function ShowaddConv() {
  group_popup.classList.toggle("show");
}

function ShowaddtoGroupe(path = "", type = "conv") {
  conv_popup.classList.toggle("show");
  document.getElementById("submit_ajouter").setAttribute('onclick', "add_to_group('" + path + "', '" + type + "')")
}

conv_popup.addEventListener('click', e => {
  if(e.target == e.currentTarget){
    ShowaddtoGroupe()
  }
});

group_popup.addEventListener('click', e => {
  if(e.target == e.currentTarget){
    ShowaddConv()
  }
});

function add_to_group(conv_name, type = "conv"){
  pseudo_input = document.getElementById('pseudo')
  pseudo = pseudo_input.value  
  xhttp = new XMLHttpRequest()
  xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200){
      console.log(this.responseText)
      if (this.responseText == "1"){
        ShowaddtoGroupe()
      }else{
        alert("echec de l'ajout de la personne a la conversation")
      }
    }
  }
  list_data_path = JSON.stringify(["../../../data/admin/data.csv", "../../../data/administration/data.csv", "../../../data/etudiant/choixEtudiantsParcours1.csv", "../../../data/etudiant/choixEtudiantsParcours2.csv", "../../../data/etudiant/choixEtudiantsParcours3.csv"])
  xhttp.open("GET", "add_to_conv.php?conv=" + conv_name + "&pseudo=" + pseudo + "&data_list=" + list_data_path + "&type_conv=" + type + "&prelink=" + "../../../", true)
  xhttp.send()
}

function create_conv(type_conv = "conv"){
  name_input = document.getElementById('name_group')
  pseudo_input = document.getElementById('pseudo_group')
  name_groupe = name_input.value
  pseudo = pseudo_input.value  
  xhttp = new XMLHttpRequest()
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200){
      data = JSON.parse(this.responseText)
      if (data[0] == "1"){
        window.location = '../conversation/conv_template.php?name=' + name_groupe + '&conv_path=' + data[1] + '&conv_info=' + data[2];
      }
    }
  }
  list_data_path = JSON.stringify(["../../../data/admin/data.csv", "../../../data/administration/data.csv", "../../../data/etudiant/choixEtudiantsParcours1.csv", "../../../data/etudiant/choixEtudiantsParcours2.csv", "../../../data/etudiant/choixEtudiantsParcours3.csv"])
  xhttp.open("GET", "create_conv.php?name_groupe=" + name_groupe + "&pseudo=" + pseudo + "&data_list=" + list_data_path + "&type_conv=" + type_conv + "&prelink=" + "../../../", true)
  xhttp.send()
}