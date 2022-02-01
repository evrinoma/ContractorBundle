# Configuration

преопределение штатного класса сущности

    contractor:
        db_driver: orm модель данных
        factory: App\Contractor\Factory\ContractorFactory фабрика для создания объектов, 
                 не достающие значения можно разрешить на уровне Mediator или переопределив фабрику 
        entity: App\Contractor\Entity\Contractor сущность
        split: default(false) включает разделение сущностей на две таблицы пока не работает
        // -- entity_company: App\Contractor\Entity\ContractorCompany сущность компании
        // -- entity_person: App\Contractor\Entity\ContractorPerson сущность перосоны
        dto_class: App\Contractor\Dto\ContractorDto класс dto с которым работает сущность 

# CQRS model

Actions в контроллере разбиты на две группы
создание, редактирование, удаление данных

        1. putAction(PUT), postAction(POST), deleteAction(DELETE)
получение данных

        2. getAction(GET), criteriaAction(GET)
    
каждый метод работает со своим менеджером

        1. CommandManagerInterface
        2. QueryManagerInterface

При переопределении штатного класса сущности, дополнение данными осуществляется декорированием, с помощью MediatorInterface


группы  сериализации
    
    1. api_get_contractor - получение контрагентов
    2. api_post_contractor - создание контрагента
    3. api_put_contractor -  редактирование контрагента

# Статусы:

    создание:
        контрагент создан HTTP_CREATED 201
    обновление:
        контрагент обновление HTTP_OK 200
    удаление:
        контрагент удален HTTP_ACCEPTED 202
    получение:
        контрагент(ы) найдены HTTP_OK 200
    ошибки:
        если контрагент не найден ContractorNotFoundException возвращает HTTP_NOT_FOUND 404
        если контрагент не уникален UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если контрагент не прошел валидацию ContractorInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если контрагент не может быть сохранен ContractorCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

# Constraint

Для добавления проверки поля сушности contractor нужно описать логику проверки реализующую интерфейс Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface и зарегестрировать сервис с этикеткой evrinoma.contractor.constraint.propert

    evrinoma.contractor.constraint.property.custom:
        class: App\Contractor\Constraint\Property\Custom
        tags: [ 'evrinoma.contractor.constraint.property' ]

# Тесты:

    composer install --dev

### run all tests

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests --teamcity

### run personal test for example testPost

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests/Functional/Controller/TypeApiControllerTest.php --filter "/::testPost( .*)?$/" 

