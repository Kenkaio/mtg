<?php ob_start(); ?>
<?php

    if (empty($req)) { ?>
        <h3 id="titleSelectCommander">Select your commander</h3>
        <input type="text" id="selectCommander">
        <div id="returnCommander"></div>
        <div id="checkingCommander"></div>
        <?php
    }
    else{
    ?>

        <div class="row">
            <?php
                if($_SESSION['allDeckInformations']->getType() == 'Duel' || $_SESSION['allDeckInformations']->getType() == 'Multi'){
                    echo '<h3 id="deckName">'.$deckList[0]->commander .' '. $req[1] .'</h3>';
            ?>
            <input type="text" id="newList">
            <div id="checking"></div>
            <ul id="returnList"></ul>
            <div id="completeList">
                <div class="listDiv" id="commandersCards"><h1>COMMANDER</h1></div>
                <div class="listDiv" id="landsCards"><h1>LANDS</h1></div>
                <div class="listDiv" id="creaturesCards"><h1>CREATURES</h1></div>
                <div class="listDiv" id="artifactsCards"><h1>ARTIFACTS</h1></div>
                <div class="listDiv" id="enchantmentsCards"><h1>ENCHANTMENTS</h1></div>
                <div class="listDiv" id="spellsCards"><h1>SPELLS</h1></div>
            </div>
        </div>

        <div id="historicList" class="row">
            <button id="confirmList"><img src="public/images/confirm.png" alt="confirm"></button>
            <a id="linkPrint" href='printList.php?commander=<?= $deckList[0]->commander?>'> <img src="public/images/print.png" alt="print"></a>
            <div id="historic">
                <h3 id="titleHistoric">Historic</h3>
            </div>
        </div>
        <?php
        }
    }
?>
<?php $contentAdmin = ob_get_clean(); ?>

<?php require 'models/templates/admin.php'; ?>
