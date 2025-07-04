<?php
// app/controllers/HomeController.php

require_once __DIR__ . '/../models/Gallery.php';

class HomeController {
    
    public function index() {
        $galleryModel = new Gallery();
        $data['images'] = $galleryModel->getAllImages();

        require_once __DIR__ . '/../views/home/index.php';
    }
}
