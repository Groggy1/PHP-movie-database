<div class="login">
	<form role="form" action="<?php echo URL; ?>login/login" method="post">
		<div class="form-group">
			<label for="usernameInput">Användarnamn</label>
			<input type="username" name="username" class="form-control" id="usernameInput" placeholder="Användarnamn">
		</div>
		<div class="form-group">
			<label for="passwordInput">Lösenord</label>
			<input type="password" name="password" class="form-control" id="passwordInput" placeholder="Lösenord">
		</div>
		<input type="hidden" name="path" value="<?php echo rtrim(URL . $url['path']['controller'] . '/' . $url['path']['action'] . '/' . $url['path']['id'], '/'); ?>" />
		<button type="submit" class="btn btn-default">
			Submit
		</button>
	</form>
</div>