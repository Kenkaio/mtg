<?php ob_start(); ?>

<div class="row">
    <h1 id="listTitle" class="<?= $deckType['type'] ?>"><?= $deckType['type'] ?></h1>
    <h3><?= $deckType['name'] ?></h3>
    <input type="text" id="newList">
    <div id="checking"></div>
    <ul id="returnList"></ul>
    <div id="listDetail">
    </div>
</div>

<?php $contentAdmin = ob_get_clean(); ?>

<?php require '../models/templates/admin.php'; ?>
