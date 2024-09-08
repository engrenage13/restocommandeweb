<?php
include("front/classes/Page.php");
header('content-type: text/html; charset=utf-8');

/**
 * Génère une page de liste d'élements divers.
 */
class FormPage extends Page {
  // Variables et constantes de la classe.
  // Type d'entite listé.
  private string $entite;
  // True si le type listé et de genre masculin (UN examen, Un type, un diplôme).
  private bool $est_masculin;

  /**
   * Construit la classe d'affichage.
   * @param string $entite Nom du type d'entités (objets de la base de données) affichées dans la liste.
   * @param bool $est_masculin Précise le genre de ce qui a été saisie au paramètre précédent afin de faire des bons accords de grammaire. 
   */
  public function __construct(string $entite, bool $est_masculin = true) {
    // Charge les informations stockées dans le fichier de configuration.
    parent::__construct();
    $this->entite = strtolower($entite);
    $this->est_masculin = $est_masculin;
  }

  /**
   * Génère les champs du formulaire.
   * @param array $champs La liste des champs à afficher dans le formulaire ([nom, type, id, options: [], maxlength, valeur]).
   * @param bool $formulaire Si true encadre la liste des champs entre une paire de balises div possédant la classe css formulaire.
   */
  private function genere_formulaire(array $champs, bool $formulaire = true) {
    // On vérifie si $formulaire vaut true
    if ($formulaire) {
      // Si c'est le cas, on génère une balise div avec la classe css formulaire
      ?>
      <div class="formulaire">
        <?php
    }
      foreach ($champs as $champ) {
        $nom = $champ["nom"];
        $type = $champ["type"];
        $idchamp = $champ["id"];
        $max = $champ["maxlength"];
        $options = $champ["options"];
        $valeur = $champ["valeur"];
        $min = isset($champ["min"]) ? $champ["min"] : 0;
        $sous_champs = isset($champ["sous_champs"]) ? $champ["sous_champs"] : [];
        // Vérifie si le champ est obligatoire.
        if (isset($champ["required"])) {
          $required = $champ["required"];
        } else {
          $required = false;
        }
        // Vérifie si le champ à créer a des sous-champs
        if (count($sous_champs) > 0) {
          // Si c'est le cas, on crée un une capsule autour du champ parent et de ses sous-champs
          ?>
          <div id="capsule_<?php echo $nom; ?>" class="<?php echo $valeur ? "capsule_champs" : "capsule_champs_desactive"; ?>">
            <div id="entete_<?php echo $nom; ?>" class="<?php echo $valeur ? "entete_capsule_champs" : "entete_capsule_champs_desactive"; ?>">
          <?php
        }
        // Crée un champ
        ?>
        <div class="champ">
          <!-- Crée le label du champ -->
          <label for="<?php echo $idchamp; ?>" class="form-label"><?php echo ucfirst($nom); ?></label>
          <?php
          if (strtolower($type) == "select") {
            // Crée un champ select
            if (count($sous_champs) > 0) {
              // Si le champ possède des sous-champs on relie la fonction javascript "etendRepliCapsule".
              ?>
              <select id="<?php echo $idchamp; ?>" name="<?php echo $idchamp; ?>" class="form-field" <?php echo $required ? "required" : ""; ?> onchange="etendRepliCapsule('capsule_<?php echo $nom; ?>', 'entete_<?php echo $nom; ?>', 'contenu_<?php echo $nom; ?>', '<?php echo $idchamp; ?>');">
              <?php
            } else {
              // Dans le cas contraire on définit juste le champ select sans le paramètre onchange.
              ?>
              <select id="<?php echo $idchamp; ?>" name="<?php echo $idchamp; ?>" class="form-field" <?php echo $required ? "required" : ""; ?>>
              <?php
            }
              foreach ($options as $option) {
                $value = $option["value"];
                $option_valeur = $option["valeur"];
                $selected = $option["selected"];
                if ($selected) {
                  ?>
                  <option value="<?php echo $value; ?>" selected><?php echo $option_valeur; ?></option>
                  <?php
                } else {
                  ?>
                  <option value="<?php echo $value; ?>"><?php echo $option_valeur; ?></option>
                  <?php
                }
              }
              ?>
            </select>
            <?php
          } else {
            // Crée un autre type de champ.
            ?>
            <input type="<?php echo $type; ?>" id="<?php echo $idchamp; ?>" name="<?php echo $idchamp; ?>" value="<?php echo $valeur; ?>" maxlength="<?php echo $max; ?>" min="<?php echo $min ?>" max="<?php echo $max ?>" class="form-field" <?php echo $required ? "required" : ""; ?>>
            <?php
          }
          ?>
        </div>
        <?php
        // On vérifie s'il y a des sous-champs
        if (count($sous_champs) > 0) {
          // On referme l'entête de la capsule (contenant le premier champ)
          ?>
            </div>
            <div id="contenu_<?php echo $nom; ?>" class="contenu_capsule_champs <?php echo !$valeur ? "invisible" : "" ?>">
          <?php
          // S'il y a des sous-champs on les affiche à l'écran
          $this->genere_formulaire($sous_champs, false);
          // Une fois les sous-champs générés, on referme la capsule
          ?>
            </div>
          </div>
          <?php
        }
      }
    // On vérifie si $formulaire vaut true
    if ($formulaire) {
      // Si c'est le cas, on génère la balise div fermante de celle qui a été ouverte au début de la méthode.
      ?>
      </div>
      <?php
    }
  }

  /**
   * Affiche le formulaire de création d'un objet.
   * @param string $action L'action déclenchée par le formulaire.
   * @param array $champs La liste des champs à afficher dans le formulaire ([nom, type, id, options: [], maxlength, valeur]).
   * @param string $lien_retour Page de destination lors de l'appuie sur le bouton "Annuler".
   */
  public function affiche_creation(string $action = "", array $champs = [], string $lien_retour = "index.php") {
    $titre = "Création d'".($this->est_masculin ? "un nouveau " : "une nouvelle ").$this->entite;
    ?>
    <html>
      <?php $this->genere_header($titre); ?>
      <body>
        <div class="page">
          <!-- Appel de la méthode d'affichage du menu -->
          <?php $this->afficheMenu(); ?>
          <main class="page-body">
            <div class="container">
              <div class="nom-container"><?php echo $titre; ?></div>
              <!-- formulaire -->
              <form class="centrer" method="post" action="<?php echo $action; ?>">
                <!-- Crée les champs du formulaire -->
                <?php $this->genere_formulaire($champs); ?>
                <!-- Bouton de création -->
                <div class="lignebouton">
                  <input value="Créer" type="submit" class="coloredButton">
                  <a href=<?php echo $lien_retour; ?> class="coloredButton">Annuler</a>
                </div>
              </form>
            </div>
          </main>
          <!-- Appel de la méthode d'affichage du pied de page -->
          <?php $this->afficheFooter(); ?>
        </div>
      </body>
    </html>
    <?php
  }

  /**
   * Affiche la page de modification d'un objet.
   * @param string $action L'action déclenchée par le formulaire.
   * @param array $champs La liste des champs à afficher dans le formulaire ([nom, type, id, options: [], maxlength, valeur]).
   * @param string $lien_retour Page de destination lors de l'appuie sur le bouton "Annuler".
   * @param string $desc_sup Contenu de l'alerte affiché sur le bloc de suppression.
   * @param string $action_sup Action de suppression.
   * @param int $id Identifiant de l'objet modifié.
   */
  public function affiche_modification(string $action = "", array $champs = [], string $lien_retour = "index.php", string $desc_sup = "", string $action_sup = "", int $id) {
    $titre = "Modification ".($this->est_masculin ? "du " : "de la ").$this->entite;
    $titre_sup = "Suppression ".($this->est_masculin ? "du " : "de la ").$this->entite;
    ?>
    <html>
      <?php echo $this->genere_header($titre); ?>
      <script type="text/javascript" src="front/displayClasses/FormPage/formpage.js"></script>
      <body>
        <div class="page">
          <!-- Appel de la méthode d'affichage du menu -->
          <?php $this->afficheMenu(); ?>
          <main class="page-body">
            <div class="container">
              <div class="nom-container"><?php echo $titre; ?></div>
              <!-- formulaire -->
              <form class="centrer" method="post" action="<?php echo $action; ?>">
                <input type="hidden" value="<?php echo $id; ?>" name="ID">
                <!-- Crée les champs du formulaire -->
                <?php $this->genere_formulaire($champs); ?>
                <!-- Bouton de modification et de retour -->
                <div class="lignebouton">
                  <input value="Modifier" type="submit" class="coloredButton">
                  <a href=<?php echo $lien_retour; ?> class="coloredButton">Retour à la liste</a>
                </div>
              </form>
            </div>
            <form class="center-container" action="<?php echo $action_sup; ?>" method="post">
              <div class="nom-container danger"><?php echo $titre_sup; ?></div>
              <input type="hidden" value="<?php echo $id; ?>" name="ID">
              <p class="alerte-container"><?php echo $desc_sup; ?><br><br>Cette action est irréversible.</p>
              <!-- Bouton de suppression -->
              <div class="lignebouton">
                <a class="coloredButton danger-button" id="btSup" onclick="afficheConfirmation()">Supprimer</a>
                <a class="coloredButton invisible" id="btAnnuleSup" onclick="cacheConfirmation()">Annuler la suppression</a>
                <a href=<?php echo $lien_retour; ?> class="coloredButton">Retour à la liste</a>
              </div>
              <div class="lignebouton invisible" id="ligneBtConfSup">
                <input type="submit" class="coloredButton danger-button" value="Confirmer la suppression">
              </div>
            </form>
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