<?php

require_once(__DIR__ . "/../models/Contact.php");

class ContactsController
{

    public function create($data)
    {

        $errors = array();
        if (empty($data["name"])) {
            $errors["name"] = "Name Field is Required!";
        }
        if (empty($data["email"])) {
            $errors["email"] = "Email Field is Required!";
        }
        if (empty($data["subject"])) {
            $errors["subject"] = "Subject field is required!";
        }
        if (empty($data["message"])) {
            $errors["message"] = "Message field is required!";
        }

        if (!empty($errors)) {
            return [
                "status" => "errors",
                "errors" => $errors
            ];
        }
        $Contact = new Contact();

        if ($Contact->create($data)) {
            return [
                "status" => "success",
                "message" => "Your Query is Submitted Successfully You'll get Response soon on given email."
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Unable to Submit your query!"
            ];
        }
    }

    public function findById($id)
    {
        $Contact = new Contact();
        $data = $Contact->findById($id);

        if (count($data) > 0) {
            return [
                "status" => "success",
                "data" => $data
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Contact Entry Not Found!",
                "code" => 404
            ];
        }
    }
       public function count()
    {
        $count = (new Contact())->count();
        
        return $count;
    }

    public function findAll($offset = 0, $limit = 8)
    {
        $Contact = new Contact();
        $data = $Contact->findAll($offset, $limit);
        if (count($data["data"]) > 0) {
            return [
                "status" => "success",
                "data" => $data["data"],
                "total"=> $data["total"]
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Not Found!",
                "code" => 404
            ];
        }
    }

    public function updateStatus($data)
    {

        $Contact = new Contact();

        if ($Contact->updateStatus($data)) {
            return [
                "status" => "success",
                "message" => "Query Resolved Successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Unable to Update Query Status!"
            ];
        }
    }

    public function delete($id)
    {
        $Contact = new Contact();

        $contact_entry = $Contact->findByid($id);

        if (!count($contact_entry) > 0) {
            return [
                "status" => "error",
                "message" => "Contact Entry Not Found!",
                "code" => 404
            ];
        }


        if ($Contact->delete($id)) {
            return [
                "status" => "success",
                "message" => "Query Deleted successfully!"
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Unable to Deleted Entry!"
            ];
        }
    }
}
