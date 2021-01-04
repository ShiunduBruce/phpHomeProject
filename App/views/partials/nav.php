<nav class="navbar is-success" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="https://bulma.io">
      <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>
  <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true):?>
  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
      <h1 class="navbar-item"><?=$_SESSION['username']['name'] ?> </h1>       
    </div>
    <div class="navbar-start">
      <h1 class="navbar-item">SSN - <?=$_SESSION['username']['SSN'] ?> </h1>       
    </div>
  </div>
  <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a href="/" class="button is-primary">
            <strong>HOME</strong>
          </a>
          <a href='/logout' class="button is-light">
            Log out
          </a>
        </div>
      </div>
    </div>
    <?php else:?>
    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a href="/signup" class="button is-primary">
            <strong>Sign up</strong>
          </a>
          <a href='login' class="button is-light">
            Log in
          </a>
        </div>
      </div>
    </div>
  </div>
    <?php endif?>

</nav>