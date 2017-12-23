<?php
use app\assets\FileInputAsset;

FileInputAsset::register($this);
/* @var $this yii\web\View */

$this->title = 'HomeCost';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Bienvenue sur HomeCost</h1>
        <p class="lead">Télécharger un relevé de compte au format Excel.</p>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <input id="excelFile" type="file">
            </div>
        </div>
        <small>Fichier export relevé Crédit Mutuel</small>
    </div>
</div>
