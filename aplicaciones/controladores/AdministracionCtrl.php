<?php
session_start();
require_once "../modelos/Conexion.php";
require_once "../modelos/AdministracionDAO.php";
	$OpAccion = $_POST["accionjs"];

	if ($OpAccion == "CrearHoteles")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
<div class="container-fluid">
                        <br>
					<input type="hidden" name="OpAux" id="OpAux" value="Unidad">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="row show_order">
        <div class="col-md-offset-1 col-md-9 col-xs-offset-1 col-xs-9">
            <div class="white-box" style="padding: 0;">
                <form id="frmSubmit" method="post">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">Hoteles</th>
                                    <th style="text-align: center; vertical-align: middle; width: 350px;">AGREGAR HOTELES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <ul id="IdTabHotel" class="list-group list-group-full" style="height: 315px; overflow-y: scroll;">
										<?php
										$listProd = $AdministracionDAO->GetHoteles();
										foreach ($listProd as $value) {
											if ($value[7] == 0){$ValBool= "false";} else {$ValBool= "true";}										
											$CantVal = $value[5];
											if ($value[5] == "") {$CantVal = 0;}
											if ($CantVal == 0) {$ValBoolCant = "false";} else {$ValBoolCant = "true";}
											if ($CantVal <> 0)
											{
											?>
											<li class="list-group-item" style="border-left: 5px solid <?php echo $value[3];?>; padding: 5px 15px;">
												<div class="" style="margin: 0;">
													<label for="product_<?php echo $value[0];?>" id="product_label_<?php echo $value[0];?>"><?php echo $value[1];?></label>
												</div>
												<div style="float: right; margin-top: -18px;">
														<?php echo $value[3];?>
												</div>
											</li>
											<?php
											}//if
										}//for
										?>
										</ul>
                                    </td>
                                    <td class="ui form">
                                        <div class="field">
                                            <label>NOMBRE:</label>
                                            <input type="hidden" name="id_hotel" id="id_hotel">
                                            <input type="text" name="hotel_name" id="hotel_name" required="" autocomplete="off">
                                        </div>

                                        <div class="field" id="show_product_units">
                                            <label>DIRECCION</label>
                                            <input type="text" name="hotel_direccion" id="hotel_direccion" value="" min="0" required data-mask="###0" data-mask-reverse="true" autocomplete="off">
                                        </div>

                                        <div class="field" id="show_product_units">
                                            <label>CIUDAD</label>
                                            <input type="text" name="hotel_ciudad" id="hotel_ciudad" value="" min="1" required data-mask="###0" data-mask-reverse="true" autocomplete="off">
                                        </div>

                                        <div class="field" id="show_product_units">
                                            <label>NIT</label>
                                            <input type="text" name="hotel_nit" id="hotel_nit" value="" min="1" required data-mask="###0" data-mask-reverse="true" autocomplete="off">
                                        </div>

                                        <div class="field" id="show_product_units">
                                            <label>NUMERO DE HABITACIONES</label>
                                            <input type="text" name="hotel_numhab" id="hotel_numhab" value="" min="1" required data-mask="###0" data-mask-reverse="true" autocomplete="off" onkeypress="return solonumeros(event)">
                                        </div>


                                        <div style="text-align: center; margin-top: 20px;">
                                            <button type="button" class="ui positive button btnSubmit" onclick="creahotel()">REGISTRAR</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                                    </div>
<?php
	}	

	if ($OpAccion == "CrearHotelTbl")
	{
		$AdministracionDAO = new AdministracionDAO();
		$hotel_name = $_POST["hotel_namejs"];
		$hotel_direccion = $_POST["hotel_direccionjs"];
		$hotel_ciudad = $_POST["hotel_ciudadjs"];		
		$hotel_nit = $_POST["hotel_nitjs"];		
		$hotel_numhab = $_POST["hotel_numhabjs"];		
		$HotMaxVal = $AdministracionDAO -> MaxValor("Id_Hotel","tbl_Hoteles");
		$IdHot = 0;
		foreach ($HotMaxVal as $value) {$IdHot = $value[0] + 1;}		
		if (Getvaltabl("Nombre","tbl_Hoteles",$Nombre))
		{
			echo "No se puede Crear, el nombre del Hotel es repetido";						
		}else
		{
		 $matriz = array($IdHot, $hotel_name, $hotel_direccion, $hotel_ciudad, $hotel_nit, $hotel_numhab);	
		 $AgrProd = $AdministracionDAO -> Crear_Registro("tbl_Hoteles",$matriz);
		 echo "Registro Agregado";
		}				

	}

	if ($OpAccion == "CargarHotelAgr")
	{
		$AdministracionDAO = new AdministracionDAO();
		$listProd = $AdministracionDAO->GetHoteles();
		foreach ($listProd as $value) {
			if ($value[7] == 0){$ValBool= "false";} else {$ValBool= "true";}										
			$CantVal = $value[5];
			if ($value[5] == "") {$CantVal = 0;}
			if ($CantVal == 0) {$ValBoolCant = "false";} else {$ValBoolCant = "true";}
			if ($CantVal <> 0)
			{
			?>
				<li class="list-group-item" style="border-left: 5px solid <?php echo $value[3];?>; padding: 5px 15px;">
					<div class="" style="margin: 0;">
						<label for="product_<?php echo $value[0];?>" id="product_label_<?php echo $value[0];?>"><?php echo $value[1];?></label>
					</div>
					<div style="float: right; margin-top: -18px;">
							<?php echo $value[3];?>
					</div>
				</li>
			<?php
			}//if
		}//for
	}

	if ($OpAccion == "CrearHabit")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
<div class="container-fluid">
                        <br>
					<input type="hidden" name="OpAux" id="OpAux" value="Unidad">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="row show_order">
        <div class="col-md-offset-1 col-md-9 col-xs-offset-1 col-xs-9">
            <div class="white-box" style="padding: 0;">
                <form id="frmSubmit" method="post">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">Hoteles</th>
                                    <th style="text-align: center; vertical-align: middle; width: 350px;">AGREGAR HABITACIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <ul id="IdTabHotel" class="list-group list-group-full" style="height: 315px; overflow-y: scroll;">
										<?php
										$listProd = $AdministracionDAO->GetHoteles();
										foreach ($listProd as $value) {
											if ($value[7] == 0){$ValBool= "false";} else {$ValBool= "true";}										
											$CantVal = $value[5];
											if ($value[5] == "") {$CantVal = 0;}
											if ($CantVal == 0) {$ValBoolCant = "false";} else {$ValBoolCant = "true";}
											if ($CantVal <> 0)
											{
											?>
											<li class="list-group-item" style="border-left: 5px solid <?php echo $value[3];?>; padding: 5px 15px;">
												<div class="checkbox radio" style="margin: 0;">
													<input name="product_id" type="radio" value="<?php echo $value[0];?>" id="product_id" class="product_editcrear" data-id="<?php echo $value[0];?>" data-name="<?php echo $value[1];?>" data-cant="<?php echo $value[5];?>"/>
													<label for="product_<?php echo $value[0];?>" id="product_label_<?php echo $value[0];?>"><?php echo $value[1];?></label>
												</div>
												<div style="float: right; margin-top: -18px;">
														<?php echo $value[5];?>
												</div>
											</li>
											<?php
											}//if
										}//for
										?>
										</ul>
                                    </td>
                                    <td class="ui form">
                                        <div class="field">
                                            <label>CANTIDAD:</label>
                                            <input type="hidden" name="id_hotel" id="id_hotel">
                                            <input type="hidden" name="id_hotelCant" id="id_hotelCant">
                                            <input type="text" name="hotel_cant" id="hotel_cant" required="" autocomplete="off" onkeypress="return solonumeros(event)">
                                        </div>

                                        <div class="field" id="show_product_units">
                                            <label>TIPO HABITACION - ACOMODACION</label>
									<div class="ui fluid selection dropdown">
										<input type="hidden" name="product_category" id="product_category" required value="<?php echo $ValProd;?>">
										<i class="dropdown icon"></i>
										<div class="default text">Seleccionar una Opci&oacute;n</div>
										<div class="menu">
										<?php
										$listAdm = $AdministracionDAO->GetTipHabit();
										foreach ($listAdm as $value) {
										?>
											<div class="item" data-value="<?php echo $value[0];?>">
											<div class="ui red empty circular label" style="background-color: <?php echo $value[2];?> !important; border-color: #11ff00 !important;"></div>
												<?php echo $value[1];?>
											</div>										
										<?php
										}//for										
										?>
										</div>
									</div>											
                                        </div>

                                        <div style="text-align: center; margin-top: 20px;">
                                            <button type="button" class="ui positive button btnSubmit" onclick="creahabita()">REGISTRAR</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                                    </div>
<?php
	}	


	if ($OpAccion == "CrearHabitTbl")
	{
		$AdministracionDAO = new AdministracionDAO();
		$id_hotel = $_POST["id_hoteljs"];
		$hotel_cant = $_POST["hotel_cantjs"];		
		$product_category = $_POST["product_categoryjs"];		
		$id_hotelCant = $_POST["id_hotelCantjs"];		
		$HotMaxVal = $AdministracionDAO -> MaxValor("Id_Habitacion","tbl_Habitacion");
		$IdHot = 0;
		foreach ($HotMaxVal as $value) {$IdHot = $value[0] + 1;}		
		$listProd = $AdministracionDAO->GetTipHabitValid($id_hotel,$product_category);
		$Valid = "";
		foreach ($listProd as $value) {
			$Valid = $value[0];
		}
		
		$listProd = $AdministracionDAO->GetTipHabitSum($id_hotel);
		$Valid_Cant = 0;
		foreach ($listProd as $value) {
			$Valid_Cant = $value[0];
		}

		$cantidad_total = $hotel_cant + $Valid_Cant;
		if ($id_hotelCant < $cantidad_total)
		{
			echo "No se puede Crear, cantidad de habitaciones maxima no permitida";									
		} else 		
		if ($Valid <> "")
		{
			echo "No se puede Crear, el tipo de Habitacion es repetido";						
		}else
		{
		 $matriz = array($IdHot, $id_hotel, $hotel_cant, $product_category);	
		 $AgrProd = $AdministracionDAO -> Crear_Registro("tbl_Habitacion",$matriz);
		 echo "Registro Agregado";
		}				

	}








	


	
	
	
	if ($OpAccion == "CrearProductos")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>

<div class="container-fluid"><br>
			<div class="row">
				<div class="col-md-12">
					<div class="white-box">
						<div class="row">
								<div class="row show_order">
<div class="col-md-offset-1 col-md-9 col-xs-offset-1 col-xs-9">
	<div class="white-box" style="padding: 0;">
		<form id="frmSubmit" method="post">
			<div class="table-responsive">
				<table class="ui compact celled table">
					<thead>
						<tr>
							<th style="text-align: center; vertical-align: middle;">PRODUCTOS</th>
							<th style="text-align: center; vertical-align: middle; width: 350px;">CREAR UN PRODUCTO DEL INVENTARIO</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<ul class="list-group list-group-full" id="IdReporteProd">
								<?php
								$listProd = $AdministracionDAO->GetProductos();
								foreach ($listProd as $value) {
									?>
									<li class="list-group-item" style="border-left: 5px solid <?php echo $value[3];?>; padding: 5px 15px;">
										<?php echo $value[1];?>
										<div style="float: right;">
											<?php echo $value[8]." ".number_format($value[4],2,',','.');?>
										</div>
									</li>
									<?php
								}//for
								?>
								</ul>
							</td>
							<td class="ui form">
								<div class="field">
									<label>NOMBRE PRODUCTO</label>
									<input type="text" name="product_name" id="product_name" required="" autocomplete="off">
								</div>

								<div class="field">
									<?php
									$listValid = $AdministracionDAO->GetCategoria($_SESSION['usur']);
									$ContVal = 0;
									$ValProd = 0;
									foreach ($listValid as $value) {
										$ContVal = $ContVal + 1;
										if ($ContVal == 1) {
											$ValProd = $value[0];
										}//if
									}//for
									?>
									<label>CATEGORÍA</label>
									<div class="ui fluid selection dropdown">
										<input type="hidden" name="product_category" id="product_category" required value="<?php echo $ValProd;?>">
										<i class="dropdown icon"></i>
										<div class="default text">Seleccionar una categoría</div>
										<div class="menu">
										<?php
										$listAdm = $AdministracionDAO->GetCategoria($_SESSION['usur']);
										foreach ($listAdm as $value) {
										?>
											<div class="item" data-value="<?php echo $value[0];?>">
											<div class="ui red empty circular label" style="background-color: <?php echo $value[2];?> !important; border-color: #11ff00 !important;"></div>
												<?php echo $value[1];?>
											</div>										
										<?php
										}//for										
										?>
										</div>
									</div>
								</div>								
								<?php
									$listValid = $AdministracionDAO->Getmoneda();
									$ContVal = 0;
									$ValProd = 0;
									foreach ($listValid as $value) {
										$ContVal = $ContVal + 1;
										if ($ContVal == 1) {
											$ValProd = $value[4];
										}//if
									}//for
								?>
								<div class="field">
									<?php
									$listValid = $AdministracionDAO->Getmoneda();
									?>
									<label>MONEDA</label>
									<div class="ui fluid selection dropdown">
										<input type="hidden" name="moneda_category" id="moneda_category" required value="<?php echo $ValProd;?>">
										<i class="dropdown icon"></i>
										<div class="default text">Seleccionar una moneda</div>
										<div class="menu">
										<?php
										$listAdm = $AdministracionDAO->Getmoneda();
										foreach ($listAdm as $value) {
										?>
											<div class="item" data-value="<?php echo $value[4];?>">
											<div class="label" style="border-color: #11ff00 !important;"></div>
												<?php echo $value[1];?>
											</div>										
										<?php
										}//for										
										?>
										</div>
									</div>
								</div>
								<div class="checkbox" style="margin: 0;" onclick="($('#product_accountant').is(':checked') ? $('#show_product_units').show() : $('#show_product_units').hide())">
									<input name="product_accountant" type="checkbox" id="product_accountant" />
									<label for="product_accountant" id="product_accountant_label"> INVENTARIO DE UNIDADES</label>
								</div>
								<br>

								<div class="field" id="show_product_units" style="display: none;">
									<label>UNIDADES</label>
									<input type="text" name="product_units" id="product_units" required="" value="1" min="1" data-mask="###0" data-mask-reverse="true" autocomplete="off">
								</div>

								<div class="field">
									<label>PRECIO UNITARIO</label>
									<input type="text" name="product_amount" id="product_amount" required="" step="any" value="1.00" min="1.00" autocomplete="off" class="money_format">
								</div>

								<div class="checkbox" style="margin: 0;">
									<input name="product_inventory" type="checkbox" id="product_inventory" />
									<label for="product_inventory" id="product_inventory_label"> MOSTRAR EN EL INVENTARIO</label>
								</div>

								<div style="text-align: center; margin-top: 20px;">
									<button type="button" class="ui positive button btnSubmit" onclick="accionprod('1')">CREAR PRODUCTO</button>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</form>
	</div>
</div>
</div>
						</div>
					</div>
				</div>
			</div>

							</div>

		<?php
	}	
	if ($OpAccion == "CargarProductos")
	{
		$AdministracionDAO = new AdministracionDAO();
		$listProd = $AdministracionDAO->GetProductos();
		foreach ($listProd as $value) {
			?>
			<li class="list-group-item" style="border-left: 5px solid <?php echo $value[3];?>; padding: 5px 15px;">
				<?php echo $value[1];?>
				<div style="float: right;">
					<?php echo $value[8]." ".number_format($value[4],2,',','.');?>
				</div>
			</li>
			<?php
		}//for		
	}	
	if ($OpAccion == "AgregarProductos")
	{
		$AdministracionDAO = new AdministracionDAO();
		$Nombre = $_POST["Nombrejs"]; 
		$IdCat = $_POST["IdCatjs"];
		$Cantidad = $_POST["Cantidadjs"];
		$Precio = $_POST["Preciojs"];
		$ChInv = $_POST["ChInvjs"];
		$Moneda = $_POST["monedajs"];
		$ProdMaxVal = $AdministracionDAO -> MaxValor("Id_Productos","tbl_productos");		
		$IdProd = 0;
		foreach ($ProdMaxVal as $value) {$IdProd = $value[0];}
		if (Getvaltabl("Nombre","tbl_productos",$Nombre))
		{
			echo "No se puede Crear, el nombre del Producto es repetido";						
		}else
		{
			$matriz = array($IdProd, $Nombre, $IdCat, $Cantidad, $Moneda, $Precio, $ChInv);	
			$AgrProd = $AdministracionDAO -> Crear_Registro("tbl_productos",$matriz);
			echo "Producto Creado";			
			reg_bitac($_SESSION['usur'],"Inventario - Productos","Agregar Registro. $Nombre, Cantidad: $Cantidad, Moneda: $Moneda, Precio: $Precio, Mostrar Inventario: $ChInv");			
		}
	}
	if ($OpAccion == "ModificarProductos")
	{
		$AdministracionDAO = new AdministracionDAO();
		$IdProd = $_POST["IdProdjs"]; 
		$Nombre = $_POST["Nombrejs"]; 
		$IdCat = $_POST["IdCatjs"];
		$Cantidad = $_POST["Cantidadjs"];
		$Moneda = $_POST["monedajs"];
		$Precio = $_POST["Preciojs"];
		$ChInv = $_POST["ChInvjs"];
		$Inic_matriz = array("Id_Productos", "Nombre", "Id_Categoria", "Cantidad", "Moneda", "Precio", "ChInv");	
		$matriz = array($IdProd, $Nombre, $IdCat, $Cantidad, $Moneda, $Precio, $ChInv);	
		if ($_SESSION['NivPerm_6'] == "0") {
			$Inic_matriz = array("Id_Productos", "Nombre", "Id_Categoria", "Cantidad", "Moneda", "Precio");	
			$matriz = array($IdProd, $Nombre, $IdCat, $Cantidad, $Moneda, $Precio);				
		}
		$where = "where (Id_Productos = '$IdProd')";
		if ($_SESSION['NivPerm_26'] == "1") {
			$ModProd = $AdministracionDAO -> Modificar_Registro("tbl_productos",$Inic_matriz,$matriz,$where);
			echo "Producto Actualizado";
			reg_bitac($_SESSION['usur'],"Inventario - Productos","Modificar Registro. $Nombre, Cantidad: $Cantidad, Moneda: $Moneda, Precio: $Precio, Mostrar Inventario: $ChInv");		
		}else {
			echo "No se puede modificar, no tiene los permisos para hacerlo";
		}
	}
	if ($OpAccion == "CrearUnidadesTbl")
	{
		$AdministracionDAO = new AdministracionDAO();
		$IdProd = $_POST["IdProdjs"]; 
		$UnidCantidad = $_POST["UnidCantidadjs"];
		$Cantidad = $_POST["Cantidadjs"];
		$Nombrepro = $_POST["nombreprojs"];		
		$UnidCantidadAct = $Cantidad + $UnidCantidad;
		$ModProd = $AdministracionDAO -> ModifUnidad($IdProd, $UnidCantidadAct);
		echo "Unidades Agregadas";
		reg_bitac($_SESSION['usur'],"Inventario - Inventario","Agregar Unidades. $Nombrepro: Antes: $UnidCantidad,Ahora: $UnidCantidadAct");		
	}
	if ($OpAccion == "CrearCuentaTbl")
	{
		$AdministracionDAO = new AdministracionDAO();
		$Nombre = $_POST["category_namejs"]; 
		$Color = $_POST["category_colorjs"]; 
		$ChAct = $_POST["Chcategory_status"]; 		
		$CatMaxVal = $AdministracionDAO -> MaxValor("Id_Categoria","tbl_categoria");
		$Idcat = 0;
		foreach ($CatMaxVal as $value) {$Idcat = $value[0];}		
		if (Getvaltabl("Nombre","tbl_categoria",$Nombre))
		{
			echo "No se puede Crear, el nombre de la Cuenta es repetido";						
		}else
		{
			$matriz = array($Idcat, $Nombre, $Color, $ChAct);	
			$AgrProd = $AdministracionDAO -> Crear_Registro("tbl_categoria",$matriz);
			echo "Cuentas Agregadas";
			reg_bitac($_SESSION['usur'],"Cuentas de Pago","Agregar Registro. $Nombre, Color:$Color, Activo:$ChAct");		
		}				
	}	
	if ($OpAccion == "ModifCuentaTbl")
	{
		$AdministracionDAO = new AdministracionDAO();
		$IdCat = $_POST["id_categoryjs"]; 
		$Nombre = $_POST["category_namejs"]; 
		$Color = $_POST["category_colorjs"]; 
		$ChAct = $_POST["Chcategory_status"];
		$Inic_matriz = array("Nombre", "Color", "ChAct");	
		$matriz = array($Nombre, $Color, $ChAct);	
		$where = "where (Id_Categoria = '$IdCat')";
		if ($_SESSION['NivPerm_25'] == "1") {
			$ModProd = $AdministracionDAO -> Modificar_Registro("tbl_categoria",$Inic_matriz,$matriz,$where);		
			echo "Cuentas Modificada";		
			reg_bitac($_SESSION['usur'],"Cuentas de Pago","Modificar Registro. $Nombre, Color:$Color, Activo:$ChAct");		
		}else {
			echo "No se puede modificar, no tiene los permisos para hacerlo";
		}
	}
	if ($OpAccion == "CrearCoordTbl")
	{
		$AdministracionDAO = new AdministracionDAO();
		$Nombre = $_POST["coordination_namejs"]; 
		$CoorMaxVal = $AdministracionDAO -> MaxValor("Id_Coor","tbl_coordinacion");		
		$Idcoor = 0;
		foreach ($CoorMaxVal as $value) {$Idcoor = $value[0];}		
		if (Getvaltabl("Nombre","tbl_coordinacion",$Nombre))
		{
			echo "No se puede Crear, el nombre de la Coordinacion es repetido";						
		}else
		{
			$matriz = array($Idcoor, $Nombre);	
			$AgrProd = $AdministracionDAO -> Crear_Registro("tbl_coordinacion",$matriz);
			echo "Coordinacion Agregada";
			reg_bitac($_SESSION['usur'],"Coordinacione","Agregar Registro. $Nombre");					
		}
	}	
	if ($OpAccion == "ModifCoordTbl")
	{
		$AdministracionDAO = new AdministracionDAO();
		$Idcoor = $_POST["id_coordinationjs"]; 
		$Nombre = $_POST["coordination_namejs"]; 
		$Inic_matriz = array("Nombre");	
		$matriz = array($Nombre);	
		$where = "where (Id_Coor = '$Idcoor')";
		if ($_SESSION['NivPerm_24'] == "1") {
			$ModProd = $AdministracionDAO -> Modificar_Registro("tbl_coordinacion",$Inic_matriz,$matriz,$where);		
			echo "Coordinacion Modificada";
			reg_bitac($_SESSION['usur'],"Coordinacione","Modificar Registro. $Nombre");		
		}else {
			echo "No se puede modificar, no tiene los permisos para hacerlo";
		}
	}	
	if ($OpAccion == "CrearUsurTbl")
	{
		$AdministracionDAO = new AdministracionDAO();
		$dni = $_POST["dnijs"]; 
		$Nombre = $_POST["namejs"]; 
		$email = $_POST["emailjs"];
		$usuario = $_POST["usuariojs"]; 
		$username = $_POST["usernamejs"]; 
		$passwords = $_POST["passwordjs"]; 
		$Tipo = $_POST["tipojs"];	
		$matriz = array($dni, $Nombre, $usuario, $username, $passwords, $Tipo, $email);	
        $AgrProd = $AdministracionDAO -> Crear_Registro("tbl_usuarios",$matriz);
		reg_bitac($_SESSION['usur'],"Usuarios","Agregar Registro. $Nombre, Correo: $email,");		
	}
	
	if ($OpAccion == "ModificUsurTbl")
	{
		$AdministracionDAO = new AdministracionDAO();
		$dni = $_POST["dnijs"]; 
		$Nombre = $_POST["namejs"]; 
		$email = $_POST["emailjs"];
		$usuario = $_POST["usuariojs"]; 
		$username = $_POST["usernamejs"]; 
		$passwords = $_POST["passwordjs"]; 
		$Tipo = $_POST["tipojs"];	
		$Inic_matriz = array("dni","nombre","clav","Tipo","email");	
		$matriz = array($dni, $Nombre, $passwords, $Tipo, $email);	
		if ($passwords == "**")
		{
			$Inic_matriz = array("dni","nombre","Tipo","email");	
			$matriz = array($dni, $Nombre, $Tipo, $email);				
		}
		$where = "where (usur = '$username')";
		if ($_SESSION['NivPerm_27'] == "1") {
			$ModProd = $AdministracionDAO -> Modificar_Registro("tbl_usuarios",$Inic_matriz,$matriz,$where);				
			reg_bitac($_SESSION['usur'],"Usuarios","Modificar Registro. $Nombre, Correo: $email,");		
		}else {
			echo "*****";
		}
	}


    if (subir_archivo() <> '')
	{		
		require_once('../../libreria/libexcel/PHPExcel.php');
		require_once('../../libreria/libexcel/PHPExcel/Reader/Excel5.php');		
		$xlsarchivo = subir_archivo();
		$objReader = new PHPExcel_Reader_Excel5();
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($xlsarchivo);
		
		?>
			<table class="ui compact celled table">
				<thead>
					<tr>
						<th style="text-align: center; vertical-align: middle;">
						<?php echo $objPHPExcel->getActiveSheet()->getCell('A1')->getFormattedValue();?>
						</th>
						<th style="text-align: center; vertical-align: middle; width: 350px;">
						<?php echo $objPHPExcel->getActiveSheet()->getCell('B1')->getFormattedValue();?>						
						</th>
						<th style="text-align: center; vertical-align: middle; width: 350px;">
						<?php echo $objPHPExcel->getActiveSheet()->getCell('C1')->getFormattedValue();?>						
						</th>
						<th style="text-align: center; vertical-align: middle; width: 350px;">
						<?php echo $objPHPExcel->getActiveSheet()->getCell('D1')->getFormattedValue();?>						
						</th>
						<th style="text-align: center; vertical-align: middle; width: 350px;">
						<?php echo $objPHPExcel->getActiveSheet()->getCell('E1')->getFormattedValue();?>						
						</th>
						<th style="text-align: center; vertical-align: middle; width: 350px;">
						<?php echo $objPHPExcel->getActiveSheet()->getCell('F1')->getFormattedValue();?>						
						</th>
						<th style="text-align: center; vertical-align: middle; width: 350px;">
						<?php echo $objPHPExcel->getActiveSheet()->getCell('G1')->getFormattedValue();?>						
						</th>
						<th style="text-align: center; vertical-align: middle; width: 350px;">
						<?php echo $objPHPExcel->getActiveSheet()->getCell('H1')->getFormattedValue();?>						
						</th>
						<th style="text-align: center; vertical-align: middle; width: 350px;">
						<?php echo $objPHPExcel->getActiveSheet()->getCell('I1')->getFormattedValue();?>						
						</th>
						<th style="text-align: center; vertical-align: middle; width: 350px;">
						<?php echo $objPHPExcel->getActiveSheet()->getCell('J1')->getFormattedValue();?>						
						</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$ContVal = 1;
					$ContReg = 0;
					$Fin_Archivo = false;
					while (($Fin_Archivo == false) and ($ContVal < 100000))
					{
						$ContVal = $ContVal + 1;
						$ContReg = $ContReg + 1;
						$Arch_Val = $objPHPExcel->getActiveSheet()->getCell('A'.$ContVal)->getFormattedValue();
						if ($Arch_Val == '')
						{$Fin_Archivo = true;} else 
							{ ?>
							<input name="product_id[]" type="hidden" value="<?php echo $ContReg;?>" id="product_id<?php echo $ContReg;?>"  
							data-cedula="<?php    echo $objPHPExcel->getActiveSheet()->getCell('A'.$ContVal)->getFormattedValue();?>" 
							data-nombre1="<?php   echo $objPHPExcel->getActiveSheet()->getCell('B'.$ContVal)->getFormattedValue();?>" 
							data-nombre2="<?php   echo $objPHPExcel->getActiveSheet()->getCell('C'.$ContVal)->getFormattedValue();?>" 
							data-apellido1="<?php echo $objPHPExcel->getActiveSheet()->getCell('D'.$ContVal)->getFormattedValue();?>" 
							data-apellido2="<?php echo $objPHPExcel->getActiveSheet()->getCell('E'.$ContVal)->getFormattedValue();?>" 
							data-fechingr="<?php  echo $objPHPExcel->getActiveSheet()->getCell('F'.$ContVal)->getFormattedValue();?>" 
							data-semestre="<?php  echo $objPHPExcel->getActiveSheet()->getCell('G'.$ContVal)->getFormattedValue();?>" 
							data-carrera="<?php   echo $objPHPExcel->getActiveSheet()->getCell('H'.$ContVal)->getFormattedValue();?>" 
							data-situacion="<?php echo $objPHPExcel->getActiveSheet()->getCell('I'.$ContVal)->getFormattedValue();?>" 
							data-fechret="<?php   echo $objPHPExcel->getActiveSheet()->getCell('J'.$ContVal)->getFormattedValue();?>" 
							/>							
							<tr>
							<td style="text-align: center; vertical-align: middle;">
							<?php echo $objPHPExcel->getActiveSheet()->getCell('A'.$ContVal)->getFormattedValue();?>&nbsp;
							</td>
							<td style="text-align: center; vertical-align: middle;">
							<?php echo $objPHPExcel->getActiveSheet()->getCell('B'.$ContVal)->getFormattedValue();?>&nbsp;
							</td>
							<td style="text-align: center; vertical-align: middle;">
							<?php echo $objPHPExcel->getActiveSheet()->getCell('C'.$ContVal)->getFormattedValue();?>&nbsp;
							</td>
							<td style="text-align: center; vertical-align: middle;">
							<?php echo $objPHPExcel->getActiveSheet()->getCell('D'.$ContVal)->getFormattedValue();?>&nbsp;
							</td>
							<td style="text-align: center; vertical-align: middle;">
							<?php echo $objPHPExcel->getActiveSheet()->getCell('E'.$ContVal)->getFormattedValue();?>&nbsp;
							</td>
							<td style="text-align: center; vertical-align: middle;">
							<?php echo $objPHPExcel->getActiveSheet()->getCell('F'.$ContVal)->getFormattedValue();?>&nbsp;
							</td>
							<td style="text-align: center; vertical-align: middle;">
							<?php echo $objPHPExcel->getActiveSheet()->getCell('G'.$ContVal)->getFormattedValue();?>&nbsp;
							</td>
							<td style="text-align: center; vertical-align: middle;">
							<?php echo $objPHPExcel->getActiveSheet()->getCell('H'.$ContVal)->getFormattedValue();?>&nbsp;
							</td>
							<td style="text-align: center; vertical-align: middle;">
							<?php echo $objPHPExcel->getActiveSheet()->getCell('I'.$ContVal)->getFormattedValue();?>&nbsp;
							</td>
							<td style="text-align: center; vertical-align: middle;">
							<?php echo $objPHPExcel->getActiveSheet()->getCell('J'.$ContVal)->getFormattedValue();?>&nbsp;
							</td>
							</tr>
							<?php
							}//ifelse
					}//while
				?>
				</tbody>
			</table>
		<?php
	}//if

	if ($OpAccion == "SubirArch_Cargar")
	{
		$AdministracionDAO = new AdministracionDAO();
		$cad_valor = $_POST["cad_valjs"];
		$cont = $_POST["contjs"];
		$alumnos = json_decode($cad_valor);
		for ($i = 1;$i <= $cont;$i++)
		{
		$where = "where (Cedula = '".($alumnos->{"Cedula".$i})."')"; 
		$matriz = array($alumnos->{"Cedula".$i},$alumnos->{"Nombre1_".$i},
						$alumnos->{"Nombre2_".$i},$alumnos->{"Apellido1_".$i},
						$alumnos->{"Apellido2_".$i},$alumnos->{"FechIngr".$i},
						$alumnos->{"Semestre".$i},$alumnos->{"Carrera".$i},
						$alumnos->{"Situacion".$i},$alumnos->{"FechRet".$i});	
		$EliReg = $AdministracionDAO -> Eliminar_Registro("tbl_personas",$where);
        $AgrReg = $AdministracionDAO -> Crear_Registro("tbl_personas",$matriz);						
		}
		echo "Registros Cargados";
	}
		
	if ($OpAccion == "SubirLote")
	{
		?>		
<div class="container-fluid"><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="row show_order">
        <div class="col-md-offset-1 col-md-9 col-xs-offset-1 col-xs-9">
            <div class="white-box" style="padding: 0;">
                <form id="frmSubmit" method="post">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th width="75%" style="text-align: center; vertical-align: middle;">ALUMNOS</th>
                                    <th width="25%" style="text-align: center; vertical-align: middle; width: 350px;">
										<table width="100%">
											<tr>
												<td width="90%" style="text-align: center; vertical-align: middle; width: 350px;">CARGA MASIVA DE ALUMNOS</td>
												<td width="10%">
												<a href="../../aplicaciones/archivos/carga_masiva_alumnos.xls">
												<img src="../../aplicaciones/imagenes/xls.jpg" height="40" width="40" title="Descargar Formato Excel">
												</a>
												</td>
											</tr>
										</table>									
									</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <ul id="IdRerporteProdAct" class="list-group list-group-full" 
										style="height: 400px;width: 500px;overflow:auto;">
										</ul>
                                    </td>
                                    <td class="ui form">
                                        <div class="field">
                                            <label>ARCHIVO A ADJUNTAR</label>
                                            <input type="file" name="file_alumnos" id="file_alumnos" accept=".xls">
                                        </div>
										<br>
                                        <div style="text-align: left; margin-top: 20px;">
                                            <button type="button" id="adj_arch" style="" class="ui positive button btnSubmit" onclick="subirarch()">ADJUNTAR ARCHIVO</button>
                                            <button type="button" id="car_arch" style="display:none" class="ui positive button btnSubmit" onclick="cargarch()">CARGAR REGISTROS</button>
                                        </div>
                                   </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

	</div>
</div>
	<?php
	}
	
	if ($OpAccion == "CargarProductosAct")
	{
		$AdministracionDAO = new AdministracionDAO();
		$listProd = $AdministracionDAO->GetProductos();
		foreach ($listProd as $value) {
			if ($value[7] == 0){$ValBool= "false";} else {$ValBool= "true";}										
			$CantVal = $value[5];
			if ($value[5] == "") {$CantVal = 0;}
			if ($CantVal == 0) {$ValBoolCant = "false";} else {$ValBoolCant = "true";}
			?>
				<li class="list-group-item" style="border-left: 5px solid <?php echo $value[3];?>; padding: 5px 15px;">
					<div class="checkbox radio" style="margin: 0;">
						<input name="product_id" type="radio" value="<?php echo $value[0];?>" id="product_id" class="product_edit" data-id="<?php echo $value[0];?>" data-name="<?php echo $value[1];?>" data-amount="<?php echo $value[4];?>" data-units="<?php echo $CantVal;?>" data-accountant="<?php echo $ValBoolCant;?>" data-inventory="<?php echo $ValBool;?>" data-category="<?php echo $value[6];?>" />
						<label for="product_<?php echo $value[0];?>" id="product_label_<?php echo $value[0];?>"><?php echo $value[1];?></label>
					</div>

					<div style="float: right; margin-top: -18px;">
						<?php echo $value[8]." ".number_format($value[4],2,',','.');?>
					</div>
				</li>
			<?php
		}//for
	}
	
	if ($OpAccion == "CargarUnidadAgr")
	{
		$AdministracionDAO = new AdministracionDAO();
		$listProd = $AdministracionDAO->GetProductos();
		foreach ($listProd as $value) {
			if ($value[7] == 0){$ValBool= "false";} else {$ValBool= "true";}										
			$CantVal = $value[5];
			if ($value[5] == "") {$CantVal = 0;}
			if ($CantVal == 0) {$ValBoolCant = "false";} else {$ValBoolCant = "true";}
			if ($CantVal <> 0)
			{
			?>
			<li class="list-group-item" style="border-left: 5px solid <?php echo $value[3];?>; padding: 5px 15px;">
				<div class="checkbox radio" style="margin: 0;">
					<input name="product_id" type="radio" value="<?php echo $value[0];?>" id="product_id" class="product_editcrear" data-id="<?php echo $value[0];?>" data-name="<?php echo $value[1];?>" data-amount="<?php echo $value[4];?>" data-units="<?php echo $CantVal;?>" data-accountant="<?php echo $ValBoolCant;?>" data-inventory="<?php echo $ValBool;?>" data-category="<?php echo $value[6];?>" />
					<label for="product_<?php echo $value[0];?>" id="product_label_<?php echo $value[0];?>"><?php echo $value[1];?></label>
				</div>
				<div style="float: right; margin-top: -18px;">
						<?php echo $value[8]." ".number_format($value[4],2,',','.');?>
				</div>
			</li>
			<?php
			}//if
		}//for
	}
	
	if ($OpAccion == "ModifProductos")
	{
		$AdministracionDAO = new AdministracionDAO();
	?>
<div class="container-fluid"><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="row show_order">
        <div class="col-md-offset-1 col-md-9 col-xs-offset-1 col-xs-9">
            <div class="white-box" style="padding: 0;">
                <form id="frmSubmit" method="post">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">PRODUCTOS</th>
                                    <th style="text-align: center; vertical-align: middle; width: 350px;">MODIFICAR UN PRODUCTO DEL INVENTARIO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <ul id="IdRerporteProdAct" class="list-group list-group-full" style="height: 315px; overflow-y: scroll;">
								<?php
								$listProd = $AdministracionDAO->GetProductos();
								foreach ($listProd as $value) {
									if ($value[7] == 0){$ValBool= "false";} else {$ValBool= "true";}										
									$CantVal = $value[5];
									if ($value[5] == "") {$CantVal = 0;}
									if ($CantVal == 0) {$ValBoolCant = "false";} else {$ValBoolCant = "true";}
									?>
										<li class="list-group-item" style="border-left: 5px solid <?php echo $value[3];?>; padding: 5px 15px;">
											<div class="checkbox radio" style="margin: 0;">
												<input name="product_id" type="radio" value="<?php echo $value[0];?>" id="product_id" class="product_edit" data-id="<?php echo $value[0];?>" data-name="<?php echo $value[1];?>" data-amount="<?php echo $value[4];?>" data-units="<?php echo $CantVal;?>" data-moneda="<?php echo $value[8];?>" data-accountant="<?php echo $ValBoolCant;?>" data-inventory="<?php echo $ValBool;?>" data-category="<?php echo $value[6];?>" />
												<label for="product_<?php echo $value[0];?>" id="product_label_<?php echo $value[0];?>"><?php echo $value[1];?></label>
											</div>

											<div style="float: right; margin-top: -18px;">
												<?php echo $value[8]." ".number_format($value[4],2,',','.');?>
											</div>
										</li>
									<?php
								}//for
								?>
										</ul>
                                    </td>
                                    <td class="ui form">
                                        <div class="field">
                                            <label>NOMBRE PRODUCTO</label>
                                            <input type="hidden" name="id_product_name" id="id_product_name">
                                            <input type="text" name="product_name" id="product_name" required="" autocomplete="off">
                                        </div>

                                        <div class="field">
									<?php
									$listValid = $AdministracionDAO->GetCategoria($_SESSION['usur']);
									$ContVal = 0;
									$ValProd = 0;
									foreach ($listValid as $value) {
										$ContVal = $ContVal + 1;
										if ($ContVal == 1) {
											$ValProd = $value[0];
										}//if
									}//for
									?>
                                            <label>CATEGORÍA</label>
                                            <div class="ui fluid selection dropdown">
                                                <input type="hidden" name="product_category" id="product_category" required value="<?php echo $ValProd;?>">
                                                <i class="dropdown icon"></i>
                                                <div class="default text">Seleccionar una categoría</div>
                                                <div class="menu">
										<?php
										$listAdm = $AdministracionDAO->GetCategoria($_SESSION['usur']);
										foreach ($listAdm as $value) {
										?>
											<div class="item" data-value="<?php echo $value[0];?>">
											<div class="ui red empty circular label" style="background-color: <?php echo $value[2];?> !important; border-color: #11ff00 !important;"></div>
												<?php echo $value[1];?>
											</div>										
										<?php
										}//for										
										?>
                                            </div>
                                        </div>

                                        <div class="checkbox" style="margin: 0;" onclick="($('#product_accountant').is(':checked') ? $('#show_product_units').show() : $('#show_product_units').hide())">
                                            <input name="product_accountant" type="checkbox" id="product_accountant" />
                                            <label for="product_accountant" id="product_accountant_label"> INVENTARIO DE UNIDADES</label>
                                        </div>
                                        <br>
										<?php
											$listValid = $AdministracionDAO->Getmoneda();
											$ContVal = 0;
											$ValProd = 0;
											foreach ($listValid as $value) {
												$ContVal = $ContVal + 1;
												if ($ContVal == 1) {
													$ValProd = $value[4];
												}//if
											}//for
										?>
										<div class="field">
											<?php
											$listValid = $AdministracionDAO->Getmoneda();
											?>
											<label>MONEDA</label>
											<div class="ui fluid selection dropdown">
												<input type="hidden" name="moneda_category" id="moneda_category" required value="<?php echo $ValProd;?>">
												<i class="dropdown icon"></i>
												<div class="default text">Seleccionar una moneda</div>
												<div class="menu">
												<?php
												$listAdm = $AdministracionDAO->Getmoneda();
												foreach ($listAdm as $value) {
												?>
													<div class="item" data-value="<?php echo $value[4];?>">
													<div class="label" style="border-color: #11ff00 !important;"></div>
														<?php echo $value[1];?>
													</div>										
												<?php
												}//for										
												?>
												</div>
											</div>
										</div><br>
                                        <div class="field" id="show_product_units" style="display: none;">
                                            <label>UNIDADES</label>
                                            <input type="text" name="product_units" id="product_units" value="1" min="1" data-mask="###0" data-mask-reverse="true" autocomplete="off">
                                        </div>

                                        <div class="field">
                                            <label>PRECIO UNITARIO</label>
                                            <input type="text" name="product_amount" id="product_amount" required="" step="any" value="1.00" min="1.00" class="money_format" autocomplete="off">
                                        </div>

                                        <div class="checkbox" style="margin: 0;">
                                            <input name="product_inventory" type="checkbox" id="product_inventory" />
                                            <label for="product_inventory" id="product_inventory_label"> MOSTRAR EN EL INVENTARIO</label>
                                        </div>

                                        <div style="text-align: center; margin-top: 20px;">
                                            <button type="button" class="ui positive button btnSubmit disabled" onclick="accionprod('2')">ACTUALIZAR PRODUCTO</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                                    </div>
	<?php	
	}
	
	if ($OpAccion == "CrearUnidades")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
<div class="container-fluid">
                        <br>
					<input type="hidden" name="OpAux" id="OpAux" value="Unidad">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="row show_order">
        <div class="col-md-offset-1 col-md-9 col-xs-offset-1 col-xs-9">
            <div class="white-box" style="padding: 0;">
                <form id="frmSubmit" method="post">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">PRODUCTOS</th>
                                    <th style="text-align: center; vertical-align: middle; width: 350px;">A&Ntilde;ADIR UNIDADES A UN PRODUCTO DEL INVENTARIO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <ul id="IdCrearUnid" class="list-group list-group-full" style="height: 315px; overflow-y: scroll;">
										<?php
										$listProd = $AdministracionDAO->GetProductos();
										foreach ($listProd as $value) {
											if ($value[7] == 0){$ValBool= "false";} else {$ValBool= "true";}										
											$CantVal = $value[5];
											if ($value[5] == "") {$CantVal = 0;}
											if ($CantVal == 0) {$ValBoolCant = "false";} else {$ValBoolCant = "true";}
											if ($CantVal <> 0)
											{
											?>
											<li class="list-group-item" style="border-left: 5px solid <?php echo $value[3];?>; padding: 5px 15px;">
												<div class="checkbox radio" style="margin: 0;">
													<input name="product_id" type="radio" value="<?php echo $value[0];?>" id="product_id" class="product_editcrear" data-id="<?php echo $value[0];?>" data-name="<?php echo $value[1];?>" data-amount="<?php echo $value[4];?>" data-units="<?php echo $CantVal;?>" data-accountant="<?php echo $ValBoolCant;?>" data-inventory="<?php echo $ValBool;?>" data-category="<?php echo $value[6];?>" />
													<label for="product_<?php echo $value[0];?>" id="product_label_<?php echo $value[0];?>"><?php echo $value[1];?></label>
												</div>
												<div style="float: right; margin-top: -18px;">
														<?php echo $value[8]." ".number_format($value[4],2,',','.');?>
												</div>
											</li>
											<?php
											}//if
										}//for
										?>
										</ul>
                                    </td>
                                    <td class="ui form">
                                        <div class="field">
                                            <label>NOMBRE PRODUCTO</label>
                                            <input type="hidden" name="id_product_name" id="id_product_name">
                                            <input type="text" name="product_name" id="product_name" required="" autocomplete="off" readonly>
                                        </div>

                                        <div class="field" id="show_product_units">
                                            <label>UNIDADES ACTUALES</label>
                                            <input type="text" name="product_units_exist" id="product_units_exist" value="" min="0" readonly required data-mask="###0" data-mask-reverse="true" autocomplete="off">
                                        </div>

                                        <div class="field" id="show_product_units">
                                            <label>NUEVAS UNIDADES</label>
                                            <input type="text" name="product_units" id="product_units" value="" min="1" required data-mask="###0" data-mask-reverse="true" autocomplete="off">
                                        </div>

                                        <div style="text-align: center; margin-top: 20px;">
                                            <button type="button" class="ui positive button btnSubmit disabled" onclick="creaunidad()">A&Ntilde;ADIR UNIDADES</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                                    </div>
<?php
	}	
	
	if ($OpAccion == "CuadrarInv")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
		<div class="container-fluid">
                        <br>
					<input type="hidden" name="OpAux" id="OpAux" value="Cuadrar">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="row show_order">
        <div class="col-md-offset-1 col-md-9 col-xs-offset-1 col-xs-9">
            <div class="white-box" style="padding: 0;">
                <form id="frmSubmit" method="post">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">PRODUCTOS</th>
                                    <th style="text-align: center; vertical-align: middle; width: 350px;">CUADRAR UNIDADES A UN PRODUCTO DEL INVENTARIO PERMITE QUITAR UNIDADES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <ul id="IdCrearUnid" class="list-group list-group-full" style="height: 315px; overflow-y: scroll;">
										<?php
										$listProd = $AdministracionDAO->GetProductos();
										foreach ($listProd as $value) {
											if ($value[7] == 0){$ValBool= "false";} else {$ValBool= "true";}										
											$CantVal = $value[5];
											if ($value[5] == "") {$CantVal = 0;}
											if ($CantVal == 0) {$ValBoolCant = "false";} else {$ValBoolCant = "true";}
											if ($CantVal <> 0)
											{
											?>
											<li class="list-group-item" style="border-left: 5px solid <?php echo $value[3];?>; padding: 5px 15px;">
												<div class="checkbox radio" style="margin: 0;">
													<input name="product_id" type="radio" value="<?php echo $value[0];?>" id="product_id" class="product_editcrear" data-id="<?php echo $value[0];?>" data-name="<?php echo $value[1];?>" data-amount="<?php echo $value[4];?>" data-units="<?php echo $CantVal;?>" data-accountant="<?php echo $ValBoolCant;?>" data-inventory="<?php echo $ValBool;?>" data-category="<?php echo $value[6];?>" />
													<label for="product_<?php echo $value[0];?>" id="product_label_<?php echo $value[0];?>"><?php echo $value[1];?></label>
												</div>
												<div style="float: right; margin-top: -18px;">
														<?php echo $value[8]." ".number_format($value[4],2,',','.');?>
												</div>
											</li>
											<?php
											}//if
										}//for
										?>
										</ul>
                                    </td>
                                    <td class="ui form">
                                        <div class="field">
                                            <label>NOMBRE PRODUCTO</label>
                                            <input type="hidden" name="id_product_name" id="id_product_name">
                                            <input type="text" name="product_name" id="product_name" required="" autocomplete="off">
                                        </div>

                                        <div class="field" id="show_product_units">
                                            <label>UNIDADES ACTUALES</label>
                                            <input type="text" name="product_units_exist" id="product_units_exist" value="" min="0" readonly required data-mask="###0" data-mask-reverse="true" autocomplete="off">
                                        </div>

                                        <div class="field" id="show_product_units">
                                            <label>NUEVAS UNIDADES (PONER EN NEGATIVO PARA RESTAR)</label>
                                            <input type="text" name="product_units" id="product_units" value="" required data-mask-reverse="true" autocomplete="off">
                                        </div>

                                        <div style="text-align: center; margin-top: 20px;">
                                            <button type="button" class="ui positive button btnSubmit disabled" onclick="creaunidad()">AÑADIR UNIDADES</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                                    </div>
<?php
	}
		
	if ($OpAccion == "CrearCarreraTbl")
	{
		$AdministracionDAO = new AdministracionDAO();
		$Nombre = $_POST["career_namejs"]; 
		$IdCoor = $_POST["career_coordinationjs"];
		$CarrMaxVal = $AdministracionDAO -> MaxValor("Id_Carrera","tbl_carrera");		
		$IdCarr = 0;
		foreach ($CarrMaxVal as $value) {
			$IdCarr = $value[0];				
		}		
		if (Getvaltabl("Nombre","tbl_carrera",$Nombre))
		{
			echo "No se puede Crear, el nombre de la Carrera es repetido";						
		}else
		{
			$matriz = array($IdCarr, $Nombre, $IdCoor);	
			$AgrReg = $AdministracionDAO -> Crear_Registro("tbl_carrera",$matriz);		
			echo "Carrera Creada";
			reg_bitac($_SESSION['usur'],"Carrera","Agregar Registro. $Nombre, Num.Coor: $IdCoor");					
		}
	}
	
	if ($OpAccion == "ModifCarreraTbl")
	{
		$AdministracionDAO = new AdministracionDAO();		
		$IdCarr = $_POST["id_carrerajs"]; 
		$Nombre = $_POST["career_namejs"]; 
		$IdCoor = $_POST["career_coordinationjs"];
		$Inic_matriz = array("Id_Carrera", "Nombre", "Id_Coor");	
		$matriz = array($IdCarr, $Nombre, $IdCoor);	
		$where = "where (Id_Carrera = '$IdCarr')";
		if ($_SESSION['NivPerm_23'] == "1") {
			$ModReg = $AdministracionDAO -> Modificar_Registro("tbl_carrera",$Inic_matriz,$matriz,$where);
			echo "Carrera Actualizada";			
			reg_bitac($_SESSION['usur'],"Carrera","Modfiicar Registro. $Nombre, Num.Coor: $IdCoor");		
		}else {
			echo "No se puede modificar, no tiene los permisos para hacerlo";
		}
	}	
	if ($OpAccion == "ElimRegTbl")
	{
		$AdministracionDAO = new AdministracionDAO();
		$Campo = $_POST["campojs"];
		$Valor = $_POST["registrojs"];		
		$Tabla = $_POST["valtabljs"];		
		if ($Campo == "CampoUsuario") {$CampoReg = "usur";}
		if ($Tabla == "princusuarios") {$TablaReg = "tbl_usuarios";}		
		if ($Campo == "CampoUsuarioEst") {$CampoReg = "usur";}
		if ($Tabla == "princusuariosEst") {$TablaReg = "tbl_usu_alum";}		
		if ($Campo == "CampoCarrera") {$CampoReg = "Id_Carrera";}
		if ($Tabla == "princcarreras") {$TablaReg = "tbl_carrera";}		
		if ($Campo == "CampoCuenta") {$CampoReg = "Id_Categoria";}
		if ($Tabla == "princcuenta") {$TablaReg = "tbl_categoria";}		
		if ($Campo == "CampoCoord") {$CampoReg = "Id_Coor";}
		if ($Tabla == "princcoord") {$TablaReg = "tbl_coordinacion";}
		$where = "where ($CampoReg = '$Valor')";
		$regdel = $AdministracionDAO -> Eliminar_Registro($TablaReg,$where);
		reg_bitac($_SESSION['usur'],substr($Tabla,5,20),"Eliminar Registro. Id: $Campo");		
	}	
	if ($OpAccion == "CargarCarreraAgr")
	{
		$AdministracionDAO = new AdministracionDAO();
		$ListCarrera = $AdministracionDAO -> GetCarreras();
		foreach ($ListCarrera as $value)
		{
		?>
		<li class="list-group-item" style="padding: 5px 15px;">
			<strong><?php echo $value[1];?></strong>
			<div style="float: right;">
				<strong><?php echo $value[3];?>
			</div>
		</li>
		<?php
		}//for
	}
	
	if ($OpAccion == "CargarCarreraMod")
	{		
		$AdministracionDAO = new AdministracionDAO();
		$ListCarrera = $AdministracionDAO -> GetCarreras();
		foreach ($ListCarrera as $value)
		{
		?>
			<li class="list-group-item" style="padding: 5px 15px;">
				<div class="checkbox radio" style="margin: 0;">
					<input name="career_id" type="radio" value="<?php echo $value[0];?>" id="career_id" class="career_edit" data-id="<?php echo $value[0];?>" data-name="<?php echo $value[1];?>" data-coordination="<?php echo $value[2];?>" />
					<label for="career_<?php echo $value[1];?>" id="career_label_<?php echo $value[1];?>"><?php echo $value[1];?></label>
				</div>

				<div style="float: right; margin-top: -18px;">
					<?php echo $value[3];?>
				</div>
			</li>
		<?php
		}//for
	}
	
	if ($OpAccion == "CrearCarrera")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
<div class="container-fluid">
	<br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="row show_order">
        <div class="col-md-offset-1 col-md-9 col-xs-offset-1 col-xs-9">
            <div class="white-box" style="padding: 0;">
                <form id="frmSubmit" method="post">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">CARRERA (COORDINACIÓN)</th>
                                    <th style="text-align: center; vertical-align: middle; width: 350px;">CREAR UNA CARRERA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
									
                                        <ul id="IdTabCarrera" class="list-group list-group-full" style="height: 320px; overflow-y: scroll;">
											<?php
											$ListCarrera = $AdministracionDAO -> GetCarreras();
											foreach ($ListCarrera as $value)
											{
											?>
											<li class="list-group-item" style="padding: 5px 15px;">
												<strong><?php echo $value[1];?></strong>
												<div style="float: right;">
													<strong><?php echo $value[3];?>
												</div>
											</li>
											<?php
											}//for
											?>												
										</ul>
                                    </td>

                                    <td class="ui form">
                                        <div class="field">
                                            <label>NOMBRE CARRERA</label>
                                            <input type="text" name="career_name" id="career_name" required="" autocomplete="off">
                                        </div>

                                        <div class="field">
                                            <label>¿A QUÉ COORDINACIÓN PERTENECE?</label>
                                            <div class="ui fluid selection dropdown">
                                                <input type="hidden" name="career_coordination" id="career_coordination" required value="2">
                                                <i class="dropdown icon"></i>
                                                <div class="default text">Seleccionar una coordinaci&oacute;n</div>
                                                <div class="menu">
												<?php
													$ListCoor = $AdministracionDAO -> GetCoordinacion($_SESSION['usur']);
													foreach ($ListCoor as $value)
													{
														?>
														<div class="item" data-value="<?php echo $value[0];?>">
                                                            <?php echo $value[1];?>
                                                        </div>
														<?php
													}
												?>
												</div>
                                            </div>
                                        </div>
                                        <div style="text-align: center; margin-top: 20px;">
                                            <button type="button" class="ui positive button btnSubmit" onclick="creacarrera()">CREAR CARRERA</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

</div>
		<?php
	}
	if ($OpAccion == "ModifCarrera")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
                <div class="container-fluid">
                        <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="row show_order">
        <div class="col-md-offset-1 col-md-9 col-xs-offset-1 col-xs-9">
            <div class="white-box" style="padding: 0;">
                <form id="frmSubmit" method="post">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">CARRERA (COORDINACIÓN)</th>
                                    <th style="text-align: center; vertical-align: middle; width: 350px;">MODIFICAR UNA CARRERA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <ul id="IdTabCarrera" class="list-group list-group-full" style="height: 320px; overflow-y: scroll;">
											<?php
											$ListCarrera = $AdministracionDAO -> GetCarreras();
											foreach ($ListCarrera as $value)
											{
											?>
												<li class="list-group-item" style="padding: 5px 15px;">
                                                    <div class="checkbox radio" style="margin: 0;">
                                                        <input name="career_id" type="radio" value="<?php echo $value[0];?>" id="career_id" class="career_edit" data-id="<?php echo $value[0];?>" data-name="<?php echo $value[1];?>" data-coordination="<?php echo $value[2];?>" />
                                                        <label for="career_<?php echo $value[1];?>" id="career_label_<?php echo $value[1];?>"><?php echo $value[1];?></label>
                                                    </div>

                                                    <div style="float: right; margin-top: -18px;">
                                                        <?php echo $value[3];?>
                                                    </div>
                                                </li>
											<?php
											}//for
											?>												
										</ul>
                                    </td>
                                    <td class="ui form">
                                        <div class="field">
                                            <label>NOMBRE CARRERA</label>
                                            <input type="hidden" name="id_carrera" id="id_carrera">
                                            <input type="text" name="career_name" id="career_name" required="" autocomplete="off">
                                        </div>

                                        <div class="field">
                                            <label>¿A QUÉ COORDINACIÓN PERTENECE?</label>
                                            <div class="ui fluid selection dropdown">
                                                <input type="hidden" name="career_coordination" id="career_coordination" required>
                                                <i class="dropdown icon"></i>
                                                <div class="default text">Seleccionar una coordinaci&oacute;n</div>
                                                <div class="menu">
												<?php
													$ListCoor = $AdministracionDAO -> GetCoordinacion($_SESSION['usur']);
													foreach ($ListCoor as $value)
													{
														?>
														<div class="item" data-value="<?php echo $value[0];?>">
                                                            <?php echo $value[1];?>
                                                        </div>
														<?php
													}
												?>
												</div>
                                            </div>
                                        </div>
                                        <div class="checkbox checkbox-danger" style="margin: 0;">
										<?php 
										$ValActivo = "disabled";
										if ($_SESSION['NivPerm_3'] == "1") {$ValActivo = "";}
										?>
                                            <input name="career_delete" type="checkbox" id="career_delete" <?php echo $ValActivo;?> />
                                            <label for="career_delete" id="career_delete_label"> ¿Eliminar carrera?</label>
                                        </div>
                                        <div style="text-align: center; margin-top: 20px;">
                                            <button type="button" class="ui positive button btnSubmit disabled" onclick="modifcarrera()">MODIFICAR CARRERA</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                                    </div>
		<?php
	}

	if ($OpAccion == "agregarmon")
	{
		$AdministracionDAO = new AdministracionDAO();
		$Id = Null;
		$moneda = $_POST["monedajs"];
		$monedas = $_POST["monedasjs"];		
		$abrev = $_POST["abrevjs"];
		$simb = $_POST["simbjs"];
		
		if (Getvaltabl("Nombre","tbl_moneda",$Nombre))
		{
			echo "No se puede Crear, el nombre de la Moneda es repetido";						
		}else
		{
			$matriz = array($Id,$moneda,$monedas,$abrev,$simb);	
			$AgrReg = $AdministracionDAO -> Crear_Registro("tbl_moneda",$matriz);				
			echo "Moneda Creada";
			reg_bitac($_SESSION['usur'],"Moneda","Agregar Registro. Moneda: $moneda, Abrev: $abrev, Simbolo: $simb ");					
		}
	}
	if ($OpAccion == "modifmon")
	{
		$AdministracionDAO = new AdministracionDAO();
		$Id = $_POST["monedaidjs"];
		$moneda = $_POST["monedajs"];
		$monedas = $_POST["monedasjs"];		
		$abrev = $_POST["abrevjs"];
		$simb = $_POST["simbjs"];		
		$Inic_matriz = array("Nombre", "NombrePl", "Abrev", "Simbolo");	
		$matriz = array($moneda, $monedas, $abrev, $simb);	
		$where = "where (Id = '$Id')";
		$ModReg = $AdministracionDAO -> Modificar_Registro("tbl_moneda",$Inic_matriz,$matriz,$where);
		echo "Moneda Actualizada";			
		reg_bitac($_SESSION['usur'],"Moneda","Modificar Registro. Moneda: $moneda, Abrev: $abrev, Simbolo: $simb ");		
	}
	if ($OpAccion == "CrearPersonasTbl")
	{
		$AdministracionDAO = new AdministracionDAO();
		$dni = $_POST["dnijs"];
		$nombre1 = $_POST["nombre1js"];
		$nombre2 = $_POST["nombre2js"];
		$apellido1 = $_POST["apellido1js"];
		$apellido2 = $_POST["apellido2js"];		
		$fechainscr = $_POST["fechaincrjs"];
		$semestre = $_POST["semestrejs"];
		$carrera = $_POST["carrerajs"];
		$situacion = $_POST["situacionjs"];
		$fecharet = $_POST["fecharet"];
		$matriz = array($dni,$nombre1,$nombre2,$apellido1,$apellido2,$fechainscr,$semestre,$carrera,$situacion,$fecharet);	
        $AgrReg = $AdministracionDAO -> Crear_Registro("tbl_personas",$matriz);				
		echo "Persona Creada";
		reg_bitac($_SESSION['usur'],"Persona","Agregar Registro. Cedula: $dni, Nombre y Apellidos: $nombre1 $nombre2 $apellido1 $apellido2, Fecha Inscr: $fechainscr, IdSem: $semestre, IdCarr: $carrera, IdSit: $situacion ");		
	}
	if ($OpAccion == "ModificarPersonasTbl")
	{
		$AdministracionDAO = new AdministracionDAO();
		$dni = $_POST["dnijs"];
		$nombre1 = $_POST["nombre1js"];
		$nombre2 = $_POST["nombre2js"];
		$apellido1 = $_POST["apellido1js"];
		$apellido2 = $_POST["apellido2js"];		
		$fechainscr = $_POST["fechaincrjs"];
		$semestre = $_POST["semestrejs"];
		$carrera = $_POST["carrerajs"];
		$situacion = $_POST["situacionjs"];
		$fecharet = $_POST["fecharet"];
		$Inic_matriz = array("Cedula", "Nombre1", "Nombre2","Apellido1","Apellido2","FechaIns","Id_Semestre","Id_Carrera","Id_Situacion","FechaRet");	
		$matriz = array($dni,$nombre1,$nombre2,$apellido1,$apellido2,$fechainscr,$semestre,$carrera,$situacion,$fecharet);	
		$where = "where (Cedula = '$dni')";
		$ModReg = $AdministracionDAO -> Modificar_Registro("tbl_personas",$Inic_matriz,$matriz,$where);
		echo "Datos Modificados";
		reg_bitac($_SESSION['usur'],"Persona","Modificar Registro. Cedula: $dni, Nombre y Apellidos: $nombre1 $nombre2 $apellido1 $apellido2, Fecha Inscr: $fechainscr, IdSem: $semestre, IdCarr: $carrera, IdSit: $situacion ");		
	}

	if ($OpAccion == "CrearPersonas")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
            <div id="page-wrapper" style="background-color: white;">
				<div class="container-fluid">
                        <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
	<form method="post" id="frmSubmit">
        <div class="row show_order">
            <div class="col-md-offset-2 col-md-8 col-xs-offset-2 col-xs-8">
                <div class="white-box" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">DATOS PERSONALES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="ui form frmSelect" style="padding: 10px;">
                                            <div class="three fields">
                                                <div class="field"></div>
                                                <div class="field">
                                                    <label>C&Eacute;DULA</label>
                                                    <input data-mask="##00000000" required maxlength="8" type="text" name="dni" id="dni" value="" class="dni" onkeypress="return solonumeros(event)">
                                                </div>
                                                <div class="field"></div>
                                            </div>
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>PRIMER NOMBRE</label>
                                                    <input data-mask="SSSSSSSSSSSSSSSSSSSSSSSSSSSSSS" maxlength="30" type="text" name="name_first" id="name_first" required value="">
                                                </div>
                                                <div class="field">
                                                    <label>SEGUNDO NOMBRE</label>
                                                    <input data-mask="SSSSSSSSSSSSSSSSSSSSSSSSSSSSSS" maxlength="30" type="text" name="name_second" id="name_second" value="">
                                                </div>
                                            </div>
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>PRIMER APELLIDO</label>
                                                    <input data-mask="SSSSSSSSSSSSSSSSSSSSSSSSSSSSSS" maxlength="30" type="text" name="surname_first" id="surname_first" required value="">
                                                </div>
                                                <div class="field">
                                                    <label>SEGUNDO APELLIDO</label>
                                                    <input data-mask="SSSSSSSSSSSSSSSSSSSSSSSSSSSSSS" maxlength="30" type="text" name="surname_second" id="surname_second" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-offset-2 col-md-8 col-xs-offset-2 col-xs-8">
                <div class="white-box" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">DATOS ACADÉMICOS (
									<input name="ch_noapl" type="checkbox" id="ch_noapl" onclick="oncambiar_apl()"/>
									No aplicable)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="ui form frmSelect" style="height: 300px; padding: 10px;">
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>FECHA DE INSCRIPCIÓN</label>
                                                    <input type="date" name="registration" id="registration" required value="<?php echo date("Y-m-d");?>">
                                                </div>

                                                <div class="field">
                                                    <label>SEMESTRE</label>
                                                    <div class="ui fluid selection dropdown form_semestre">
                                                        <input type="hidden" name="half" id="half" required value="1">
                                                        <i class="dropdown icon"></i>
                                                        <div class="default text">Seleccionar un semestre</div>
                                                        <div class="menu">
														<?php
															$lissem = $AdministracionDAO -> Getsemestre();
															foreach ($lissem as $value)
															{
																?>
																<div class="item" data-value="<?php echo $value[0];?>"><?php echo $value[1];?></div>
																<?php
															}
														?>
														</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>CARRERA</label>
                                                    <div class="ui fluid selection dropdown form_carrera">
                                                        <input type="hidden" name="career" id="career" required value="7">
                                                        <i class="dropdown icon"></i>
                                                        <div class="default text">Seleccionar una carrera</div>
                                                        <div class="menu">
															<?php
															$ConsCarrera = $AdministracionDAO -> GetCarreras();
															foreach ($ConsCarrera as $value)
															{
																?>
																	<div class="item" data-value="<?php echo $value[0];?>">
																		<?php echo $value[1];?>
																	</div>
																<?php
															}
															?>
														</div>
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <label>SITUACIÓN</label>
                                                    <div class="ui fluid selection dropdown">
                                                        <input type="hidden" name="retirement" id="retirement" required value="0" onchange="($(this).val() == 0 ? $('.retirement_date').hide() : $('.retirement_date').show())">
                                                        <i class="dropdown icon"></i>
                                                        <div class="default text">Seleccionar una situaci&oacute;n</div>
                                                        <div class="menu">
															<?php
															$ConsSit = $AdministracionDAO -> Getsituacion();
															foreach ($ConsSit as $value)
															{
																?>
																	<div class="item" data-value="<?php echo $value[0];?>">
																		<?php echo $value[1];?>
																	</div>
																<?php
															}
															?>
														</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="two fields retirement_date" style="display: none;">
                                                <div class="field">
                                                    <label>FECHA DE RETIRO</label>
                                                    <input type="date" name="retirement_date" id="retirement_date" value="<?php echo date("Y-m-d");?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btnSearchStudent" style="text-align: right; margin-right: 10px; margin-bottom: 20px;">
                                            <button type="button" class="ui positive button btnSave" onclick="accionpersona(1)">GUARDAR PERSONA</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                                    </div>                
            </div>
		<?php
	}
	if ($OpAccion == "ModifPersonas")
	{
	?>
	<div class="container-fluid" id="consulta_cedula"><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="col-md-6 col-md-offset-3">
        <div class="text-center">
            <img src="../imagenes/logoIUJO.png" />
            <h3 id="titulo">MODIFICAR PERSONA</h3>

            <center>
                <form method="post" class="frmUsername ui form">
                    <div class="field" style="width: 260px;">
                        <div class="ui action left icon input">
                            <i class="user icon"></i>
                            <input data-mask="##00000000" maxlength="8" type="text" placeholder="Cédula..." name="username" id="dni" value="" class="username" onkeypress="return solonumeros(event)">
                            <button type="button" class="ui red icon button btnUsername" onclick="buscar_persona()">
                                <i class="search icon"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </center>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

	</div>	
	<div class="container-fluid" id="datos_consulta_cedula" style="display:none"></div>
	<?php
	}
	if ($OpAccion == "buscar_personas")
	{
		$Cedula = $_POST["dnijs"];
		$AdministracionDAO = new AdministracionDAO();
		$ConsPersona = $AdministracionDAO -> GetPersona($Cedula);
		if (is_array($ConsPersona) || is_object($ConsPersona)) 
		{
			$nombre1 = "";
			foreach ($ConsPersona as $values)
			{
				$nombre1 = $values[1];
				$nombre2 = $values[2];
				$apellido1 = $values[3];
				$apellido2 = $values[4];
				$fechainscr = substr($values[5],6,4)."-".substr($values[5],3,2)."-".substr($values[5],0,2);;
				$semestre = $values[6];
				$carrera = $values[7];
				$situacion = $values[8];
				$fecharet = substr($values[9],6,4)."-".substr($values[9],3,2)."-".substr($values[9],0,2);;
			}//for
			if ($nombre1 <> "")
			{
			?>
				<div class="container-fluid">
                        <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
	<form method="post" id="frmSubmit">
        <div class="row show_order">
            <div class="col-md-offset-2 col-md-8 col-xs-offset-2 col-xs-8">
                <div class="white-box" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">DATOS PERSONALES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="ui form frmSelect" style="padding: 10px;">
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>PRIMER NOMBRE</label>
                                                    <input data-mask="SSSSSSSSSSSSSSSSSSSSSSSSSSSSSS" maxlength="30" type="text" name="name_first" id="name_first" required value="<?php echo $nombre1;?>">
                                                </div>
                                                <div class="field">
                                                    <label>SEGUNDO NOMBRE</label>
                                                    <input data-mask="SSSSSSSSSSSSSSSSSSSSSSSSSSSSSS" maxlength="30" type="text" name="name_second" id="name_second" value="<?php echo $nombre2;?>">
                                                </div>
                                            </div>
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>PRIMER APELLIDO</label>
                                                    <input data-mask="SSSSSSSSSSSSSSSSSSSSSSSSSSSSSS" maxlength="30" type="text" name="surname_first" id="surname_first" required value="<?php echo $apellido1;?>">
                                                </div>
                                                <div class="field">
                                                    <label>SEGUNDO APELLIDO</label>
                                                    <input data-mask="SSSSSSSSSSSSSSSSSSSSSSSSSSSSSS" maxlength="30" type="text" name="surname_second" id="surname_second" value="<?php echo $apellido2;?>">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-offset-2 col-md-8 col-xs-offset-2 col-xs-8">
                <div class="white-box" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">DATOS ACADÉMICOS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="ui form frmSelect" style="height: 300px; padding: 10px;">
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>FECHA DE INSCRIPCIÓN</label>
                                                    <input type="date" name="registration" id="registration" required value="<?php echo $fechainscr;?>">
                                                </div>

                                                <div class="field">
                                                    <label>SEMESTRE</label>
                                                    <div class="ui fluid selection dropdown">
                                                        <input type="hidden" name="half" id="half" required value="<?php echo $semestre;?>">
                                                        <i class="dropdown icon"></i>
                                                        <div class="default text">Seleccionar un semestre</div>
                                                        <div class="menu">
														<?php
															$lissem = $AdministracionDAO -> Getsemestre();
															foreach ($lissem as $value)
															{
																?>
																<div class="item" data-value="<?php echo $value[0];?>"><?php echo $value[1];?></div>
																<?php
															}
														?>
														</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>CARRERA</label>
                                                    <div class="ui fluid selection dropdown">
                                                        <input type="hidden" name="career" id="career" required value="<?php echo $carrera;?>">
                                                        <i class="dropdown icon"></i>
                                                        <div class="default text">Seleccionar una carrera</div>
                                                        <div class="menu">
															<?php
															$ConsCarrera = $AdministracionDAO -> GetCarreras();
															foreach ($ConsCarrera as $value)
															{
																?>
																	<div class="item" data-value="<?php echo $value[0];?>">
																		<?php echo $value[1];?>
																	</div>
																<?php
															}
															?>
														</div>
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <label>SITUACIÓN</label>
                                                    <div class="ui fluid selection dropdown">
                                                        <input type="hidden" name="retirement" id="retirement" required value="<?php echo $situacion;?>" onchange="($(this).val() == 0 ? $('.retirement_date').hide() : $('.retirement_date').show())">
                                                        <i class="dropdown icon"></i>
                                                        <div class="default text">Seleccionar una situaci&oacute;n</div>
                                                        <div class="menu">
															<?php
															$ConsSit = $AdministracionDAO -> Getsituacion();
															foreach ($ConsSit as $value)
															{
																?>
																	<div class="item" data-value="<?php echo $value[0];?>">
																		<?php echo $value[1];?>
																	</div>
																<?php
															}
															?>
														</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="two fields retirement_date" style="display: none;">
                                                <div class="field">
                                                    <label>FECHA DE RETIRO</label>
                                                    <input type="date" name="retirement_date" id="retirement_date" value="<?php echo $fecharet;?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btnSearchStudent" style="text-align: right; margin-right: 10px; margin-bottom: 20px;">
                                            <button type="button" class="ui positive button btnSave" onclick="accionpersona(2)">MODIFICAR REGISTRO</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                                    </div>			
			<?php
			}//if
		}//if
	}//if
	if ($OpAccion == "modificar_personas_lote")
	{
		$AdministracionDAO = new AdministracionDAO();

		$cedula = $_POST["jscedula"];
		$carrera = $_POST["jscambcarr"];
		$semestre = $_POST["jscambsem"];
		$situacion = $_POST["jscambsit"];
			
		$Inic_matriz = array();	
		$matriz = array();				
		
		$Inic_matriz[0] = "Cedula";
		$matriz[0] = $cedula;
		if ($semestre <> "")
		{
			$Inic_matriz[1] = "Id_Semestre";
			$matriz[1] = $semestre;
		}
		if ($carrera <> "")
		{			
			$Inic_matriz[2] = "Id_Carrera";
			$matriz[2] = $carrera;
		}
		if ($situacion <> "")
		{
			$Inic_matriz[3] = "Id_Situacion";
			$matriz[3] = $situacion;
		}
		$where = "where (Cedula = '$cedula')";
		$ModReg = $AdministracionDAO -> Modificar_Registro("tbl_personas",$Inic_matriz,$matriz,$where);
		reg_bitac($_SESSION['usur'],"Persona","Modificar Registro Lote. Cedula: $cedula, IdSem: $semestre, IdCarr: $carrera, IdSit: $situacion ");		
	}
	if ($OpAccion == "buscar_personas_lote")
	{
		$AdministracionDAO = new AdministracionDAO();
		$Carrera = $_POST["carrerajs"];
		$Semestre = $_POST["semestrejs"];
		$IdOrder = $_POST["orderbyjs"];
		$Order = "Apellido1";
		if ($IdOrder == "1") {$Order = "Apellido1,Apellido2,Nombre1,Nombre2";}
		if ($IdOrder == "2") {$Order = "Cedula*1 Asc";}		
		?>
		<tbody class="student_table">
			<?php
			$list = $AdministracionDAO -> GetPersonaLote($Carrera,$Semestre,$Order);
			foreach ($list as $value)
			{
			?>		
			<tr style="cursor: pointer;text-transform: capitalize;">
				<td class="collapsing" style="text-align: center;vertical-align:middle;">
					<div class="checkbox">
						<input type="checkbox" name="dni[]" value="<?php echo $value[0];?>" class="order_dni person_check unchecked">
						<label style="padding:0 !important;" for="order_<?php echo $value[0];?>"></label>
					</div>
				</td>
				<td style="text-align:left; vertical-align:middle, padding-left: 2px;">
				<?php echo $value[0];?>
				</td>
				<td style="text-align:left; vertical-align:middle">
				<?php echo $value[3]." ".$value[4]." ".$value[1]." ".$value[2];?>
				</td>
			</tr>
			<?php
			}//for
			?>					
		</tbody>
		<?php
	}
	if ($OpAccion == "ModifLotes")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
	<div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="row show_order">
        <div class="col-md-offset-2 col-md-8 col-xs-offset-2 col-xs-8">
            <div class="white-box" style="padding: 0;">
                <div class="table-responsive">
                    <table class="ui compact celled table">
                        <thead>
                            <tr>
                                <th style="text-align: center; vertical-align: middle; text-transform: uppercase;">Cambios por lotes a grupos de personas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="ui form frmSelect" style="padding: 2px;">
                                        <div class="three fields">
                                            <div class="field">
                                                <label>CARRERA</label>
                                                <div class="ui fluid selection dropdown">
                                                    <input type="hidden" name="career" id="order_career" required value="">
                                                    <i class="dropdown icon"></i>
                                                    <div class="default text">Seleccionar una carrera</div>
                                                    <div class="menu">
															<?php
															$ConsCarrera = $AdministracionDAO -> GetCarreras();
															foreach ($ConsCarrera as $value)
															{
																?>
																	<div class="item" data-value="<?php echo $value[0];?>">
																		<?php echo $value[1];?>
																	</div>
																<?php
															}
															?>
													</div>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <label>SEMESTRE</label>
                                                <div class="ui fluid selection dropdown">
                                                    <input type="hidden" name="half" id="order_half" required value="1">
                                                    <i class="dropdown icon"></i>
                                                    <div class="default text">Seleccionar un semestre</div>
                                                    <div class="menu">
														<?php
															$lissem = $AdministracionDAO -> Getsemestre();
															foreach ($lissem as $value)
															{
																?>
																<div class="item" data-value="<?php echo $value[0];?>"><?php echo $value[1];?></div>
																<?php
															}
														?>
													</div>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <label>ORDERNAR POR</label>
                                                <div class="ui fluid selection dropdown">
                                                    <input type="hidden" name="order" id="order_type" required value="1">
                                                    <i class="dropdown icon"></i>
                                                    <div class="default text">Seleccionar</div>
                                                    <div class="menu">
                                                        <div class="item" data-value="1">Apellidos</div>
                                                        <div class="item" data-value="2">C&eacute;dula</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btnSearchStudent" style="text-align: right; margin-right: 10px; margin-bottom: 20px;">
                                        <button type="button" class="ui positive button btnOrderCheck" onclick="buscar_alumnos_lote()">BUSCAR ALUMNOS</button>
                                        &nbsp;
                                        <a href="javascript:menu_principal('ModifLotes','Administracion')" class="ui default button">REGRESAR</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="show_student"><?php // style="display: none;"?>
                                <td>
                                    <div class="table-responsive">
                                        <table class="ui compact celled definition table">
                                            <thead>
                                                <tr>
                                                    <td class="collapsing" style="width:10%;padding: 2px; text-align: center; vertical-align: middle;">
                                                        <div class="checkbox">
                                                            <input type="checkbox" id="order_all" class="unchecked" onclick="selec_todos_perslot()">
                                                            <label for="order_all">&nbsp;TODOS</label>
                                                        </div>
                                                    </td>
                                                    <th style="width:25%;text-align: center; vertical-align: middle;">CÉDULA</th>
                                                    <th style="width:65%;text-align: center; vertical-align: middle;">APELLIDOS Y NOMBRES</th>
                                                </tr>
                                            </thead>
                                            <tbody class="student_table" id="tabla_lot_estudiante"></tbody>
                                        </table>
                                    </div>
                                    <br>
                                    <div class="ui form" style="height: 240px; padding: 10px;">
                                        <div class="three fields">
                                            <div class="field">
                                                <div class="checkbox" style="margin: 0;">
                                                    <input name="change_career_check" type="checkbox" class="unchecked" id="change_career_check" onclick="act_cambiocheck('change_career_check','change_career')"/>
                                                    <label for="change_career_check" id="change_career_check_select">CAMBIAR CARRERA</label>
                                                </div>
                                                <div class="ui fluid selection dropdown change_career disabled">
                                                    <input type="hidden" name="change_career" id="change_career" required value="">
                                                    <i class="dropdown icon"></i>
                                                    <div class="default text">Seleccionar una carrera</div>
                                                    <div class="menu">
														<?php
														$ConsCarrera = $AdministracionDAO -> GetCarreras();
														foreach ($ConsCarrera as $value)
														{
															?>
																<div class="item" data-value="<?php echo $value[0];?>">
																	<?php echo $value[1];?>
																</div>
															<?php
														}
														?>
													</div>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <div class="checkbox" style="margin: 0;">
                                                    <input name="change_half_check" type="checkbox" class="unchecked" id="change_half_check" onclick="act_cambiocheck('change_half_check','change_half')"/>
                                                    <label for="change_half_check" id="change_half_check_select">CAMBIAR SEMESTRE</label>
                                                </div>
                                                <div class="ui fluid selection dropdown change_half disabled">
                                                    <input type="hidden" name="change_half" id="change_half" required value="1">
                                                    <i class="dropdown icon"></i>
                                                    <div class="default text">Seleccionar un semestre</div>
                                                    <div class="menu">
														<?php
															$lissem = $AdministracionDAO -> Getsemestre();
															foreach ($lissem as $value)
															{
																?>
																<div class="item" data-value="<?php echo $value[0];?>"><?php echo $value[1];?></div>
																<?php
															}
														?>
													</div>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <div class="checkbox" style="margin: 0;">
                                                    <input name="change_type_check" type="checkbox" class="unchecked" id="change_type_check" onclick="act_cambiocheck('change_type_check','change_type')"/>
                                                    <label for="change_type_check" id="change_type_check_select">CAMBIAR SITUACI&Oacute;N</label>
                                                </div>
                                                <div class="ui fluid selection dropdown change_type disabled">
                                                    <input type="hidden" name="change_type" id="change_type" required value="0" onchange="($(this).val() == 0 ? $('.retirement_date').hide() : $('.retirement_date').show())">
                                                    <i class="dropdown icon"></i>
                                                    <div class="default text">Seleccionar una situaci&oacute;n</div>
                                                    <div class="menu">
														<?php
														$ConsSit = $AdministracionDAO -> Getsituacion();
														foreach ($ConsSit as $value)
														{
															?>
																<div class="item" data-value="<?php echo $value[0];?>">
																	<?php echo $value[1];?>
																</div>
															<?php
														}
														?>
													</div>
                                                </div>
                                                <br>
                                                <div class="retirement_date" style="display: none;">
                                                    <div class="field">
                                                        <label>FECHA DE RETIRO</label>
                                                        <input type="text" readonly class="dateSelect" name="retirement_date" id="retirement_date" value="16/02/2021">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="text-align: right; margin-right: 10px; margin-bottom: 10px; margin-top: 10px;">
                                        <button type="button" class="ui positive button btnSaveStudent disabled" onclick="rea_cambios()">REALIZAR CAMBIOS</button>
                                        &nbsp;
                                        <button type="button" class="ui default button btnBackStudent disabled" onclick="menu_principal('ModifLotes','Administracion')">REGRESAR</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

	</div>
	<?php
	}
	if ($OpAccion == "CargarCuentaAgr")
	{
		$AdministracionDAO = new AdministracionDAO();
		$ConsCat = $AdministracionDAO -> GetCategoria($_SESSION['usur']);
		foreach ($ConsCat as $value)
		{
			?>													
			<li class="list-group-item" style="border-left: 5px solid <?php echo $value[2];?>; padding: 5px 15px;">
				<?php echo $value[1];?>
			</li>
			<?php
		}
	}
	if ($OpAccion == "CargarCuentaModTbl")
	{
		$AdministracionDAO = new AdministracionDAO();
		$ConsCat = $AdministracionDAO -> GetCategoria($_SESSION['usur']);
		foreach ($ConsCat as $value)
		{
			$cadBool = "true";
			if ($value[4] == "0") {$cadBool = "false";}													
			?>													
			<li class="list-group-item" style="border-left: 5px solid <?php echo $value[2];?>; padding: 5px 15px;">
				<div class="checkbox radio" style="margin: 0;">
					<input name="category_id" type="radio" value="<?php echo $value[0];?>" id="category_id" class="category_edit" data-id="<?php echo $value[0];?>" data-name="<?php echo $value[1];?>" data-color="<?php echo $value[2];?>" data-status="<?php echo $cadBool;?>" />
					<label for="category_<?php echo $value[0];?>" id="category_label_<?php echo $value[0];?>"><?php echo $value[1];?></label>
				</div>
			</li>
		<?php
		}
	}
	if ($OpAccion == "CrearCuenta")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
<div class="container-fluid"><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="row show_order">
        <div class="col-md-offset-1 col-md-9 col-xs-offset-1 col-xs-9">
            <div class="white-box" style="padding: 0;">
                <form id="frmSubmit" method="post">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">CUENTAS PAGO</th>
                                    <th style="text-align: center; vertical-align: middle; width: 350px;">CREAR NUEVA CUENTA DE PAGO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <ul class="list-group list-group-full" id="IdTabCuenta">
											<?php
												$ConsCat = $AdministracionDAO -> GetCategoria($_SESSION['usur']);
												foreach ($ConsCat as $value)
												{
													?>													
													<li class="list-group-item" style="border-left: 5px solid <?php echo $value[2];?>; padding: 5px 15px;">
														<?php echo $value[1];?>
													</li>
													<?php
												}
											?>
										</ul>
                                    </td>
                                    <td class="ui form">
                                        <div class="field">
                                            <label for="category_name">NOMBRE DE LA CUENTA</label>
                                            <input type="text" name="category_name" id="category_name" required="" autocomplete="off">
                                        </div>

                                        <div class="field">
                                            <label for="category_color">COLOR</label>
                                            <input type="color" name="category_color" id="category_color" readonly required="" autocomplete="off">
                                        </div>

                                        <div class="checkbox" style="margin: 0;">
                                            <input name="category_status" type="checkbox" id="category_status" />
                                            <label for="category_status" id="category_status_label"> ¿Activo?</label>
                                        </div>

                                        <div style="text-align: center; margin-top: 20px;">
                                            <button type="button" class="ui positive button btnSubmit" onclick="crearcuenta()">CREAR CUENTA</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                                    </div>		
		<?php
	}
	if ($OpAccion == "ModifCuenta")
	{
		$AdministracionDAO = new AdministracionDAO();
			?>
	<div class="container-fluid"><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="row show_order">
        <div class="col-md-offset-1 col-md-9 col-xs-offset-1 col-xs-9">
            <div class="white-box" style="padding: 0;">
                <form id="frmSubmit" method="post">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">CUENTAS PAGO</th>
                                    <th style="text-align: center; vertical-align: middle; width: 350px;">MODIFICAR CUENTA DE PAGO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <ul id="IdTabCuenta" class="list-group list-group-full" style="height: 315px; overflow-y: scroll;">
										<?php
										$ConsCat = $AdministracionDAO -> GetCategoria($_SESSION['usur']);
										foreach ($ConsCat as $value)
										{
											$cadBool = "true";
											if ($value[4] == "0") {$cadBool = "false";}													
											?>													
											<li class="list-group-item" style="border-left: 5px solid <?php echo $value[2];?>; padding: 5px 15px;">
												<div class="checkbox radio" style="margin: 0;">
													<input name="category_id" type="radio" value="<?php echo $value[0];?>" id="category_id" class="category_edit" data-id="<?php echo $value[0];?>" data-name="<?php echo $value[1];?>" data-color="<?php echo $value[2];?>" data-status="<?php echo $cadBool;?>" />
													<label for="category_<?php echo $value[0];?>" id="category_label_<?php echo $value[0];?>"><?php echo $value[1];?></label>
												</div>
											</li>
										<?php
										}
										?>
										</ul>
                                    </td>
                                    <td class="ui form">
                                        <div class="field">
                                            <label for="category_name">NOMBRE DE LA CUENTA</label>											
                                            <input type="hidden" name="id_category" id="id_category">
                                            <input type="text" name="category_name" id="category_name" required="" autocomplete="off">
                                        </div>

                                        <div class="field">
                                            <label for="category_color">COLOR</label>
                                            <input type="color" name="category_color" id="category_color" readonly required="" autocomplete="off">
                                        </div>

                                        <div class="checkbox" style="margin: 0;">
                                            <input name="category_status" type="checkbox" id="category_status" />
                                            <label for="category_status" id="category_status_label"> ¿Activo?</label>
                                        </div><br>
										<?php 
										$ValActivo = "disabled";
										if ($_SESSION['NivPerm_4'] == "1") {$ValActivo = "";}
										?>
                                        <div class="checkbox checkbox-danger" style="margin: 0;">
                                            <input name="category_delete" type="checkbox" id="category_delete" <?php echo $ValActivo;?> />
                                            <label for="category_delete" id="category_delete_label"> ¿Eliminar cuenta?</label>
                                        </div>

                                        <div style="text-align: center; margin-top: 20px;">
                                            <button type="button" class="ui positive button btnSubmit disabled" onclick="modifcuenta()">ACTUALIZAR CUENTA</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

	</div>
			<?php
	}
	if ($OpAccion == "CargarCoorAgr")
	{
		$AdministracionDAO = new AdministracionDAO();
		$ListCoor = $AdministracionDAO -> GetCoordinacion($_SESSION['usur']);
		foreach ($ListCoor as $value)
		{
			?>
			<li class="list-group-item" style="padding: 5px 15px;">
				<?php echo $value[1];?>
			</li>
			<?php
		}
	}
	if ($OpAccion == "CargarMoneda")
	{		
		$AdministracionDAO = new AdministracionDAO();
		$ListMon = $AdministracionDAO -> Getmoneda();
		foreach ($ListMon as $value)
		{
			?>
				<li class="list-group-item" style="padding: 5px 15px;">
					<?php echo $value[1].". (".$value[4].")";?>
				</li>
			<?php
		}
	}	
	if ($OpAccion == "CargarMonedaModif")
	{		
		$AdministracionDAO = new AdministracionDAO();
		$ListMon = $AdministracionDAO -> Getmoneda();
		foreach ($ListMon as $value)
		{
			?>
				<li class="list-group-item" style="padding: 5px 15px;">
					<input name="moneda_id" type="radio" value="<?php echo $value[0];?>" id="moneda_id<?php echo $value[0];?>" class="moneda_edit" data-id="<?php echo $value[0];?>" data-name="<?php echo $value[1];?>" data-names="<?php echo $value[2];?>" data-abr="<?php echo $value[3];?>" data-simb="<?php echo $value[4];?>" />
					<?php echo $value[1].". (".$value[4].")";?>
				</li>
			<?php
		}
	}	
	if ($OpAccion == "CrearMoneda")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
		<div class="container-fluid">
                        <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="row show_order">
        <div class="col-md-offset-1 col-md-9 col-xs-offset-1 col-xs-9">
            <div class="white-box" style="padding: 0;">
                <form id="frmSubmit" method="post">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">MONEDAS EXISTENTES</th>
                                    <th style="text-align: center; vertical-align: middle; width: 350px;">CREAR UNA MONEDA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <ul class="list-group list-group-full" id="IdMoneda">
										<?php
											$ListCoor = $AdministracionDAO -> Getmoneda();
											foreach ($ListCoor as $value)
											{
												?>
												<li class="list-group-item" style="padding: 5px 15px;">
													<?php echo $value[1].". (".$value[4].")";?>
												</li>
												<?php
											}
										?>										
										</ul>
                                    </td>
                                    <td class="ui form">
                                        <div class="field">
                                            <label for="coordination_name">NOMBRE DE LA MONEDA</label>
                                            <input type="text" name="moneda_name" id="moneda_name" required="" autocomplete="off">
                                        </div>

                                        <div class="field">
                                            <label for="coordination_name">NOMBRE DE LA MONEDA (PLURAL)</label>
                                            <input type="text" name="monedas_name" id="monedas_name" required="" autocomplete="off">
                                        </div>
										
                                        <div class="field">
                                            <label for="category_name">ABREVIATURA</label>
                                            <input type="text" name="moneda_abrev" id="moneda_abrev" required="" autocomplete="off">
                                        </div>

                                        <div class="field">
                                            <label for="category_color">SIMBOLO</label>
                                            <input type="text" name="moneda_simb" id="moneda_simb" required="" autocomplete="off">
                                        </div>

                                        <div style="text-align: center; margin-top: 20px;">
                                            <button type="button" class="ui positive button btnSubmit" onclick="guardarmon('1')">CREAR MONEDA</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

		</div>
		<?php
	}	
	if ($OpAccion == "ModifMoneda")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
		<div class="container-fluid">
                        <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="row show_order">
        <div class="col-md-offset-1 col-md-9 col-xs-offset-1 col-xs-9">
            <div class="white-box" style="padding: 0;">
                <form id="frmSubmit" method="post">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">MONEDAS EXISTENTES</th>
                                    <th style="text-align: center; vertical-align: middle; width: 350px;">MODIFICAR UNA MONEDA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <ul class="list-group list-group-full" id="IdMoneda">
										<?php
											$ListCoor = $AdministracionDAO -> Getmoneda();
											foreach ($ListCoor as $value)
											{
												?>
												<li class="list-group-item" style="padding: 5px 15px;">
													<input name="moneda_id" type="radio" value="<?php echo $value[0];?>" id="moneda_id<?php echo $value[0];?>" class="moneda_edit" data-id="<?php echo $value[0];?>" data-name="<?php echo $value[1];?>" data-names="<?php echo $value[2];?>" data-abr="<?php echo $value[3];?>" data-simb="<?php echo $value[4];?>" />
													<?php echo $value[1].". (".$value[4].")";?>
												</li>
												<?php
											}
										?>										
										</ul>
                                    </td>
                                    <td class="ui form">
										<input type="hidden" name="moneda_id_val" id="moneda_id_val">
                                        <div class="field">
                                            <label for="coordination_name">NOMBRE DE LA MONEDA</label>
                                            <input type="text" name="moneda_name" id="moneda_name" required="" autocomplete="off">
                                        </div>

                                        <div class="field">
                                            <label for="coordination_name">NOMBRE DE LA MONEDA (PLURAL)</label>
                                            <input type="text" name="monedas_name" id="monedas_name" required="" autocomplete="off">
                                        </div>
										
                                        <div class="field">
                                            <label for="category_name">ABREVIATURA</label>
                                            <input type="text" name="moneda_abrev" id="moneda_abrev" required="" autocomplete="off">
                                        </div>

                                        <div class="field">
                                            <label for="category_color">SIMBOLO</label>
                                            <input type="text" name="moneda_simb" id="moneda_simb" required="" autocomplete="off">
                                        </div>

                                        <div style="text-align: center; margin-top: 20px;">
                                            <button type="button" class="ui positive button btnSubmit" onclick="guardarmon('2')">MODIFICAR MONEDA</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

		</div>
		<?php
	}
	if ($OpAccion == "CrearCoordinacion")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
		<div class="container-fluid">
                        <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="row show_order">
        <div class="col-md-offset-1 col-md-9 col-xs-offset-1 col-xs-9">
            <div class="white-box" style="padding: 0;">
                <form id="frmSubmit" method="post">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">COORDINACIONES EXISTENTES</th>
                                    <th style="text-align: center; vertical-align: middle; width: 350px;">CREAR UNA COORDINACIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <ul class="list-group list-group-full" id="IdCoordinacion">
										<?php
											$ListCoor = $AdministracionDAO -> GetCoordinacion($_SESSION['usur']);
											foreach ($ListCoor as $value)
											{
												?>
												<li class="list-group-item" style="padding: 5px 15px;">
													<?php echo $value[1];?>
												</li>
												<?php
											}
										?>										
										</ul>
                                    </td>
                                    <td class="ui form">
                                        <div class="field">
                                            <label for="coordination_name">NOMBRE DE LA COORDINACIÓN</label>
                                            <input type="text" name="coordination_name" id="coordination_name" required="" autocomplete="off">
                                        </div>

                                        <div style="text-align: center; margin-top: 20px;">
                                            <button type="button" class="ui positive button btnSubmit" onclick="crearcoord()">CREAR COORDINACIÓN</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

		</div>
		<?php
	}
	if ($OpAccion == "CargarCoorMod")
	{
		$AdministracionDAO = new AdministracionDAO();
		$ListCoor = $AdministracionDAO -> GetCoordinacion($_SESSION['usur']);
		foreach ($ListCoor as $value)
		{
			?>												
			<li class="list-group-item" style="padding: 5px 15px;">
				<div class="checkbox radio" style="margin: 0;">
					<input name="coordination_id" type="radio" value="<?php echo $value[0];?>" id="coordination_<?php echo $value[1];?>" class="coordination_edit" data-id="<?php echo $value[0];?>" data-name="<?php echo $value[1];?>" />
					<label for="coordination_<?php echo $value[1];?>" id="coordination_label_<?php echo $value[1];?>"><?php echo $value[1];?></label>
				</div>
			</li>
			<?php
		}
	}
	if ($OpAccion == "ModifCoordin")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
		<div class="container-fluid"><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                        <div class="row show_order">
        <div class="col-md-offset-1 col-md-9 col-xs-offset-1 col-xs-9">
            <div class="white-box" style="padding: 0;">
                <form id="frmSubmit" method="post">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">COORDINACIONES EXISTENTES</th>
                                    <th style="text-align: center; vertical-align: middle; width: 350px;">MODIFICAR UNA COORDINACIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <ul class="list-group list-group-full" style="height: 315px; overflow-y: scroll;" id="IdCoordinacion">
										<?php
											$ListCoor = $AdministracionDAO -> GetCoordinacion($_SESSION['usur']);
											foreach ($ListCoor as $value)
											{
												?>												
												<li class="list-group-item" style="padding: 5px 15px;">
                                                    <div class="checkbox radio" style="margin: 0;">
                                                        <input name="coordination_id" type="radio" value="<?php echo $value[0];?>" id="coordination_<?php echo $value[1];?>" class="coordination_edit" data-id="<?php echo $value[0];?>" data-name="<?php echo $value[1];?>" />
                                                        <label for="coordination_<?php echo $value[1];?>" id="coordination_label_<?php echo $value[1];?>"><?php echo $value[1];?></label>
                                                    </div>
                                                </li>
												<?php
											}
										?>										
										</ul>
                                    </td>
                                    <td class="ui form">
                                        <div class="field">
                                            <label for="coordination_name">NOMBRE DE LA COORDINACIÓN</label>
                                            <input type="text" name="coordination_name" id="coordination_name" required="" autocomplete="off">
                                            <input type="hidden" name="id_coordination" id="id_coordination">
                                        </div>
										<?php 
										$ValActivo = "disabled";
										if ($_SESSION['NivPerm_4'] == "1") {$ValActivo = "";}
										?>
                                        <div class="checkbox checkbox-danger" style="margin: 0;">
                                            <input name="coordination_delete" type="checkbox" id="coordination_delete" <?php echo $ValActivo;?> />
                                            <label for="coordination_delete" id="coordination_delete_label"> ¿Eliminar coordinación?</label>
                                        </div>

                                        <div style="text-align: center; margin-top: 20px;">
                                            <button type="button" class="ui positive button btnSubmit disabled" onclick="modifcoord()">ACTUALIZAR</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
                                </div>
                            </div>
                        </div>
                    </div>

		</div>
		<?php
	}	
	if ($OpAccion == "CrearUsuarios")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>				
		<div class="container-fluid"><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
		<form method="post" id="frmSubmit">
        <div class="row show_order">
            <div class="col-md-offset-2 col-md-8 col-xs-offset-2 col-xs-8">
                <div class="white-box" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: left; vertical-align: middle;">

                                        <div class="ui form frmSelect" style="padding: 10px;">
											<div class="two fields">
												<div class="field">
													<label>CREAR USUARIO</label>
												</div>
												<div class="field">
													<div class="ui fluid selection dropdown">
														<input type="hidden" name="tipo" id="tipo" required>
														<i class="dropdown icon"></i>
														<div class="default text">Seleccionar un Tipo de Usuario</div>
														<div class="menu">
															<div class="item" data-value="Administrador">Administrador</div>
															<div class="item" data-value="Usuario">Usuario</div>
															<div class="item" data-value="Invitado">Invitado</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="ui form frmSelect" style="padding: 10px;">
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>C&Eacute;DULA</label>
                                                    <input data-mask="##00000000" required maxlength="8" type="text" name="dni" id="dni" value="" class="dni">
                                                </div>
                                                <div class="field">
                                                    <label>NOMBRE COMPLETO</label>
                                                    <input  minlength="6" maxlength="60" type="text" name="name" id="name" value="">
                                                </div>
                                            </div>
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>E-MAIL</label>
                                                    <input type="email" name="email" id="email" required value="">
                                                </div>
                                                <div class="field">
                                                    <label>USUARIO</label>
                                                    <input minlength="4" data-mask="SSSSSSSSSSSSSSS" maxlength="15" type="text" name="username" id="username" value="">
                                                </div>
                                            </div>
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>CONTRASE&Ntilde;A</label>
                                                    <input minlength="6" type="password" name="password" id="password" required value="">
                                                </div>
                                                <div class="field">
                                                    <label>REPITA CONTRASE&Ntilde;A</label>
                                                    <input minlength="6" type="password" name="password_repeat" id="password_repeat" required value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btnSearchStudent" style="text-align: right; margin-right: 10px; margin-bottom: 20px;">
                                            <button type="button" class="ui positive button btnSave" onclick="crearusus()">AGREGAR USUARIO</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
		</form>
                                </div>
                            </div>
                        </div>
                    </div>

		</div>
		<?php
	}
	if ($OpAccion == "ModifUsuarios")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
		<br>
		<div class="col-md-offset-4 col-md-8 col-xs-offset-1 col-xs-6">
		<form method="post" class="frmUsername ui form">
			<div class="field" style="width: 260px;">
				<div class="ui action left icon input">
					<div class="ui fluid selection dropdown" align="center">
						<input type="hidden" name="iduser" id="iduser" required>
						<i class="dropdown icon"></i>
						<div class="default text">Seleccionar un usuario</div>
							<div class="menu">
								<?php
									$usur = $AdministracionDAO -> GetUsuarios();
									foreach ($usur as $value)
									{
										?>
										<div class="item cuser_<?php echo $value[2];?>" data-value="<?php echo $value[2];?>" data-dni="<?php echo $value[0];?>" data-nombre="<?php echo $value[1];?>" data-usuario="<?php echo $value[2];?>" data-tipo="<?php echo $value[3];?>" data-email="<?php echo $value[4];?>" >
											<i class="user icon"></i>
											<?php echo $value[2];?>
										</div>
										<?php
									}
								?>
							</div>
					</div>
					<button class="ui red icon button btnUsername">
						<i class="search icon"></i>
					</button>
				</div>
			</div>
		</form>
		</div>
		<div class="container-fluid"><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
			<form method="post" id="frmSubmit">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="username" value="1">
        <div class="row show_order">
            <div class="col-md-offset-2 col-md-8 col-xs-offset-2 col-xs-8">
                <div class="white-box" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: left; vertical-align: middle;">
                                        <div class="ui form frmSelect" style="padding: 10px;">
											<div class="two fields">
												<div class="field">
													<label>MODIFICAR USUARIO</label>
												</div>
												<div class="field">
													<div class="ui fluid selection dropdown">
														<input type="hidden" name="tipo" id="tipo" required>
														<i class="dropdown icon"></i>
														<div class="default text">Seleccionar un Tipo de Usuario</div>
														<div class="menu">
															<div class="item" data-value="Administrador">Administrador</div>
															<div class="item" data-value="Usuario">Usuario</div>
															<div class="item" data-value="Invitado">Invitado</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="ui form frmSelect" style="padding: 10px;">
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>C&Eacute;DULA</label>
                                                    <input data-mask="##00000000" required maxlength="8" type="text" name="dni" value="" id="dni">
                                                </div>
                                                <div class="field">
                                                    <label>NOMBRE COMPLETO</label>
                                                    <input minlength="6" maxlength="60" type="text" name="name" id="name" value="">
                                                </div>
                                            </div>
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>E-MAIL</label>
                                                    <input type="email" name="email" id="email" required value="">
                                                </div>
                                                <div class="field">
                                                    <label>USUARIO</label>
                                                    <input minlength="4" data-mask="SSSSSSSSSSSSSSS" readonly maxlength="15" type="text" name="username_" id="username" value="">
                                                </div>
                                            </div>
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>CONTRASE&Ntilde;A</label>
                                                    <input minlength="6" type="password" name="password" id="password" value="">
                                                </div>
                                                <div class="field">
                                                    <label>REPITA CONTRASE&Ntilde;A</label>
                                                    <input minlength="6" type="password" name="password_repeat" id="password_repeat" value="">
                                                </div>
                                            </div>
                                        </div>


										<?php 
										$ValActivo = "disabled";
										if ($_SESSION['NivPerm_7'] == "1") {$ValActivo = "";}
										?>
                                        <div class="checkbox checkbox-danger" style="margin: 0;">
                                            <input name="user_delete" type="checkbox" id="user_delete" <?php echo $ValActivo;?> />
                                            <label for="user_delete" id="user_delete_label"> ¿Eliminar usuario?</label>
                                        </div>										
                                        <div class="btnSearchStudent" style="text-align: right; margin-right: 10px; margin-bottom: 20px;">
                                            <button type="button" class="ui positive button btnSave disabled" onclick="guardarusu()">GUARDAR USUARIO</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                                    </div>
		<?php
	}
	if ($OpAccion == "Modificconfparam")
	{
		$AdministracionDAO = new AdministracionDAO();
		$Id = $_POST["Idjs"];
		$Nombre = $_POST["Nombrejs"];
		$Direccion = $_POST["Direccionjs"];
		$Poblacion = $_POST["Poblacionjs"];
		$RIF = $_POST["RIFjs"];
		$Telefono = $_POST["Telefonojs"];
		$Lap_Act = $_POST["Lap_Actjs"];
		$Lap_Sig = $_POST["Lap_Sigjs"];
		$Semilla = $_POST["Semillajs"];		
		$Inic_matriz = array("Nombre", "Direccion", "Poblacion", "RIF", "Telefono", "Lap_Act", "Lap_Sig", "Semilla");	
		$matriz = array($Nombre, $Direccion, $Poblacion, $RIF, $Telefono, $Lap_Act, $Lap_Sig, $Semilla);	
		$where = "where (Id = '$Id')";
		$ModProd = $AdministracionDAO -> Modificar_Registro("tbl_empresa",$Inic_matriz,$matriz,$where);	
		reg_bitac($_SESSION['usur'],"Configuracion","Modificar Parametros. $Nombre, Dir.: Direccion, Pobl: $Poblacion, RIF: $RIF, Tel: $Telefono, Semilla: $Semilla");
	}
	if ($OpAccion == "ConfParam")
	{
		$AdministracionDAO = new AdministracionDAO();
		$Confparam = $AdministracionDAO -> GetEmpresa();
		foreach ($Confparam as $value)
		{
			$Id = $value[0];
			$Nombre = $value[1];
			$Direccion = $value[2];
			$Poblacion = $value[3];
			$RIF = $value[4];
			$Telefono = $value[5];
			$Lap_Act = $value[6];
			$Lap_Sig = $value[7];
			$Semilla = $value[8];
		}
		?>
		<input name="Id" id="Id" type="hidden" value="<?php echo $Id;?>">
		<div class="container-fluid">
                        <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
		<form method="post" id="frmSubmit" class="ui form">
        <div class="row show_order">
            <div class="col-md-offset-2 col-md-8 col-xs-offset-2 col-xs-8">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <span class="titulo">Configurar parámetros</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="field">
                                        <label>Lapso Actual</label>
                                        <input data-mask="0-0000" maxlength="6" type="text" name="period_current" id="period_current" required="" value="<?php echo $Lap_Act;?>" autocomplete="off">
                                    </div>
                                    <div class="field">
                                        <label>Lapso Siguiente</label>
                                        <input data-mask="0-0000" maxlength="6" type="text" name="period_next" id="period_next" required="" value="<?php echo $Lap_Sig;?>" autocomplete="off">
                                    </div>
                                    <div class="field">
                                        <label>Semilla</label>
                                        <input data-mask="00" maxlength="2" type="text" min="3" max="30" name="code" id="code" required="" value="<?php echo $Semilla;?>" autocomplete="off">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="checkbox radio radio-danger" style="margin: 0;">
                        <input name="category_delete" value="set" type="radio" id="category_delete" />
                        <label for="category_delete" id="category_delete_label"> Marcar a las personas como inasistentes para la reinscripción</label>
                    </div>
                    <br>
                    <div class="checkbox radio radio-danger" style="margin: 0;">
                        <input name="category_delete" value="revert" type="radio" id="category_delete_revert" />
                        <label for="category_delete_revert" id="category_delete_revert_label"> Revierte al estatus de activo a los marcados hoy como inasistentes</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    <span class="titulo">Datos Instituto</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="field">
                                        <label>Nombre</label>
                                        <input type="text" name="name" id="name" required="" value="<?php echo $Nombre;?>" autocomplete="off">
                                    </div>
                                    <div class="field">
                                        <label>Dirección</label>
                                        <input type="text" name="address" id="address" required="" value="<?php echo $Direccion;?>" autocomplete="off">
                                    </div>
                                    <div class="field">
                                        <label>Población</label>
                                        <input type="text" name="population" id="population" required="" value="<?php echo $Poblacion;?>" autocomplete="off">
                                    </div>
                                    <div class="field">
                                        <label>RIF</label>
                                        <input data-mask="J-99999999-9" type="text" name="rif" id="rif" required="" value="<?php echo $RIF;?>" autocomplete="off">
                                    </div>
                                    <div class="field">
                                        <label>Teléfono</label>
                                        <input data-mask="(9999) 999-9999" type="text" name="phone" id="phone" required="" value="<?php echo $Telefono;?>" autocomplete="off">
                                    </div>

                                    <center>
                                        <button type="button" class="ui button positive btnSave" onclick="guardarconfparam()">GUARDAR CAMBIOS</button>
                                    </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
		</form>
                                </div>
                            </div>
                        </div>
                    </div>

		</div>
	<?php		
	}
	if ($OpAccion == "mod_permission")
	{
		$User = $_POST["userjs"];
		$Perm = $_POST["permjs"];
		$param = $_POST["paramjs"];
		if ($param == "SobreCoord") {$Campo = "Id_Coor";$Tabla = "tbl_usurper_coor";}							
		if ($param == "SobreCuent") {$Campo = "Id_Categoria";$Tabla = "tbl_usurper_cuent";}							
		if ($param == "SobrePag")   {$Campo = "Id_Pag";$Tabla = "tbl_usurper_pag";}							
		$AdministracionDAO = new AdministracionDAO();
		$Buscperm = $AdministracionDAO -> GetUsurCoor($Tabla,$Campo,$User,$Perm);
		$CadValid = "";
		$Validacion = "";
		foreach ($Buscperm as $value) {$CadValid = $value[0];}
		if ($CadValid == "") {$Validacion = "0";} else {$Validacion = "1";}
		echo '{"Permiso":"'.$Perm.'","Valid":"'.$Validacion.'"}';
	}
	if ($OpAccion == "eliminarusu")
	{
		$AdministracionDAO = new AdministracionDAO();
		$usern = $_POST["usernamejs"];
		$where = "where (usur = '$usern')";
		$param = $_POST["paramjs"];
		if ($param == "SobreCoord") {$Tabla = "tbl_usurper_coor";}							
		if ($param == "SobreCuent") {$Tabla = "tbl_usurper_cuent";}							
		if ($param == "SobrePag")   {$Tabla = "tbl_usurper_pag";}							
		$usurdel = $AdministracionDAO -> Eliminar_Registro($Tabla,$where);
	}
	if ($OpAccion == "agregarusumov")
	{
		$AdministracionDAO = new AdministracionDAO();
		$usern = $_POST["usernamejs"];		
		$perm = $_POST["permjs"];		
		$param = $_POST["paramjs"];
		if ($param == "SobreCoord") {$Tabla = "tbl_usurper_coor";}							
		if ($param == "SobreCuent") {$Tabla = "tbl_usurper_cuent";}							
		if ($param == "SobrePag")   {$Tabla = "tbl_usurper_pag";}							
		$matriz = array($usern,$perm);	
        $AgrProd = $AdministracionDAO -> Crear_Registro($Tabla,$matriz);		
		reg_bitac($_SESSION['usur'],"Permisos $param","Modificar Configuracion");
	}
	if (($OpAccion == "SobreCoord") or ($OpAccion == "SobreCuent") or ($OpAccion == "SobrePag"))
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
		<br>
		<div class="col-md-offset-4 col-md-8 col-xs-offset-1 col-xs-6">
		<form method="post" class="frmUsername ui form">
			<div class="field" style="width: 260px;">
				<div class="ui action left icon input">
					<div class="ui fluid selection dropdown" align="center">
						<input type="hidden" name="iduserCoor" id="iduserCoor" required>
						<i class="dropdown icon"></i>
						<div class="default text">Seleccionar un usuario</div>
							<div class="menu">
								<?php
									$usur = $AdministracionDAO -> GetUsuarios();
									foreach ($usur as $value)
									{
										?>
										<div class="item cuser_<?php echo $value[2];?>" data-value="<?php echo $value[5];?>">
											<i class="user icon"></i>
											<?php echo $value[2];?>
										</div>
										<?php
									}
								?>
							</div>
					</div>
					<button class="ui red icon button btnUsername">
						<i class="search icon"></i>
					</button>
				</div>
			</div>
		</form>
		</div>
		<div class="container-fluid"><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
			<form method="post" id="frmSubmit">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="username">
        <div class="row show_order">
            <div class="col-md-offset-1 col-md-10 col-xs-offset-1 col-xs-10">
                <div class="white-box" style="padding: 0;">
                    <div class="table-responsive">
					<?php
						if ($OpAccion == "SobreCoord") {$Nombr = "COORDINACIONES";$Campo ="Id_Coor";$Tabla = "tbl_coordinacion";}							
						if ($OpAccion == "SobreCuent") {$Nombr = "CUENTAS";$Campo ="Id_Categoria";$Tabla = "tbl_categoria";}							
						if ($OpAccion == "SobrePag")   {$Nombr = "PAGINAS";$Campo ="Id_Pag";$Tabla = "tbl_pagina";}							
					?>
						<input type="hidden" name="idaccion" id="idaccion" value="<?php echo $OpAccion;?>">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th colspan="3" style="text-align: left; vertical-align: middle;">
										<label>PERMISOS SOBRE <?php echo $Nombr;?> ( 
										<input name="selectodos" type="checkbox" id="selectodos"/>
										SELECCIONAR TODO
										)</label>									
									</th>
                                </tr>
                            </thead>
							<tbody>
							<?php
							$ContRow = 0;
							$coord = $AdministracionDAO -> GetCoor($Tabla);							
							foreach ($coord as $value)
							{
								if ($ContRow % 3 == 0) {echo "<tr>";}
								$ContRow = $ContRow + 1;
								//GetUsurCoor($usuario)
								?>
								<td style="text-align: center;">
									<div class="field">
										<div class="checkbox" style="margin: 0; text-align: left;">
											<input name="permissions[]" value="<?php echo $value[0];?>" type="checkbox" id="permission_<?php echo $value[0];?>" />
											<label for="permission_<?php echo $value[0];?>" id="permission_label_<?php echo $value[0];?>"><?php echo $value[1];?></label>
										</div>
									</div>
								</td>
								<?php		
								if ($ContRow % 3 == 0) {echo "</tr>";}
							}//foreach
								if ($ContRow % 3 == 1) {echo "<td>&nbsp;</td><td>&nbsp;</td></tr>";}
								if ($ContRow % 3 == 2) {echo "<td>&nbsp;</td></tr>";}
							?>
                                <tr>
                                    <td colspan="3" style="text-align: right; vertical-align: middle;">
										<button type="button" class="ui positive button btnSave disabled" onclick="guardarpermusu('<?php echo $OpAccion;?>')">GUARDAR CAMBIOS</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
                                </div>
                            </div>
                        </div>
                    </div>

		</div>
		<?php
	}
	if ($OpAccion == "Bitac")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
		<br>
		<div class="col-md-offset-1 col-md-8 col-xs-offset-1 col-xs-6">
		<form method="post" class="frmUsername ui form">
			<div class="field" style="width: 260px;">
				<div class="ui action left icon input">
					<div class="ui fluid selection dropdown" align="center">
						<input type="hidden" name="iduserBitcar" id="iduserBitcar" required>
						<i class="dropdown icon"></i>
						<div class="default text">Seleccionar una fecha</div>
							<div class="menu">
								<?php
									$usur = $AdministracionDAO -> GetFechBit();
									foreach ($usur as $value)
									{
										?>
										<div class="item cuser" data-value="<?php echo $value[0];?>">
											<i class="fa fa-calendar"></i>
											<?php echo substr($value[0],6,2)."/".substr($value[0],4,2)."/".substr($value[0],0,4);?>
										</div>
										<?php
									}
								?>
							</div>
					</div>
					<button class="ui red icon button btnUsername">
						<i class="search icon"></i>
					</button>
				</div>
			</div>
		</form>
		</div>		
		<div id="Pag_Rep_Bitac" class="col-md-offset-1 col-md-10 col-xs-offset-1 col-xs-6"></div>
		<?php
	}		
	if ($OpAccion == "Busc_Bitcar_Fech")
	{
			$Fecha = $_POST["fechbitjs"];
			$AdministracionDAO = new AdministracionDAO();
			?>
			<table class="ui compact celled table">
				<thead>
					<tr>
						<th colspan="3" style="text-align: left; vertical-align: middle;">BITACORA</th>
					</tr>
					<tr>
						<th width="10%" style="font-size:12px;text-align: center; vertical-align: middle;">HORA</th>
						<th width="20%" style="font-size:12px;text-align: center; vertical-align: middle; padding: 0;">MODULO</th>
						<th width="70%" style="font-size:12px;text-align: center; vertical-align: middle;">ACCION</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$Bitac = $AdministracionDAO -> GetBitacr($Fecha);
					foreach ($Bitac as $value)
					{
					?>
					<tr>
						<td style="text-align: center; vertical-align: middle;"><?php echo $value[0];?></td>
						<td style="text-align: center; vertical-align: middle; padding: 0;"><?php echo $value[1];?></td>
						<td style="text-align: center; vertical-align: middle;"><?php echo $value[2];?></td>
					</tr>
					<?php						
					}
					?>
				</tbody>
			</table>
	<?php
	}

	if ($OpAccion == "CrearUsurEstTbl")
	{
		$AdministracionDAO = new AdministracionDAO();
		$dni = $_POST["dnijs"]; 
		$Nombre = $_POST["namejs"]; 
		$email = $_POST["emailjs"];
		$usuario = $_POST["usuariojs"]; 
		$username = $_POST["usernamejs"]; 
		$passwords = $_POST["passwordjs"]; 
		$matriz = array($dni, $Nombre, $usuario, $username, $passwords, $email);	
        $AgrProd = $AdministracionDAO -> Crear_Registro("tbl_usu_alum",$matriz);
		reg_bitac($_SESSION['usur'],"Usuarios Estudiantes","Agregar Registro. $Nombre, Correo: $email,");				
	}

	if ($OpAccion == "CrearUsuariosEst")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>				
		<div class="container-fluid"><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
		<form method="post" id="frmSubmit">
        <div class="row show_order">
            <div class="col-md-offset-2 col-md-8 col-xs-offset-2 col-xs-8">
                <div class="white-box" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: left; vertical-align: middle;">

                                        <div class="ui form frmSelect" style="padding: 10px;">
											<div class="two fields">
												<div class="field">
													<label>CREAR USUARIO PARA ESTUDIANTES</label>
												</div>
											</div>
										</div>
									</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="ui form frmSelect" style="padding: 10px;">
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>C&Eacute;DULA</label>
                                                    <input data-mask="##00000000" required maxlength="8" type="text" name="dni" id="dni" value="" class="dni">
                                                </div>
                                                <div class="field">
                                                    <label>NOMBRE COMPLETO</label>
                                                    <input  minlength="6" maxlength="60" type="text" name="name" id="name" value="">
                                                </div>
                                            </div>
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>E-MAIL</label>
                                                    <input type="email" name="email" id="email" required value="">
                                                </div>
                                                <div class="field">
                                                    <label>USUARIO</label>
                                                    <input minlength="4" data-mask="SSSSSSSSSSSSSSS" maxlength="15" type="text" name="username" id="username" value="">
                                                </div>
                                            </div>
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>CONTRASE&Ntilde;A</label>
                                                    <input minlength="6" type="password" name="password" id="password" required value="">
                                                </div>
                                                <div class="field">
                                                    <label>REPITA CONTRASE&Ntilde;A</label>
                                                    <input minlength="6" type="password" name="password_repeat" id="password_repeat" required value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btnSearchStudent" style="text-align: right; margin-right: 10px; margin-bottom: 20px;">
                                            <button type="button" class="ui positive button btnSave" onclick="crearususest()">AGREGAR USUARIO</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
		</form>
                                </div>
                            </div>
                        </div>
                    </div>

		</div>
		<?php
	}
	
	if ($OpAccion == "ModificUsurTblEst")
	{
		$AdministracionDAO = new AdministracionDAO();
		$dni = $_POST["dnijs"]; 
		$Nombre = $_POST["namejs"]; 
		$email = $_POST["emailjs"];
		$usuario = $_POST["usuariojs"]; 
		$username = $_POST["usernamejs"]; 
		$passwords = $_POST["passwordjs"]; 
		$Inic_matriz = array("dni","nombre","clav","email");	
		$matriz = array($dni, $Nombre, $passwords, $email);	
		if ($passwords == "**")
		{
			$Inic_matriz = array("dni","nombre","email");	
			$matriz = array($dni, $Nombre, $email);				
		}
		$where = "where (usur = '$username')";
		$ModProd = $AdministracionDAO -> Modificar_Registro("tbl_usu_alum",$Inic_matriz,$matriz,$where);				
		reg_bitac($_SESSION['usur'],"Usuarios","Modificar Registro. $Nombre, Correo: $email,");		
	}

	if ($OpAccion == "ModifUsuariosEst")
	{
		$AdministracionDAO = new AdministracionDAO();
		?>
		<br>
		<div class="col-md-offset-4 col-md-8 col-xs-offset-1 col-xs-6">
		<form method="post" class="frmUsername ui form">
			<div class="field" style="width: 260px;">
				<div class="ui action left icon input">
					<div class="ui fluid selection dropdown" align="center">
						<input type="hidden" name="iduser" id="iduser" required>
						<i class="dropdown icon"></i>
						<div class="default text">Seleccionar un usuario</div>
							<div class="menu">
								<?php
									$usur = $AdministracionDAO -> GetUsuariosEst();
									foreach ($usur as $value)
									{
										?>
										<div class="item cuser_<?php echo $value[2];?>" data-value="<?php echo $value[2];?>" data-dni="<?php echo $value[0];?>" data-nombre="<?php echo $value[1];?>" data-usuario="<?php echo $value[2];?>" data-email="<?php echo $value[3];?>" >
											<i class="user icon"></i>
											<?php echo $value[2];?>
										</div>
										<?php
									}
								?>
							</div>
					</div>
					<button class="ui red icon button btnUsername">
						<i class="search icon"></i>
					</button>
				</div>
			</div>
		</form>
		</div>
		<div class="container-fluid"><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
			<form method="post" id="frmSubmit">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="username" value="1">
        <div class="row show_order">
            <div class="col-md-offset-2 col-md-8 col-xs-offset-2 col-xs-8">
                <div class="white-box" style="padding: 0;">
                    <div class="table-responsive">
                        <table class="ui compact celled table">
                            <thead>
                                <tr>
                                    <th style="text-align: left; vertical-align: middle;">
                                        <div class="ui form frmSelect" style="padding: 10px;">
											<div class="two fields">
												<div class="field">
													<label>MODIFICAR USUARIO PARA ESTUDIANTES</label>
												</div>
											</div>
										</div>
									</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="ui form frmSelect" style="padding: 10px;">
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>C&Eacute;DULA</label>
                                                    <input data-mask="##00000000" required maxlength="8" type="text" name="dni" value="" id="dni">
                                                </div>
                                                <div class="field">
                                                    <label>NOMBRE COMPLETO</label>
                                                    <input minlength="6" maxlength="60" type="text" name="name" id="name" value="">
                                                </div>
                                            </div>
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>E-MAIL</label>
                                                    <input type="email" name="email" id="email" required value="">
                                                </div>
                                                <div class="field">
                                                    <label>USUARIO</label>
                                                    <input minlength="4" data-mask="SSSSSSSSSSSSSSS" readonly maxlength="15" type="text" name="username_" id="username" value="">
                                                </div>
                                            </div>
                                            <div class="two fields">
                                                <div class="field">
                                                    <label>CONTRASE&Ntilde;A</label>
                                                    <input minlength="6" type="password" name="password" id="password" value="">
                                                </div>
                                                <div class="field">
                                                    <label>REPITA CONTRASE&Ntilde;A</label>
                                                    <input minlength="6" type="password" name="password_repeat" id="password_repeat" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="checkbox checkbox-danger" style="margin: 0;">
                                            <input name="user_delete" type="checkbox" id="user_delete"/>
                                            <label for="user_delete" id="user_delete_label"> ¿Eliminar usuario?</label>
                                        </div>										
                                        <div class="btnSearchStudent" style="text-align: right; margin-right: 10px; margin-bottom: 20px;">
                                            <button type="button" class="ui positive button btnSave disabled" onclick="guardarusuest()">GUARDAR USUARIO</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                                    </div>
		<?php
	}
	
	?>