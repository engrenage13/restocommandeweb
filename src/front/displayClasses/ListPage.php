<?php
include("front/classes/Page.php");

/**
 * Génère une page de liste d'élements divers.
 */
class ListPage extends Page {
  // Variables et constantes de la classe.
  // Type d'entité listé.
  private string $entite;
  // Même entité mais au pluriel.
  private string $entites;
  // True si le type listé et de genre masculin (UN examen, Un type, un diplôme).
  private bool $est_masculin;

  /**
   * Construit la classe d'affichage.
   * @param string $entite Nom du type d'entités (objets de la base de données) affichées dans la liste.
   * @param bool $est_masculin Précise le genre de ce qui a été saisie au paramètre précédent afin de faire des bons accords de grammaire.
   * @param string $pluriel Nom du type d'entités du prmier paramètre mais au pluriel. S'il n'est pas défini, la classe en définira un par défaut.
   */
  public function __construct(string $entite, bool $est_masculin = true, string $pluriel = "") {
    // Appel le constructeur de sa classe parente afin de charger les informations stockées dans le fichier de configuration.
    parent::__construct();
    $this->entite = strtolower($entite);
    // Vérifie si un pluriel est défini, sinon en défini un à partir de l'entité passée en paramètres.
    if ($pluriel != "") {
      $this->entites = $pluriel;
    } else {
      $this->entites = $entite."s";
    }
    $this->est_masculin = $est_masculin;
  }

  /**
   * Affiche toute une page à l'écran..
   * @param Controller $controller Nom du controller à interroger pour la liste d'élément à afficher.
   * @param string $lien_creation Le nom de la page sur la-quelle les boutons de créations doivent envoyer.
   */
  public function afficheListe(Controller $controller, string $lien_creation = "") {
    $titre = "Liste des $this->entites";
    $liste = $controller->getAll();
    ?>
    <html>
      <?php $this->genere_header($titre); ?>
      <style>
        .separation {
          align-self: center;
        }

        .liste {
          display: flex;
          flex-direction: column;
          align-items: stretch;
          padding: 0;
          margin: 0;
        }

        .petit_ecart_en_haut {
          margin-top: 1rem;
        }
      </style>
      <body>
        <div class="page">
          <!-- Appel de la méthode d'affichage du menu -->
          <?php $this->afficheMenu(); ?>
          <main class="page-body-full-screen">
            <div class="zone-titre" style="margin-bottom: .8rem; justify-content: center;">
              <h1><?php echo $titre; ?></h1>
            </div>
            <div class="page-body liste" style="flex-grow: 0;">
              <!-- Bouton de création d'un nouvel élément (haut) -->
              <div class="lignebouton petit_ecart_en_haut">
                <a href="<?php echo $lien_creation; ?>" class="coloredButton">Créer <?php echo ($this->est_masculin ? "un" : "une")." $this->entite"; ?></a>
              </div>
              <div class="separation" style="margin-bottom: 1rem;">&nbsp;</div>
              <?php
              if (sizeof($liste) > 0) {
                // Affiche les éléments trouvés par le controller.
                foreach ($liste as $objet) {
                  $objet->affiche();
                }
              } else {
                // Message d'info si le controller n'a pas trouvé d'éléments.
                ?>
                <p style ="font-size:16px;">
                  <?php echo $this->est_masculin ? "Aucun" : "Aucune"; ?> <?php echo $this->entite; ?> <?php echo $this->est_masculin ? "existant" : "existante"; ?>
                </p>
                <?php
              }
              ?>
              <div class="separation" style="height: .6rem;">&nbsp;</div>
              <!-- Bouton de création d'un nouvel élément (bas) -->
              <div class="lignebouton">
                <a href="<?php echo $lien_creation; ?>" class="coloredButton">Créer <?php echo ($this->est_masculin ? "un" : "une")." $this->entite"; ?></a>
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