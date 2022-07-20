<section class="container login">
  <?php include_once __DIR__ . "/../templates/alerts.php" ?>
  <h3 class="login__title">login</h3>
  <div class="login__container">
    <div class="login-up">
      <form class="login-up__form" method="POST" action="/login">
        <label for="email" class="login-up__form--label">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          class="login-up__form--input"
          placeholder="your email"
          value="<?php echo s($auth->email) ?>"
        />
        <div class="login-up__form--forgot">
        <label for="password" class="login-up__form--label">Password</label>
        <a href="/forgot-password">Forgot password?</a>
        </div> <!-- FORGOT -->
        <input
          type="password"
          id="password"
          name="password"
          class="login-up__form--input"
          placeholder="your password"
        />
        <input 
          type="submit"
          value="SUBMIT"
          class="login-up__form--submit"     
        />
      </form>
    </div> <!-- LOGIN-UP -->
    <div class="login-down"></div>
  </div>
  <p class="login__text">Don't have an account? <a href="/signup">Sign up</a></p>
</section> <!-- LOGIN -->