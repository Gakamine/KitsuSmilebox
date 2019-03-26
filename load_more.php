<?php
  function connexion_de_base_de_donnees(){
    $connexion=mysqli_connect("localhost","user_db","password_db","tablename") or die("Impossible de se connecter".mysqli_connect_error());
    return $connexion;
  }

  if (isset($_POST['compteur'])) {
    $val=$_POST['compteur'];
    $bdd=connexion_de_base_de_donnees();
    $req_NbId=$bdd->query("SELECT COUNT(*) AS NB_ID FROM ID");
    $Nb_Id=$req_NbId->fetch_assoc();
    $NbId=$Nb_Id['NB_ID'];
    if($val<=$NbId) {
      $req1=$bdd->query("SELECT * FROM ID WHERE id<=$NbId-$val ORDER BY id DESC LIMIT 12");
      while ($result = $req1->fetch_assoc()) {
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
    }
    else {
      echo "stop";
    }
  }
?>
