<!DOCTYPE html>
<html>

	<head>

		<meta charset="utf-8" />

		<title>Crontab Generator for Backups</title>

		<link rel="stylesheet" href="css/bootstrap.css" />
		<link rel="stylesheet" href="css/bootstrap-responsive.css" />
		<link rel="stylesheet" href="css/styles.css" />

		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/functions.js"></script>

	</head>

	<body>

		<div class="container">

			<h2>Crontab</h2>

			<div class="row">

				<div class="span6">

					<p>Introduzca los datos necesarios para generar respaldos programados de bases de datos.</p>

					<form class="form-horizontal">

						<fieldset>
							
							<legend>Información</legend>

							<div class="control-group">

								<label class="control-label" for="">Base de Datos</label>

								<div class="controls">

									<input type="text" class="span2" />

								</div>

							</div>

							<div class="control-group">

								<label class="control-label" for="">Usuario</label>

								<div class="controls">

									<input type="text" class="span2" />

								</div>

							</div>

							<div class="control-group">

								<label class="control-label" for="">Contraseña</label>

								<div class="controls">

									<input type="text" class="span2" />
									<p class="help-block">La contraseña se mostrará en <strong>texto plano</strong></p>

								</div>

							</div>

							<div class="control-group">

								<label class="control-label" for="">Carpeta destino</label>

								<div class="controls">

									<input type="text" class="span2" />
									<p class="help-block">Ruta completa — incluya "/"</p>

								</div>

							</div>

						</fieldset>

						<fieldset>

							<legend>Opciones avanzadas</legend>

							<div class="control-group">

								<label class="control-label" for="">Host</label>

								<div class="controls">

									<input type="text" class="span2" />
									<p class="help-block">Se utilizará <em>localhost</em> por defecto</p>

								</div>

							</div>

							<div class="control-group">

								<label class="control-label" for="">Ruta a <em>mysqldump</em></label>

								<div class="controls">

									<input type="text" class="span2" />
									<p class="help-block">Se utilizará <em>/usr/bin/mysqldump</em> por defecto</p>

								</div>

							</div>

							<div class="control-group">

								<label class="control-label" for="">Utilizar <em>keywords</em></label>

								<div class="controls">
									
									<label class="checkbox">
										
										<input type="checkbox" />
										Se generarán las fechas y horas con formato <strong>@date</strong>
									
									</label>

								</div>

							</div>

						</fieldset>

						<div class="simple form-actions">

							<input type="submit" class="btn btn-primary" value="Generar" />

						</div>
						
					</form>

				</div>

			</div>

		</div>

	</body>

</html>