<?php

/**
 * Génère un composant listant les dernières entités créées dans la bdd.
 * @todo Modify for generalize.
 */
class ExtractSome {
  // Variables et constantes de la classe.
  // Nom du type d'entite listé.
  private string $entite;
  // Entités listées.
  private array $liste;
  // True si le type listé et de genre masculin (UN examen, UN type, UN diplôme).
  private bool $est_masculin;
  private bool $au_pluriel;
  private string $lien_page_liste;

  /**
   * Construit la classe d'affichage du composant.
   * @param string $entite Nom du type d'entités (objets de la base de données) affichées dans la liste.
   * @param string $type Type de données à lister.
   * @param bool $est_masculin Précise le genre de ce qui a été saisie au paramètre précédent afin de faire des bons accords de grammaire.
   * @param bool $met_au_pluriel Si true, le type d'entité passé en paramètres sera affiché avec un "s" à la fin.
   * @param int $nb_element Nombre maximum d'éléments à afficher.
   */
  public function __construct(string $entite, string $type, bool $est_masculin = true, bool $met_au_pluriel = true, int $nb_element = 3) {
    $this->entite = strtolower($entite);
    $this->est_masculin = $est_masculin;
    $this->au_pluriel = $met_au_pluriel;
    $this->liste = [];
    switch (strtolower($type)) {
      case "destinataire": 
        $this->instancie_destinataires($nb_element);
        $this->lien_page_liste = "destinataire.php";
        break;
      case "diplome": 
        $this->instancie_diplomes($nb_element);
        $this->lien_page_liste = "diplome.php";
        break;
      case "matiere": 
        $this->instancie_matieres($nb_element);
        $this->lien_page_liste = "matiere.php";
        break;
      case "modele": 
        $this->instancie_modeles($nb_element);
        $this->lien_page_liste = "modele.php";
        break;
      case "salle": 
        $this->instancie_salles($nb_element);
        $this->lien_page_liste = "salle.php";
        break;
      case "surveillant": 
        $this->instancie_surveillants($nb_element);
        $this->lien_page_liste = "surveillant.php";
        break;
      case "type": 
        $this->instancie_types($nb_element);
        $this->lien_page_liste = "type.php";
        break;
      case "epreuve": 
        $this->instancie_epreuves($nb_element);
        $this->lien_page_liste = "epreuve.php";
        break;
    };
  }

  /**
   * Va chercher des destinataires sur la base de données et les charges dans la liste.
   * @param int $nb_element Nombre maximum d'éléments à afficher.
   */
  private function instancie_destinataires(int $nb_element) {
    $liste = fetchLastDestinataires($nb_element);
    foreach ($liste as $objet) {
      array_push($this->liste, new Destinataire($objet["id"], $objet["nom"]));
    }
  }

  /**
   * Va chercher des diplômes sur la base de données et les charges dans la liste.
   * @param int $nb_element Nombre maximum d'éléments à afficher.
   */
  private function instancie_diplomes(int $nb_element) {
    $liste = fetchLastDiplomes($nb_element);
    foreach ($liste as $objet) {
      array_push($this->liste, new Diplome($objet["id"], $objet["specialite"], $objet["option"], $objet["type"]));
    }
  }

  /**
   * Va chercher des matières sur la base de données et les charges dans la liste.
   * @param int $nb_element Nombre maximum d'éléments à afficher.
   */
  private function instancie_matieres(int $nb_element) {
    $liste = fetchLastMatieres($nb_element);
    foreach ($liste as $objet) {
      array_push($this->liste, new Matiere($objet["id"], $objet["nom"], $objet["code"]));
    }
  }

  /**
   * Va chercher des modèles sur la base de données et les charges dans la liste.
   * @param int $nb_element Nombre maximum d'éléments à afficher.
   */
  private function instancie_modeles(int $nb_element) {
    $liste = fetchLastModeles($nb_element);
    foreach ($liste as $objet) {
      array_push($this->liste, new Modele($objet["id"], $objet["nom"], $objet["document"], $objet["session"], $objet["specialite"], $objet["option"], $objet["matiere"], $objet["date"], $objet["heure_debut"], $objet["minute_debut"], $objet["heure_fin"], $objet["minute_fin"], $objet["surveillants"], $objet["effectif"], $objet["updated_at"]));
    }
  }

  /**
   * Va chercher des salles sur la base de données et les charges dans la liste.
   * @param int $nb_element Nombre maximum d'éléments à afficher.
   */
  private function instancie_salles(int $nb_element) {
    $liste = fetchLastSalles($nb_element);
    foreach ($liste as $objet) {
      array_push($this->liste, new Salle($objet["id"], $objet["nom"]));
    }
  }

  /**
   * Va chercher des surveillants sur la base de données et les charges dans la liste.
   * @param int $nb_element Nombre maximum d'éléments à afficher.
   */
  private function instancie_surveillants(int $nb_element) {
    $liste = fetchLastSurveillants($nb_element);
    foreach ($liste as $objet) {
      array_push($this->liste, new Surveillant($objet["id"], $objet["nom"], $objet["prenom"], $objet["civ"], $objet["ext"], $objet["email"], $objet['utilisateur']));
    }
  }

  /**
   * Va chercher des types de diplôme sur la base de données et les charges dans la liste.
   * @param int $nb_element Nombre maximum d'éléments à afficher.
   */
  private function instancie_types(int $nb_element) {
    $liste = fetchLastTypes($nb_element);
    foreach ($liste as $objet) {
      array_push($this->liste, new Type($objet["id"], $objet["nom"], $objet["code"], $objet["coordonnees"], $objet["modele"]));
    }
  }

  /**
   * Va chercher des épreuves sur la base de données et les charges dans la liste.
   * @param int $nb_element Nombre maximum d'éléments à afficher.
   */
  private function instancie_epreuves(int $nb_element) {
    $liste = fetchLastEpreuves($nb_element);
    foreach ($liste as $objet) {
      array_push($this->liste, new Epreuve($objet["id"], $objet["date"], $objet["date_envoi"], $objet["destinataire"], $objet["matiere"], $objet['diplome']));
    }
  }

  /**
   * Affiche le composant à l'écran.
   */
  public function affiche() {
    $titre = ($this->est_masculin ? "Derniers" : "Dernières").($this->au_pluriel ? " $this->entite"."s " : " $this->entite ").($this->est_masculin ? "créés" : "créées");
    ?>
      <style>
        .container {
          display: flex;
          flex-direction: column;
        }

        .liste {
          margin: .5rem 1rem 0;
        }

        .icone {
          transition: all .2s;
          margin: 0 .5rem 0 0;
        }
      </style>
      <div class="container">
        <div class="nom-container"><?php echo $titre; ?><b class="transparent">.</b></div>
        <div class="liste">
          <?php
          if (sizeof($this->liste) > 0) {
            // Affiche les éléments trouvés par le controller.
            foreach ($this->liste as $objet) {
              $objet->affiche(false);
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
        </div>
        <div class="ressort"></div>
        <a href="<?php echo $this->lien_page_liste; ?>" class="boutonLien">
          Toute la liste
          <img class="icone" src="../images/icones/fleche.svg" width="30rem">
        </a>
      </div>
    <?php
  }
}

?>