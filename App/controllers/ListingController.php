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

    /**
     * Store data in database
     * 
     * @return void 
     */

     public function store(){

        $allowedFields = ['title', 'description', 'salary', 'tags', 'company', 'address', 'city', 'state', 'phone', 'email', 'requirements', 'benefits'];
        
        // Check the key on bouth arrays
        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

        $newListingData['user_id'] = 1;
        
        // Sanitized data
        $newListingData = array_map('sanizite', $newListingData);
        
        // Separate required fields
        $requiredFields = ['title', 'description', 'email', 'city', 'state'];

        $errors = [];
        
        // Check every field 
        foreach ($requiredFields as $field) {
            if (empty($newListingData[$field]) || Validation::string($newListingData[$field])) {
                $errors[$field] = ucfirst($field) . 'is reqired!';
            }
        }

        if (!empty($errors)) {
            //Reload view with errors
            loadView('listings/create', [
                'errors' => $errors,
                'listing' => $newListingData
            ]);
        }else{
            // Submit data
        }
     }
};
