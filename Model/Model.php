<?php
$ROOT = __DIR__;
$DS = DIRECTORY_SEPARATOR;
require_once "{$ROOT}{$DS}..{$DS}Config{$DS}connect.php";

class Model {

    protected static $table;
    protected static $clePrimaire; // Primary key name
    protected static $db = null;

    /**
     * Connect to the database
     *
     * @return PDO Instance of PDO class
     */
    public static function connect() {
        if (self::$db == null) {
            try {
                self::$db = new PDO("mysql:host=" . connect::$HOST . ";dbname=" . connect::$DB, connect::$USER, connect::$PASSWORD);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$db->query("SET NAMES 'utf8'");
            } catch (PDOException $exception) {
                die($exception->getMessage());
            }
        }
        return self::$db;
    }

    /**
     * List all records in a table
     *
     * @return array List of found records
     */
    public function getAll() {
        // Connect to the database
        $db = self::connect();

        // Create a string containing the SQL query to execute
        $sql = "SELECT * FROM {$this->table}";
        $liste = [];
        try {
            $resultat = $db->query($sql); // Execute the SQL query
            $liste = $resultat->fetchAll(PDO::FETCH_CLASS, get_class($this));
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }

        return $liste;
    }
    public function getAllByForum($idForum) {
        $sql = "SELECT * FROM $this->table WHERE id_forum = :idForum";
        $db = self::connect();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":idForum", $idForum, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, get_class($this));
    }

    /**
     * Récupérer un enregistrement par son identifiant (clé primaire) unique
     *
     * @param int $id La valeur de la clé primaire
     * @return false si l'objet est introuvable sinon une instance de la classe en question
     */
    public function getById($id){
        // Se connecter à la base de données
        $db = self::connect();
        // Créer une chaîne de caractère contenant la requête à exécuter
        $sql = "SELECT * FROM {$this->table} where {$this->clePrimaire} = $id";
        try{
            $resultat = $db->query($sql); // Exécuter la requêtes SQL
            if($resultat->rowCount() == 1){
                $record = $resultat->fetchObject();
                return $record;
            }
            else{
                return false;
            }
        }
        catch(PDOException $ex){
            die($ex->getMessage());
        }
        finally{
            // Libérer les ressources
            $resultat->closeCursor();
        }
    }
    public function setTable($table) {
        $this->table = $table;
    }

    public function setClePrimaire($clePrimaire) {
        $this->clePrimaire = $clePrimaire;
    }

    /**
     * Supprimer un enregistrement par son identifiant (clé primaire) unique
     *
     * @param int $id La valeur de la clé primaire
     * @return int Nombre de ligne affectées par la la requête
     */
    public function delete($id){
        // Se connecter à la base de données
        $db = self::connect();
        // Créer une chaîne de caractère contenant la requête à exécuter
        $sql = "DELETE FROM {$this->table} WHERE {$this->clePrimaire} = '$id'";
        try{
            $resultat = $db->exec($sql);
            return $resultat;
        }
        catch(PDOException $ex){
            die($ex->getMessage());
        }
    }

    /**
     * Insérer un enregistrement
     *
     * @param array $ligne Tableau associatif representant l'enregistrement à insérer
     * @return int Identifiant de la dernière ligne insérée
     */
    public function insert($ligne){
        // Se connecter à la base de données
        $db = self::connect();
        // Créer une chaîne de caractère contenant la requête à exécuter
        $sql = "INSERT INTO {$this->table} (";
        foreach($ligne as $key=>$value){
            $sql .= $key. ",";
        }
        $sql = rtrim($sql, ",") . ") VALUES (";
        foreach($ligne as $key=>$value){
            $sql .= ":" . $key. ",";
        }
        $sql = rtrim($sql, ",") . ")";
        $requete = $db->prepare($sql);
        foreach($ligne as $key=>$value){
            $requete->bindValue($key, $value);
        }
        try{
            $resultat = $requete->execute();
            if($resultat){
                return $db->lastInsertId();
            }
            else{
                return false;
            }
        }
        catch(PDOException $ex){
            die($ex->getMessage());
        }
    }

    /**
     * Modifier un enregistrement
     *
     * @param array $ligne Tableau associatif representant l'enregistrement à remplacer
     * @param int $id clé primaire de la ligne à modifier
     * @return int Nombre de ligne affectées par la la requête
     */
    public function update($ligne, $id){
        // Se connecter à la base de données
        $db = self::connect();
        // Créer une chaîne de caractère contenant la requête à exécuter
        $sql = "UPDATE {$this->table} SET ";
        foreach($ligne as $key=>$value){
            $sql .= $key . " = :" . $key . ",";
        }
        $sql = rtrim($sql, ",") . " WHERE " . $this->clePrimaire . " = :" . $this->clePrimaire;
        $requete = $db->prepare($sql);
        foreach($ligne as $key=>$value){
            $requete->bindValue($key, $value);
        }
        $requete->bindValue($this->clePrimaire, $id);
        try{
            $resultat = $requete->execute();
            return $resultat;
        }
        catch(PDOException $ex){
            die($ex->getMessage());
        }
    }
    public static function lastInserted() {
        $pdo = static::getPdo(); 
        return $pdo->lastInsertId();
    }
    public static function where($column, $value) {
        $table = static::$table;
        $pdo = new PDO("mysql:host=localhost;dbname=stagi", "root", "");
    
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE $column = ?");
        $stmt->execute([$value]);
        $results = $stmt->fetchAll(PDO::FETCH_CLASS, get_called_class());
    
        return $results;
    }
    
    public static function find($id) {
        $table = static::$table;
        $primary = static::$primary;
    
        $pdo = new PDO("mysql:host=localhost;dbname=stagi", "root", "");
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE $primary = ?");
        $stmt->execute([$id]);
    
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($data) {
            $object = new static(); // Crée une instance dynamique du modèle appelant
    
            foreach ($data as $key => $value) {
                $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
                if (method_exists($object, $method)) {
                    $object->$method($value);
                }
            }
    
            return $object;
        }
    
        return null;
    }
    public function save() {
        $pdo = self::connect();
        $reflection = new ReflectionObject($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);
    
        $fields = [];
        $params = [];
    
        foreach ($properties as $prop) {
            $prop->setAccessible(true);
            $name = $prop->getName();
            $value = $prop->getValue($this);
    
            // On stocke les champs sauf la clé primaire pour update
            if (!($name === static::$primary)) {
                $fields[$name] = $value;
            }
    
            // On garde la clé primaire pour décider si insert ou update
            if ($name === static::$primary) {
                $primaryKeyValue = $value;
            }
        }
    
        // S'il y a une clé primaire définie (donc l'objet existe déjà → UPDATE)
        if (!empty($primaryKeyValue)) {
            $sql = "UPDATE " . static::$table . " SET ";
            foreach ($fields as $key => $val) {
                $sql .= "$key = ?, ";
                $params[] = $val;
            }
            $sql = rtrim($sql, ', ') . " WHERE " . static::$primary . " = ?";
            $params[] = $primaryKeyValue;
        } else {
            // Sinon, c'est une insertion
            $sql = "INSERT INTO " . static::$table . " (" . implode(",", array_keys($fields)) . ") VALUES (" . rtrim(str_repeat("?,", count($fields)), ",") . ")";
            $params = array_values($fields);
        }
    
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
}

?>
