<?php
/*
Plugin Name: Lista Posts
Plugin URI:  www.foureyes.com
Description: Plugin para listar postagens cadastradas.
Version:     1.0
Author:      Tiago Góes 
Author URI:  tiago.goes2009@gmail.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


require_once("Controller/class-simple-list-posts-config-page.php");
$Simple_List_Post = new Simple_List_Posts();

require_once("Controller/class-imovel-controller.php");
$Imovel_Controller = new Imovel_Controller();


