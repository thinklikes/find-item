<?php

if (empty($result)) {
    throw new \Exception('no results');
}

foreach ($result as $name => $items) { ?>
    <table width="50%">
        <thead>
            <tr>
                <th><?php echo $name ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item) { ?>
                <tr>
                    <td><?=$item['image']?></td>
                    <td><?=$item['name']?></td>
                    <td><?=$item['note']?></td>
                    <td><a href="<?=$item['uri']?>" target="_blank">連結</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php
}
