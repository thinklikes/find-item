<style>
    img {
        width: 160px;
    }
</style>
<?php

if (empty($result)) {
    throw new \Exception('no results');
}

$childrenOfRow = 8;

foreach ($result as $name => $items) { ?>
    <hr>
    <table width="100%">
        <thead>
            <tr>
                <th><h1><?php echo $name ?></h1></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $key => $item) { ?>
                <?php if ($key % $childrenOfRow == 0) { ?><tr> <?php } ?>
                    <td>
                        <?=$item['image']?><br>
                        <?=$item['name']?><br>
                        <?=$item['note']?><br>
                        <a href="<?=$item['uri']?>" target="_blank">連結</a>
                    </td>
            <?php if ($key % $childrenOfRow == ($childrenOfRow - 1)) { ?></tr> <?php } ?>
            <?php } ?>
        </tbody>
    </table>
    <?php
}
