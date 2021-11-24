function menu_principal(accion,param)
{
	var Accion = accion;
		document.getElementById("page-wrapper").style.display = "none";	 
	var CedulaVar = "";
	if (Accion.substr(0,17) == "ReimprimirRebPago")		
	{
		CedulaVar = Accion.substr(17,10);
		Accion = Accion.substr(0,17);
		accion = Accion;
	}
	$.ajax(
			{
				url: '../controladores/' + param + 'Ctrl.php',
				type: "POST",
				data: {accionjs: Accion}
			}).done(function (data) {
		document.getElementById("page-wrapper").innerHTML = data;
		$("#page-wrapper").fadeIn(2000);
        $('.ui.dropdown').dropdown();
		cambioprod();
		modulopersonas();
		var Accion = accion;
		if (Accion == "EmitirOrdPagLot"){emision_ordpag_lote()}	
		if ((Accion == "ReimprimirRebPago") && (CedulaVar != ""))
		{
			onclimprrebpag(CedulaVar)
		}	
	});		
}


function creahotel(){
	var accionjs = "CrearHotelTbl";
	var hotel_namejs = $("#hotel_name").val();
	var hotel_direccionjs = $("#hotel_direccion").val();
	var hotel_ciudadjs = $("#hotel_ciudad").val();
	var hotel_nitjs = $("#hotel_nit").val();
	var hotel_numhabjs = $("#hotel_numhab").val();

    if (valid(hotel_namejs,hotel_direccionjs,hotel_ciudadjs,hotel_nitjs,hotel_numhabjs,"*","*","*","*","*","*","*","*","*","*") == false)
	{
		$.ajax(
		{
			url: '../controladores/AdministracionCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, hotel_namejs: hotel_namejs, hotel_direccionjs: hotel_direccionjs, hotel_ciudadjs:hotel_ciudadjs, 
			hotel_nitjs:hotel_nitjs, hotel_numhabjs : hotel_numhabjs}
		}).done(function (data) {
			valid_Cargar("CargarHotelAgr","IdTabHotel");
			mensaje("Mensaje",1,data,"top-right");
		});		
	}
}


function creahabita(){
	var accionjs = "CrearHabitTbl";
	var id_hoteljs = $("#id_hotel").val();
	var hotel_cantjs = $("#hotel_cant").val();
	var product_categoryjs = $("#product_category").val();
	var id_hotelCantjs  = $("#id_hotelCant").val();

    if (valid(id_hoteljs,hotel_cantjs,product_categoryjs,"*","*","*","*","*","*","*","*","*","*","*","*") == false)
	{
		$.ajax(
		{
			url: '../controladores/AdministracionCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, id_hoteljs: id_hoteljs, hotel_cantjs: hotel_cantjs, product_categoryjs:product_categoryjs,id_hotelCantjs:id_hotelCantjs}
		}).done(function (data) {
			mensaje("Mensaje",1,data,"top-right");
		});		
	}
}



function oncambiar_apl() 
{
	if (document.getElementById("ch_noapl").checked == true)
	{
		$('.form_semestre').dropdown('set selected', '0').dropdown('refresh');
		$('.form_carrera').dropdown('set selected', '13').dropdown('refresh');
	}else {
		$('.form_semestre').dropdown('set selected', '1').dropdown('refresh');
		$('.form_carrera').dropdown('set selected', '1').dropdown('refresh');
	}
}

function mensaje(titulo,icono,descr,ubicacion)
{
	if (icono == 1) {var descricon = "success";}
	if (icono == 2) {var descricon = "info";}
	if (icono == 3) {var descricon = "error";}
	$.toast({
		heading:   titulo,
		text:      descr,
		position:  ubicacion,
		loaderBg:  '#ff6849',
		icon:      descricon,
		hideAfter: 3000
	});					
}

function valid_Cargar(accion,id_tabl)
{
	var accionjs = accion;
    $.ajax(
            {
                url: '../controladores/AdministracionCtrl.php',
                type: "POST",
                data: {accionjs: accionjs}
            }).done(function (data) {
				$("#"+id_tabl).html(data);
				cambioprod();
			});		
}

function valid(par1,par2,par3,par4,par5,par6,par7,par8,par9,par10,par11,par12,par13,par14,par15)
{
	if (par1 != ''  && par2 != ''  && par3 != ''  && par4 != ''  && par5 != ''  && 
	    par6 != ''  && par7 != ''  && par8 != ''  && par9 != ''  && par10 != '' && 
		par11 != '' && par12 != '' && par13 != '' && par14 != '' && par15 != '')
	{ 
		return false;
	} else 
	{
		mensaje("Mensaje",2,"Llene todos los datos, por favor","top-right");
		return true;
	}		
}

function ir_rebpag(Codigo)
{
	var accionjs = "GenerarRebPag";
	var Cedulajs = "";
		$.ajax(
		{
			url: '../controladores/ReimprimirCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, Codigojs: Codigo}
		}).done(function (data) { 
			document.getElementById("wrapper").innerHTML = data;
            $(function () {
                
                $('.btnPrint').click(function () {
                    $('.no-print').hide();

                    window.print();

                    swal({
                        title: '',
                        text:  "Imprimiendo recibo de pago.\nPulse OK para continuar",
                        type:  "info",
                        timer: 2000
                    });

                    $('.no-print').show();
                });

                $('.btnCancelled').click(function () {
                    swal({
                        title:              "¿Desea anular este recibo?",
                        text:               "Tenga en cuenta que es un paso irreversible.",
                        type:               "warning",
                        showCancelButton:   true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText:  "Si, anular recibo",
                        cancelButtonText:   "Cancelar",
                        closeOnConfirm:     false
                    }, function () {
//                       swal({
//                            title:             "Verificando información",
//                            text:              "Estamos verificando la información necesaria para la anulación del recibo de pago, será redireccionado al finalizar el proceso.",
//                            type:              "info",
//                            showCancelButton:  false,
//                            showConfirmButton: false
//                        });
						
                        ////$('#frmCancelled').submit();
						anular_reb();
                    });
                });
            });			
		});	
}

function anular_reb()
{
	var accionjs = "anular_reb";
	var Id_Pagosjs = $("#Id_Pagos").val();
	$.ajax(
			{
				url: '../controladores/ReimprimirCtrl.php',
				type: "POST",
				data: {accionjs: accionjs, Id_Pagosjs:Id_Pagosjs}
			}).done(function (data) {
				mensaje("Mensaje",1,"Registro Anulado","top-right");				
				ir_principal("ReimprimirRebPago","Reimprimir");
			});			
}
function registrar_abono()
{
	var accionjs = "registrabono";	
	var reg_cedulajs = $("#reg_cedula").val();
	var emipagojs = $("#emis_category").val();
	var fechabonjs = $("#registration").val();
	var conceptojs = $("#order_text").val();
	var monedajs = $("#moneda_category").val();
	var montojs = $("#order_amount").val();	
	var Id_Pagosjs = $("#Id_Pagos").val();
	$(".btnOrderCheck").addClass("loading");
	$.ajax(
			{
				url: '../controladores/EmitirOrdPagCtrl.php',
				type: "POST",
				data: {accionjs: accionjs, reg_cedulajs:reg_cedulajs, emipagojs: emipagojs, fechabonjs: fechabonjs, 
				conceptojs: conceptojs, monedajs: monedajs,  montojs: montojs, Id_Pagosjs: Id_Pagosjs}
			}).done(function (data) {
				mensaje("Mensaje",1,data,"top-right");				
				window.setTimeout(function(){
					$(".btnOrderCheck").removeClass("loading");
					ir_principal("RegistrAbon","EmitirOrdPag");
				}, 2000);
			});			
}
function onclprinc()
{
	var accionjs = "ConsultaCed";
	var Cedulajs = $("#username").val()
    if (valid(Cedulajs,"*","*","*","*","*","*","*","*","*","*","*","*","*","*") == false)
	{
		$(".btnUsername").addClass("loading");
		$("#page-wrapper-princ").hide();
		$.ajax(
		{
			url: '../controladores/PrincipalCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, Cedulajs: Cedulajs}
		}).done(function (data) {			
			$("#id_titulo").hide();
			$("#page-wrapper-princ").hide();
			document.getElementById("page-wrapper-princ").innerHTML = data;
			$("#page-wrapper-princ").fadeIn(1500);
			$('.ui.dropdown').dropdown();
			document.getElementById("order_all").checked = true;
			$('.cart_order:visible').click();	
			$(".btnUsername").removeClass("loading");
		});		
	}
}

function subirarch()
{
	var accionjs = "SubirArch";
	var file_data = $('#file_alumnos').prop('files')[0]; 	
	$('#adj_arch').css({'display':'none'});
	$('#car_arch').css({'display':'block'});
	$("#car_arch").addClass("loading");
	var form_data = new FormData();                  
	form_data.append('file', file_data);
	$.ajax(
	{
		url: '../controladores/AdministracionCtrl.php',
		dataType: 'text',  
		type: 'post',
		cache: false,
		contentType: false,
		processData: false,			
		data: form_data                         
	}).done(function (data) {
		document.getElementById("IdRerporteProdAct").innerHTML = data;
		$("#car_arch").removeClass("loading");
	 });	
}

function cargarch()
{
	var accionjs = "SubirArch_Cargar";
	$('#adj_arch').css({'display':'block'});
	$('#car_arch').css({'display':'none'});
	var product_lot = document.getElementsByName("product_id[]");
	var cad_val = '{';
	var j = 0;
	for (var i = 0; i < product_lot.length; i++) { 
		j = j + 1;
		if (j > 1) {cad_val = cad_val + ",";}
		$_that   = $("#product_id"+j);			
		$register = $_that.data();				
		cad_val = cad_val + 
		'"Cedula'+j+'":"'+   $register.cedula+'"' + 
		',"Nombre1_'+j+'":"'+  $register.nombre1+'"' + 
		',"Nombre2_'+j+'":"'+  $register.nombre2+'"' + 
		',"Apellido1_'+j+'":"'+$register.apellido1+'"' + 
		',"Apellido2_'+j+'":"'+$register.apellido2+'"' + 
		',"FechIngr'+j+'":"'+ $register.fechingr+'"' + 
		',"Semestre'+j+'":"'+ $register.semestre+'"' + 
		',"Carrera'+j+'":"'+  $register.carrera+'"' + 
		',"Situacion'+j+'":"'+$register.situacion+'"' + 
		',"FechRet'+j+'":"'+  $register.fechret+'"';
	}
	var cad_val = cad_val + '}';
	var contjs = j;
	$.ajax(
	{
		url: '../controladores/AdministracionCtrl.php',
		type: "POST",
		data: {accionjs: accionjs, cad_valjs:cad_val, contjs:contjs}
	}).done(function (data) {
		mensaje("Mensaje",1,data,"top-right");
	});
}

function ir_menimprimir(Cedula)
{
	ir_principal('ReimprimirRebPago'+Cedula,'Reimprimir');
}

function onconsrep(TipoRep)
{
	var val_ced = "*";
	if (TipoRep == "1") {var accionjs = "ConsRepArq";} 
	if (TipoRep == "2") {var accionjs = "ConsRepDesgl";} 
	if (TipoRep == "3") {var accionjs = "ConsInfPagCed";var val_ced = $("#username").val();} 
	if (TipoRep == "4") {var accionjs = "ConsRepPagPend";var val_ced = $("#username").val();if (val_ced == ""){val_ced = "*";} } 
	if (TipoRep == "5") {var accionjs = "ConsRepPagPendNombr";var val_ced = $("#username").val();if (val_ced == ""){val_ced = "*";} } 
	var val_efe = "";
	var val_tar = "";
	var val_exo = "";
	var val_vau = ""; 
	var fecha_desde = document.getElementById("date_from").value;
	var fecha_desde = fecha_desde.substr(8,2) + "/" + fecha_desde.substr(5,2) + "/" + fecha_desde.substr(0,4);	
	var fecha_hasta = document.getElementById("date_at").value;
	var fecha_hasta = fecha_hasta.substr(8,2) + "/" + fecha_hasta.substr(5,2) + "/" + fecha_hasta.substr(0,4);	
	if (TipoRep != "4" && TipoRep != "5")
	{
		if (document.getElementById("type_Efectivo").checked)    {val_efe = document.getElementById("type_Efectivo").value;}
		if (document.getElementById("type_Tarjeta").checked)     {val_tar = document.getElementById("type_Tarjeta").value;}
		if (document.getElementById("type_Exoneracion").checked) {val_exo = document.getElementById("type_Exoneracion").value;}
		if (document.getElementById("type_Vaucher").checked)     {val_vau = document.getElementById("type_Vaucher").value;}		
	}
    if (valid(val_ced,"*","*","*","*","*","*","*","*","*","*","*","*","*","*") == false)
	{
		$("#btnconsrep").addClass("loading");
		var categ_lot = document.getElementsByName("category[]");
		var cad_val = '{';
		var j = 0;
		for (var i = 0; i < categ_lot.length; i++) { 
			if (categ_lot[i].checked)
			{
				j = j + 1;
				if (j > 1) {cad_val = cad_val + ",";}
				var categjs = categ_lot[i].value;
				cad_val = cad_val + '"'+j+'":"'+categ_lot[i].value+'"';
			}
		}
		var cad_val = cad_val + '}';
		$.ajax(
		{
			url: '../controladores/ReportesCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, cad_valjs: cad_val, val_efejs:val_efe, val_tarjs:val_tar, val_exojs:val_exo, 
			val_vaujs:val_vau, fecha_desdejs:fecha_desde, fecha_hastajs:fecha_hasta, val_cedjs:val_ced}
		}).done(function (data) {
			document.getElementById("wrapper").innerHTML = data;		
			$("#btnconsrep").removeClass("loading");
			$(function () {
				$('.btnPrint').click(function () {
					$('.no-print').hide();
					window.print();
					swal({
						title: '',
						text:  "Imprimiendo reporte.\nPulse OK para continuar",
						type:  "info",
						timer: 2000
					});

					$('.no-print').show();
				});

				$('#desglose').click(function () {
					$('#tbl_arqueo, #tbl_desglose').toggle();
				});

				$(document).contextmenu(function () {
					return false;
				});
			});
		});
	}
}

function onclimprrebpag(Cedu)
{
	var accionjs = "ConsultaCed";	
	var Cedulajs = Cedu;
	if (Cedulajs == ""){		
		var Cedulajs = $("#username").val();
	}
    if (valid(Cedulajs,"*","*","*","*","*","*","*","*","*","*","*","*","*","*") == false)
	{
		$(".btnUsername").addClass("loading");
		$.ajax(
		{
			url: '../controladores/ReimprimirCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, Cedulajs: Cedulajs}
		}).done(function (data) {			
			$("#id_titulo").hide();
			$("#page-wrapper-reimpr").hide();
			document.getElementById("page-wrapper-reimpr").innerHTML = data;
			$("#page-wrapper-reimpr").fadeIn(1500);
			$(".btnUsername").removeClass("loading");
			$(function () {
				$('.table.dt').DataTable({
					dom:          'lf<"clear">B<"clear">rtip',
					buttons:      [
						'csv', 'excel', 'pdf'
					],
					language:     {
						"sProcessing":     "Procesando...",
						"sLengthMenu":     "Mostrar _MENU_ registros",
						"sZeroRecords":    "No se encontraron resultados",
						"sEmptyTable":     "Ningún dato disponible en esta tabla",
						"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
						"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
						"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
						"sInfoPostFix":    "",
						"sSearch":         "Buscar:",
						"sUrl":            "",
						"sInfoThousands":  ",",
						"sLoadingRecords": "Cargando...",
						"oPaginate":       {
							"sFirst":    "Primero",
							"sLast":     "Último",
							"sNext":     "Siguiente",
							"sPrevious": "Anterior"
						},
						"oAria":           {
							"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
							"sSortDescending": ": Activar para ordenar la columna de manera descendente"
						}
					},
					initComplete: function () {
						$('select').addClass('ui dropdown');
					}
				});
			});
		});		
	}
}

function onclimprclav()
{
	var accionjs = "BuscarReimpClave";
	var Cedulajs = $("#username").val()
    if (valid(Cedulajs,"*","*","*","*","*","*","*","*","*","*","*","*","*","*") == false)
	{
		$.ajax(
		{
			url: '../controladores/ReimprimirCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, Cedulajs: Cedulajs}
		}).done(function (data) {			
			$("#id_titulo").hide();
			$("#wrapper").hide();
			document.getElementById("wrapper").innerHTML = data;
			$("#wrapper").fadeIn(1500);
            $(function () {
                $('.btnPrint').click(function () {
                    $('.no-print').hide();

                    window.print();

                    swal({
                        title: '',
                        text:  "Imprimiendo clave para la reinscripción.\nPulse OK para continuar",
                        type:  "info",
                        timer: 2000
                    });

                    $('.no-print').show();
                });
            });
            $(document).on("contextmenu", function (e) {

                return false;
            });
		});		
	}	
}


function regr_princ()
{
	$("#page-wrapper-princ").hide();
	$("#id_titulo").fadeIn(1500);
	
}

function accionprod(param)//1:incluir,2:Modificar
{
	var accionjs = "AgregarProductos";
	var IdProdjs = "";
	if (param == "2") 
	{
		var accionjs = "ModificarProductos";
		var IdProdjs = $("#id_product_name").val();
	}
	var Nombrejs = $("#product_name").val(); 
	var IdCatjs = $("#product_category").val();
	var Cantidadjs = $("#product_units").val();
	var monedajs = $("#moneda_category").val();
	if (document.getElementById("product_accountant").checked == false)
	{var Cantidadjs = 0;}		
	var Preciojs = $("#product_amount").val();
	if (document.getElementById("product_inventory").checked == false)
	{var ChInvjs = 0;} else {var ChInvjs = 1;}
    if (valid(Nombrejs,Preciojs,"*","*","*","*","*","*","*","*","*","*","*","*","*") == false)
	{
		$.ajax(
		{
			url: '../controladores/AdministracionCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, IdProdjs: IdProdjs, Nombrejs: Nombrejs, IdCatjs:IdCatjs, Cantidadjs:Cantidadjs, 
			Preciojs:Preciojs, ChInvjs: ChInvjs, monedajs:monedajs}
		}).done(function (data) {
			if (param == "1") {valid_Cargar("CargarProductos","IdReporteProd");}
			if (param == "2") {valid_Cargar("CargarProductosAct","IdRerporteProdAct");}
			mensaje("Mensaje",1,data,"top-right");
		});
	}
}

function creaunidad(){
	var accionjs = "CrearUnidadesTbl";
	var Cantidadjs = $("#product_units").val();
	var UnidCantidadjs = $("#product_units_exist").val();	
	var IdProdjs = $("#id_product_name").val();	
	var nombreprojs = $("#product_name").val();
	$.ajax(
	{
		url: '../controladores/AdministracionCtrl.php',
		type: "POST",
		data: {accionjs: accionjs, IdProdjs: IdProdjs, Cantidadjs: Cantidadjs, UnidCantidadjs: UnidCantidadjs, nombreprojs:nombreprojs}
	}).done(function (data) {
		valid_Cargar("CargarUnidadAgr","IdCrearUnid");
		mensaje("Mensaje",1,data,"top-right");
	});
}

function creacarrera(){
	var accionjs = "CrearCarreraTbl";
	var career_namejs = $("#career_name").val();
	var career_coordinationjs = $("#career_coordination").val();	
	var IdProdjs = $("#id_product_name").val();
    if (valid(career_namejs,"*","*","*","*","*","*","*","*","*","*","*","*","*","*") == false)
	{
		$.ajax(
		{
			url: '../controladores/AdministracionCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, career_namejs: career_namejs, career_coordinationjs: career_coordinationjs}
		}).done(function (data) {
			valid_Cargar("CargarCarreraAgr","IdTabCarrera");
			mensaje("Mensaje",1,data,"top-right");
		});		
	}
}

function modifcarrera()
{
	var accionjs = "ModifCarreraTbl";	
	var id_carrerajs = $("#id_carrera").val();
	var career_namejs = $("#career_name").val();
	var career_coordinationjs = $("#career_coordination").val();	
	var IdProdjs = $("#id_product_name").val();
	if (document.getElementById("career_delete").checked == true)
	{
		eliminar_reg("CampoCarrera",id_carrerajs,"princcarreras");		
		window.setTimeout(function(){
			valid_Cargar("CargarCarreraMod","IdTabCarrera");			
		}, 2000);
	} else 
	{
		$.ajax(
            {
                url: '../controladores/AdministracionCtrl.php',
                type: "POST",
                data: {accionjs: accionjs, id_carrerajs: id_carrerajs, career_namejs: career_namejs, career_coordinationjs: career_coordinationjs}
            }).done(function (data) {
				valid_Cargar("CargarCarreraMod","IdTabCarrera");
				mensaje("Mensaje",1,data,"top-right");
			});			
	}//ifelse
}

function crearcuenta(){
	var accionjs = "CrearCuentaTbl";
	var category_namejs = $("#category_name").val();
	var category_colorjs = $("#category_color").val();	
	if (document.getElementById("category_status").checked == false)
	{var Chcategory_status = 0;} else {var Chcategory_status = 1;}
    if (valid(category_namejs,"*","*","*","*","*","*","*","*","*","*","*","*","*","*") == false)
	{
		$.ajax(
		{
			url: '../controladores/AdministracionCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, category_namejs: category_namejs, category_colorjs: category_colorjs, Chcategory_status:Chcategory_status}
		}).done(function (data) {
			valid_Cargar("CargarCuentaAgr","IdTabCuenta");
			mensaje("Mensaje",1,data,"top-right");
		});		
	}
}

function modifcuenta()
{
	var accionjs = "ModifCuentaTbl";	
	var id_categoryjs = $("#id_category").val();
	var category_namejs = $("#category_name").val();
	var category_colorjs = $("#category_color").val();	
	if (document.getElementById("category_status").checked == false)
	{var Chcategory_status = 0;} else {var Chcategory_status = 1;}
	if (document.getElementById("category_delete").checked == true)
	{
		eliminar_reg("CampoCuenta",id_categoryjs,"princcuenta");		
		window.setTimeout(function(){
			valid_Cargar("CargarCuentaModTbl","IdTabCuenta");
		}, 2000);
	} else {
    $.ajax(
            {
                url: '../controladores/AdministracionCtrl.php',
                type: "POST",
				data: {accionjs: accionjs, id_categoryjs:id_categoryjs, category_namejs: category_namejs, category_colorjs: category_colorjs, Chcategory_status:Chcategory_status}
            }).done(function (data) {
				valid_Cargar("CargarCuentaModTbl","IdTabCuenta");
				mensaje("Mensaje",1,data,"top-right");
			});			
	}//ifelse
}

function crearcoord(){
	var accionjs = "CrearCoordTbl";
	var coordination_namejs = $("#coordination_name").val();
    if (valid(coordination_namejs,"*","*","*","*","*","*","*","*","*","*","*","*","*","*") == false)
	{
		$.ajax(
		{
			url: '../controladores/AdministracionCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, coordination_namejs: coordination_namejs}
		}).done(function (data) {
			valid_Cargar("CargarCoorAgr","IdCoordinacion");
			mensaje("Mensaje",1,data,"top-right");
		});		
	}
}

function modifcoord(){
	var accionjs = "ModifCoordTbl";
	var id_coordinationjs = $("#id_coordination").val();
	var coordination_namejs = $("#coordination_name").val();
    if (valid(coordination_namejs,"*","*","*","*","*","*","*","*","*","*","*","*","*","*") == false)
	{
		if (document.getElementById("coordination_delete").checked == true)
		{
			eliminar_reg("CampoCoord",id_coordinationjs,"princcoord");		
			window.setTimeout(function(){
				valid_Cargar("CargarCoorMod","IdCoordinacion");
			}, 2000);
		} else {
			$.ajax(
				{
					url: '../controladores/AdministracionCtrl.php',
					type: "POST",
					data: {accionjs: accionjs, id_coordinationjs:id_coordinationjs, coordination_namejs: coordination_namejs}
				}).done(function (data) {
					valid_Cargar("CargarCoorMod","IdCoordinacion");
					mensaje("Mensaje",1,data,"top-right");
				});		
		}//ifelse
	}
}

function crearusus()
{
	var accionjs = "CrearUsurTbl";	
	var dnijs = $("#dni").val();
	var namejs = $("#name").val();
	var emailjs = $("#email").val();
	var usuariojs = $("#username").val();
	var usernamejs = SHA1($("#username").val());
	var passwordjs = SHA1($("#password").val());	
	var tipojs = $("#tipo").val();
	var password_repeatjs = SHA1($("#password_repeat").val());
	if (passwordjs == password_repeatjs)
	{
		if (valid(dnijs,namejs,emailjs,usernamejs,passwordjs,password_repeatjs,tipojs,"*","*","*","*","*","*","*","*") == false)
		{
			$.ajax(
			{
				url: '../controladores/AdministracionCtrl.php',
				type: "POST",
				data: {accionjs: accionjs, dnijs:dnijs, namejs:namejs, usuariojs:usuariojs, tipojs:tipojs, emailjs:emailjs, usernamejs:usernamejs, passwordjs:passwordjs}
			}).done(function (data) {
				if (data != ""){mensaje("Mensaje",3,"Registro No Guardado","top-right");}
				else {mensaje("Mensaje",1,"Usuario Creado","top-right");}
			});		
		}
	}else{mensaje("Mensaje",2,"Clave no coincide","top-right");}
}

function crearususest()
{
	var accionjs = "CrearUsurEstTbl";	
	var dnijs = $("#dni").val();
	var namejs = $("#name").val();
	var emailjs = $("#email").val();
	var usuariojs = $("#username").val();
	var usernamejs = SHA1($("#username").val());
	var passwordjs = SHA1($("#password").val());	
	var password_repeatjs = SHA1($("#password_repeat").val());
	if (passwordjs == password_repeatjs)
	{
		if (valid(dnijs,namejs,emailjs,usernamejs,passwordjs,password_repeatjs,"*","*","*","*","*","*","*","*","*") == false)
		{
			$.ajax(
			{
				url: '../controladores/AdministracionCtrl.php',
				type: "POST",
				data: {accionjs: accionjs, dnijs:dnijs, namejs:namejs, usuariojs:usuariojs, emailjs:emailjs, usernamejs:usernamejs, passwordjs:passwordjs}
			}).done(function (data) {
				if (data != ""){mensaje("Mensaje",3,"Registro No Guardado","top-right");}
				else {mensaje("Mensaje",1,"Usuario Creado","top-right");}
			});		
		}
	}else{mensaje("Mensaje",2,"Clave no coincide","top-right");}
}

function guardarconfparam()
{
	var accionjs = "Modificconfparam";	
	var Idjs = $("#Id").val();
	var Nombrejs = $("#name").val();
	var Direccionjs = $("#address").val();
	var Poblacionjs = $("#population").val();
	var RIFjs = $("#rif").val();
	var Telefonojs = $("#phone").val();
	var Lap_Actjs = $("#period_current").val();
	var Lap_Sigjs = $("#period_next").val();
	var Semillajs = $("#code").val();	
	if (valid(Nombrejs,Direccionjs,Poblacionjs,RIFjs,Telefonojs,Lap_Actjs,Lap_Sigjs,Semillajs,"*","*","*","*","*","*","*") == false)
	{
		$.ajax(
		{
			url: '../controladores/AdministracionCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, Idjs:Idjs, Nombrejs:Nombrejs, Direccionjs:Direccionjs, Poblacionjs:Poblacionjs, 
			RIFjs:RIFjs, Telefonojs:Telefonojs, Lap_Actjs:Lap_Actjs, Lap_Sigjs:Lap_Sigjs, Semillajs:Semillajs}
		}).done(function (data) {
			mensaje("Mensaje",1,"Registros Guardados","top-right");
		});		
	}
	
}

function guardarusu()
{
	var accionjs = "ModificUsurTbl";	
	var dnijs = $("#dni").val();
	var namejs = $("#name").val();
	var emailjs = $("#email").val();
	var usuariojs = $("#username").val();
	var usernamejs = SHA1($("#username").val());
	var passwordjs = SHA1($("#password").val());	
	var tipojs = $("#tipo").val();
	var password_repeatjs = SHA1($("#password_repeat").val());
	if (passwordjs == "" && password_repeatjs == "") {
		var passwordjs = "**";
		var password_repeatjs = "**";
	}
	if (passwordjs == password_repeatjs)
	{
		if (document.getElementById("user_delete").checked == true)
		{
			eliminar_reg("CampoUsuario",usernamejs,"princusuarios");		
		} else 
		if (valid(dnijs,namejs,emailjs,usernamejs,passwordjs,password_repeatjs,tipojs,"*","*","*","*","*","*","*","*") == false)
		{
			$.ajax(
			{
				url: '../controladores/AdministracionCtrl.php',
				type: "POST",
				data: {accionjs: accionjs, dnijs:dnijs, namejs:namejs, usuariojs:usuariojs, tipojs:tipojs, emailjs:emailjs, usernamejs:usernamejs, passwordjs:passwordjs}
			}).done(function (data) {
				if (data != ""){mensaje("Mensaje",3,"Registro No Guardado","top-right");}
				else {mensaje("Mensaje",1,"Usuario Actualizado","top-right");}
			});		
		}
	}else{mensaje("Mensaje",2,"Clave no coincide","top-right");}
}

function guardarusuest()
{
	var accionjs = "ModificUsurTblEst";	
	var dnijs = $("#dni").val();
	var namejs = $("#name").val();
	var emailjs = $("#email").val();
	var usuariojs = $("#username").val();
	var usernamejs = SHA1($("#username").val());
	var passwordjs = SHA1($("#password").val());	
	var password_repeatjs = SHA1($("#password_repeat").val());
	if (passwordjs == "" && password_repeatjs == "") {
		var passwordjs = "**";
		var password_repeatjs = "**";
	}
	if (passwordjs == password_repeatjs)
	{
		if (document.getElementById("user_delete").checked == true)
		{
			eliminar_reg("CampoUsuarioEst",usernamejs,"princusuariosEst");		
		} else 
		if (valid(dnijs,namejs,emailjs,usernamejs,passwordjs,password_repeatjs,"*","*","*","*","*","*","*","*","*") == false)
		{
			$.ajax(
			{
				url: '../controladores/AdministracionCtrl.php',
				type: "POST",
				data: {accionjs: accionjs, dnijs:dnijs, namejs:namejs, usuariojs:usuariojs, emailjs:emailjs, usernamejs:usernamejs, passwordjs:passwordjs}
			}).done(function (data) {
				if (data != ""){mensaje("Mensaje",3,"Registro No Guardado","top-right");}
				else {mensaje("Mensaje",1,"Usuario Actualizado","top-right");}
			});		
		}
	}else{mensaje("Mensaje",2,"Clave no coincide","top-right");}
}

function accionpersona(param)//1:incluir, 2:modificar
{
	var accionjs = "CrearPersonasTbl";
	if (param == 2) {var accionjs = "ModificarPersonasTbl";}
	var dnijs = $("#dni").val();
	var nombre1js = $("#name_first").val();
	var nombre2js = $("#name_second").val();	
	var apellido1js = $("#surname_first").val();
	var apellido2js = $("#surname_second").val();	
	var fechaincrjs = $("#registration").val();
	var fechaincrjs = fechaincrjs.substr(8,2) + "/" + fechaincrjs.substr(5,2) + "/" + fechaincrjs.substr(0,4);	
	var semestrejs = $("#half").val();	
	var carrerajs = $("#career").val();
	var situacionjs = $("#retirement").val();
	var fecharet = $("#retirement_date").val();
	var fecharet = fecharet.substr(8,2) + "/" + fecharet.substr(5,2) + "/" + fecharet.substr(0,4);	
    if (valid(dni,nombre1js,apellido1js,fechaincrjs,semestrejs,carrerajs,situacionjs,"*","*","*","*","*","*","*","*") == false)
	{
		$.ajax(
		{
			url: '../controladores/AdministracionCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, dnijs: dnijs, nombre1js:nombre1js, nombre2js:nombre2js, 
			apellido1js:apellido1js, apellido2js:apellido2js, fechaincrjs:fechaincrjs,
			semestrejs:semestrejs, carrerajs:carrerajs, situacionjs:situacionjs, fecharet,fecharet}
		}).done(function (data) {
			if (data == "Persona Creada"){mensaje("Mensaje",1,data,"top-right");}else
			if (data == "Datos Modificados"){mensaje("Mensaje",1,data,"top-right");}
			else {mensaje("Mensaje",3,"Registro No Guardado","top-right");}
		});		
	}
}

function guardarpermusu(param)
{
	var usernamejs = $("#iduserCoor").val();
	var accionjs = "eliminarusu";
	var paramjs = param;
	$.ajax(
	{
		url: '../controladores/AdministracionCtrl.php',
		type: "POST",
		data: {accionjs: accionjs, usernamejs:usernamejs, paramjs:paramjs}
	}).done(function (data) {
		var perm_lot = document.getElementsByName("permissions[]");
		var usernamejs = $("#iduserCoor").val();		
		var accionjs = "agregarusumov";
		var paramjs = param;
		for (var i = 0; i < perm_lot.length; i++) { 
			if (perm_lot[i].checked)
			{
				var permjs = perm_lot[i].value;
				$.ajax(
				{
					url: '../controladores/AdministracionCtrl.php',
					type: "POST",
					data: {accionjs: accionjs, usernamejs:usernamejs, permjs:permjs, paramjs:paramjs}
				}).done(function (data) {});
			}//if
		}//for
		mensaje("Mensaje",1,"Datos Actualizados","top-right");	
	});		
}

function guardarmon(param)
{
	var monedajs = $("#moneda_name").val();
	var monedasjs = $("#monedas_name").val();	
	var abrevjs = $("#moneda_abrev").val();
	var simbjs = $("#moneda_simb").val();
	var accionjs = "agregarmon";
	var monedaidjs = "";
	if (param == "2") 
	{
		var accionjs = "modifmon";
		var monedaidjs = $("#moneda_id_val").val();
	}	
	var paramjs = param;
	$.ajax(
	{
		url: '../controladores/AdministracionCtrl.php',
		type: "POST",
		data: {accionjs: accionjs, monedajs:monedajs, monedasjs:monedasjs, abrevjs:abrevjs, simbjs:simbjs, monedaidjs:monedaidjs}
	}).done(function (data) {
		mensaje("Mensaje",1,data,"top-right");	
		if (param == "1") {valid_Cargar("CargarMoneda","IdMoneda");}
		if (param == "2") {valid_Cargar("CargarMonedaModif","IdMoneda");}
		
	});		
}

function eliminar_reg(campojs,registrojs,valtabljs)
{
	var accionjs = "ElimRegTbl";
	$.ajax(
	{
		url: '../controladores/AdministracionCtrl.php',
		type: "POST",
		data: {accionjs: accionjs, campojs:campojs, registrojs:registrojs, valtabljs:valtabljs}
	}).done(function (data) {
		mensaje("Mensaje",1,"Registro Eliminado","top-right");			
	});	
}
function buscar_ced_emi()
{
	var CedAlumjs = $("#username").val();
	if (CedAlumjs == ""){mensaje("Mensaje",2,"Debe llenar la cedula","top-right");}
	else{
		var accionjs = "BuscarCedulaEmis";
		$.ajax(
		{
			url: '../controladores/EmitirOrdPagCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, CedAlumjs:CedAlumjs}
		}).done(function (data) {
			var valid = data;
			if (valid == "0")
			{
				mensaje("Mensaje",2,"Cedula No Encontrada","top-right");
			} else
			{
				$("#consulta_cedula_emis").fadeOut(200);
				document.getElementById("datos_consulta_cedula_emis").innerHTML = data;
				$("#datos_consulta_cedula_emis").fadeIn(1500);
				$('.ui.dropdown').dropdown();
				emision_ordpag();
				gen_categ();
			}
		});	
		
	}
}
function buscar_ced_abon()
{
	var CedAlumjs = $("#username").val();
	if (CedAlumjs == ""){mensaje("Mensaje",2,"Debe llenar la cedula","top-right");}
	else{
		var accionjs = "RegistrAbon_mov";
		$(".btnUsername").addClass("loading");
		$.ajax(
		{
			url: '../controladores/EmitirOrdPagCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, CedAlumjs:CedAlumjs}
		}).done(function (data) {
			var valid = data;
			if (valid == "0")
			{
				mensaje("Mensaje",2,"Cedula No Encontrada","top-right");
			} else
			{
				$("#consulta_cedula_emis").fadeOut(200);
				document.getElementById("datos_consulta_cedula_abon").innerHTML = data;
				$("#datos_consulta_cedula_abon").fadeIn(1500);
				$('.ui.dropdown').dropdown();
				//emision_ordpag();
			}
		$(".btnUsername").removeClass("loading");
		});	
		
	}	
}
function buscar_regresar()
{
	$("#datos_consulta_cedula_emis").fadeOut(200);
	document.getElementById("datos_consulta_cedula_emis").innerHTML = "";
	$("#username").val("");
	$("#consulta_cedula_emis").fadeIn(1500);	
}
function regresar()
{
	$("#page-wrapper").fadeOut(1000);	
}
function generar_ordpag()
{
	var idcategoriajs = $("#product_category").val();
	var order_textjs = $("#order_text").val();
	var montojs = $("#order_amount").val();
	var monedajs = $("#moneda_category").val();	
	var Cedulajs = $("#username").val();
	var accionjs = "RegOrdPag";
	$.ajax(
	{
		url: '../controladores/EmitirOrdPagCtrl.php',
		type: "POST",
		data: {accionjs: accionjs, idcategoriajs:idcategoriajs, order_textjs:order_textjs, montojs:montojs, 
		Cedulajs:Cedulajs, monedajs:monedajs}
	}).done(function (data) {
		buscar_regresar();
		mensaje("Mensaje",1,data,"top-right");
	});		
}
function generar_ordpag_mov()
{
	var Cedulajs = $("#username").val();
	var accionjs = "id_conceptos_ant";
	$.ajax(
	{
		url: '../controladores/EmitirOrdPagCtrl.php',
		type: "POST",
		data: {accionjs: accionjs, Cedulajs:Cedulajs}
	}).done(function (data) {
		document.getElementById("id_conceptos_ant").innerHTML = data;		
	});		
}
function gen_categ()
{
	var product_categoryjs = $("#product_category").val();
	var accionjs = "gen_prod";
	$.ajax(
	{
		url: '../controladores/EmitirOrdPagCtrl.php',
		type: "POST",
		data: {accionjs: accionjs, product_categoryjs:product_categoryjs}
	}).done(function (data) {
		document.getElementById("listaEmit").innerHTML = data;		
	});	
}
function cambioprod(){
        $('#dateSelect .input-daterange').datepicker({
            keyboardNavigation: false,
            forceParse:         false,
            autoclose:          true,
            format:             "dd/mm/yyyy",
            language:           "es",
            todayHighlight:     true,
        });
        $(document).on('blur change', '#product_amount', function () {
            $amount = parseFloat($(this).val());

            if (isNaN($amount) || $amount < 0) {
                $(this).val('1.00');
            } else {
                $(this).val(parseFloat($amount).toFixed(2));
            }
        });
        $(document).on('blur change', '#product_units', function () {
            $units = parseInt($(this).val());

            if (isNaN($units) || $units < 1) {
				if ($("#OpAux").val() != "Cuadrar")	{$(this).val('1');} else
				if (isNaN($units))	{$(this).val('1');}
            } else {
                $(this).val(parseInt($units).toFixed(0));
            }
        });
        $('#frmSubmit').submit(function () {
            $('.btnSubmit').addClass('disabled loading');
        });
		$('#selectodos').click(function () {			
			var perm_lot = document.getElementsByName("permissions[]")
			for (var i = 0; i < perm_lot.length; i++) { 
				perm_lot[i].checked = $("#selectodos").prop("checked");
			}
		});
	
	$('.product_edit').change(function () {
		$_that   = $(this);
		$product = $_that.data();

		$('#id_product_name').val($product.id);
		$('#product_name').val($product.name);		
		$('.ui.dropdown').dropdown('set selected', $product.category).dropdown('refresh');
		$('#product_units').val(parseInt($product.units));
		$('#product_amount').val($product.amount);
		
		$('.ui.dropdown').dropdown('set selected', $product.moneda).dropdown('refresh');
		
		if ($product.inventory) {
			if (!$('#product_inventory').is(':checked')) {
				$('#product_inventory').click();
			}
		} else {
			if ($('#product_inventory').is(':checked')) {
				$('#product_inventory').click();
			}
		}

		if ($product.accountant) {
			$('#product_units').attr({'required': 'required', 'min': 1});

			if (!$('#product_accountant').is(':checked')) {
				$('#product_accountant').click();
			}
		} else {
			$('#product_units').removeAttr('required').attr('min', 0);

			if ($('#product_accountant').is(':checked')) {
				$('#product_accountant').click();
			}
		}

		$('.btnSubmit').removeClass('disabled');
	});
	$('.product_editcrear').change(function () {
		$_that   = $(this);
		$product = $_that.data();
		$('#id_hotel').val($product.id);
		$('#id_hotelCant').val($product.cant);

		$('.btnSubmit').removeClass('disabled');
	});
	$('.product_editcuadr').change(function () {
		$_that   = $(this);
		$product = $_that.data();

		$('#product_name').val($product.name);
		$('#product_units_exist').val(parseInt($product.units));
		$('#product_units').val(1);

		$('.btnSubmit').removeClass('disabled');
	});
        $('.career_edit').change(function () {
            $_that   = $(this);
            $career = $_that.data();
			$('#id_carrera').val($career.id);
            $('#career_name').val($career.name);
            $('.ui.dropdown').dropdown('set selected', $career.coordination).dropdown('refresh');

            if ($('#career_delete').is(':checked')) {
                $('#career_delete').click();
            }

            $('.btnSubmit').removeClass('disabled');
        });
        $('.category_edit').change(function () {
            $_that   = $(this);
            $category = $_that.data();
            $('#id_category').val($category.id);			
            $('#category_name').val($category.name);
            $('#category_color').val($category.color);

            if ($category.status) {
                if (!$('#category_status').is(':checked')) {
                    $('#category_status').click();
                }
            } else {
                if ($('#category_status').is(':checked')) {
                    $('#category_status').click();
                }
            }

            $('.btnSubmit').removeClass('disabled');
        });
        $('.coordination_edit').change(function () {
            $_that   = $(this);
            $coordination = $_that.data();

            $('#coordination_name').val($coordination.name);
            $('#id_coordination').val($coordination.id);

            if ($('#coordination_delete').is(':checked')) {
                $('#coordination_delete').click();
            }

            $('.btnSubmit').removeClass('disabled');
        });
        $('.moneda_edit').change(function () {
            $_that   = $(this);
            $moneda = $_that.data();			
            $('#moneda_id_val').val($moneda.id);
            $('#moneda_name').val($moneda.name);
            $('#monedas_name').val($moneda.names);
            $('#moneda_simb').val($moneda.simb);
            $('#moneda_abrev').val($moneda.abr);
		});
        $('#iduser').change(function () {
            $_that   = $('.cuser_' + $(this).val());
            $coordination = $_that.data();
            $('#dni').val($coordination.dni);
            $('#name').val($coordination.nombre);
            $('#username').val($coordination.usuario);			
			$('.ui.dropdown').dropdown('set selected', $coordination.tipo).dropdown('refresh');
            $('#email').val($coordination.email);
			$(".btnSave").removeClass('disabled');			
        });
        $('#iduserBitcar').change(function () {
			var accionjs = "Busc_Bitcar_Fech";		
			var FechBit = $('#iduserBitcar').val();
			$.ajax(
			{
				url: '../controladores/AdministracionCtrl.php',
				type: "POST",
				data: {accionjs: accionjs, fechbitjs:FechBit}
			}).done(function (data) {
				document.getElementById("Pag_Rep_Bitac").innerHTML = data;
			});
			
		});
        $('#iduserCoor').change(function () {
            $_that   = $('.cuser_' + $(this).val());
            $coordination = $_that.data();
            var userjs = $("#iduserCoor").val();
			var accionjs = "mod_permission";			
			var paramjs = $("#idaccion").val();
			var perm_lot = document.getElementsByName("permissions[]")
			for (var i = 0; i < perm_lot.length; i++) { 
				var permjs = perm_lot[i].value;
				$.ajax(
				{
					url: '../controladores/AdministracionCtrl.php',
					type: "POST",
					data: {accionjs: accionjs, userjs:userjs, permjs:permjs, paramjs:paramjs}
				}).done(function (data) {
					var objetoem = JSON.parse(data);
					var valor = objetoem.Valid;					
					var perm = objetoem.Permiso;					
					if (valor == "0") {
							document.getElementById("permission_"+perm).checked = false;
						}else {
							document.getElementById("permission_"+perm).checked = true;
						}						
				});					
			}				
			$(".btnSave").removeClass('disabled');			
        });		
}
function buscar_persona()
{
	accionjs = "buscar_personas";
	var dnijs = $("#dni").val();
    if (valid(dnijs,"*","*","*","*","*","*","*","*","*","*","*","*","*","*") == false)
	{
		$.ajax(
		{
			url: '../controladores/AdministracionCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, dnijs: dnijs}
		}).done(function (data) {
			if (data == "") {mensaje("Mensaje",2,"Persona No existe","top-right");} else
			{
				$("#consulta_cedula").fadeOut(200);
				document.getElementById("datos_consulta_cedula").innerHTML = data;
				$("#datos_consulta_cedula").fadeIn(1000);
				$('.ui.dropdown').dropdown();
				cambioprod();
				modulopersonas();
			}
		});		
	}	
}

function buscar_alumnos_lote()
{
	accionjs = "buscar_personas_lote";
	var carrerajs = $("#order_career").val();
	var semestrejs = $("#order_half").val();
	var orderbyjs = $("#order_type").val();	
	$.ajax(
	{
		url: '../controladores/AdministracionCtrl.php',
		type: "POST",
		data: {accionjs: accionjs, carrerajs:carrerajs, semestrejs:semestrejs, orderbyjs:orderbyjs}
	}).done(function (data) {
		if (data == "") {mensaje("Mensaje",2,"Persona No existe","top-right");} else
		{
			document.getElementById("tabla_lot_estudiante").innerHTML = data;
			$(".btnSaveStudent").removeClass("disabled");
			$(".btnBackStudent").removeClass("disabled");
		}
	});		
}
function selec_todos_perslot()
{
    var ced_lot = document.getElementsByName("dni[]")
    for (var i = 0; i < ced_lot.length; i++) { 
		ced_lot[i].checked = $("#order_all").prop("checked");
    }
}

function act_cambiocheck(nombchk,nomcmb)
{
	if ($("#"+nombchk).prop('checked'))
	{
		$("."+nomcmb).removeClass("disabled");
	}	 else
	{
		$("."+nomcmb).addClass("disabled");
	}
}

function rea_cambios()
{
	accionjs = "modificar_personas_lote";
    var ced_lot = document.getElementsByName("dni[]");
	var jscambcarr = "";
	if ($("#change_career_check").prop('checked'))
	{
		var jscambcarr = $("#change_career").val();		
	}
	var jscambsem = "";
	if ($("#change_half_check").prop('checked'))
	{
		var jscambsem = $("#change_half").val();		
	}
	var jscambsit = "";
	if ($("#change_type_check").prop('checked'))
	{
		var jscambsit = $("#change_type").val();		
	}
	var val_limit = ced_lot.length - 1;
    for (var i = 0; i < ced_lot.length; i++) { 
		if (ced_lot[i].checked)
		{
			var jscedula = ced_lot[i].value;
			$.ajax(
			{
				url: '../controladores/AdministracionCtrl.php',
				type: "POST",
				data: {accionjs: accionjs, jscedula:jscedula, jscambcarr:jscambcarr, jscambsem:jscambsem, jscambsit:jscambsit}
			}).done(function (data) {				
			if (data != ""){
				mensaje("Mensaje",3,"Hubo errores en el proceso de carga: " + data,"top-right");
			}
			});
		}//if
		if (i == val_limit) {
			mensaje("Mensaje",1,"Registros Actualizados","top-right");
		}
    }
}
function modulopersonas()
{
	$(function () {
		$.extend($.fn.autoNumeric.defaults, {
			aSep: '',
			aDec: '.'
		});
		$('.money_format').autoNumeric('init');

		$('.username').focus();
		var $frmUsername = $('.frmUsername');
		$frmUsername.form({
			on:     'blur',
			inline: true,
			fields: {
				username: {
					identifier: 'username',
					rules:      [{
						type:   'empty',
						prompt: 'Por favor, introduzca una Cédula'
					}]
				}
			}
		}).form('is valid');

		$frmUsername.submit(function () {
			if ($frmUsername.form('is valid')) {
				$('.btnUsername').addClass('loading disabled');
			}
		});
	});	
	$('.dateSelect').datepicker({
		keyboardNavigation: false,
		forceParse:         false,
		autoclose:          true,
		format:             "dd/mm/yyyy",
		language:           "es",
		todayHighlight:     true,
	});

	$('#frmSubmit').submit(function () {
		$('.btnSave').addClass('disabled loading');
	});

	$('#dateSelect .input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse:         false,
		autoclose:          true,
		format:             "dd/mm/yyyy",
		language:           "es",
		todayHighlight:     true,
		endDate:            'now'
	});

	$('#order_all').click(function () {
		if ($(this).hasClass('checked')) {
			$('.category_check.checked').click();
			$(this).removeClass('checked');
			$(this).addClass('unchecked');
		} else {
			$('.category_check.unchecked').click();
			$(this).removeClass('unchecked');
			$(this).addClass('checked');
		}
	});

	$('.category_check').click(function () {
		if ($(this).hasClass('checked')) {
			$(this).removeClass('checked');
			$(this).addClass('unchecked');
		} else {
			$(this).removeClass('unchecked');
			$(this).addClass('checked');
		}
	});

	$('.ui.positive').click(function () {
		if ($('.category_check:checked').length !== 0 && $('.payment_check:checked').length !== 0) {
			return true;
		} else {
			$(this).removeClass('disabled loading');

			return false;
		}
	});			
}
function emision_ordpag()
{
        $(function () {
            var $form = $('.ui.form');

            $form.form({
                on:     'blur',
                inline: true,
                fields: {
                    category: {
                        identifier: 'category',
                        rules:      [{
                            type:   'empty',
                            prompt: 'Por favor, seleccione una categoría'
                        }]
                    },
                    text:     {
                        identifier: 'text',
                        rules:      [{
                            type:   'empty',
                            prompt: 'Por favor, introduzca un texto para la orden'
                        }, {
                            type:   'length[4]',
                            prompt: 'El texto de la orden debe tener al menos 4 caracteres'
                        }]
                    },
                    amount:   {
                        identifier: 'amount',
                        rules:      [{
                            type:   'empty',
                            prompt: 'Por favor, introduzca un monto válido'
                        }, {
                            type:   'length[4]',
                            prompt: 'el monto a cobrar debe tener al menos 4 cifras'
                        }]
                    }
                }
            }).form('is valid');

            $('.btnOrderCheck').click(function () {
                if ($form.form('is valid')) {
                    swal({
                        title:              "¿Está seguro que desea continuar?",
                        text:               "Has eligido generar una orden de pago con:\n\n" +
                                            "Concepto: " + $('#order_text').val() + "\n" +
                                            "Monto: " + $('#order_amount').val() + " " + $('#moneda_category').val(),
                        type:               "warning",
                        showCancelButton:   true,
                        confirmButtonColor: "#16ab39",
                        confirmButtonText:  "Continuar",
                        cancelButtonText:   "Cancelar"
                    }, function () {
                        $('.valCategory').val($('#order_category').val());
                        $('.valText').val($('#order_text').val());
                        $('.valAmount').val($('#order_amount').val());

                        $('.show_order').hide();
                        $('.show_pending').show();
                    });
                }
            });

            $('.btnBack').click(function () {
                $('.show_order').show();
                $('.show_pending').hide();
            });

            $(document).on('blur change', '#order_amount', function () {
                $amount = parseFloat($(this).val());

                if (isNaN($amount) || $amount < 0) {
                    $(this).val('1.00');
                } else {
                    $(this).val(parseFloat($amount).toFixed(2));
                }
            });

            $('#order_text').on('change keydown keyup', function() {
                $(this).val($(this).val().toUpperCase());
            });
        });	
}

function oncl_reg_pag(val_emi_pag)
{
	var accionjs = val_emi_pag;
	var ord_lot = $(".cart_order");
	var Cedula = $("#dni").val();
	for (var i = 0; i < ord_lot.length; i++) { 		
		if (ord_lot[i].checked)
		{
			var id_emi_pagjs = ord_lot[i].value;
			$_that    = $("#tr_"+id_emi_pagjs);
			fechajs = $_that.data('date');
			monedajs = $_that.data('moneda');
			montojs = $("#order_amount_"+id_emi_pagjs).val();
			tipopagojs = $("#order_type_"+id_emi_pagjs).val();		
			facturajs = "";
			tarj_nlotjs = $("#tarj_nlot_"+id_emi_pagjs).val();
			tarj_nautjs = $("#tarj_naut_"+id_emi_pagjs).val();
			vau_ndepjs  = $("#vau_ndep_" +id_emi_pagjs).val();
			vau_nfechjs = $("#vau_nfech_"+id_emi_pagjs).val();
			exo_ncheqjs = $("#exo_ncheq_"+id_emi_pagjs).val();	
			var pag_enl = 'PrincipalCtrl';
			if (val_emi_pag == 'emi_reg_pag_valid'){ var pag_enl = 'EmitirOrdPagCtrl';}
			$.ajax(
			{
				url: '../controladores/'+pag_enl+'.php',
				type: "POST",
				data: {accionjs: accionjs, id_emi_pagjs:id_emi_pagjs, fechajs:fechajs, montojs:montojs, 
				tipopagojs:tipopagojs, facturajs:facturajs, tarj_nlotjs:tarj_nlotjs, tarj_nautjs:tarj_nautjs, 
				vau_ndepjs:vau_ndepjs, vau_nfechjs:vau_nfechjs, exo_ncheqjs:exo_ncheqjs, monedajs:monedajs}
			}).done(function (data) {				
				if (data != ""){
					mensaje("Mensaje",3,"Hubo errores en el proceso de carga: " + data,"top-right");
				}
			});				
		}//if
	}//for
	if (val_emi_pag != "emi_reg_pag_valid"){
		reporteemi(Cedula);		
	}
	var valid_esp = "";
	if (val_emi_pag == "emi_reg_pag_est"){
		var valid_esp = ", pendiente para su validación";
	}	
	mensaje("Mensaje",1,"Registros Cargados" + valid_esp,"top-right");					
}

function cargar_mov()
{
	accionjs = "regajusprec";
	var movimiento = $("#order_mov").val();
	var moneda = $("#moneda_category").val();
	var monto = $("#order_amount").val();
    if (valid(movimiento,moneda,monto,"*","*","*","*","*","*","*","*","*","*","*","*") == false)
	{
		$(".btnCargarAjusPre").addClass("loading");
		$.ajax(
		{
			url: '../controladores/EmitirOrdPagCtrl.php',
			type: "POST",
			data: {accionjs: accionjs, movimientojs:movimiento, monedajs:moneda, montojs:monto}
		}).done(function (data) {
			mensaje("Mensaje",1,"Registros Cargados","top-right");
			window.setTimeout(function(){
				$(".btnCargarAjusPre").removeClass("loading");
				ir_principal("AjustPrec","EmitirOrdPag");
			}, 2000);
		});				
	}
	
}

function emision_ordpag_lote(){
        $(function () {
            var $form = $('.ui.form');

            $form.form({
                on:     'blur',
                inline: true,
                fields: {
                    category: {
                        identifier: 'category',
                        rules:      [{
                            type:   'empty',
                            prompt: 'Por favor, seleccione una categoría'
                        }]
                    },
                    text:     {
                        identifier: 'text',
                        rules:      [{
                            type:   'empty',
                            prompt: 'Por favor, introduzca un texto para la orden'
                        }, {
                            type:   'length[4]',
                            prompt: 'El texto de la orden debe tener al menos 4 caracteres'
                        }]
                    },
                    amount:   {
                        identifier: 'amount',
                        rules:      [{
                            type:   'empty',
                            prompt: 'Por favor, introduzca un monto válido'
                        }, {
                            type:   'length[4]',
                            prompt: 'el monto a cobrar debe tener al menos 4 cifras'
                        }]
                    },
                    career:   {
                        identifier: 'career',
                        rules:      [{
                            type:   'empty',
                            prompt: 'Por favor, seleccione una carrera'
                        }]
                    }
                }
            }).form('is valid');

            $('.btnOrderCheck').click(function () {				
                $_this = $(this);
                if ($form.form('is valid')) {
                    $_this.addClass('disabled loading');										
					var Carrerajs = $("#order_career").val();
					var Semestrejs = $("#order_half").val();
					var Orderjs = $("#order_type").val();
					var accionjs = "buscar_lote_alumn_emi";						
					$.ajax(
					{
						url: '../controladores/EmitirOrdPagCtrl.php',
						type: "POST",
						data: {accionjs: accionjs, Carrerajs:Carrerajs, Semestrejs:Semestrejs, Orderjs:Orderjs}
					}).done(function (data) {
						var valid = data;
						if (valid == 0) {
							mensaje("Mensaje",2,"No se encontraron alumnos para la carrera y el semestre seleccionados por favor intentelo nuevamente.","top-right");
                            $('.frmSelect').css({'pointer-events': '', 'height': '350px'});
							$_this.removeClass('disabled loading');
						}else {
							$(".btnSearchStudent").hide();														
							$(".show_student").removeClass('disabled');							
                            $('.frmSelect').css({'pointer-events': 'none', 'height': '190px'});
							document.getElementById("id_student_table").innerHTML = data;
							$(".show_student").fadeIn(1000);							
						}
					});						
					/*
                    $.get('../controladores/json', {career: $('#order_career').val(), half: $('#order_half').val(), order: $('#order_type').val()}, function ($json) {
                        $('.student_table').html('');

                        if ($json.length === 0) {
                            $('.btnSearchStudent').show();
                            $('.frmSelect').css({'pointer-events': '', 'height': '350px'});
                            $('.show_student').hide();
                            swal({
                                title: '',
                                text:  "No se encontraron alumnos para la carrera y el semestre seleccionados por favor intentelo nuevamente.",
                                type:  "error",
                                timer: 2000
                            });
                        } else {
                            $('.btnSearchStudent').hide();
                            $('.frmSelect').css({'pointer-events': 'none', 'height': '190px'});

                            $.each($json, function ($index, $item) {
                                $('.student_table').append(($.templates("#tplStudent")).render($item));
                            });
                            $('.show_student').show();
                        }
                        $_this.removeClass('disabled loading');
                    });
				*/
                }
            });

            $('.btnBack').click(function () {
                $('.show_order').show();
                $('.show_pending').hide();
            });

            $('.btnSaveStudent').click(function () {				
                $_this = $(this);
                swal({
                    title:              "¿Está seguro que desea continuar?",
                    text:               "Has eligido generar una orden de pago con:\n\n" +
                                        "Concepto: " + $('#order_text').val() + "\n" +
                                        "Monto: " + $('#order_amount').val() + " " + $('#moneda_category').val(),
                    type:               "warning",
                    showCancelButton:   true,
                    confirmButtonColor: "#16ab39",
                    confirmButtonText:  "Continuar",
                    cancelButtonText:   "Cancelar"
                }, function () {
                    $_this.addClass('disabled loading');
					var ced_lot = document.getElementsByName("dni[]");
					var idcategoriajs = $("#order_category").val();
					var order_textjs = $("#order_text").val();
					var monedajs = $("#moneda_category").val();
					var montojs = $("#order_amount").val();
					var val_limit = ced_lot.length - 1;
					var seleccionado = 0;
					for (var i = 0; i < ced_lot.length; i++) { 
						if (ced_lot[i].checked) var seleccionado = 1;					
					}
					if (seleccionado == 1) {						
						var carrera = $("#order_career").val();
						var semestre = $("#order_half").val();
						accionjs = "RegMovPag";
						$.ajax(
						{
							url: '../controladores/EmitirOrdPagCtrl.php',
							type: "POST",								
							data: {accionjs: accionjs, idcategoriajs:idcategoriajs, 
							order_textjs:order_textjs, montojs:montojs, monedajs:monedajs,
							carrerajs:carrera,semestrejs:semestre}
						}).done(function (data) { 
							var mov_pago = data;
							accionjs = "RegOrdPag";
							for (var i = 0; i < ced_lot.length; i++) { 
								if (ced_lot[i].checked)
								{
									var Cedulajs = ced_lot[i].value;
									$.ajax(
									{
										url: '../controladores/EmitirOrdPagCtrl.php',
										type: "POST",								
										data: {accionjs: accionjs, Cedulajs:Cedulajs, idcategoriajs:idcategoriajs, 
										order_textjs:order_textjs, montojs:montojs, monedajs:monedajs, mov_pagojs:mov_pago}
									}).done(function (data) {
									});
								}//if
								if (i == val_limit) {
									mensaje("Mensaje",1,"Registros Cargados","top-right");
									window.setTimeout(function(){
										window.location.href = '../vista/';								
									}, 2600);							
								}//if
							}//for		
						});
					} else {
								mensaje("Mensaje",2,"Seleccione al menos un Estudiante","top-right");
								$_this.removeClass('disabled loading');
							}
                });
            });

            $(document).on('click', '.btnBackStudent', function () {
                $('.student_table').html('');
                $('.btnSearchStudent').show();
                $('.frmSelect').css({'pointer-events': '', 'height': '350px'});
                $('.show_student').hide();
				$('.btnOrderCheck ').removeClass('disabled loading');								
            });

            $(document).on('blur change', '#order_amount', function () {
                $amount = parseFloat($(this).val());

                if (isNaN($amount) || $amount < 0) {
                    $(this).val('1.00');
                } else {
                    $(this).val(parseFloat($amount).toFixed(2));
                }
            });

            $('#order_text').on('change keydown keyup', function() {
                $(this).val($(this).val().toUpperCase());
            });

            $('#order_all').click(function () {
                if ($(this).hasClass('checked')) {
                    $('.person_check.checked').click();
                    $(this).removeClass('checked');
                    $(this).addClass('unchecked');
                } else {
					
                    $('.person_check.unchecked').click();
                    $(this).removeClass('unchecked');
                    $(this).addClass('checked');
                }
            });

            $(document).on('click', '.person_check', function () {
                if ($(this).hasClass('checked')) {
                    $(this).removeClass('checked');
                    $(this).addClass('unchecked');
                } else {
                    $(this).removeClass('unchecked');
                    $(this).addClass('checked');
                }
            });
        });	
}
function solonumeros(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "0123456789";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

	function sum_total() {
		var $sum_amount = 0.00;
		$.each($('.cart_order_amount.sum_total:visible'), function () {
			$sum_amount = ($sum_amount + parseFloat($(this).val()));
		});
		
		$('#total_amount').text(formatNumber($sum_amount));
//		$('#total_amount').text(parseFloat($sum_amount).toFixed(2));
	}

	function sum_total_visible() {
		var $sum_amount = 0.00;
		$.each($('.cart_order_amount:visible'), function () {
			$sum_amount = ($sum_amount + parseFloat($(this).val()));
		});
		$('#total_amount').text(formatNumber($sum_amount));
		$('#order_all').click();
	}

function formatNumber(num) {
    if (!num || num == 'NaN') return '-';
    if (num == 'Infinity') return '&#x221e;';
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3) ; i++)
        num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num + ',' + cents);
}

	function selec_todos_regprinc()
	{
		var ord_lot = $(".cart_order")
		for (var i = 0; i < ord_lot.length; i++) { 		
			if (ord_lot[i].checked != $("#order_all").prop("checked"))
			{$('#order_check_'+ord_lot[i].value).click();}
		}
	}
	
	function onvalidpago()
	{
		$_this = $(".btnOrder");
		if ($(".cart_order:checked").length === 0) {
			swal({
				title:             '¡Vaya! ¡Algo salió mal!',
				text:              "Para poder registrar un pago debe seleccionarlo.",
				type:              "error",
				confirmButtonText: "Continuar"
			});
		} else {
			var $error = false;
			$.each($('.type_num:visible'), function () {
				if (!$(this).val()) {
					$error = true;
					$(this).focus();
				}
			});

			if ($error) {
				swal({
					title:             '¡Vaya! ¡Algo salió mal!',
					text:              "Para poder registrar un pago debe rellenar todos los campos requeridos.",
					type:              "error",
					confirmButtonText: "Continuar"
				});
			} else {
				swal({
					title:              '',
					text:               "¿Está seguro que desea continuar?",
					type:               "warning",
					showCancelButton:   true,
					confirmButtonColor: "#16ab39",
					confirmButtonText:  "Continuar",
					cancelButtonText:   "Cancelar"
				}, function () {
					$_this.addClass('disabled loading');
					rpago = $("#regpago").val();						
					oncl_reg_pag("emi_reg_pag_valid");
					var Accion = "cargar_valid_pag";
					$.ajax(
							{
								url: '../controladores/EmitirOrdPagCtrl.php',
								type: "POST",
								data: {accionjs: Accion}
							}).done(function (data) {
						document.getElementById("regpagmov").innerHTML = data;
					});		
				});
			}
		}
	}
	
	function principal_cal()
	{
		/*
        $('#order_all').click(function () {
			$('.cart_order:visible').click();
		});
		*/
        $(document).on('click', '.cart_order', function () {
            $_that    = $(this);
            $order_id = $_that.data('id');
            if ($_that.hasClass('checked')) {
                $_that.removeClass('checked');

                $('#order_amount_' + $order_id).removeClass('sum_total');

                $('#type_' + $order_id).addClass('disabled');
                $('#order_' + $order_id + ', #order_amount_' + $order_id + ', #order_type_' + $order_id).attr('disabled', 'disabled');
            } else {
                $_that.addClass('checked');
                $('#order_amount_' + $order_id).addClass('sum_total');

                $('#type_' + $order_id).removeClass('disabled');
                $('#order_' + $order_id + ', #order_amount_' + $order_id + ', #order_type_' + $order_id).removeAttr('disabled');
            }

            sum_total();
        });

        $(document).on('blur change', '.cart_order_amount', function () {
            $amount = parseFloat($(this).val());

            if (isNaN($amount) || $amount < 1.00) {
                $(this).val($(this).attr('max'));
            } else if ($amount > $(this).attr('max')) {
                $(this).val($(this).attr('max'));
            } else {
                $(this).val(parseFloat($amount).toFixed(2));
            }

            sum_total();
        });

        $(document).on('click', '.btnOrder', function () {
            $_this = $(this);
            if ($(".cart_order:checked").length === 0) {
                swal({
                    title:             '¡Vaya! ¡Algo salió mal!',
                    text:              "Para poder registrar un pago debe seleccionarlo.",
                    type:              "error",
                    confirmButtonText: "Continuar"
                });
            } else {
                var $error = false;
                $.each($('.type_num:visible'), function () {
                    if (!$(this).val()) {
                        $error = true;
                        $(this).focus();
                    }
                });

                if ($error) {
                    swal({
                        title:             '¡Vaya! ¡Algo salió mal!',
                        text:              "Para poder registrar un pago debe rellenar todos los campos requeridos.",
                        type:              "error",
                        confirmButtonText: "Continuar"
                    });
                } else {
                    swal({
                        title:              '',
                        text:               "¿Está seguro que desea continuar?",
                        type:               "warning",
                        showCancelButton:   true,
                        confirmButtonColor: "#16ab39",
                        confirmButtonText:  "Continuar",
                        cancelButtonText:   "Cancelar"
                    }, function () {
                        $_this.addClass('disabled loading');
						rpago = $("#regpago").val();						
						if (rpago == "Estudiante"){
							oncl_reg_pag("emi_reg_pag_est");
							window.setTimeout(function(){
								document.getElementById("regpagmov").innerHTML = "Cargando...";
								var Accion = "cargarregpr";
								var Cedula = $("#dni").val();
								$.ajax(
										{
											url: '../controladores/PrincipalCtrl.php',
											type: "POST",
											data: {accionjs: Accion,Cedulajs:Cedula}
										}).done(function (data) {
									document.getElementById("regpagmov").innerHTML = data;
									$_this.removeClass('disabled loading');
								});		
							}, 1000);
						}else {
							oncl_reg_pag("emi_reg_pag");							
						}

                    });
                }
            }
        });

        $(document).on("contextmenu", function (e) {
            $('.cm_null, .cm_detail').hide();
            $(".contextmenu").css({'display': 'block', 'left': (parseInt(e.pageX) - 20), 'top': (parseInt(e.pageY) - 85), 'position': 'absolute', 'z-index': '100000'});
            return false;
        });

        $(document).on("contextmenu", ".contextmenu_detail", function (e) {
            $_this = $(this);

            $('.cm_null, .cm_detail').show();
            $('.cm_assign').text($_this.data('assign'));
            $('.cm_date').text($_this.data('date'));
            $('.cm_unit').text($_this.data('unit'));
            $('.cm_unitamount').text($_this.data('unitamount'));
            $('.cm_concept').data('id', $_this.data('id')).data('concept', $_this.data('concept')).html('(' + $_this.data('id') + ') <strong style="color: #000000;">' + $_this.data('concept') + '</strong>');

            $(".contextmenu").css({'display': 'block', 'left': (parseInt(e.pageX) - 20), 'top': (parseInt(e.pageY) - 85), 'position': 'absolute', 'z-index': '100000'});

            return false;
        });

        $(document).click(function (e) {
            $(".contextmenu").hide();
        });

        $('.cm_concept').click(function () {
            $_this = $(this).data();

            swal({
                title:               'Va a eliminar la orden de pago',
                text:                '<strong>(' + $_this.id + ') ' + $_this.concept + '</strong><br><br>Esto implica que se generará una orden de pago igual pero con monto negativo y se emitirá un recibo con esas dos órdenes de pago.<br>Si desea imprimirla puede acudir a reimpresión de recibos de pagos.',
                type:                "warning",
                showCancelButton:    true,
                closeOnConfirm:      false,
                showLoaderOnConfirm: true,
                confirmButtonText:   "Continuar",
                cancelButtonText:    "Cancelar",
                html:                true
            }, function () {
                $.ajax({
                    url:     'https://sisca.luissuarez.dev/payment/pending/null',
                    data:    {emission_id: $_this.id},
                    type:    'POST',
                    success: function ($data) {
                        if ($data.payment_id !== 'null') {
                            $('#tr_' + $_this.id).remove();

                            swal({
                                text:  'Si desea imprimirla puede acudir a reimpresión de pagos.<br> Recibo N°: <a href="' + $data.payment_url + '" style="color: #f89406 !important; cursor: pointer !important;">' + $data.payment_id + '</a>',
                                type:  'success',
                                title: 'Orden de pago anulada',
                                html:  true
                            });
                        }
                    }
                });

                return true;
            });
        });

        $(document).on('change', '.cart_order_type', function () {
            $_that    = $(this);
            $order_id = $_that.data('id');

            $('.div_card_' + $order_id + ', .div_transfer_' + $order_id + ', .div_free_' + $order_id).attr('disabled', 'disabled').hide();

            if ($_that.val() === 'Tarjeta') {
                $('.div_card_' + $order_id).removeAttr('disabled').show();
            } else if ($_that.val() === 'Vaucher') {
                $('.div_transfer_' + $order_id).removeAttr('disabled').show();
            } else if ($_that.val() === 'Exoneración') {
                $('.div_free_' + $order_id).removeAttr('disabled').show();
            }
        });

        var $type_num_card = '';
        $(document).on('keydown keyup', '.type_num_card', function () {
            $type_num_card = $(this).val();
            $('.type_num_card').val($type_num_card);
        });
        var $type_num_card_o = '';
        $(document).on('keydown keyup', '.type_num_card_o', function () {
            $type_num_card_o = $(this).val();
            $('.type_num_card_o').val($type_num_card_o);
        });

        var $type_num_transfer = '';
        $(document).on('keydown keyup', '.type_num_transfer', function () {
            $type_num_transfer = $(this).val();
            $('.type_num_transfer').val($type_num_transfer);
        });
        var $type_num_transfer_o = '';
        $(document).on('change', '.type_num_transfer_o', function () {
            $type_num_transfer_o = $(this).val();
            $('.type_num_transfer_o').val($type_num_transfer_o);
        });

        var $type_num_free = '';
        $(document).on('keydown keyup', '.type_num_free', function () {
            $type_num_free = $(this).val();
            $('.type_num_free').val($type_num_free);
        });

        $(document).on('click', '.filter_item', function () {
            $_that  = $(this);
            $filter = $_that.data('filter');

            $('.cart_order').each(function () {
                if ($(this).hasClass('checked')) {
                    $(this).click();
                }
            });

            $('.filter_all').hide();
            $('.filter_' + $filter).show();

            sum_total_visible();
        });
        sum_total_visible();
	}
	
function reporteemi(Cedula)
{
	var accionjs = "cargar_rec_pag";
	$.ajax(
			{
				url: '../controladores/PrincipalCtrl.php',
				type: "POST",
				data: {accionjs: accionjs, cedulajs: Cedula}
			}).done(function (data) {
		$("#wrapper").hide();
		document.getElementById("wrapper").innerHTML = data;
		$("#wrapper").fadeIn(2000);
		$(function () {
			$('.btnPrint').click(function () {
				$('.no-print').hide();
				window.print();
				swal({
					title: '',
					text:  "Imprimiendo clave para la reinscripción.\nPulse OK para continuar",
					type:  "info",
					timer: 2000
				});

				$('.no-print').show();
			});
		});
		$(document).on("contextmenu", function (e) {

			return false;
		});		
	});		
}	
function ir_principal(Param1,Param2)
{
	location.href = "?Param1="+Param1+"&Param2="+Param2;
}
	
	