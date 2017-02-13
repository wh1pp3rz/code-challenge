<?php

use Symfony\Component\HttpFoundation\Response;
use \Page\ApiProductPage;

class ProductsControllerCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function getInvalidProduct(ApiTester $I)
    {
        $I->wantTo('ensure Getting an invalid Product id returns a 404 code');
        $I->sendGET(ApiProductPage::route('/589998'));
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
        $I->seeResponseIsJson();
    }

    public function ensureDefaultResponseTypeIsJson(ApiTester $I)
    {
        $I->sendGET(ApiProductPage::route('/1'));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
    }

    public function getValidProduct(ApiTester $I)
    {
        foreach ($this->validProductProvider() as $data) {
            $I->sendGET(ApiProductPage::route('/' . $data[0]));
            $I->seeResponseCodeIs(Response::HTTP_OK);
            $I->seeResponseIsJson();
            $I->seeResponseContainsJson($data[1]);
        }
    }


    public function getProductsCollection(ApiTester $I)
    {
        $I->sendGET(ApiProductPage::$URL);
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'name' => 'Pong',
                'category' => 'Games',
                'sku' => 'A0001',
                'price' => 69.99,
                'quantity' => 20
            ],
            [
                'name' => 'GameStation 5',
                'category' => 'Games',
                'sku' => 'A0002',
                'price' => 269.99,
                'quantity' => 15
            ],
            [
                'name' => 'AP Oman PC - Aluminum',
                'category' => 'Computers',
                'sku' => 'A0003',
                'price' => 1399.99,
                'quantity' => 10
            ],
            [
                'name' => 'Fony UHD HDR 55" 4k TV',
                'category' => 'TVs and Accessories',
                'sku' => 'A0004',
                'price' => 69.99,
                'quantity' => 5
            ]
        ]);
    }

    public function getProductsCollectionWithLimit(ApiTester $I)
    {
        $I->sendGET(ApiProductPage::route('?limit=1'));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'name' => 'Pong',
                'category' => 'Games',
                'sku' => 'A0001',
                'price' => 69.99,
                'quantity' => 20
            ],
        ]);
    }

    public function getProductsCollectionWithOffset(ApiTester $I)
    {
        $I->sendGET(ApiProductPage::route('?offset=1'));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'name' => 'GameStation 5',
            'category' => 'Games',
            'sku' => 'A0002',
            'price' => 269.99,
            'quantity' => 15
        ]);
    }


    public function getProductsCollectionWithLimitAndOffset(ApiTester $I)
    {
        $I->sendGET(ApiProductPage::route('?offset=1&limit=3'));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'name' => 'Fony UHD HDR 55" 4k TV',
            'category' => 'TVs and Accessories',
            'sku' => 'A0004',
            'price' => 69.99,
            'quantity' => 5
        ]);
    }

    public function postWithEmptyFieldsReturns400ErrorCode(ApiTester $I)
    {
        $I->sendPOST(ApiProductPage::$URL, []);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    public function postWithBadFieldsReturns400ErrorCode(ApiTester $I)
    {
        $I->sendPOST(ApiProductPage::$URL, array(
            'bad_field' => 'abcdefghijk'
        ));
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    private function validProductProvider()
    {
        return [
            [
                '1',
                [
                    'name' => 'Pong',
                    'category' => 'Games',
                    'sku' => 'A0001',
                    'price' => 69.99,
                    'quantity' => 20
                ]
            ],
            [
                '2',
                [
                    'name' => 'GameStation 5',
                    'category' => 'Games',
                    'sku' => 'A0002',
                    'price' => 269.99,
                    'quantity' => 15
                ]
            ],
            [
                '3',
                [
                    'name' => 'AP Oman PC - Aluminum',
                    'category' => 'Computers',
                    'sku' => 'A0003',
                    'price' => 1399.99,
                    'quantity' => 10
                ]
            ],
            [
                '4',
                [
                    'name' => 'Fony UHD HDR 55" 4k TV',
                    'category' => 'TVs and Accessories',
                    'sku' => 'A0004',
                    'price' => 69.99,
                    'quantity' => 5
                ]
            ],
        ];
    }
}
