<?php

require_once(__DIR__ . "/../models/Blog.php");
require_once(__DIR__ . "/../middlewares/Auth.php");
require_once(__DIR__ . "/../middlewares/Admin.php");

class BlogController
{
    public function create($data)
    {

        if (!auth()) {
            return [
                "code" => 401,
                "status" => "error",
                "message" => "Unauthorized Access"
            ];
        }

        $errors   = [];
        $content = trim(strip_tags($data["content"]));

        if (empty(trim($data["title"]))) {
            $errors["title"] = "Title Field is Required!";
        }
        if (empty(trim($data["category"]))) {
            $errors["category"] = "Category Field is Required!";
        }
        if (empty(trim($content))) {
            $errors["content"] = "Content Field is Required!";
        }

        if (empty(trim($data["excerpt"]))) {
            $errors["excerpt"] = "Excerpt Field is Required!";
        }
        if (empty($data["featured_image"]["name"])) {
            $errors["featured_image"] = "Featured Image is Required!";
        }

        // Handle File Upload
        $file = $data["featured_image"];
        $featured_image = null;

        if ($file && $file["error"] === 0) {
            $target_dir = __DIR__ . "/../public/images/featured/";
            // ensure folder exists
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

            // Validate file is image
            $check = getimagesize($file["tmp_name"]);

            if ($check === false) {
                $errors["featured_image"] = "File is Not a Valid Image!";
            }

            // Allow only specific types
            $allowed_types = ["jpg", "jpeg", "png"];
            if (!in_array($imageFileType, $allowed_types)) {

                $errors["featured_image"] = "Only JPG, JPEG & PNG allowed";
            }

            // Generate unique filename
            $newFileName = uniqid("blog_", true) . "." . $imageFileType;
            $target_file = $target_dir . $newFileName;

            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                // Save relative path for DB
                $featured_image = "images/featured/" . $newFileName;
            } else {
                $errors["featured_image"] = "Error uploading file!";
            }
        }

        if (!empty($errors)) {
            return [
                "status" => "error",
                "errors" => $errors
            ];
        }


        $user_id = $_SESSION["id"]; // fallback if not logged in

        $blog = new Blog();
        $blog->user_id = $user_id;
        $blog->title = $data["title"];
        $blog->content = $data["content"];
        $blog->category = $data["category"];
        $blog->featured_image = $featured_image;

        if ($blog->create()) {
            return [
                "status" => "success",
                "message" => "You Blog has been Successfully submitted!"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Unknown Error During Blog submition!"
            ];
        }
    }

    public function findAll($data)
    {
        $blogModel = new Blog();


        if (!empty($data["query"]) || !empty($data["category_id"])) {

            $blogs = $blogModel->search($data);

            if ($blogs && count($blogs["blogs"]) > 0) {
                return [
                    "status" => "success",
                    "blogs" => $blogs["blogs"],
                    "total" => $blogs["total"],
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Not Found",
                    "code" => 404
                ];
            }
        }

        $blogs = $blogModel->findAll($data);

        if ($blogs && count($blogs["blogs"]) > 0) {
            return [
                "status" => "success",
                "blogs" => $blogs["blogs"],
                "total" => $blogs["total"]
            ];
        }
        return [
            "status" => "error",
            "message" => "Not Found!",
            "code" => 404
        ];
    }

    public function count()
    {
        $count = (new Blog())->count();
        return $count;
    }

    public function findById($id)
    {
        $blog = (new Blog())->findById($id);
        if ($blog) {
            return $blog;
        }
        return false;
    }
    public function findFeatured()
    {
        $featured = (new Blog())->findFeatured();
        if ($featured) {
            return $featured;
        }
        return false;
    }

    public function findByCategory($data)
    {


        $blog = (new Blog())->findByCategory($data);
        if ($blog) {
            return [
                "status" => "success",
                "blogs" => $blog
            ];
        }


        return [
            "status" => "error",
            "message" => "Not Found!",
            "code" => 404
        ];
    }
    public function findByUserId($id = null)
    {
        if (!$id) {

            $id = $_SESSION["id"];
        }

        $blogs = (new Blog())->findByUserId($id);
        if ($blogs) {
            return $blogs;
        } else {

            return false;
        }
    }

    public function findByTitle($title)
    {
        if ($title == "") {
            return [
                "status" => "error",
                "message" => "Title is Required"
            ];
        } else {

            $blog = (new Blog())->findByTitle($title);

            if ($blog) {
                return $blog;
            } else {
                return false;
            }
        }
    }

    public function search($data = array())
    {

        $blogs = new Blog();
        if (!empty($data["query"]) || !empty($data["category_id"])) {
        }
        if ($blogs) {
            return [
                "status" => "success",
                "blogs" => $blogs
            ];
        }
        return [
            "status" => "error",
            "message" => "Not Found"
        ];
    }
    public function update($id, $data)
    {



        if (!auth()) {
            return [
                "code" => 401,
                "status" => "error",
                "message" => "Unauthorized Access"
            ];
        }

        $blogModel = new Blog();
        $blog = $blogModel->findById($id);

        if (!$blog) {
            return [
                "status" => "error",
                "message" => "Not Found"
            ];
        }

        if ($blog["user_id"] != $_SESSION['id'] && !checkAdmin()) {
            return [
                'status' => 'error',
                'message' => 'Unauthorized Access',
                'code' => 401
            ];
        }

        $errors = [];

        if (empty($data["title"])) {
            $errors["title"] = "Title Field is Required!";
        }
        if (empty($data["category"])) {
            $errors["category"] = "Category is Required!";
        }
        if (empty(trim(strip_tags($data["content"])))) {
            $errors["content"] = "Content Field is Required!";
        }

        $file = $data["featured_image"] ?? null;
        $featured_image = $blog["featured_image"]; // keep old by default

        if ($file && $file["error"] === 0) {
            $target_dir = __DIR__ . "/../public/images/featured/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
            $check = getimagesize($file["tmp_name"]);

            if ($check === false) {
                $errors["featured_image"] = "File is Not a Valid Image!";
            }

            $allowed_types = ["jpg", "jpeg", "png"];
            if (!in_array($imageFileType, $allowed_types)) {
                $errors["featured_image"] = "Only JPG, JPEG & PNG allowed";
            }

            if (empty($errors)) {
                // Generate new filename
                $newFileName = uniqid("blog_", true) . "." . $imageFileType;
                $target_file = $target_dir . $newFileName;

                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    // Delete old file after successful upload
                    if (!empty($blog["featured_image"])) {
                        $oldFile = __DIR__ . "/../public/" . $blog["featured_image"];
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }
                    // Save new relative path
                    $featured_image = "images/featured/" . $newFileName;
                } else {
                    $errors["featured_image"] = "Error uploading file!";
                }
            }
        }

        if (!empty($errors)) {
            return [
                "status" => "error",
                "errors" => $errors
            ];
        }

        $data["featured_image"] = $featured_image;

        if ($blogModel->update($id, $data)) {
            return [
                "status" => "success",
                "message" => "Blog Successfully Updated!"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Unknown Error During Update!"
            ];
        }
    }


    public function delete($id)
    {

        if (!auth()) {
            return [
                "code" => 401,
                "status" => "error",
                "message" => "Unauthorized Access"
            ];
        }

        $Blog = new Blog();

        if ($blog = $Blog->findById($id)) {

            if ($blog["user_id"] != $_SESSION['id'] && !checkAdmin()) {
                return [
                    'status' => 'error',
                    'message' => 'Unauthorized Access',
                    'code' => 401
                ];
            }


            if ($Blog->delete($id)) {
                return [
                    "status" => "success",
                    "message" => "Blog Deleted Successfully!"
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Unknown Error During Delete!"
                ];
            }
        } else {

            return [
                "status" => "error",
                "message" => "Not Found!"
            ];
        }
    }
}
