<section class="container forgot">
  <?php include_once __DIR__ . '/../templates/alerts.php'; ?>
  <h3 class="forgot__title">reset your password</h3>
  <div class="forgot__container">
    <div class="forgot-up">
      <form class="forgot-up__form" method="POST" action="/forgot-password">
        <label for="email" class="forgot-up__form--label">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          class="forgot-up__form--input"
          placeholder="your email"
        />
        <input 
          type="submit"
          value="SUBMIT"
          class="forgot-up__form--submit"     
        />
      </form>
    </div> <!-- FORGOT-UP -->
    <div class="forgot-down"></div>
  </div>
  <p class="forgot__text">Don't have an account? <a href="/signup">Sign up</a></p>
</section> <!-- FORGOT -->