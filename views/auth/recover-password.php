<?php include_once __DIR__ . '/../templates/alerts.php'; ?>
<?php if($error) return; ?>
<h1>Recover Password</h1>
<p>Set your new password</p>
<form class="" method="POST">
  <label for="password" class="">Password</label>
  <input
    type="password"
    id="password"
    name="password"
    class=""
    placeholder="your new password"
  />
  <input 
    type="submit"
    value="SUBMIT"
    class=""     
  />
</form>

<p>already you have account?<a href="/login">Log In</a></p>
<p>do you not have account?<a href="/signup">Sign Up</a></p>