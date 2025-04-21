<?php

namespace App\Controllers;

use App\Models\Product;

use Framework\Viewer;

use Framework\Exceptions\PageNotFoundException;

class Products
{
    public function index()
    {

        //require "src/models/product.php";

        $model = new Product();

        // call getData() method from product model
        // assign result set to $products variable
        $products = $model->getData();

        if ($products === false) {

            throw new PageNotFoundException("Product not found");
            
        }

        $viewer = new Viewer;

        echo $viewer->render("shared/header.php", [
            "title" => "Product List"
        ]);

        echo $viewer->render("Products/index.php", [
            "products" => $products
        ]);
        //require "views/product-list.php";
    }

    public function show(?string $id = NULL)
    {

        $model = new Product;

        $product = $model->find($id);

        if ($product === false) {

            throw new PageNotFoundException("Product not found");
        }   
        
        $viewer = new Viewer;

        echo $viewer->render("shared/header.php", [
            "title" => "Product Details"
        ]);

        echo $viewer->render("Products/show.php");
    }
}