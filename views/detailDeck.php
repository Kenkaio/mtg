<?php ob_start(); ?>



<?php $contentAdmin = ob_get_clean(); ?>

<?php require '../models/templates/admin.php'; ?>
