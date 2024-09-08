<?php

include("front/classes/Page.php");

/**
 * Gère l'affichage de pages complexes avec un menu verticale permettant de naviguer entre plusieurs pages web.
 */
class MenuPage extends Page {
  // Variables et constantes de la classe.
  protected array $donnees;
  protected string $dossier;
  protected array $pages;

  /**
   * Construit la classe d'affichage.
   * @param string $dossier Le dossier dans lequel sont stockés le fichier de paramètres des liens du menu ainsi que les différentes pages qui y sont liés.
   */
  public function __construct(string $dossier) {
    // Appel le constructeur de sa classe parente afin de charger les informations stockées dans le fichier de configuration.
    parent::__construct();
    $this->dossier = $dossier;
    $this->donnees = json_decode(file_get_contents($dossier.'/liens.json'), true);
    $this->pages = [];
    foreach ($this->donnees as $lien) {
      array_push($this->pages, $lien["code"]);
    }
  }

  /**
   * Affiche toute une page à l'écran.
   * @param string $titre Le titre de la page (affiché sur elle et sur l'onglet du navigateur).
   * @param string $contenu Nom du fichier contenant le contenu à afficher.
   * @param bool $affiche_titre Si true affiche l'entête avec le titre.
   * @param string $super_entete Une entête particulière à afficher sur cette page.
   */
  public function affiche(string $titre, string $contenu, bool $affiche_titre = true, string $super_entete = "") {
    ?>
    <!DOCTYPE html>
    <html>
      <?php $this->genere_header($titre); ?>
      <style>
        h2 {
          text-align: left;
        }
      </style>
      <body>
        <div class="page">
          <!-- Appel de la méthode d'affichage du menu -->
          <?php 
          $this->afficheMenu();
          // Vérifie si une page est sélectionnée.
          if (isset($_GET['page'])) {
            $selected_page = $_GET['page'];
          } else {
            $selected_page = $this->pages[0];
          }
          ?>
          <main class="page-body-full-screen">
            <div class="zone-titre" style="justify-content: flex-start; margin-bottom: .8rem;">
              <h1 style="margin-left: 1rem;"><?php echo $titre; ?> > <?php echo $this->donnees[array_search($selected_page, $this->pages)]["nom"]; ?></h1>
            </div>
            <div class="toute-la-longueur liste-horizontale" style="align-items: stretch;">
              <div class="menu-vertical" style="margin: 0 1rem; align-self: flex-start">
                <?php
                foreach ($this->donnees as $lien) {
                  if ($selected_page == $lien["code"]) {
                    $classe = "menu-actif";
                  } else {
                    $classe = "menu1";
                  }
                  ?>
                  <a href="<?php echo $lien["lien"]; ?>" class="<?php echo $classe; ?> <?php echo implode(" ", $lien["classes"]); ?>">
                    <b><?php echo $lien["nom"]; ?></b>
                    <img src="../images/icones/fleche.svg" alt="Ouvrir" class="icone" width="20rem">
                  </a>
                  <?php
                }
                ?>
              </div>
              <div>
                <?php
                if (isset($_GET['page'])) {
                  $indice_page = array_search($_GET['page'], $this->pages);
                  if (is_int($indice_page)) {
                    include($this->dossier.'/'.$this->donnees[$indice_page]["cible"]);
                  } else {
                    include($this->dossier.'/index.php');
                  }
                } else {
                  include($this->dossier.'/index.php');
                }
                ?>
              </div>
            </div>
          </main>
          <!-- Appel de la méthode d'affichage du pied de page -->
          <?php $this->afficheFooter(); ?>
        </div>
      </body>
    </html>
    <?php
  }
}

?>