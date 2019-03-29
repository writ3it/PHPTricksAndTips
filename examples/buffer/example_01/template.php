<?php
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 27.03.19
 * Time: 16:50
 */

/** @var array $data */

?>
<ul>

<?php foreach($data as $row): ?>
    <li><?= $row; ?></li>
<?php endforeach; ?>

</ul>