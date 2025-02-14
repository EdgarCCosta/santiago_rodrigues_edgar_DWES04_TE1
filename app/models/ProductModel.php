<?php
require_once 'Product.php';

class ProductModel
{
    private $pathFichero = '../data/products.json';

    public function getAll()
    {
        $data = json_decode(file_get_contents($this->pathFichero), true);
        return array_map(function ($item) {
            return new Product($item['id'], $item['nombre'], $item['precio'], $item['stock'], $item['descripcion']);
        }, $data);
    }

    public function getById($id)
    {
        $products = $this->getAll();
        foreach ($products as $product) {
            if ($product->id == $id) {
                return $product;
            }
        }
        return null;
    }

    public function add($data)
    {
        $products = $this->getAll();
        if (!isset($data['id']) || empty($data['id'])) {
            $data['id'] = uniqid();
        }

        $newProduct = new Product($data['id'], $data['nombre'], $data['precio'], $data['stock'], $data['descripcion']);
        $products[] = $newProduct;

        return file_put_contents($this->pathFichero, json_encode($products, JSON_PRETTY_PRINT));
    }

    public function update($id, $data)
    {
        $products = $this->getAll();
        foreach ($products as &$product) {
            if ($product->id == $id) {
                $product->nombre = $data['nombre'];
                $product->precio = $data['precio'];
                $product->stock = $data['stock'];
                $product->descripcion = $data['descripcion'];
                return file_put_contents($this->pathFichero, json_encode($products, JSON_PRETTY_PRINT));
            }
        }
        return false;
    }

    public function delete($id)
    {
        $products = $this->getAll();
        foreach ($products as $key => $product) {
            if ($product->id == $id) {
                unset($products[$key]);
                return file_put_contents($this->pathFichero, json_encode(array_values($products), JSON_PRETTY_PRINT));
            }
        }
        return false;
    }
}
