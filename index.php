<?php if (isset($_POST['submit'])) {
	
	// export all values to single variables
	foreach($_POST as $key => $a) {
		$$key = $a;
	}

	// if basic info is missing, show error, do not generate
	if (empty($database) OR empty($username) OR empty($destination)) {		
			$error		= 'All information fields are required.';
		} else {
			$generate	= TRUE;
		}
	
	// if the no pass option wasn't selected, check if there's a password sent
	if (!isset($nopass)) {
		if (!isset($password) OR empty($password)) {
			$error		= 'All information fields are required.';
			$generate	= FALSE;
			$password	= NULL;
		} else {
			$password	= ' -p' . $password;
		}
	}

	// if the no pass option was selected, truncate the password
	if (isset($nopass)) {
		$password		= NULL;
	}

	// set defaults
	if (empty($hostname)):	$hostname	= 'localhost'; 			endif;
	if (empty($mysqldump)):	$mysqldump 	= '/usr/bin/mysqldump';	endif;

	// configure keywords
	if (isset($keywords)) {
		$hourly		= '@hourly';
		$daily		= '@daily';
		$weekly		= '@weekly';
		$monthly	= '@monthly';
		$yearly		= '@yearly';
	} else {
		/* 
			crontab syntax:
				min - hour - dom - month - dow
			
			values:
				min: 0-59
				hour: 0-23 (midnight = 0)
				day of month: 1-31
				month: 1-12
				day of week: 0-6 (sun = 0)
		*/

		$hourly		= '0 * * * *';
		$daily		= '0 0 * * *';
		$weekly		= '0 0 * * 1'; // starts at monday!
		$monthly	= '0 0 1 * *';
		$yearly		= '0 0 1 1 *';
	}

}

?>
<!DOCTYPE html>
<html>

	<head>

		<meta charset="utf-8" />

		<title>Crontab Generator</title>

		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Cutive' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/bootstrap.css" />
		<link rel="stylesheet" href="css/bootstrap-responsive.css" />
		<link rel='stylesheet' href='css/styles.css' type='text/css'>
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/functions.js"></script>

		<script type="text/javascript">

			$(document).ready(function(){
				$('#nopass').on('change', function() {		
					if ($('#nopass').attr('checked') == 'checked') {
						$('#password').prop('disabled', true).addClass('disabled');
					} else {
						$('#password').prop('disabled', false).removeClass('disabled');
					}
				});
			});

		</script>

	</head>

	<body>

		<div class="container">

			<div class="page-header">

				<h3>Crontab Generator</h3>

			</div>

			<!-- errors -->
			<?php if (isset($error)): ?>

			<div class="alert">

				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<?php echo $error; ?>

			</div>

			<?php endif; ?>
			<!-- end errors -->

			<div class="row">

					<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

					<div class="span6">

						<fieldset>
							
							<legend>Information</legend>

							<div class="control-group">

								<label class="control-label" for="database">Database</label>

								<div class="controls">

									<input type="text" name="database" id="database" />
									<p class="help-block">The database to backup</p>

								</div>

							</div>

							<div class="control-group">

								<label class="control-label" for="username">Username</label>

								<div class="controls">

									<input type="text" name="username" id="username" />
									<p class="help-block">User with access to the database</p>

								</div>

							</div>

							<div class="control-group">

								<label class="control-label" for="password">Password</label>

								<div class="controls">

									<input type="text" name="password" id="password" />
									<p class="help-block">Password will be shown in <strong>plaintext</strong></p>

								</div>

							</div>

							<div class="control-group">

								<label class="control-label" for="nopass">No password</label>

								<div class="controls">

									<label class="checkbox">
										
										<input type="checkbox" name="nopass" id="nopass" value="true"/>
										Do you connect to your DB with no password?
									
									</label>

								</div>

							</div>

							<div class="control-group">

								<label class="control-label" for="destination">Destination folder</label>

								<div class="controls">

									<input type="text" name="destination" id="destination" />
									<p class="help-block">UNIX paths only - include root slash</p>

								</div>

							</div>

						</fieldset>

					</div>

					<div class="span6">

						<fieldset>

							<legend>Options</legend>

							<div class="control-group">

								<label class="control-label" for="hostname">Hostname</label>

								<div class="controls">

									<input type="text" name="hostname" id="hostname" />
									<p class="help-block">If empty, <em>localhost</em> will be used</p>

								</div>

							</div>

							<div class="control-group">

								<label class="control-label" for="mysqldump">Path to <em>mysqldump</em></label>

								<div class="controls">

									<input type="text" name="mysqldump" id="mysqldump" />
									<p class="help-block">If empty, <em>/usr/bin/mysqldump</em> will be used</p>

								</div>

							</div>

							<div class="control-group">

								<label class="control-label" for="keywords">Use <em>keywords</em></label>

								<div class="controls">
									
									<label class="checkbox">
										
										<input type="checkbox" name="keywords" id="keywords" value="true"/>
										Dates and times will be generated using <strong>@keyword</strong> format
									
									</label>

								</div>

							</div>

						</fieldset>

						<div class="simple form-actions">

							<input type="submit" class="btn" value="Generate" name="submit" />

						</div>

					</div>
						
					</form>

				</div>

				<div class="row">

					<?php if (isset($generate) AND $generate === TRUE): ?>
						
<pre>
<?php echo $hourly	. ' ' . $mysqldump . ' -u ' . $username . $password . ' -h ' . $hostname . ' ' . $database . ' > ' . rtrim($destination, '/') . '/hourly.sql'		. "\n"; ?>
<?php echo $daily	. ' ' . $mysqldump . ' -u ' . $username . $password . ' -h ' . $hostname . ' ' . $database . ' > ' . rtrim($destination, '/') . '/daily.sql'		. "\n"; ?>
<?php echo $weekly	. ' ' . $mysqldump . ' -u ' . $username . $password . ' -h ' . $hostname . ' ' . $database . ' > ' . rtrim($destination, '/') . '/weekly.sql'		. "\n"; ?>
<?php echo $monthly	. ' ' . $mysqldump . ' -u ' . $username . $password . ' -h ' . $hostname . ' ' . $database . ' > ' . rtrim($destination, '/') . '/monthly.sql'	. "\n"; ?>
<?php echo $yearly	. ' ' . $mysqldump . ' -u ' . $username . $password . ' -h ' . $hostname . ' ' . $database . ' > ' . rtrim($destination, '/') . '/yearly.sql' 	. "\n"; ?>
</pre>

					<?php endif; ?>

				</div>

			</div>

	</body>

</html>