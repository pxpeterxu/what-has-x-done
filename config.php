<?php
$textsFileName = 'gen/texts.js';

if (!empty($_POST)) {
    $texts = array();
    foreach ($_POST['texts'] as $i => $text) {
        if (empty($text)) continue;
        
        $info = array('text' => $text);
        if (!empty($_POST['links'][$i])) {
            $info['link'] = $_POST['links'][$i];
        }
        $texts[] = $info;
    }
    
    $buttonTexts = $_POST['buttonTexts'];
    
    file_put_contents($textsFileName, 'var texts = ' . json_encode($texts) . '; var buttonTexts = ' . json_encode($buttonTexts) . ';');
}

$file = file_get_contents($textsFileName);
$textsJson = preg_replace(array('/var buttonTexts.*$/s', '/var texts = /', '/;/'), '', $file);
$texts = json_decode($textsJson, true);

$buttonTextsJson = preg_replace(array('/.*var buttonTexts = /s', '/;/'), '', $file);
$buttonTexts = json_decode($buttonTextsJson, true);
//print_r($buttonTextsJson);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>What has X done configuration page</title>
        <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.css">
        <style>
            body {
                padding: 20px;
            }
        </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script>
        function bindRemoveButtons() {
            $('.remove-button').click(function(e) {
                e.preventDefault();
                var $this = $(this);
                $this.parent().remove();
            });
        }
        $(document).ready(function() {
            bindRemoveButtons();
            
            $('.add-button').click(function(e) {
                e.preventDefault();
                $('#texts').append('<div class="row-fluid text-entry"><input type="text" name="texts[]" placeholder="Text to display" class="span8 text"> <input type="text" name="links[]" placeholder="Link with source" class="span3 link"> <button class="btn remove-button">Remove</button></div>');
                bindRemoveButtons();
            });
            

            $('.add-button-button').click(function(e) {
                e.preventDefault();
                $('#button-texts').append('<div><input type="text" name="buttonTexts[]" placeholder="Button text"> <button class="btn remove-button">Remove</button></div>');
                bindRemoveButtons();
            });
        });
        </script>
    </head>
    <body>
        <h1>What has X done configuration</h1>
        <form action="config.php" method="post">
        <input class="btn btn-primary btn-large" type="submit" value="Save">
        <h2>Texts <button class="btn add-button">Add</button></h2>
        <div id="texts">
            <div class="row-fluid">
                <div class="span8">Text</div>
                <div class="span4">Link (optional)</div>
            </div>
            <?php
            foreach ($texts as $text) {
            ?>
                <div class="row-fluid text-entry">
                    <input type="text" name="texts[]" placeholder="Text to display" class="span8 text" value="<?php echo htmlspecialchars($text['text']); ?>">
                    <input type="text" name="links[]" placeholder="Link with source" class="span3 link" value="<?php echo htmlspecialchars($text['link']); ?>">
                    <button class="btn remove-button">Remove</button>
                </div>
            <?php
            }
            ?>
        </div>
        <h2>Button labels <button class="btn add-button-button">Add</button></h2>
        <div id="button-texts">
        <?php
        foreach ($buttonTexts as $text) {
        ?>
            <div><input type="text" name="buttonTexts[]" placeholder="Button text" value="<?php echo htmlspecialchars($text); ?>"> <button class="btn remove-button">Remove</button></div>
        <?php
        }
        ?>
        
        </form>
    </body>
</html>
