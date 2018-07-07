#Гайд по использованию Api

## Авторизация:

- Получение кода
    ```
        POST api/v1/get-code
            params:
                - email[required][string]
            return:
                - code
    ```

- Получение токена
    ```
        POST api/v1/auth
            params:
                - code [required][integer(6)]
            return:
                - token
    ```

### После получения токена работает bearer авторизация.
Токены безсрочные, можно использовать разные токены на разных устройствах.

## Профиль:

- Получение профиля текущего пользователя
    ```
        GET api/v1/profile
            return:
                - profile
                (профиль, текущие настройки, фильтры, закладки)
    ```
    
- Обновление профиля текущего пользователя(изменение профиля настроек)
    ```
        POST api/v1/profile/update
            params:
                - settings_id [required][integer]
            return:
                - profile(см.выше)
    ```

## Настройки пользователя:

- Получение всех профилей настроек текущего пользователя
    ```
        GET api/v1/user-settings
            return:
                - settings[]
    ```
    
- Получение текущего/ещё какого-то профиля настроек текущего пользователя(если не указывать id, то текущие)
    ```
        GET api/v1/user-settings/view/<id>
            params:
                - id [integer]
            return:
                - settings
    ```

- Удаление профиля настроек текущено польозвателя по id
    ```
        DELETE api/v1/user-settings/delete/<id>
            params:
                - id [required][integer]
            return:
                - bool
    ```

- Создание профиля настроек для текущего пользователя
    ```
        POST api/v1/user-settings/create
            params:
                - name [required][string][max 255]
                - description [string]
            return:
                - settings
    ```

- Обновление текущего профиля настроек для текущего пользователя
    ```
        POST api/v1/user-settings/update
            params:
                - name [string 255]
                - description [string]
                - parsers[JSON]
                - currency[string(3)]
                - valueFrom[integer]
                - valueTo[integer]
                - showPrice[integer]
                - searchTitle[integer]
                - searchDescription[integer]
            return:
                - settings
    ```

## Фильтры:

- Все фильтры
    ```
        GET api/v1/user-filter
            return:
                - filter[]
    ```

- Создание
    ```
        POST api/v1/user-filter/create
            params:
                - value[required][string]
            return:
                - bool
    ```

- Удаление
    ```
        DELETE api/v1/user-filter/delete/<id>
            params:
                - id[required][integer]
            return:
                - filter
    ```

## Получение данных:

- Поиск - если не указано id, то выдаёт limit элементов, если указано id, 
то searchBefore или searchAfter обязательные и поиск проводится от указанного id - 
searchBefore выводить < id, и наоборот...

    ```
        POST api/v1/project/search
            params:
                - id[integer]
                - searchBefore[integer][0 or 1]
                - searchAfter[integer][0 or 1]
                - limit[integer][10 - 100]
            return:
                - project[]
    ```

## Дополнительные роуты:
    
1. Список парсеров:

    - Получение списка всех доступных парсеров
    
    ```
        GET api/v1/parser
    ```
    
1. Список доступных кодов валют:

    - Получение списка всех доступных кодов валют
    ```
        GET api/v1/currency
    ```
    
    - Поиск кода по названию
    ```
        GET api/v1/currency/search/<q>
    ```
    
###Что не понятно спрашивай!"# api-demo" 
