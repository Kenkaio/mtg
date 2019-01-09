<?php ob_start(); ?>

<h1 class="title">My decks</h1>

<div class="listAllDecks">
    <?php
        $type = array_keys($arrayName);
        for ($i=0; $i < count($type); $i++) {

            echo '<div>
                    <h1>' . $type[$i] . '</h1>';
            for ($x=0; $x < count($arrayName[$type[$i]]); $x++) {
                echo '<h2><a href="../controllers/deck.php?deck=' . $arrayName[$type[$i]][$x]->name . '">' . $arrayName[$type[$i]][$x]->name . '</a></h2>';
            }
            echo '</div>';
        }
    ?>
    </div><h4 id="newDeck"><a href="../controllers/deck.php?decks=new"> Create new deck ?</a></h4>


<?php $contentAdmin = ob_get_clean(); ?>

<?php require '../models/templates/admin.php'; ?>
