<?php
declare(strict_types=1);

AddEventHandler('main', 'OnAfterUserAdd', ['CodeDotCheckEvent', 'OnAfterUserRegisterHandler']);
AddEventHandler('main', 'OnAfterUserAuthorize', ['CodeDotCheckEvent', 'OnAfterUserAuthorizeHandler']);
AddEventHandler('main', 'OnAfterUserUpdate', ['CodeDotCheckEvent', 'OnAfterUserUpdateHandler']);

AddEventHandler('sale', 'OnBasketUpdate', ['CodeDotCheckEvent', 'OnBasketUpdate']);
AddEventHandler('sale', 'OnBasketDelete', ['CodeDotCheckEvent', 'OnBasketDelete']);
AddEventHandler('favorite', 'OnFavoriteUpdate', ['CodeDotCheckEvent', 'OnFavoriteUpdate']);
AddEventHandler('favorite', 'OnFavoriteDelete', ['CodeDotCheckEvent', 'OnFavoriteDelete']);
AddEventHandler('sale', 'OnOrderSave', ['CodeDotCheckEvent', 'OnOrderSave']);
\Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleStatusOrderChange',
    'onOnSaleStatusOrderChange'
);
AddEventHandler('product', 'OnCatalogView', ['CodeDotCheckEvent', 'OnCatalogView']);
AddEventHandler('product', 'OnProductView', ['CodeDotCheckEvent', 'OnProductView']);

AddEventHandler('subscribe', 'OnFooterSubscribe', ['CodeDotCheckEvent', 'OnFooterSubscribe']);

class CodeDotCheckEvent
{
    public static function OnAfterUserAuthorizeHandler($arUser)
    {
        file_put_contents('checkEVENT.log', date('Y-m-d H:i:s') . " - <pre>" . json_encode($arUser)."</pre>" . "\n", FILE_APPEND);

        if (!empty($arUser['user_fields']['EMAIL']) && !empty($arUser['user_fields']['LAST_LOGIN'])) {
            $userData = [
                'websiteID' => (int)$arUser['user_fields']['ID'],
                'mobilePhone' => $arUser['user_fields']['PERSONAL_PHONE'],
                'email' => $arUser['user_fields']['EMAIL'],
            ];

            $customer = new \Codedot\Mindbox\Object\Customer($userData);
            $command = new \Codedot\Mindbox\Commands\Customer\AutorizationCommand($customer);
            $command->execute();
        }

    }

    public static function OnAfterUserRegisterHandler($arFields)
    {
        if ($arFields['ID'] > 0 && !empty($arFields['EMAIL'])) {
            $userData = [
                'websiteID' => (int)$arFields['ID'],
                'firstName' => $arFields['NAME'],
                'mobilePhone' => $arFields['PERSONAL_PHONE'],
                'email' => $arFields['EMAIL'],
            ];

            $customer = new \Codedot\Mindbox\Object\Customer($userData);
            $command = new \Codedot\Mindbox\Commands\Customer\RegistrationCommand($customer);
            $command->execute();
        }
    }

    public static function OnAfterUserUpdateHandler($arFields)
    {
        if ($arFields['RESULT']) {
            $birthDate = null;
            if ($arFields['PERSONAL_BIRTHDAY']) {
                $birthDate = DateTime::createFromFormat('d.m.Y', $arFields['PERSONAL_BIRTHDAY']);
            }
            $sex = null;
            if ($arFields['PERSONAL_GENDER']) {
                $sex = strtolower($arFields['PERSONAL_GENDER']);
            }

            $userData = [
                'websiteID' => $arFields['ID'],
                'firstName' => $arFields['NAME'],
                'lastName' => $arFields['LAST_NAME'],
                'sex' => $sex,
                'mobilePhone' => $arFields['PERSONAL_PHONE'],
                'email' => $arFields['EMAIL'],
                'birthDate' => $birthDate,
            ];
            $customer = new \Codedot\Mindbox\Object\Customer($userData);
            $command = new \Codedot\Mindbox\Commands\Customer\UpdateCommand($customer);
            $command->execute();
        }
    }

    public static function OnBasketUpdate()
    {
        $basket = \Bitrix\Sale\Basket::loadItemsForFUser(CSaleBasket::GetBasketUserID(), SITE_ID);

        $products = new \Codedot\Mindbox\Object\ProductList();
        foreach ($basket->toArray() as $item) {
            $productItem = new \Codedot\Mindbox\Object\ProductItem([
                'product' => new \Codedot\Mindbox\Object\Product([
                    'websiteID' => (int)$item['PRODUCT_ID']
                ]),
                'count' => (int)$item['QUANTITY'],
                'pricePerItem' => (float)$item['PRICE'],
            ]);

            $products->setProduct($productItem);
        }
        $command = new \Codedot\Mindbox\Commands\Cart\SetCommand($products);
        $command->execute();
    }

    public static function OnBasketDelete($ID)
    {
        $items_cnt = CSaleBasket::GetList(array(),
            array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => "NULL"
            ),
            array()
        );

        if ($items_cnt === 0) {
            $command = new \Codedot\Mindbox\Commands\Cart\ClearCommand();
            $command->execute();
        }
    }

    public static function OnFavoriteUpdate()
    {
        global $USER;
        $cur_user_id = $USER->GetID();

        $arSelect = array("PROPERTY_PRODUCT_ID");
        $arFilter = array("IBLOCK_ID" => 5, "ACTIVE" => "Y", "PROPERTY_USER_ID" => $cur_user_id);
        $res = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
        $dataIds = [];
        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            $dataIds[] = CCatalogProduct::GetByID($arFields["PROPERTY_PRODUCT_ID_VALUE"])['ID'];
        }

        $arOrder = isset($arParams['ELEMENT_SORT_FIELD']) ? [$arParams['ELEMENT_SORT_FIELD'] => $arParams['ELEMENT_SORT_ORDER']] : [];
        $arFilter = ['ACTIVE' => 'Y'];
        $arFilter['ID'] = $dataIds;

        $resOb = CIBlockElement::GetList(
            $arOrder,
            $arFilter,
            false,
            false,
            array_merge(['ID', 'NAME', 'PREVIEW_PICTURE', 'CATALOG_PRICE_1', 'CODE', 'IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL'], ['WEEK',
                'HIT',
                'NEW',
                'STIFFNESS',
                'WEIGHT',
                'HEIGHT',
                'WARRANTY',
                'OFFER_PROPS'])
        );
        $products = new \Codedot\Mindbox\Object\ProductList();
        while ($arItem = $resOb->Fetch()) {
            $productItem = new \Codedot\Mindbox\Object\ProductItem([
                'product' => new \Codedot\Mindbox\Object\Product([
                    'websiteID' => (int)$arItem['ID']
                ]),
                'count' => 1,
                'pricePerItem' => (float)$arItem['CATALOG_PRICE_1'],
            ]);

            $products->setProduct($productItem);
        }

        $command = new \Codedot\Mindbox\Commands\Favorite\SetCommand($products);
        $command->execute();
    }

    public static function OnFavoriteDelete()
    {
        $command = new \Codedot\Mindbox\Commands\Favorite\ClearCommand();
        $command->execute();
    }

    public static function OnOrderSave($orderId, $fields, $orderFields, $isNew)
    {
        $paymentsBD = \Bitrix\Sale\PaymentCollection::getList([
            'select' => ['*'],
            'filter' => [
                '=ORDER_ID' => $orderId,
            ]
        ]);
        $payment = $paymentsBD->fetch();
        $order = [];
        $order['ids']['websiteID'] = $orderId;
        $order['totalPrice'] = $orderFields['PRICE'];
        $order['lines'] = [];
        foreach ($orderFields['BASKET_ITEMS'] as $NUMBER_ITEM => $BASKET_ITEM) {
            $LINE_NUMBER = $NUMBER_ITEM+1;
            $order['lines'][] = [
                'basePricePerItem' => $BASKET_ITEM['PRICE'],
                'quantity' => (int)$BASKET_ITEM['QUANTITY'],
                'quantityType' => 'int',
                'discountedPricePerLine' => $BASKET_ITEM['PRICE'] * $BASKET_ITEM['QUANTITY'],
                'lineNumber' => $LINE_NUMBER,
                'product' => [
                    'ids' => [
                        'website' => $BASKET_ITEM['PRODUCT_ID']
                    ]
                ]
            ];
        }
        $order['payments'][] = [
            'type' => Cutil::translit($payment['PAY_SYSTEM_NAME'], "ru", array("replace_space" => "-", "replace_other" => "-")),
            'amount' => $payment['SUM']
        ];
        $order['email'] = $orderFields['USER_EMAIL'];

        if (!empty($isNew)) {
            global $USER;
            $cur_user_id = $USER->GetID();

            if ($cur_user_id == 0) {
                $userData = [
                    'websiteID' => 0,
                    'mobilePhone' => $orderFields['ORDER_PROP'][3],
                    'email' => $orderFields['ORDER_PROP'][2],
                ];
                $customer = new \Codedot\Mindbox\Object\Customer($userData);
                $command = new \Codedot\Mindbox\Commands\Order\UnauthorizedCommand($customer, $order);
            } else {
                $userData = [
                    'websiteID' => (int)$cur_user_id,
                ];
                $customer = new \Codedot\Mindbox\Object\Customer($userData);
                $command = new \Codedot\Mindbox\Commands\Order\AuthorizedCommand($customer, $order);
            }
            $command->execute();
        } else {
            $command = new \Codedot\Mindbox\Commands\Order\UpdateCommand((int)$fields['USER_ID'], $order);
            $command->execute();
        }
    }

    public static function OnCatalogView($args)
    {
        if (!empty($args['category_id'])) {
            $command = new \Codedot\Mindbox\Commands\Product\ViewCategoryCommand((int)$args['category_id']);
            $command->execute();
        }
    }

    public static function OnProductView($args)
    {
        if (!empty($args['product_id'])) {
            $command = new \Codedot\Mindbox\Commands\Product\ViewCommand((int)$args['product_id']);
            $command->execute();
        }
    }

    public static function OnFooterSubscribe($args)
    {
        $userData = [
            'email' => $args['SUBSCRIPTION']['EMAIL'],
        ];
        $command = new \Codedot\Mindbox\Commands\Subscribe\InFooter($userData);
        $command->execute();
    }
}


function onSaleStatusOrderChange(\Bitrix\Main\Event $event)
{
    $statuses = \Bitrix\Sale\OrderStatus::getAllStatusesNames();

    $status_ID = $event->getParameter('VALUE');
    $order_id = $event->getParameter('ENTITY')->getShipmentCollection()->getItemByIndex(0)->getField('ORDER_ID');

    $command = new \Codedot\Mindbox\Commands\Order\UpdateStatusCommand((int)$order_id, $statuses[$status_ID]);
    $command->execute();
}