<div>請輸入品名：</div>
<form>
    <input name="items" value="<?php echo $_GET['items'] ?? '' ?>">
    <input type="submit" value="送出">
</form><br>
<?php
putenv('STORAGE_PATH=' . __DIR__ . '/storage/');

include __DIR__ . "/vendor/autoload.php";

if (empty($_GET['items'])) {
    die();
}

try {
    $controller = new App\AppController();
    $searchText = $_GET['items'];
    $controller->addEndpoint(new App\Endpoints\Ruyiya());
    $controller->addEndpoint(new App\Endpoints\NailJapan());
    $controller->addEndpoint(new App\Endpoints\NailsInJapan());
    $controller->addEndpoint(new App\Endpoints\NailLabo());
    $controller->addEndpoint(new App\Endpoints\HcNails());
    $controller->addEndpoint(new App\Endpoints\Nail711());
    $controller->addEndpoint(new App\Endpoints\Shop3388776());
    $controller->addEndpoint(new App\Endpoints\ShenlyForYou());
    $controller->addEndpoint(new App\Endpoints\NailLaVie());
    $controller->addEndpoint(new App\Endpoints\OnsNail());
    $controller->addEndpoint(new App\Endpoints\HikariIntl());
    $controller->addEndpoint(new App\Endpoints\OstarNails());
    $result = $controller->searchItems($searchText);

    include 'viewer.php';
} catch (GuzzleHttp\Exception\GuzzleException $e) {
    var_dump($e->getFile());
    var_dump($e->getLine());
    var_dump($e->getMessage());
} catch (Exception $e) {
    var_dump($e->getFile());
    var_dump($e->getLine());
    var_dump($e->getMessage());
} catch (Throwable $e) {
    var_dump($e->getFile());
    var_dump($e->getLine());
    var_dump($e->getMessage());
}

