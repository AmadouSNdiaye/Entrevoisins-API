<?php
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    require '../vendor/autoload.php';
   
    function message ($code,$status,$message,$type=null,$object=null) {
        if ($object == null) {
            return array("code" => $code, "status" => $status, "message" => $message);
        } else {
            return array($type => $object);
        }        
    }

    $app = new \Slim\App;
    /**
     * route - CREATE - add new neighbour - POST method
     */
    $app->post
    (
        '/api/nvoisin', 
        function (Request $request, Response $old_response) {
            try {
                $params = $request->getQueryParams();                
                $nom = $params['nom'];
                $adresse = $params['adresse'];
                $numero = $params['numero'];
                $apropos= $params['apropos'];

                $sql = "insert into T_voisins (nom,adresse,numero,apropos) values (:nom,:adresse,:numero,:apropos)";

                $db_access = new DBAccess ();
                $db_connection = $db_access->getConnection();

                $statement = $db_connection->prepare($sql);                
                $statement->bindParam(':nom', $nom);
                $statement->bindParam(':adresse', $adresse);
                $statement->bindParam(':numero', $numero);
                $statement->bindParam(':apropos', $apropos);
                $statement->execute();
                
                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(200, 'OK', "The neighbour has been created successfully.")));
            } catch (Exception $exception) {
                
                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(500, 'KO', $exception->getMessage())));
            }

            return $response;
        }
    );

    /**
     * route - READ - get neighbour by id - GET method
     */
    $app->get
    (
        '/api/nvoisin/{id}', 
        function (Request $request, Response $old_response) {
            try {
                $id = $request->getAttribute('id');                

                $sql = "select * from T_voisins where id = :id";

                $db_access = new DBAccess ();
                $db_connection = $db_access->getConnection();

                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();

                $statement = $db_connection->prepare($sql);
                $statement->execute(array(':id' => $id));
                if ($statement->rowCount()) {
                    $voisin = $statement->fetch(PDO::FETCH_OBJ);                    
                    $body->write(json_encode(message(200, 'OK', "Process Successed.", "voisin", $voisin)));
                }
                else
                {
                    $body->write(json_encode(message(513, 'KO', "The neighbour with id = '".$id."' has not been found 
                    or has already been deleted.")));
                }

                $db_access->releaseConnection();
            } catch (Exception $exception) {
                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(500, 'KO', $exception->getMessage())));
            }
            
            return $response;
        }
    );

    /**
     * route - READ - get all neighbours - GET method
     */
    $app->get
    (
        '/api/nvoisins', 
        function (Request $request, Response $old_response) {
            try {
                $sql = "Select * From T_voisins";
                $db_access = new DBAccess ();
                $db_connection = $db_access->getConnection();
    
                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();

                $statement = $db_connection->query($sql);
                if ($statement->rowCount()) {
                    $etudiants = $statement->fetchAll(PDO::FETCH_OBJ);                    
                    $body->write(json_encode(message(200, 'OK', "Process Successed.", "voisins", $etudiants)));
                } else {
                    $body->write(json_encode(message(512, 'KO', "No neighbour has been recorded yet.")));
                }

                $db_access->releaseConnection();
            } catch (Exception $exception) {
                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(500, 'KO', $exception->getMessage())));
            }
    
            return $response;
        }
    );

    /**
     * route - UPDATE - update a neighbour by id - PUT method
     */
    $app->put
    (
        '/api/nvoisin/{id}', 
        function (Request $request, Response $old_response) {
            try {

                $id = $request->getAttribute('id');

                $params = $request->getQueryParams();
                $nom = $params['nom'];
                $adresse = $params['adresse'];
                $numero = $params['numero'];
                $apropos=  $params['apropos'];
                $favoris= $params ['favoris'];

                $sql = "update T_voisins set nom = :nom, adresse = :adresse, numero = :numero , apropos = :apropos, favoris =:favoris where id = :id";

                $db_access = new DBAccess ();
                $db_connection = $db_access->getConnection();

                $statement = $db_connection->prepare($sql);
                $statement->bindParam(':nom', $nom);
                $statement->bindParam(':adresse', $adresse);
                $statement->bindParam(':numero', $numero);
                $statement->bindParam(':apropos', $apropos);
                $statement->bindParam(':favoris', $favoris);
                $statement->bindParam(':id', $id);
                $statement->execute();

                $db_access->releaseConnection();

                $response = $old_response->withHeader('Content-Type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(200, 'OK', "The neighbour has been updated successfully.")));
            } catch (Exception $exception) {
                $response = $old_response->withHeader('Content-Type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(500, 'KO', $exception->getMessage())));
            }

            return $response;
        }
    );

    /**
     * route - DELETE - delete a neighbour by id - DELETE method
     */
    $app->delete
    (
        '/api/nvoisin/{id}', 
        function (Request $request, Response $old_response) {
            try {
                $id = $request->getAttribute('id');

                $sql = "delete from T_voisins where id = :id";

                $db_access = new DBAccess ();
                $db_connection = $db_access->getConnection();

                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();

                $statement = $db_connection->prepare($sql);
                $statement->execute(array(':id' => $id));

                $body->write(json_encode(message(200, 'OK', "The neighbour has been deleted successfully.")));
                $db_access->releaseConnection();
            } catch (Exception $exception) {
                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(500, 'KO', $exception->getMessage())));
            }

            return $response;
        }
    );

        /**
     * route - UPDATE - update a neighbour by id (Favoris) - Update method
     */
    $app->put
    (
        '/api/nvoisin/fav/{id}', 
        function (Request $request, Response $old_response) {
            try {
                $id = $request->getAttribute('id');
                $db_access = new DBAccess ();
                $db_connection = $db_access->getConnection();
                $response = $old_response->withHeader('Content-type', 'application/json');
                $body = $response->getBody();

                $quer="select favoris from t_voisins where id=:id";
                $statement = $db_connection->prepare($quer);
                $statement->bindParam(':id', $id);
                $statement->execute();
                $voisins = $statement->fetch(PDO::FETCH_ASSOC);
                $body->write(json_encode(message(200, 'OK', "Process Successed.", "voisins", $voisins['favoris'])));
                if($voisins['favoris'] == 1){
                    $voisins['favoris'] = 0;
                }
                else{
                    $voisins['favoris'] = 1;
                }
                $sql = "update T_voisins set favoris =:favoris where id = :id";
                $statement = $db_connection->prepare($sql);
                $statement->bindParam(':favoris', $voisins['favoris']);
                $statement->bindParam(':id', $id);
                $statement->execute();
                $db_access->releaseConnection();
                $response = $old_response->withHeader('Content-Type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(200, 'OK', "The neighbour has been updated successfully.")));
            } catch (Exception $exception) {
                $response = $old_response->withHeader('Content-Type', 'application/json');
                $body = $response->getBody();
                $body->write(json_encode(message(500, 'KO', $exception->getMessage())));
            }
            return $response;
        }
    );

    $app->run();
?>