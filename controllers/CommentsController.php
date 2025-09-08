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


    public function findAll($offset = 0,$limit = 8)
    {
      $comments = (new Comment())->findAll($offset, $limit);
      

        if (count($comments) > 0) {
            return [
                "status" => "success",
                "comments" => $comments["comments"],
                "total"=> $comments["total"],
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Comments Not Found!",
                "code" => 404
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
        if (count($comment) > 0) {
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

    public function approve($id){
        $commentModel = new Comment();
        $comment = (new Comment())->findById($id);
        if (count($comment) > 0) {
            
            if($commentModel->approve($id)) {
                return [
                    "status"=> "success",
                    "message"=> "Comment Approved Successfully!"
                    ];
            }else{
                return [
                    "status"=> "error",
                    "message"=> "Unkown Error During Comment Approval!"
                    ];
            }

        }else{
            return [
                "status"=>"error",
                "message"=> "Comment Not Found!",
                "code"=> 404
            ];
        }
    }

    public function delete($id)
    {
        $commentModel = new Comment();

        $comment = (new Comment())->findById($id);

        if(count($comment) > 0) {
            if($commentModel->delete($id)) {
                return [
                    "status"=> "success",
                    "message"=> "Comment Deleted Successfully!"
                    ];
            }else{
                return [
                    "status"=> "error",
                    "message"=> "Unknown Error During Delete!"
                    ];
                }

        }else{
            return [
                "status"=> "error",
                "message"=> "Comment Not Found!",
                "code"=> 404
                ];
            }

    }
}
