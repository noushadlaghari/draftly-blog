<?php

require_once(__DIR__ . "/../models/Category.php");

class CategoriesController
{


    public function findAll($offset = 0, $limit = 8)
    {
        $categories = (new Category())->findAll($offset, $limit);
        if ($categories) {
            return [
                "status"=>"success",
                "categories"=> $categories["categories"],
                "total"=> $categories["total"]
            ];
        }
        else{
            return [
                "status"=> "error",
                "message"=>"Categories Not Found!"
                ];
        }
    }

    public function findById($id)
    {

        $category = (new Category())->findById($id);

        if (count($category)>0) {
            return [
                "status"=> "success",
                "category"=> $category

            ];
        }
        else{
            return [
                "status"=> "error",
                "message"=> "Category not found!"
                ];
        }
    }

    public function create($data)
    {


        $errors = array();

        if (empty($data["category_name"])) {
            $errors["category_name"] = "Category Name is required!";
        }
        if (empty($data["category_slug"])) {
            $errors["category_slug"] = "Category Slug is required!";
        }
        if (!empty($errors)) {
            return [
                "statuts" => "errors",
                "errors" => $errors,
            ];
        }

        $categoryModel = new Category();

        if ($categoryModel->create($data)) {
            return [
                "status" => "success",
                "message" => "Category Created Successfully!",

            ];
        } else {
            return [
                "status" => "error",
                "message" => "Unable to Create Category!",
            ];
        }
    }

    public function update($data)
    {
        $errors = array();
        if (empty($data["category_name"])) {
            $errors["category_name"] = "Category Name is required!";
        }
        if (empty($data["category_slug"])) {
            $errors["category_slug"] = "Category Slug is required!";
        }
        if (!empty($errors)) {
            return [
                "status" => "errors",
                "errors" => $errors
            ];
        }

        $categoryModel = new Category();
        if ($categoryModel->update($data)) {
            return [
                "status" => "success",
                "message" => "Category Updated Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "No Changes were made!"
            ];
        }
    }

    public function delete($id)
    {
        $categoryModel = new Category();
        if(!count($categoryModel->findById($id))>0){
            return [
                "status"=> "error",
                "message"=> "Category Not Found!",
                "code"=>404
            ];
        }
        
        if($categoryModel->delete($id)){
            return [
                "status"=> "success",
                "message"=> "Category Deleted Successfully!"
                ];
            }else{
                return [
                    "status"=> "error",
                    "message"=> "Unable to Delete Category!"
                    ];
            }
    }
}
