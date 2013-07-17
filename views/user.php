<?php
$sitetitle = "Användar alternativ";
require_once 'template/header.php';
?>
<div class="hero-unit">
	<div class="row-fluid">
		<div class="span4">
			<p>Det kommer kanske något kul här sen :). Typ lite statistik.</p>
		</div>
		<div class="span4">
			<p>Det kommer kanske något kul här sen :). Typ lite statistik.</p>
		</div>
		<div class="span4">
			<form class="form-horizontal" name="user_edit_password" action="user.php" method="post">
				<div class="control-group">
					<div class="controls">
						<h3>Byt lösenord</h3>
					</div>
				</div>
				<?php
				if (sizeof($login -> errors) > 0 || sizeof($login -> messages) > 0) {
					echo '<hr><ul>';
					foreach ($login -> errors as $value) {
						echo '<li><p style="color:red;">' . $value . '</p></li>';
					}
					foreach ($login -> messages as $value) {
						echo '<li><p style="color:green;">' . $value . '</p></li>';
					}
					echo '</ul><hr>';
				}
				?>
				<div class="control-group">
					<label class="control-label" for="edit_input_password_old">Ditt gamla lösenord</label>
					<div class="controls">
						<input type="password" name="user_password_old" autocomplete="off" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="edit_input_password_new">Ditt nya lösenord</label>
					<div class="controls">
						<input type="password" name="user_password_new" autocomplete="off" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="edit_input_password_new_repead">Ditt nya lösenord igen</label>
					<div class="controls">
						<input type="password" name="user_password_new_repeat" autocomplete="off" />
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary" type="submit" name="user_change_password">
							Byt lösenord
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
require_once 'template/footer.php';
