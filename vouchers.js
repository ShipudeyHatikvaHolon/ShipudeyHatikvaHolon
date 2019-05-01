

function getInfo(){


var target = document.getElementById("target");
	var treatment = document.getElementById("treatmentSelect");
	cat_id = treatment.options[treatment.selectedIndex].value;
		

var xmlHttp = new XMLHttpRequest();
xmlHttp.open("GET", "vouchers_info.php?id_category=" + cat_id, true);
xmlHttp.onreadystatechange = function(){
	if(xmlHttp.readyState ==4 && xmlHttp.status == 200){	
		if(cat_id != ''){
		text = xmlHttp.responseText;
		target.innerHTML = text;
		}
		else{
			target.innerHTML="   בחר שובר מן הרשימה";
		}
	}
	
};
xmlHttp.send();

}
