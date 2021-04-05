
<?php
  date_default_timezone_set("Africa/Lagos");
  use Aws\Rekognition\RekognitionClient;
  use Aws\Exception\AwsException;

  class Dbh {
    public $client;

    public function connect() {
      $dbUser = 'DB_USERNAME';
      $dbHost = 'DB_HOST';
      $dbPassword = 'DB_PASSWORD';
      $database = 'DB_DATABASE';


      try {
        $connection = new PDO('mysql:host='. $dbHost .';dbname='. $database, $dbUser, $dbPassword);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $connection;

      } catch (PDOException $pe) {
        die('<h1>Connection to database failed.</h1>'. $pe->getMessage());
      }
    }
    



    public function rekognition() {
      $options = [
        'region' => 'AWS_DEFAULT_REGION',
        'version' => 'AWS_VERSION',
        'credentials' => array(
          'key'  => 'AWS_ACCESS_KEY_ID',
          'secret' => 'AWS_SECRET_ACCESS_KEY',
        )
      ];
      $this->client = new RekognitionClient($options);
      return $this->client;
    }




    public function redirectTo($path){
      header("Location: " . $path);
    }
  }
  

  

