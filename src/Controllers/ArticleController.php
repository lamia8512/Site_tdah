<?php

namespace App\Controllers;

use App\Models\Article;

use App\Utils\AbstractController;

//impoter la class le "use"
class ArticleController extends AbstractController
{
    public function addArticle()
    {
        if(isset($_SESSION['user'])) {
            if(isset($_POST['addArticle'])){
                $title = htmlspecialchars($_POST['article']);
                $text = htmlspecialchars($_POST['article']);
                $this->Check('article', $text);

                if(empty($this->arrayError)){
                    $today = date("Y-m-d");
                    $article = new Article(null, $title, $text, $_SESSION['user']['id_user']);
                    $article->addArticle();
                    $this->redirectToRoute('/', 200);
                }
            }
            require_once(__DIR__ . "/../Views/addArticle.view.php");
        }else{
            $this->redirectToRoute('/', 302);
        }    
    }
}
