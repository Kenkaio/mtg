<?php ob_start(); ?>
<div class="deckContent">
    <div class="row">
        <div class="col-lg-12">
            <h1 id="titleDeckName">Deck name</h1>
            <form action="../controllers/deck.php" method="post" id="formDeck">
                <label for="deckName">Name : </label><input type="text" name="deckName" id="deckName" required><br />
                <label for="type">type : </label><SELECT name="type" size="1">
                    <OPTION selected>Duel
                    <OPTION>Multi
                    <OPTION>MTGO
                    <OPTION>Legacy
                    <OPTION>Modern
                    <OPTION>Vintage
                    <OPTION>Standard
                </SELECT><br />
                <input type="submit" name="addDeck" id="addDeck" value="Confirm">
            </form>
        </div>
    </div>

    <div class="row deckDetail">
        <h1>Deck type</h1>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <h2>Duel</h2>
            <p>Duel Commander follows the exact same rules as classic multiplayer Commander, except for the following.</p>
            <p>Players start the game with 20 life.</p>
            <p>In addition to the ability to put the Commander back into the Command Zone if it would go to the graveyard
            or be exiled, you may do so also if it would be put into your library.</p>
            <p>There is a specific <a href="http://www.duelcommander.com/banlist/" target="_blank">banlist</a>.</p>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <h2>Multi Commander</h2>
            <p>Duel Commander follows the exact same rules as classic multiplayer Commander, except for the following.</p>
            <p>Players start the game with 20 life.</p>
            <p>In addition to the ability to put the Commander back into the Command Zone if it would go to the graveyard
            or be exiled, you may do so also if it would be put into your library.</p>
            <p>There is a specific <a href="http://www.duelcommander.com/banlist/" target="_blank">banlist</a>.</p>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <h2>MTGO</h2>
            <p>Duel Commander follows the exact same rules as classic multiplayer Commander, except for the following.</p>
            <p>Players start the game with 20 life.</p>
            <p>In addition to the ability to put the Commander back into the Command Zone if it would go to the graveyard
            or be exiled, you may do so also if it would be put into your library.</p>
            <p>There is a specific <a href="http://www.duelcommander.com/banlist/" target="_blank">banlist</a>.</p>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <h2>Legacy</h2>
            <p>Duel Commander follows the exact same rules as classic multiplayer Commander, except for the following.</p>
            <p>Players start the game with 20 life.</p>
            <p>In addition to the ability to put the Commander back into the Command Zone if it would go to the graveyard
            or be exiled, you may do so also if it would be put into your library.</p>
            <p>There is a specific <a href="http://www.duelcommander.com/banlist/" target="_blank">banlist</a>.</p>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <h2>Modern</h2>
            <p>Duel Commander follows the exact same rules as classic multiplayer Commander, except for the following.</p>
            <p>Players start the game with 20 life.</p>
            <p>In addition to the ability to put the Commander back into the Command Zone if it would go to the graveyard
            or be exiled, you may do so also if it would be put into your library.</p>
            <p>There is a specific <a href="http://www.duelcommander.com/banlist/" target="_blank">banlist</a>.</p>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <h2>Vintage</h2>
            <p>Duel Commander follows the exact same rules as classic multiplayer Commander, except for the following.</p>
            <p>Players start the game with 20 life.</p>
            <p>In addition to the ability to put the Commander back into the Command Zone if it would go to the graveyard
            or be exiled, you may do so also if it would be put into your library.</p>
            <p>There is a specific <a href="http://www.duelcommander.com/banlist/" target="_blank">banlist</a>.</p>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <h2>Standard</h2>
            <p>Duel Commander follows the exact same rules as classic multiplayer Commander, except for the following.</p>
            <p>Players start the game with 20 life.</p>
            <p>In addition to the ability to put the Commander back into the Command Zone if it would go to the graveyard
            or be exiled, you may do so also if it would be put into your library.</p>
            <p>There is a specific <a href="http://www.duelcommander.com/banlist/" target="_blank">banlist</a>.</p>
        </div>
    </div>
</div>


<?php $contentAdmin = ob_get_clean(); ?>

<?php require '../models/templates/admin.php'; ?>
