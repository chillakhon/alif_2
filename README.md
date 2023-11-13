## Использование 

1**Запуск:**
    - Откройте командную строку в папке со скриптом.
    - Выполните команду для добавления продукта:
      ```bash
      php task.php products.txt addline "Банан-20"
      php task.php products.txt addline "Помидоры-10"
      ```
    - Для редактирования цены продукта:
      ```bash
      php task.php products.txt edit Банан 45
      php task.php products.txt edit Помидоры 76
      ```
    - Для удаления продукта:
      ```bash
      php task.php products.txt delete "Банан"
      php task.php products.txt delete "Помидоры"
      ```
    - Для получения общей суммы цен продуктов:
      ```bash
      php task.php products.txt allprice
      ```