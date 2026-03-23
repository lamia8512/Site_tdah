<?php
// Le namespace "config" permet de ranger la classe Router dans un espace logique et d'éviter les conflits de noms.
namespace config;

// On importe le contrôleur d'erreurs pour afficher une page 404
use App\Controllers\ErrorController;

class Router
{
    // Tableau qui contiendra toutes les routes définies dans l'application.
    // Chaque entrée du tableau sera de la forme : "/chemin" => ["controller" => "NomDuController", "method" => "nomDeLaMethode"]
    private array $routes = [];

    /**
     * Méthode qui récupère l'URI demandée par l'utilisateur.
     * ex: si l'utilisateur visite http://localhost/login alors $_SERVER['REQUEST_URI'] = "/login"
     */
    public function getURI()
    {
        // parse_url extrait uniquement le chemin de l'URL (sans les paramètres ?id=...).
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**  Permet d'ajouter une route dans le tableau $routes.
     * @param string $pattern Le chemin de la route (ex: "/login")
     * @param string $controllerClass Le nom du contrôleur (ex: "LoginController")
     * @param string $method La méthode du contrôleur à exécuter (ex: "index")
     */
    public function addRoute(string $pattern, string $controllerName, string $method)
    {
        $this->routes[$pattern] = [
            'controller' => $controllerName,
            'method' => $method
        ];
    }

    public function handleRequest()
    {
        // On récupère l'URI de la requête actuelle (ex: "/login")
        $uri = $this->getURI();

        // Variable qui permet de savoir si on a trouvé une route correspondante
        $routeFound = false;

        // On parcourt toutes les routes définies dans $routes
        foreach ($this->routes as $pattern => $routeInfo)
        {
            // Si l'URI demandée correspond exactement à une route
            if($uri === $pattern){

                //on passe la variable à true
                $routeFound = true;

                // On récupère le nom du contrôleur et de la méthode associés
                $controllerClass = $routeInfo['controller'];
                $method = $routeInfo['method'];
                
                // On complète le namespace pour trouver la classe contrôleur
                $controllerClass = "App\\Controllers\\" . $controllerClass;

                // On instancie dynamiquement le contrôleur
                $controller = new $controllerClass();

                // On appelle la méthode du contrôleur correspondante
                $controller->$method();

                // Une fois la route trouvée et exécutée, on sort de la boucle
                break;

            }
        }
        if(!$routeFound){
            // Si aucune route n'a été trouvée, on appelle la page d'erreur 404
            echo ErrorController::notFound();
        }
    }

}