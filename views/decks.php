<?php ob_start(); ?>

<h1 class="title">My decks</h1>

<div class="listAllDecks">
    <?php
        $type = array_keys($arrayName);
        for ($i=0; $i < count($type); $i++) {

            echo '<div>
                    <h1>' . $type[$i] . '</h1>';
            for ($x=0; $x < count($arrayName[$type[$i]]); $x++) {
                echo '<h2><a href="index.php?action=detailDeck&id=' . $arrayName[$type[$i]][$x]->id . '">' . $arrayName[$type[$i]][$x]->name . '</a></h2>';
            }
            echo '</div>';
        }
    ?>
    </div><h4 id="newDeck"><a href="index.php?action=newDeck"> Create new deck ?</a></h4>


<?php $contentAdmin = ob_get_clean(); ?>

<?php require 'models/templates/admin.php'; ?>
