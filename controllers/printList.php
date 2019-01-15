<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../public/css/print.css">
</head>
<body onload="window.print()">

    <h3>Commander : <?= $_GET['commander']; ?></h3>
    <h3>DCI NUMBER : _______________</h3>

    <?php
            $json_source = file_get_contents('../public/assets/json/list.json');
            $data = json_decode($json_source);
    ?>

    <section id='printSection'>
        <div class="listDiv" id="landsCards">
            <h1>LANDS</h1>
            <?php
                foreach ($data as $key => $value) {
                    if($key == 'land'){
                        for ($i=0; $i < count($value); $i++) {
                            echo '<li>'.$value[$i].'</li>';
                        }
                    }

                }
            ?>
        </div>
        <div class="listDiv" id="creaturesCards">
            <h1>CREATURES</h1>
            <?php
                foreach ($data as $key => $value) {
                    if($key == 'creature'){
                        for ($i=0; $i < count($value); $i++) {
                            echo '<li>'.$value[$i].'</li>';
                        }
                    }

                }
            ?>
        </div>
        <div class="listDiv" id="artifactsCards">
            <h1>ARTIFACTS</h1>
            <?php
                foreach ($data as $key => $value) {
                    if($key == 'artifact'){
                        for ($i=0; $i < count($value); $i++) {
                            echo '<li>'.$value[$i].'</li>';
                        }
                    }

                }
            ?>
        </div>
        <div class="listDiv" id="enchantmentsCards">
            <h1>ENCHANTMENTS</h1>
            <?php
                foreach ($data as $key => $value) {
                    if($key == 'enchantment'){
                        for ($i=0; $i < count($value); $i++) {
                            echo '<li>'.$value[$i].'</li>';
                        }
                    }

                }
            ?>
        </div>
        <div class="listDiv" id="spellsCards">
            <h1>SPELLS</h1>
            <?php
                foreach ($data as $key => $value) {
                    if($key == 'spell'){
                        for ($i=0; $i < count($value); $i++) {
                            echo '<li>'.$value[$i].'</li>';
                        }
                    }

                }
            ?>
        </div>
    </section>
</body>
</html>
