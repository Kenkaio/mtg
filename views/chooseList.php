<?php ob_start(); ?>
<div class="deckContent">
    <div class="row">
        <div class="col-lg-12">
            <h1 id="titleDeckName">Deck name</h1>
            <div id="errorDeckName"></div>
            <form action="index.php?action=addNewDeck" method="post" id="formDeck">
                <label for="formDeckName">Name : </label><input type="text" name="formDeckName" id="formDeckName" required><br />
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
                <p>Players begin the game with 40 life.</p>
                <p>Commanders begin the game in the Command Zone. While a Commander is in the command zone, it may be cast,
                subject to the normal timing restrictions for casting creatures. Its owner must pay {2} for each time it was previously
                cast from the command zone; this is an additional cost.</p>
                <a href="#" id="readMoreMulti">read more</a>
                <div id="infosMulti">
                    <div id="closeInfosMulti">X</div>
                    <p>Players begin the game with 40 life.</p>
                    <p>Commanders begin the game in the Command Zone. While a Commander is in the command zone, it may be cast,
                    subject to the normal timing restrictions for casting creatures. Its owner must pay {2} for each time it was previously
                    cast from the command zone; this is an additional cost.</p>
                    <p>If a Commander would be put into a library, hand, graveyard or exile from anywhere, its owner may choose to move
                    it to the command zone instead.</p>
                    <p>Being a Commander is not a characteristic [MTG CR109.3], it is a property of the card and tied directly to the physical card.
                    As such, "Commander-ness" cannot be copied or overwritten by continuous effects. The card retains it's commanderness through any status
                    changes, and is still a commander even when controlled by another player.</p>
                    <p>If a player has been dealt 21 points of combat damage by a particular Commander during the game, that player loses a game.</p>
                    <p>Commanders are subject to the Legend rule; a player cannot control more than one legend with the same name.</p>
                    <p>Abilities which refer to other cards owned outside the game (Wishes, Spawnsire, Research, Ring of Ma'ruf) do not function in
                    Commander without prior agreement on their scope from the playgroup.</p>
                    <p>There is a specific <a href="https://magic.wizards.com/en/content/commander-format" target="_blank">banlist</a>.</p>
                </div>
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

<?php require 'models/templates/admin.php'; ?>
