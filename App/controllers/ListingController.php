<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

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
        require basePath('App/views/listings/create.view.php');
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

        $newListingData['user_id'] = 1;

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

            redirect('/Workopia/listings');
        }
    }

    /**
     * Delete the listing
     * @param array $params
     * @return void 
     */

     public function destroy(){
        $id = $_GET['id'] ?? '';

        $params = [
            'id' => $id,
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        if(!$listing){
            ErrorController::notFound('Listing not found');
            return;
        }

        $this->db->query('DELETE FROM listings WHERE id = :id', $params);

        // Set flash message
        $_SESSION['success_message'] = 'Listing deleted successfuly';

        redirect('/Workopia/listings');
    
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
};
