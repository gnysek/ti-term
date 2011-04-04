<?php

// wczytaj funkcje do wykonania przed załadowaniem frameworku
include('f.php');
// wczytaj loader
include('loader.php');
// wystartuj automatyczne ładowanie klas
Loader::start();
// wystartuj framework
Core::start();