//function: validar formato dd-mm-aa
function dateFormat(campo){
	var RegExPattern = /^\d{2,4}\-\d{1,2}\-\d{1,2}$/;
	if ((campo.match(RegExPattern)) && (campo!='')) {
	      return true;
	} else {
	      return false;
	}
}
//***
//function: revisar fecha válida
function dateExists(fecha){
	var fechaf = fecha.split("-");
	var d = fechaf[2];
	var m = fechaf[1];
	var y = fechaf[0];
	return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate();
}
//***
//function: obtener fecha de hoy
function getTodayDate(limit){
    var fecha = new Date(); //Fecha actual
    var mes = fecha.getMonth()+1; //obteniendo mes
    var dia = fecha.getDate(); //obteniendo dia
    var anio = fecha.getFullYear(); //obteniendo año
    if(dia<10){
        dia='0'+dia; //agrega cero si es menor de 10
    } 
    if(mes<10){
        mes='0'+mes //agrega cero si es menor de 10
    }
    return anio+limit+mes+limit+dia;
}
//***
