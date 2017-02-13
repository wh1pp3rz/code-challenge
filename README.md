Sumfony3 REST API based on  [Talentnet code challenge](https://github.com/TalentNet/coding-challenges/blob/master/roles/senior-php.md).

# What's outstanding

* More unit test for better code coverage
* User authentication (This can be done using the [JWT Package](https://github.com/lexik/LexikJWTAuthenticationBundle))
* Complete annotations to generate api docs based on [Nemio Api Doc Bundle](https://github.com/nelmio/NelmioApiDocBundle)
* Further deployment preparation using parameters
* Run codesniffer on all source files

# What's completed
* Basic Api methods based on Symfony3 with [FOSResBundle](https://github.com/FriendsOfSymfony/FOSRestBundle)
* Data transformation done with the [Fractal Bundle](https://github.com/thephpleague/fractal)
* Unit test based on [CodeCeption](https://github.com/Codeception/Codeception)


# Setup
* Download or clone package
* Update composer dependencies
* Setup database
* Run CodeCeption api suite


#API Endpoints
* GET /api/doc API Documentation (incomplete, requires further annotations)
* GET /api/products - List All products
* GET /api/products/{id} - GEt a specific products
* GET /api/categories - List All Categories
* POST /api/products - Create a product
* PATCH /api/products - Update a product

# Additional Notes
* Categories and Products are implemented as separate entities for normalization of the DB
* Categories and Products have separate controllers
* Data lifting is isolated from controllers by use of handlers, allow for easy substitution of the datasource if with mininal code change