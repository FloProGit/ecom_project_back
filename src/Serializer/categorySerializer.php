<?php


use App\Entity\Categories;

class categorySerializer
{
    public function deserializing(Categories $categoriesCa)
    {
        try {
            file_get_contents('../../public/FileTest/files-categories-csv-prestashop-category-2570-fr.csv');

        }
        catch(Exception $e)
        {

        }

    }
}