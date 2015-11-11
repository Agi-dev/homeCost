<?php
/**
 * Le but est de reconstruire les fichiers messages pour qu'il soit trié par clef
 * afin de faciliter la recherche ou l'ajout de clef de message
 * User: fschneider
 * Date: 15/01/14
 * Time: 17:31
 */

// Liste des fichiers de message à beautify
$filenames[] = __DIR__ . '/../config/i18n/fr_FR.php';

foreach ($filenames as $filename) {

    if (false === file_exists($filename)) {
        echo '!! ERREUR !! : impossible de trouver le fichier ' . $filename ."\n";
        continue;
    }

    // récupèration des messages
    $keys = include($filename);

    // Trie des message
    ksort($keys);

    // On écrit le fichier trier
    $txt = "<?php
/**
 * " . basename($filename) . "
 * Fichier de traduction
 */
return array(";

    $currentType = '';
    $info = array();
    foreach ($keys as $k => $m) {
        list($type, $rest) = explode('.', $k);

        // On détermine si c'est un nouveau type de message
        if ($type !== $currentType) {

            // On ajoute le header du type
            //$header = "\n    /***************************************************************************************************** $type\n" .
            $header = "\n    // $type\n";
            $currentType = $type;
            $info[$currentType] = array(
                'header' => $header,
                'maxKeyLen' => 0
            );
        }
        $len = strlen($k);
        if ($len > $info[$currentType]['maxKeyLen']) {
            $info[$currentType]['maxKeyLen'] = $len;
        }
        $info[$currentType]['keys'][$k] = $m;
    }

    // ecriture du fichier
    foreach ($info as $type => $data) {
        $txt .= $data['header'];
        foreach ($data['keys'] as $k => $m) {
            $padding = $data['maxKeyLen'] + 2;
            $m = str_replace("'", "\\'", $m);
            // si on détecte un % on le remplace par %% car sinon sprintf va croire à un formatter
            if (strpos($m, '%') !== false) {
                $m = str_replace('%', '%%', $m);
            }
            $txt .= sprintf("    %-" . $padding . "s => '$m',\n", "'" . $k . "'", $m);
        }
    }
    $txt .= ");";
    file_put_contents($filename, $txt);
}
