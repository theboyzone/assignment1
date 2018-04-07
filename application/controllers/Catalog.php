<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Catalog extends Application
{
    public function index()
    {
        $categories = $this->categories->all();

        // get all categories and associated items
        foreach ($categories as $category) {
            $accessories = $this->accessories->some('categoryId', $category->categoryId);
            foreach ($accessories as $accessory) {
                $accessory->categoryName = $category->categoryName;
            }
            $category->accessories = $accessories;
        }

        $role = $this->session->userdata('user_role');

        if (is_null($role)) {
            $role = "Guest";
        }

        $this->data['user_role'] = $role;

        $this->data['categories'] = $categories;
        $this->data['pagebody'] = 'catalog';
        $this->data['pagetitle'] = 'All options';

        $this->render();
    }
}
