<?php ob_start(); ?>
<form method="post" action="controllers/connexion.php" class="login100-form validate-form">
    <span class="login100-form-title p-b-40">
        Login
    </span>

    <div>
        <a href="#" class="btn-login-with bg1 m-b-10">
            <i class="fa fa-facebook-official"></i>
            Login with Facebook
        </a>
    </div>

    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter pseudo">
        <input class="input100" type="text" name="pseudoCo" placeholder="Pseudo">
        <span class="focus-input100"></span>
    </div>

    <div class="wrap-input100 validate-input m-b-20" data-validate="Please enter password">
        <span class="btn-show-pass">
            <i class="fa fa fa-eye"></i>
        </span>
        <input class="input100" type="password" name="pass" placeholder="Password">
        <span class="focus-input100"></span>

    </div>
    <div id="returnCoError"></div>
    <div class="container-login100-form-btn">
        <button class="login100-form-btn">
            Login
        </button>
    </div>

    <div class="flex-col-c p-t-224">
        <span class="txt2 p-b-10">
            Don’t have an account?
        </span>

        <a href="?creat" class="txt3 bo1 hov1">
            Sign up now
        </a>
    </div>

</form>
<?php $content = ob_get_clean(); ?>
<script src="public/js/index.js"></script>
<?php require 'models/templates/index.php'; ?>
