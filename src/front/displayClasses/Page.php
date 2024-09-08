<?php
include('back/fonctions/routes.php');

/**
 * Gère l'affichage basique de n'importe qu'elle page. Il existe des extensions de cette classe pour des cas plus spécifiques.
 */
class Page {
  // Variables et constantes de la classe.
  protected array $config;
  protected string $pages_route;
  protected string $entetes_route;

  /**
   * Construit la classe d'affichage.
   */
  public function __construct() {
    // Charge les informations stockées dans le fichier de configuration.
    $this->config = json_decode(file_get_contents('config.json'), true);
    $this->pages_route = $this->config['route_pages'];
    $this->entetes_route = $this->config['route_entetes'];
  }

  /**
   * Affiche le menu à l'écran.
   */
  protected function afficheMenu() {
    ?>
    <nav>
      <ul>
        <div class="logo">
          <a href="<?php echo re_route("index.php"); ?>"><img src="images/logo.svg" alt="Logo iExamen"></a>
        </div>
        <li class="menu-deroulant">
          <a href="#">Tables</a>
          <ul class="sous-menu">
            <li><a href="<?php echo re_route("diplome.php"); ?>">Diplômes</a></li>
            <li><a href="<?php echo re_route("destinataire.php"); ?>">Lieux correction</a></li>
            <li><a href="<?php echo re_route("matiere.php"); ?>">Matières</a></li>
            <li><a href="<?php echo re_route("modele.php"); ?>">Modèles</a></li>
            <li><a href="<?php echo re_route("salle.php"); ?>">Salles</a></li>
            <li><a href="<?php echo re_route("surveillant.php"); ?>">Surveillants</a></li>
            <li><a href="<?php echo re_route("type.php"); ?>">Types</a></li>
          </ul>
        </li>
        <li class="menu-deroulant">
          <a href="#">Épreuve</a>
          <ul class="sous-menu">
            <li><a href="<?php echo re_route("epreuve.php"); ?>">Saisies</a></li>
            <li><a href="<?php echo re_route("verifepreuve.php"); ?>">Vérifications</a></li>
            <li><a href="<?php echo re_route("dupliqueepreuve.php"); ?>">Duplications</a></li>
          </ul>
        </li>
        <li class="menu-deroulant">
          <a href="#">Édition</a>
          <ul class="sous-menu">
            <li><a href="<?php echo re_route("impconvoc.php"); ?>">Convocations</a></li>
            <li><a href="<?php echo re_route("impdatedate.php"); ?>">Liste date à date</a></li>
            <li><a href="<?php echo re_route("impdiplome.php"); ?>">Liste par diplôme</a></li>
            <li><a href="<?php echo re_route("impetiquettepv.php"); ?>">PV et étiquettes</a></li>
          </ul>
        </li>
        <div class="ressort"></div>
        <li><a href="<?php echo re_route("parametres.php"); ?>">Paramètres</a></li>
        <div class="utilisateur"><?php echo $_SESSION['VNOMUTIL'];?></div>
      </ul>
    </nav>
    <?php
  }

  /**
   * Affiche le pied de page à l'écran.
   */
  protected function afficheFooter() {
    ?>
    <footer>
      <div>Portail de la Communauté éducative<br>www.stvincentdepaulsoissons.net</div>
      <div><?php echo $this->config['nom']; ?> <?php echo $this->config['version']; ?></div>
      <img src="../../images/logobas.png" alt="Logo St Vincent de Paul">
    </footer>
    <?php
  }

  /**
   * Génère le header html.
   * @param string $titre Le titre de la page à afficher sur l'onglet du navigateur.
   */
  protected function genere_header(string $titre) {
    // Lecture du mode d'affichage (blanc / noir) ou thème.
    $theme = $_SESSION['THEME'];
    $couleur = $_SESSION['COULEUR'];
    ?>
    <head>
      <link href="../iprof.css" rel="stylesheet" type="text/css">
      <link href="../popup.css" rel="stylesheet" type="text/css">
      <link href="front/css/progressbar.css" rel="stylesheet" type="text/css">
      <link href="couleurs/<?php echo $couleur; ?>/theme.css" rel="stylesheet" type="text/css">
      <link href="front/css/menu.css" rel="stylesheet" type="text/css">
      <link href="themes/<?php echo $theme; ?>/exam.css" rel="stylesheet" type="text/css">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
      <title><?php echo $titre; ?></title>
    </head>
    <?php
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
      <body>
        <div class="page">
          <!-- Appel de la méthode d'affichage du menu -->
          <?php 
          $this->afficheMenu();
          if ($super_entete != "") {
            ?>
            <main class="page-body-full-screen">
            <!-- Inclus une entête particulière à afficher en haut de la page. -->
            <?php 
            include($this->entetes_route.$super_entete); 
          } else {
            if ($affiche_titre) {
              ?>
              <main class="page-body-full-screen">
                <div class="zone-titre" style="margin-bottom: .8rem; justify-content: center;">
                  <h1><?php echo $titre; ?></h1>
                </div>
              <?php
            } else {
              ?>
              <main class="page-body-full-screen" style="justify-content: center; padding-top: .8rem;">
              <?php
            }
          }
          ?>
            <div class="centrer">
              <!-- Inclus le contenu de la page. -->
              <?php include($this->pages_route.$contenu); ?>
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