<?php
/**
 * @var DateInterface $dateService
 * @var $this yii\web\View
 * @var array $listCateg
 */
use Serval\Technical\Date\DateInterface;
use app\assets\SwitchAsset;

SwitchAsset::register($this);

$htmlCateg = [];
foreach ($listCateg as $item) {
    $htmlCateg[] = $this->render('partials/categ_label', $item);
}
$htmlCateg = implode('&nbsp;', $htmlCateg);
?>

    <div class="page-header">
        <h1>Traitements des nouvelles opérations</h1>
    </div>
<?php if ($data): ?>
    <table class="table table-striped table-condensed">
        <thead> <!-- En-tête du tableau -->
        <tr>
            <th>Date</th>
            <th>Opération</th>
            <th>Catégorie</th>
            <th>Ignore</th>
            <!--        <th>Sous-Catégorie</th>-->
        </tr>
        </thead>

        <tfoot> <!-- Pied de tableau -->
        <tr>
            <th>Date</th>
            <th>Opération</th>
            <th>Catégorie</th>
            <th>Ignore</th>
            <!--        <th>Sous-Catégorie</th>-->
        </tr>
        </tfoot>

        <tbody> <!-- Corps du tableau -->

        <?php foreach ($data as $item): ?>
            <tr>
                <td><?php echo $dateService->dateMysqlToI18nString($item['date_operation']); ?></td>
                <td><?php echo $item['label']; ?></td>
                <td><?php echo $htmlCateg; ?></td>
                <td><input type="checkbox" name="my-checkbox"></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <h3>Aucune nouvelle opération à traiter</h3>
<?php endif ?>