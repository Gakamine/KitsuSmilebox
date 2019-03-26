<head>
  <title>SmileBox Kitsu</title>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <!-- UIkit CSS -->
  <link rel="stylesheet" href="./css/uikit.min.css" />
  <link rel="stylesheet" href="./css/style.css" />
  <script src="./js/jquery.min.js"></script>
  <!-- UIkit JS -->
  <script src="./js/uikit.min.js"></script>
  <script src="./js/uikit-icons.min.js"></script>
</head>
<header class="uk-navbar-container uk-margin-bottom" uk-navbar uk-sticky="top: 200; bottom: #animation; animation: uk-animation-slide-top; show-on-up: true">
  <div id="pc">
      <div class="uk-navbar-left">
          <a class="uk-navbar-toggle" uk-navbar-toggle-icon uk-toggle="target: #smartphone; animation: uk-animation-fade" disabled></a>
          <a class="uk-navbar-item uk-logo" href="./">SmileBox</a>
          <ul class="uk-navbar-nav pc">
              <li>
                  <a href="./">
                      <span class="uk-icon uk-margin-small-right" uk-icon="icon: star"></span>
                      Add a smile
                  </a>
              </li>
          </ul>

          <ul class="uk-navbar-nav pc">
              <li>
                  <a href="./?page=wall">
                      Infinite wall of smiles
                  </a>
              </li>
          </ul>
      </div>
      <div class="uk-navbar-right">

          <div class="uk-navbar-item pc">
              <form method="get" action="./" class="uk-search uk-search-default">
                  <span uk-search-icon></span>
                  <input name="search" class="uk-search-input" type="search" placeholder="Search a smile...">
              </form>
          </div>

          <a href="https://twitter.com/Gakamine_"><span class="uk-margin-small-right" uk-icon="icon: twitter; ratio: 2"></span></a>
      </div>
    </div>
    <div id="smartphone" class="smartphone" hidden>
      <div id="scroll-nav" class="nav-smartphone">
        <span class="uk-icon uk-margin-small-right smartphone" uk-icon="icon: chevron-left; ratio: 2;"></span>
          <ul class="uk-navbar-nav smartphone">
              <li>
                  <a href="./">
                      <span class="uk-icon uk-margin-small-right" uk-icon="icon: star"></span>
                      Add a smile
                  </a>
              </li>
          </ul>

          <ul class="uk-navbar-nav smartphone">
              <li>
                  <a href="./?page=wall">
                      Infinite wall of smiles
                  </a>
              </li>
          </ul>
          <ul class="uk-navbar-nav smartphone">
            <li>
              <form method="get" action="./" class="uk-search uk-search-default">
                  <span uk-search-icon></span>
                  <input name="search" class="uk-search-input" type="search" placeholder="Search a smile...">
              </form>

            </li>
          </ul>
        <span class="uk-icon uk-margin-small-right smartphone" uk-icon="icon: chevron-right; ratio: 2;"></span>
      </div>
  </div>
</header>
<?php

  error_reporting(E_ERROR | E_PARSE);

  function connexion_de_base_de_donnees(){
    $connexion=mysqli_connect("localhost","user_db","password_db","tablename") or die("Impossible de se connecter".mysqli_connect_error());
    return $connexion;
  }

  function merge($filename_x, $filename_y, $filename_result) {

     // Get dimensions for specified images

     list($width_x, $height_x) = getimagesize($filename_x);
     list($width_y, $height_y) = getimagesize($filename_y);

     // Create new image with desired dimensions

     $image = imagecreatetruecolor($width_y, $height_y);

     $exploded = explode('.',$filename_x);
     $ext = $exploded[count($exploded) - 1];
     // Load images and then copy to destination image
     if (preg_match('/jpg|jpeg/i',$ext)) {
      $image_x = imagecreatefromjpeg($filename_x);
    }
    else if (preg_match('/png/i',$ext)) {
      $image_x = imagecreatefrompng($filename_x);
    }
    else if (preg_match('/gif/i',$ext)) {
      $image_x = imagecreatefromgif($filename_x);
	  imagegif($image_x, './test.gif');
    }
    else if (preg_match('/bmp/i',$ext)) {
      $image_x = imagecreatefrombmp($filename_x);
    }
    else {
      return 0;
    }

     $image_y = imagecreatefrompng($filename_y);

     imagecopy($image, $image_x, 370, 125, 0, 0, $width_x, $height_x);
     imagecopy($image, $image_y, 0, 0, 0, 0, $width_y, $height_y);

     imagegif($image, $filename_result);

     // Clean up

     imagedestroy($image);
     imagedestroy($image_x);
     imagedestroy($image_y);

  }

  function search() {
    $bdd=connexion_de_base_de_donnees();
    $username=$_GET['search'];
    $req=$bdd->query("SELECT * FROM ID WHERE username='$username'");
    $get_kitsu_id=$req->fetch_assoc();
    $kitsu_id=$get_kitsu_id['kitsu_id'];
    $date=date('m/d/Y', strtotime($get_kitsu_id['date']));
    $file="./img/".$kitsu_id.".gif";
    if(file_exists($file)) {
      echo "<img id='picture' src='".$file."'>";
      echo "<h1>The smile of ".htmlspecialchars($username)." was protected the ".$date.".</h1>";
    }
    else {
      echo "<h1>The smile of ".htmlspecialchars($username)." isn't protected :O ! <a href='./'>Click here to protect it.</a></h1>";
    }
  }

  function post($id) {
    echo $id;
  }

  if($_GET['page']!="wall" && !isset($_GET['search'])) {
      echo '<form id="username" class="uk-padding-small" method="GET" action="./">
        <input class="uk-input" type="text" value="'.$_GET['username'].'" name="username" placeholder="Insert here the username of the person you want to protect the smile">
      </form>';
  }

  if(isset($_GET['page']) && $_GET['page']=='wall') {
    $bdd=connexion_de_base_de_donnees();
    $req=$bdd->query("SELECT * FROM ID ORDER BY ID DESC LIMIT 16");
    echo '<div id="content_table" class="uk-grid-small uk-child-width-1-4@s uk-flex-center uk-text-center" uk-grid>';
    while ($result = $req->fetch_assoc()) {
      echo '<div>
                <div class="uk-card  uk-card-hover uk-card-default">
                    <div class="uk-card-media-top">
                        <img class="character_img" src="./img/'.htmlspecialchars($result['kitsu_id']).'.gif" alt="">
                    </div>
                    <div class="uk-card-body">
                      <h3 class="uk-card-title">'.htmlspecialchars($result['username']).'</h3>
                    </div>
                </div>
          </div>';
    }
    echo '</div><span id="loader" class="uk-flex-center uk-text-center" uk-spinner="ratio: 2"></span>';
  }

  if(isset($_GET['search'])) {
      search();
  }

  if(isset($_GET['username'])) {
    $username=$_GET['username'];
    $urls = array(file_get_contents("https://kitsu.io/api/edge/users?filter[name]=$username"),file_get_contents("https://kitsu.io/api/edge/users?filter[slug]=$username"),file_get_contents("https://kitsu.io/api/edge/users?filter[id]=$username"));
    $test=false;

    for($i=0;$i<=2;$i++) {
      if($test==false) {
        $url=$urls[$i];
        $json = json_decode($url, true);
        $img = $json['data']['0']['attributes']['avatar']['large'];
        $id = $json['data']['0']['id'];
        $username=$json['data']['0']['attributes']['name'];
        if($id!="") {
          $test=true;
        }
      }
    }

    if($id!="" && isset($img)) {
      merge($img,'./template.png','./img/'.$id.'.gif');
      echo "<img id='picture' src='./img/".$id.".gif'>";
      echo "<h1>You protected the smile of ".htmlspecialchars($username).".</h1>";
      $bdd=connexion_de_base_de_donnees();
      $nb_Kitsu_id=$bdd->query("SELECT COUNT(*) AS NbId FROM ID WHERE kitsu_id=$id");
      $nbKitsuId=$nb_Kitsu_id->fetch_assoc();
      $nbKitsuid=$nbKitsuId['NbId'];
      if($nbKitsuid==0) {
        post($id);
        $bdd->query("INSERT INTO `ID` (`kitsu_id`,`username`) VALUES ('$id','$username') ");
      }
    }
    else {
      echo "<h1>There were an issue when retrieving your profile picture. Contact Gakamine on Kitsu or @Gakamine_ on Twitter.</h1>";
    }
  }
  
?>
<footer>
  Powered by ❤, made for you by Gakamine/Antoine Joly.
</footer>
<script src="./js/scroll.js"></script>
