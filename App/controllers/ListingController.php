<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Session;
use Framework\Validation;
use Framework\Authorization;

class ListingController
{
    protected $db;
    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function index()
    {
        $listings = $this->db->query('SELECT * FROM listings')->fetchAll();

        loadView('listings/index', [
            'listings' => $listings
        ]);
    }

    public function create()
    {
        loadView('listings/create');
    }

    /**
     * Store data in database
     * 
     * @return void 
     */

    public function store()
    {

        $allowedFields = ['title', 'discription', 'salary', 'tags', 'company', 'address', 'city', 'state', 'phone', 'email', 'requirements', 'benefits'];

        // Check the key on bouth arrays
        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

        $newListingData['user_id'] = Session::get('user')['id'];

        // Sanitized data
        $newListingData = array_map('sanizite', $newListingData);

        // Separate required fields
        $requiredFields = ['title', 'discription', 'salary', 'email', 'city', 'state'];

        $errors = [];



        // Check every field 
        foreach ($requiredFields as $field) {
            if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
            // inspectAndDie(Validation::string($newListingData[$field]));
        }

        if (!empty($errors)) {
            //Reload view with errors
            loadView('listings/create', [
                'errors' => $errors,
                'listing' => $newListingData
            ]);
        } else {
            // Submit data
            // Keys
            $fields = [];

            foreach ($newListingData as $field => $value) {
                $fields[] = $field;
            }

            $fields = implode(', ', $fields);

            // Values
            $values = [];

            foreach ($newListingData as $field => $value) {
                // Convert empty string to null
                if ($value === '') {
                    $newListingData[$field] = null;
                }

                $values[] = ':' . $field;
            }

            $values = implode(', ', $values);

            $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";



            $this->db->query($query, $newListingData);

            redirect('/Workopia/public/listings');
        }
    }

    /**
     * Delete the listing
     * @param array $params
     * @return void 
     */

    public function destroy()
    {
        $id = $_GET['id'] ?? '';

        $params = [
            'id' => $id,
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();
        
        // Check if listing exist
        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        // Authorization
        if (!Authorization::isOwner($listing->user_id)) {
            $_SESSION['error_message'] = 'You are not authorized to delete this listing';
            return  redirect('/Workopia/public/listings');
        }

        $this->db->query('DELETE FROM listings WHERE id = :id', $params);

        // Set flash message
        $_SESSION['success_message'] = 'Listing deleted successfuly';

        redirect('/Workopia/public/listings');
    }

    public function show()
    {
        $id = $_GET['id'] ?? '';

        $params = [
            'id' => $id,
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        loadView('listings/show', [
            'listing' => $listing
        ]);
    }

    public function edit()
    {
        $id = $_GET['id'] ?? '';
        // $id = $params['id'] ?? '';

        $params = [
            'id' => $id,
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        loadView('listings/edit', [
            'listing' => $listing
        ]);
        // Check if listing exist
        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }
    }

    public function update()
    {
        $id = $_GET['id'] ?? '';
        // $id = $params['id'] ?? '';

        $params = [
            'id' => $id,
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        // Check if listing exist
        if (!$listing) {
            ErrorController::notFound('Listing not found');
            return;
        }

        // Update fields
        $allowedFields = ['title', 'discription', 'salary', 'tags', 'company', 'address', 'city', 'state', 'phone', 'email', 'requirements', 'benefits'];

        $updateValues = [];

        // Check the key on bouth arrays
        $updateValues = array_intersect_key($_POST, array_flip($allowedFields));

        // Sanitize
        $updateValues = array_map('sanizite', $updateValues);

        // Separate required fields
        $requiredFields = ['title', 'discription', 'salary', 'email', 'city', 'state'];

        $errors = [];

        foreach($requiredFields as $field){
            if (empty($updateValues[$field]) || !Validation::string($updateValues[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        };

    
        if (!empty($errors)) {
          //Reload view with errors
          loadView('listings/edit', [
            'errors' => $errors,
            'listing' => $listing
        ]);
        exit;
        } else {
           $updateFields = [];
           foreach (array_keys($updateValues) as $field) {
            // Cross into all fields and make key value 
             $updateFields[] = "{$field} = :{$field}";
           }
           
           $updateFields = implode(', ', $updateFields);
           
        //    Build update query
           $updatequery = "UPDATE listings SET $updateFields WHERE id = :id";

           $updateValues["id"] = $id;
           
        // Run query in database
           $this->db->query($updatequery, $updateValues);

           $_SESSION['success_message'] = 'Listing Updated';

           redirect('/Workopia/public/edit?id=' . $id);

        }
    }
};
