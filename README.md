#Configuration

преопределение штатного класса сущности

    contractor:
        db_driver: orm модель данных
        class: App\Contractor\Entity\Contractor сущность
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


