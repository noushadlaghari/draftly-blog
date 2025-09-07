<?php
require_once(__DIR__ . "/../models/Comment.php");


class CommentsController
{

    public function create($data)
    {

        session_start();
        $comment = new Comment();
        $comment->user_id = $_SESSION["id"];
        $comment->content = $data["content"];
        $comment->blog_id = $data["blog_id"];

        if ($comment->create()) {
            return [
                "status" => "success",
                "message" => "Comment Added Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Unable to Add Comment!"
            ];
        }
    }

    public function findByBlogId($id)
    {

        $comment = (new Comment())->findByBlogId($id);
        if ($comment) {
            return $comment;
        } else {
            return false;
        }
    }
    public function findById($id)
    {
        $comment = (new Comment())->findById($id);
        if ($comment) {
            return $comment;
        }
        return false;
    }

    public function update($id, $data)
    {
        $comment = new Comment();
        if ($comment->findById($id)) {

            if ($comment->update($id, $data)) {
                return [
                    "status" => "success",
                    "message" => "Comment Updated Successfully!"
                ];
            } else {
                return [
                    "status" => "error",
                    "message" => "Unable to Update Comment!"
                ];
            }
        } else {
            return [

                "status" => "error",
                "message" => "Not Found!",
                "code" => 404


            ];
        }
    }
}
