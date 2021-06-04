#Configuration

преопределение штатного класса сущности

    contractor:
        db_driver: orm модель данных
        entity: App\Contractor\Entity\Contractor сущность
        split: default(false) включает разделение сущностей на две таблицы пока не работает
        // -- entity_company: App\Contractor\Entity\ContractorCompany сущность компании
        // -- entity_person: App\Contractor\Entity\ContractorPerson сущность перосоны
        dto_class: App\Contractor\Dto\ContractorDto класс dto с которым работает сущность 

#CQRS model

Actions в контроллере разбыиты на две группы
создание, редактирование, удаление данных

        1. putAction(PUT), postAction(POST), deleteAction(DELETE)
получение данных

        2. getAction(GET), criteriaAction(GET)
    
каждый метод работает со своим менеджером

        1. CommandManagerInterface
        2. QueryManagerInterface

При преопределении штатного класса сущности, дополнение данными осуществляется декорированием, с помощью MediatorInterface


группы  сериализации
    
    1. api_get_contractor - получение контрагентов
    2. api_post_contractor - создание контрагента
    3. pi_put_contractor -  редактирование контрагента

