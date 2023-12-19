<?

\Bitrix\Main\Loader::registerAutoLoadClasses(null, [
    'Codedot\Mindbox\Object\Customer' => '/local/php_interface/codedot/mindbox/objects/Customer.php',
    'Codedot\Mindbox\Object\ObjectStandart' => '/local/php_interface/codedot/mindbox/objects/ObjectStandart.php',
    'Codedot\Mindbox\Object\Product' => '/local/php_interface/codedot/mindbox/objects/Product.php',
    'Codedot\Mindbox\Object\ProductGroup' => '/local/php_interface/codedot/mindbox/objects/ProductGroup.php',
    'Codedot\Mindbox\Object\ProductItem' => '/local/php_interface/codedot/mindbox/objects/ProductItem.php',
    'Codedot\Mindbox\Object\ProductList' => '/local/php_interface/codedot/mindbox/objects/ProductList.php',
    'Codedot\Mindbox\Object\ViewCategory' => '/local/php_interface/codedot/mindbox/objects/ViewCategory.php',
    'Codedot\Mindbox\Object\ViewProduct' => '/local/php_interface/codedot/mindbox/objects/ViewProduct.php',

    'Codedot\Mindbox\Commands\Customer\AutorizationCommand' => '/local/php_interface/codedot/mindbox/commands/customer/AutorizationCommand.php',
    'Codedot\Mindbox\Commands\Customer\RegistrationCommand' => '/local/php_interface/codedot/mindbox/commands/customer/RegistrationCommand.php',
    'Codedot\Mindbox\Commands\Customer\UpdateCommand' => '/local/php_interface/codedot/mindbox/commands/customer/UpdateCommand.php',

    'Codedot\Mindbox\Commands\Cart\ClearCommand' => '/local/php_interface/codedot/mindbox/commands/cart/ClearCommand.php',
    'Codedot\Mindbox\Commands\Cart\SetCommand' => '/local/php_interface/codedot/mindbox/commands/cart/SetCommand.php',

    'Codedot\Mindbox\Commands\Favorite\ClearCommand' => '/local/php_interface/codedot/mindbox/commands/favorite/ClearCommand.php',
    'Codedot\Mindbox\Commands\Favorite\SetCommand' => '/local/php_interface/codedot/mindbox/commands/favorite/SetCommand.php',

    'Codedot\Mindbox\Commands\Order\AuthorizedCommand' => '/local/php_interface/codedot/mindbox/commands/order/AuthorizedCommand.php',
    'Codedot\Mindbox\Commands\Order\UnauthorizedCommand' => '/local/php_interface/codedot/mindbox/commands/order/UnauthorizedCommand.php',
    'Codedot\Mindbox\Commands\Order\UpdateCommand' => '/local/php_interface/codedot/mindbox/commands/order/UpdateCommand.php',
    'Codedot\Mindbox\Commands\Order\UpdateStatusCommand' => '/local/php_interface/codedot/mindbox/commands/order/UpdateStatusCommand.php',

    'Codedot\Mindbox\Commands\Product\ViewCategoryCommand' => '/local/php_interface/codedot/mindbox/commands/product/ViewCategoryCommand.php',
    'Codedot\Mindbox\Commands\Product\ViewCommand' => '/local/php_interface/codedot/mindbox/commands/product/ViewCommand.php',

    'Codedot\Mindbox\Commands\Subscribe\InFooter' => '/local/php_interface/codedot/mindbox/commands/subscribe/InFooter.php',
    'Codedot\Mindbox\Commands\Subscribe\InPopUp' => '/local/php_interface/codedot/mindbox/commands/subscribe/InPopUp.php',

    'Codedot\Mindbox\CommandInterface' => '/local/php_interface/codedot/mindbox/CommandInterface.php',
    'Codedot\Mindbox\Sendable' => '/local/php_interface/codedot/mindbox/Sendable.php',
    'Codedot\Mindbox\Sender' => '/local/php_interface/codedot/mindbox/Sender.php',
]);

require_once( $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/codedot/mindbox/Main.php');