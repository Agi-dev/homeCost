<?php
/**
 * @var DateInterface $dateService
 * @var $this yii\web\View
 * @var array $listCateg
 */
use Serval\Technical\Date\DateInterface;

$htmlCateg = [];
foreach ($listCateg as $item) {
    $htmlCateg[] = $this->render('partials/categ_label', $item);
}
$htmlCateg = implode('&nbsp;', $htmlCateg);
?>

    <div class="page-header">
        <h1>Traitements des nouvelles opérations <span class="badge"><?php echo count($data);?></span></h1>
    </div>
<?php if ($data): ?>
    <table class="table table-striped table-condensed">
        <thead> <!-- En-tête du tableau -->
        <tr>
            <th>Date</th>
            <th>Montant</th>
            <th>Opération</th>
            <th>Catégorie</th>
            <th>Ignore</th>
        </tr>
        </thead>

        <tfoot> <!-- Pied de tableau -->
        </tfoot>

        <tbody> <!-- Corps du tableau -->

        <?php foreach ($data as $item): ?>
            <tr data-id="<?php echo $item['id'];?>">
                <td><?php echo $dateService->dateMysqlToI18nString($item['date_operation']); ?></td>
                <td class="<?php echo intval( $item['amount']) > 0 ? 'success':'warning';?>"><strong><?php echo $item['amount']; ?> &euro;</strong></td>
                <td><?php echo $item['label']; ?></td>
                <td><?php echo str_replace('btn-id', 'btn-id-'.$item['id'],$htmlCateg); ?></td>
                <td>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="ignore" class="ckb-ignore ckb-id-<?php echo $item['id'];?>"> Oui
                        </label>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <h3>Aucune nouvelle opération à traiter</h3>
<?php endif ?>