<?php ob_start(); ?>
<form method="post" action="index.php?action=createUser.php" class="login100-form validate-form">
    <span class="login100-form-title p-b-40">
        Sign In
    </span>

    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter pseudo">
        <input class="input100" type="text" name="pseudo" placeholder="Pseudo" id="pseudo">
        <span class="focus-input100"></span>
        <div id="returnPseudo" class="return"></div>
    </div>

    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter email: ex@abc.xyz">
        <input class="input100" type="text" name="email" placeholder="Email" id="mail">
        <span class="focus-input100"></span>
        <div id="returnMail" class="return"></div>
    </div>

    <div class="wrap-input100 validate-input m-b-20" data-validate="Please enter password">
        <span class="btn-show-pass">
            <i class="fa fa fa-eye"></i>
        </span>
        <input class="input100" type="password" name="pass" placeholder="Password" id="pass">
        <span class="focus-input100"></span>
        <div id="returnPass" class="return"></div>
    </div>

    <div class="wrap-input100 validate-input m-b-20" data-validate="Confirm password">
        <span class="btn-show-pass">
            <i class="fa fa fa-eye"></i>
        </span>
        <input class="input100" type="password" name="confirmPass" placeholder="Confirm password" id="confirmPass">
        <span class="focus-input100"></span>
        <div id="returnConfirmPass" class="return"></div>
    </div>


    <div class="container-login100-form-btn">
        <button class="login100-form-btn" id="confirmSignUp">
            Sign Up
        </button>
    </div>

    <div class="flex-col-c p-t-224">
        <span class="txt2 p-b-10">
            Have an account?
        </span>

        <a href="index.php?action=authentification" class="txt3 bo1 hov1">
            Sign in now
        </a>
    </div>

</form>
<?php $content = ob_get_clean(); ?>

<?php require 'models/templates/index.php'; ?>
