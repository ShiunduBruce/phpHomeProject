<?php require('partials/head.php'); ?>
<div class="hero is-fullheight is-primary">
  <div class="hero-body">
    <div class="container has-text-centered">
      <div class="column is-8 is-offset-2">
      <h3 class="title has-text-white">The Natonal Health Centre login page</h3>
        <hr class="login-hr">
        <p class="subtitle has-text-white">Please login to schedule appointments!</p>
        <div class="box">
        <div class="title has-text-grey is-5">Please enter your email and password.</div>
        <?php if(isset($errors)) :?>
        <div>
          <?php foreach($errors as $err) : ?>
              <p style="color:red"><?=$err?></p>
          <?php endforeach ?>
        </div>
      <?php endif?>
      </div>
        <form method="POST">
            <div class="field">
                <div class="control">
                <input class="input is-large" name='username' type="email" placeholder="Email" autofocus="">
                </div>
            </div>
            <div class="field">
                <div class="control">
                <input class="input is-large" name='password' type="password" placeholder="Password">
                </div>
            </div>
            <label class="checkbox" style="margin: 20px;"><input type="checkbox">Remember me</label>
            <button class="button is-block is-danger is-large is-fullwidth">Login</button>
        </form>
        <p class="has-text-grey"><a href="">Sign Up</a> &nbsp;·&nbsp; </p>
      </div>
    </div>
  </div>
</div>
<?php require('partials/footer.php'); ?>
