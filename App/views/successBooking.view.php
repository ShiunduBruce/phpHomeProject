<?php require('partials/head.php'); ?>
<div class="hero is-fullheight is-primary">
    <div class="container has-text-centered">
      <div class="column is-8 is-offset-2">
      <h3 class="title has-text-white">The Natonal Health Centre  page</h3>
        <hr class="login-hr">
    </div>
        <p class="title is-2 has-text-black"> Your bookig is successful, <?=$_SESSION['username']['name'] ?></p>     
        <p class="has-text-black">Return to the <a href="/"> home page </a></p>

    </div>
</div>
<?php require('partials/footer.php'); ?>