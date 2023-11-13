<?php

class Products
{
    private string $fileName;

    public function __construct(string $fileName, string $action)
    {
        $this->fileName = $fileName;
        if (!self::fileCheck($this->fileName)) {
            exit('Файл не найден'. PHP_EOL);
        }

        if (!method_exists($this, $action)) {
            exit('Действие не найдено'. PHP_EOL);
        }
    }

    private static function fileCheck(string $fileName): bool
    {
        return file_exists($fileName);
    }

    protected function getOpenFileForWriting()
    {
        $fileForWriting = fopen($this->fileName, 'a') or die("Не удалось открыть файл". PHP_EOL);
        return $fileForWriting;
    }

    private function getProductsFromFile(): array
    {
        return array_filter(file($this->fileName)); // Получаем все записи из файла в виде массива
    }

    public function addLine(string $line)
    {
        $openFileForWriting = $this->getOpenFileForWriting();
        fwrite($openFileForWriting, $line . PHP_EOL);
        fclose($openFileForWriting);
        echo 'Строка добавлена'. PHP_EOL;
    }

    public function edit($productName, $newPrice)
    {
        $products = $this->getProductsFromFile();// Получаем все записи из файла в виде массива

        foreach ($products as $key => $product) {

            $product = explode('-', $product);

            $productNameForFile = $product[0]; //Получаем название продукта из файла

            if ($productNameForFile == $productName) {
                $productPrice = $newPrice;
                $product = $productName . '-' . $newPrice;
                $products[$key] = $product . PHP_EOL;
                file_put_contents($this->fileName, $products);
                exit('Цена изменена'. PHP_EOL);
            }
        }
        echo 'переданный продукт не найден.'. PHP_EOL;
    }

    public function delete($productName)
    {
        $products = $this->getProductsFromFile();// Получаем все записи из файла в виде массива

        foreach ($products as $key => $product) {
            if (empty(trim($product))) {
                continue;
            }
            $product = explode('-', $product); // Получаем название и цену продукта в виде массива
            $productNameForFile = trim($product[0]); //Получаем отдельно название продукта

            if ($productNameForFile == trim($productName)) {
                unset($products[$key]); // Удаляем продукт из массива
                file_put_contents($this->fileName, $products);// Обратно записываем в файл все оставшиеся продукты
                exit('Продукт удален'. PHP_EOL);
            }
        }
    }

    public function allprice()
    {
        $products = $this->getProductsFromFile();
        $totalPrice = 0;

        foreach ($products as $key => $product) {
            if (empty(trim($product))) {
                continue;
            }

            $product = explode('-', $product);
            $productPriceForFile = trim($product[1]);


            if (is_numeric($productPriceForFile)) {
                $totalPrice += floatval($productPriceForFile);  // Проверка, что цена - это число
            }
        }

        return $totalPrice;
    }
}



$fileName = $argv[1]; // Название файла
$action = $argv[2] ?? null; // Действие
$data = $argv[3] ?? null; // Данные, которую записываем в файл
$newPrice = $argv[4] ?? null; //Новая цена которую будем устанавливать для продукта
$delete = $argv[5] ?? null; //
$allPrice = $argv[6] ?? null; //


$objFile = new Products(fileName: $fileName, action: $action);

if ($action == 'edit') {
    $objFile->$action($data, $newPrice);
} else {
    (!empty($data)) ? $objFile->$action($data) : $objFile->$action();
}
if ($action == 'allprice') {
    $total = $objFile->allprice();
    echo "Общая сумма: $total" . PHP_EOL;
}




