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

        if (empty(trim($data["title"]))) {
            $errors["title"] = "Title Field is Required!";
        } else {
            if (strlen($data["title"]) < 20) {
                $errors["title"] = "Title Should be atleast 20 Characters!";
            }
        }
        if (empty(trim($data["category"]))) {
            $errors["category"] = "Category Field is Required!";
        }
        if (empty(trim($data["content"]))) {
            $errors["content"] = "Content Field is Required!";
        } else {
            if (strlen($data["content"]) < 500) {
                $errors["content"] = "Content Should be Atleast 500 Characters!";
            }
        }

        if (empty(trim(strip_tags($data["excerpt"])))) {
            $errors["excerpt"] = "Excerpt Field is Required!";
        } else {

            if (strlen($data["excerpt"]) < 80 || strlen($data["excerpt"]) > 300) {
                $errors["excerpt"] = "Excerpt Should be between 80 - 300 Characters";
            }
        }

        if (empty($data["featured_image"]["name"])) {
            $errors["featured_image"] = "Featured Image is Required!";
        }

        // Handle File Upload
        $file = $data["featured_image"];
        $featured_image = null;

        if ($file && $file["error"] === 0) {
            $target_dir = __DIR__ . "/../public/images/featured/";

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

            if ($file["size"] > 2 * 1024 * 1024) { // 2MB limit
                $errors["featured_image"] = "Image must be less than 2MB";
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

        $user_id = $_SESSION["id"];
        $user = (new User())->findById($user_id);

        if ($user["email_verified"] == "false") {
            return [
                "status" => "error",
                "message" => "Please Verify Email First!"
            ];
        }

        $sanitized_data = [
            "title" => strip_tags(trim($data["title"])),
            "content" => trim($data["content"]),
            "category" => strip_tags(trim($data["category"])),
            "excerpt" => strip_tags(trim($data["excerpt"])),
            "featured_image" => strip_tags($featured_image)
        ];

        $blog = new Blog();
        $blog->user_id = $user_id;
        $blog->title = $sanitized_data["title"];
        $blog->content = $sanitized_data["content"];
        $blog->excerpt = $sanitized_data["excerpt"];
        $blog->category = $sanitized_data["category"];
        $blog->featured_image = $sanitized_data["featured_image"];

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

    public function findAll($data = array())
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
                    "message" => "No Blogs Found!",
                    "code" => 404
                ];
            }
        }

        $blogs = $blogModel->findAll($data["offset"] ?? 0);

        if ($blogs && count($blogs["blogs"]) > 0) {
            return [
                "status" => "success",
                "blogs" => $blogs["blogs"],
                "total" => $blogs["total"]
            ];
        }
        return [
            "status" => "error",
            "message" => "No Blogs Found!",
            "code" => 404
        ];
    }

    public function topBlogs()
    {
        $blogModel = new Blog();
        $blogs = $blogModel->topBlogs();

        if ($blogs && count($blogs) > 0) {
            return [
                "status" => "success",
                "blogs" => $blogs
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Not Found!",
                "code" => 404
            ];
        }
    }
    public function count()
    {
        $count = (new Blog())->count();

        return $count;
    }

    public function addView($id)
    {
        $blogModel = new Blog();
        $blog = $blogModel->findById($id);

        if (!$blog) {
            return [
                "status" => "error",
                "message" => "Blog Not Found!",
                "code" => 404
            ];
        }

        if ($blogModel->addView($id)) {
            return [
                "status" => "success",
                "message" => "View Added",
            ];
        }
    }

    public function findById($id)
    {
        $blog = (new Blog())->findById($id);
        if ($blog) {
            return [
                "status" => "success",
                "blog" => $blog,
            ];
        }
        return [
            "status" => "error",
            "message" => "Blog Not Found",
            "code" => 404
        ];
    }
    public function findFeatured()
    {
        $blogs = (new Blog())->findFeatured();
        if (count($blogs) > 0) {
            return [
                "status" => "success",
                "blogs" => $blogs
            ];
        }
        return [
            "status" => "error",
            "message" => "No Featured Blogs Found!",
            "code" => 404
        ];
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
            "message" => "Blogs Not Found!",
            "code" => 404
        ];
    }
    public function findByUserId($id = null)
    {
        if (!$id || $id == null) {

            return [
                "status" => "error",
                "message" => "Blogs Not Found!",
                "code" => 404
            ];
        }

        $blogs = (new Blog())->findByUserId($id);
        if (count($blogs["blogs"]) > 0) {
            return [
                "status" => "success",
                "blogs" => $blogs["blogs"],
                "total" => $blogs["total"]
            ];
        } else {

            return [
                "status" => "error",
                "message" => "Blogs Not Found!",
                "code" => 404
            ];
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
        if (empty(trim(strip_tags($data["excerpt"])))) {
            $errors["excerpt"] = "Excerpt Field is Required!";
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
                "message" => "No changes were made!"
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
