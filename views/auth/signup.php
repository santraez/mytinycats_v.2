<section class="container signup">
  <div class="signup__content">
    <h2>Lorem, ipsum dolor.</h2>
    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Earum maxime dolor doloribus eius quam itaque.</p>
	</div> <!-- CONTENT -->
  <div class="signup__form">
    <?php include_once __DIR__ . "/../templates/alerts.php" ?>
    <h3 class="signup__form--title">signup</h3>
    <div class="signup__form--container">
      <div class="signup__form-up">
        <form class="signup-up-form" method="POST" action="/signup">
          <label for="display" class="signup-up-form__label">Display name</label>
          <input
            type="text"
            id="display"
            name="display"
            class="signup-up-form__input"
            placeholder="your display"
            value="<?php echo s($user->display) ?>"
          >
          <label for="email" class="signup-up-form__label">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            class="signup-up-form__input"
            placeholder="your email"
            value="<?php echo s($user->email) ?>"
          >
          <label for="password" class="signup-up-form__label">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            class="signup-up-form__input"
            placeholder="your password"
          >
          <label for="confirm-password" class="signup-up-form__label">Confirm password</label>
          <input
            type="password"
            id="confirm-password"
            name="confirmPassword"
            class="signup-up-form__input"
            placeholder="repeat your password"
          >
          <input 
            type="submit"
            value="SUBMIT"
            class="signup-up-form__submit"     
          >
        </form>
      </div> <!-- SIGNUP__FORM -->
      <div class="signup__form-down"></div>
    </div> <!-- CONTAINER -->
    <p class="signup__text">Already have an account? <a href="/login">Log in</a></p>
  </div> <!-- FORM -->
</section> <!-- SIGNUP -->