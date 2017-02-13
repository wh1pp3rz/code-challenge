<?php

use Symfony\Component\HttpFoundation\Response;
use \Page\ApiCategoriesPage;

class CategoriesControllerCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    public function ensureDefaultResponseTypeIsJson(ApiTester $I)
    {
        $I->sendGET(ApiCategoriesPage::$URL);
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
    }

    public function getAllCategories(ApiTester $I)
    {
        $I->sendGET(ApiCategoriesPage::$URL);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(
            [
                'name' => 'Games'
            ],
            [
                'name' => 'Computers'
            ],
            [
                'name' => 'TVs and Accessories'
            ]
        );
    }
}
