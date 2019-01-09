<?php ob_start(); ?>

<div class="row">
    <div class="col-xs-10 col-md-10 col-lg-10">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-offset-1 col-lg-3">
                <div class="decks rubric">
                    <h1 class="title" id="titleDeck">Decks</h1>
                    <div class="allDecks">
                        <img src="../public/images/deckBox.png" alt="deck box" id="deckBoxImg">
                        <ol id="listDeck">
                            <?php
                                while ($getDeck = $getDecks->fetch(PDO::FETCH_OBJ)){
                                    ?>
                                    <li><?= $getDeck->name; ?></li>
                                    <?php
                                }
                            ?>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-offset-2 col-lg-4">
                <div class="matches rubric">
                    <h1 class="title" id="titleMatch">Matches</h1>
                    <div class="allMatches">
                        <img src="../public/images/vs.png" alt="versus" id="versusImg">
                        <ul id="listMatches">
                        <?php
                            while ($getMatche = $getMatches->fetch(PDO::FETCH_OBJ)){
                                $name = $getMatche->idOpponent;
                                $return = $matches->getNameOpponent($name);
                                $pseudoOpponent = $return->fetch(PDO::FETCH_OBJ);
                                ?>
                                <li>VS <strong><?= $pseudoOpponent->pseudo ?></strong> (<?= $getMatche->deckNameOpponent ?>) <?= $getMatche->pointsUser ?> - <?= $getMatche->pointsOpponent ?> </li>
                                <?php
                            }
                        ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <select name="selectDate" id="selectDate">
            <option value="2018">2018</option>
            <option value="2019" selected>2019</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
        </select>
        <div class="chartContainer">
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <div class="col-xs-2 col-md-2 col-lg-2">
        <div class="members">
            <h1 class="title" id="titleMembers">Connected</h1>
            <div class="allMembers">
                <div id="membersConnected"></div>
            </div>
        </div>
    </div>
</div>

<?php $contentAdmin = ob_get_clean(); ?>

<?php require '../models/templates/admin.php'; ?>
