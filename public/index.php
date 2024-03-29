<?php
use App\controllers\Author\WikiController;
require_once __DIR__ . '/../vendor/autoload.php';
session_start();
use App\controllers\Login;
use App\controllers\Register;
use App\controllers\HomeController;
use App\controllers\AboutController;
use App\controllers\ContactController;
use App\controllers\Admin\DashController;
use App\controllers\Admin\CategoryController;
use App\controllers\Admin\TagController;



$route = isset($_GET['route']) ? $_GET['route'] : 'home';

switch($route){

    case 'register': 
        $cons= new Register;
        $con =$cons->Register();
        break;
        case 'regcheck': 
            $cons= new Register;
            $con =$cons->check();
            break;
        case 'login': 
            $cons= new Login;
            $con =$cons->Login();
            break;
            case 'logcheck': 
                $cons= new Login;
                $con =$cons->check();
                break;
            case 'logout': 
                $cons= new Login;
                $con =$cons->logout();
                break;
            case 'home': 
                $cons= new HomeController;
                $con =$cons->index();
                break;
                case 'about': 
                    $cons= new AboutController;
                    $con =$cons->index();
                    break;
                    case 'contact': 
                        $cons= new ContactController;
                        $con =$cons->index();
                        break;
                        case 'dash': 
                            $cons= new DashController;
                            $con =$cons->index();
                            break;
                            case 'category': 
                                $cons= new CategoryController;
                                $con =$cons->index();
                                break;
                                case 'tag': 
                                    $cons= new TagController;
                                    $con =$cons->index();
                                    break;
                                    case 'author': 
                                        $cons= new WikiController;
                                        $con =$cons->getpage();
                                        break;
                                        case 'wiki': 
                                            $cons= new WikiController;
                                            $con =$cons->index();
                                            break;
                                            case 'profile': 
                                                $cons= new WikiController;
                                                $con =$cons->profile();
                                                break;
                                                case 'search': 
                                                    $cons= new HomeController;
                                                    $con =$cons->search();
                                                    break;
                                                    case 'content': 
                                                        $cons= new HomeController;
                                                        $con =$cons->contentpage();
                                                        break;
                                                        default:
                                                        $cons= new HomeController;
                                                        $con =$cons->F403();
                                                        break;
    
}