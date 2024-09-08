<?php

/**
 * Classe générant le calendrier.
 */
class Calendar {
  private array $liste_jours = ['Lundi', 'Mardi', 'Mercredi','Jeudi', 'Vendredi', 'Samedi','Dimanche'];
  private array $liste_mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
  private string $date;
  private string $jour;
  private string $mois;
  private string $annee;
  private string $today;
  // Base de l'url de la page dans laquelle sera affiché ce composant.
  private string $base_url;

  /**
   * Constructeur de la classe.
   * @param string $date Date sélectionnée sur le calendrier (format base de données : aaaa-mm-jj).
   * @param string $base_url La base de l'url à utiliser sur les boutons, afin de rester sur la même page tout en passant les commandes des boutons.
   */
  public function __construct(string $date, string $base_url) {
    $this->date = $date;
    $this->jour = extract_day_of_date($date);
    $this->mois = extract_month_of_date($date);
    $this->annee = extract_year_of_date($date);
    $this->today = date("Y-m-d");
    $this->base_url = $base_url;
  }

  /**
   * Renvoi le lien permettant de passer au mois suivant.
   * @return string Le lien pour passer au premier jour du mois suivant.
   */
  private function get_link_mois_suivant(): string {
    $mois = $this->mois+1;
    $annee = intval($this->annee);
    if ($mois == 13) {
      $mois = 1;
      $annee++;
    }
    return $this->base_url."?date=".date("Y-m-d", mktime(0, 0, 0, $mois, 1, $annee));
  }

  /**
   * Renvoi le lien permettant de passer au mois précédent.
   * @return string Le lien pour passer au dernier jour du mois précédent.
   */
  private function get_link_mois_precedent(): string {
    $mois = $this->mois-1;
    $annee = intval($this->annee);
    if ($mois == 0) {
      $mois = 12;
      $annee--;
    }
    return $this->base_url."?date=".date("Y-m-d", mktime(0, 0, 0, $mois, cal_days_in_month(CAL_GREGORIAN, $mois, $annee), $annee));
  }

  /**
   * Renvoi le lien permettant de passer au premier jour avec des épreuves.
   * @return string Le lien du premier jour avec des PVs ou vers aujourd'hui s'il n'y a aucun PV.
   */
  private function get_link_first_day_with_epreuves(): string {
    $date = fetchFirstDateEpreuve();
    if ($date == null) {
      $date = date("Y-m-d");
    }
    return "$this->base_url?date=$date";
  }

  /**
   * Renvoi le lien permettant de passer au dernier jour avec des épreuves.
   * @return string Le lien du dernier jour avec des PVs ou vers aujourd'hui s'il n'y a aucun PV.
   */
  private function get_link_last_day_with_epreuves(): string {
    $date = fetchLastDateEpreuve();
    if ($date == null) {
      $date = date("Y-m-d");
    }
    return "$this->base_url?date=$date";
  }

  /**
   * Permet d'afficher le calendrier à l'écran.
   * @param bool $affiche_colonne Si true, les différents bloc du calendrier sont affichés en colonne, les uns au dessus des autres. Sinon ils sont affichés en ligne, les uns à côté des autres.
   * @param array $classes Liste de classes css à ajouter au calendrier.
   * @param string $styles Styles css à ajouter au calendrier.
   */
  public function affiche(bool $affiche_colonne = true, array $classes = [], string $styles = "") {
    $mois = intval($this->mois);
    $annee = intval($this->annee);
    $premier_decalage = date("w", mktime(0, 0, 0, $mois, 0, $annee));
    $nombre_de_jours_dans_le_mois = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);
    $nb_cases = $premier_decalage + $nombre_de_jours_dans_le_mois;
    // On vérifie si le total de cases modulo 7 est plus grand que 0.
    if ($nb_cases % 7 > 0) {
      // Si c'est la cas, on augmente le nombre jusqu'à ce qu'il soit égal à 0 quand il est comparé à un modulo 7.
      $nb_cases += (7 - $nb_cases%7);
    }
    ?>
    <style>
      .element-cliquable-actif {
        background-color: var(--bloc-color);
        &:hover {
          background-color: var(--primary-hover);
        }
      }
    </style>
    <div class="container-principal calendrier" style="<?php echo $affiche_colonne ? "flex-direction: column;" : ""; ?> <?php echo $styles; ?>">
      <!-- Calendrier -->
      <div class="container <?php echo implode(" ", $classes); ?>" style="min-width: 25rem; <?php echo !$affiche_colonne ? "align-self: flex-start;" : ""; ?>">
        <div class="nom-container" style="padding: .5rem 0 0; align-items: center; text-indent: 0; flex-direction: column;">
          <div class="ligne-tableau-container" style="width: 100%; border: none;">
            <a href="<?php echo $this->get_link_mois_precedent(); ?>" class="icobouton" style="margin-left: 1rem;"><img src="images/icones/retour.svg" alt="<" width="25rem"></a>
            <h4 style="display: flex; flex-grow: 1; align-self: center; justify-content: center; font-size: medium;"><?php echo $this->liste_mois[$mois-1]." ".$this->annee; ?></h4>
            <a href="<?php echo $this->get_link_mois_suivant(); ?>" class="icobouton" style="margin: 0 1rem 0 0;"><img src="images/icones/fleche.svg" alt=">" width="25rem"></a>
          </div>
          <div class="ligne-tableau-container" style="margin: .4rem 0 .2rem; width: 97.5%; border: none;">
            <?php
            foreach ($this->liste_jours as $jour) {
              ?>
              <div class="case"><?php echo substr($jour, 0, 1); ?></div>
              <?php
            }
            ?>
          </div>
        </div>
        <div class="liste-verticale" style="margin: .5rem; padding-right: 0; gap: .3rem;">
          <?php
          $compteur = 1;
          for ($i = 0; $i < ($nb_cases/7); $i++) {
            ?>
            <div class="ligne-tableau-container" style="border: none; gap: .3rem;">
              <?php
              for ($j = 0; $j < 7; $j++) {
                // Définition du jour de la semaine.
                $jour = 0;
                if ($compteur > $premier_decalage && $compteur <= ($premier_decalage+$nombre_de_jours_dans_le_mois)) {
                  $jour = $compteur-$premier_decalage;
                }
                // Date du jour traité au format aaaa-mm-yy.
                $date = date("Y-m-d", mktime(0, 0, 0, $mois, $jour, $annee));
                // Vérification du nombre d'épreuves ayant lieu ce jour.
                $nb_epreuves = countEpreuvesOfOneDay($date);
                ?>
                <div class="case">
                  <a href="<?php echo $jour == 0 ? "" : "$this->base_url?date=$annee-$this->mois-".date("d", mktime(0, 0, 0, $mois, $jour, $annee)); ?>" 
                    class="<?php echo $jour == 0 ? "element-cliquable-desactive" : ($nb_epreuves == 0 ? "element-cliquable" : "element-cliquable-actif"); ?> calendrier-case <?php echo $this->today == $date ? "calendrier-today" : ""; ?> <?php echo $this->date == $date ? "calendrier-selected" : ""; ?>" 
                    style="<?php echo $j >= 5 ? "color: #f64032;" : ""; ?>"
                  >
                    <?php echo $jour == 0 ? "" : $jour; ?>
                  </a>
                </div>
                <?php
                $compteur++;
              }
              ?>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
      <!-- Barre des options avancées -->
      <div class="container <?php echo $affiche_colonne ? "ligne-tableau-container" : ""; ?>" style="border: none; <?php echo $affiche_colonne ? "margin-top: 0;" : "margin-left: 0;"; ?> padding: .5rem; justify-content: space-between;">
        <a href="<?php echo $this->get_link_first_day_with_epreuves(); ?>" class="icobouton"><img src="../images/icones/gotofirst.svg" alt="<<" width="25rem"></a>
        <?php
        if ($affiche_colonne) {
          // Si le calendrier est affiché en colonne, on affiche un bouton "aujourd'hui".
          ?>
          <a href="<?php echo "$this->base_url?date=".date("Y-m-d"); ?>" class="coloredButton">Aujourd'hui</a>
          <?php
        } else {
          // Sinon on affiche un petit bouton rond avec un cercle.
          ?>
          <a href="<?php echo "$this->base_url?date=".date("Y-m-d"); ?>" class="icobouton"><img src="../images/icones/cercle.svg" alt="Aujourd'hui" width="25rem"></a>
          <?php
        }
        ?>
        <a href="<?php echo $this->get_link_last_day_with_epreuves(); ?>" class="icobouton"><img src="../images/icones/gotolast.svg" alt=">>" width="25rem"></a>
        <a class="icobouton" onclick="afficheCacheLegende()"><img src="../images/icones/question.svg" alt="Afficher/cacher la légende" width="25rem"></a>
      </div>
      <!-- Panneau de la légende -->
      <div id="legende" class="container invisible" style="<?php echo $affiche_colonne ? "margin-top: 0;" : "margin-left: 0;"; ?> padding: .5rem .5rem 0;">
        <div class="ligne-tableau-container espace-haut">
          <div class="calendrier-case element-cliquable-actif">3</div>
          <p>Jour où il y a des épreuves organisées</p>
        </div>
        <div class="ligne-tableau-container espace-haut">
          <div class="calendrier-case element-cliquable calendrier-today">7</div>
          <p>Aujourd'hui</p>
        </div>
        <div class="ligne-tableau-container espace-haut">
          <div class="calendrier-case element-cliquable calendrier-selected">13</div>
          <p>Jour sélectionné sur le calendrier</p>
        </div>
        <div class="ligne-tableau-container espace-haut">
          <div class="calendrier-case element-cliquable" style="color: #f64032;">19</div>
          <p>Jour de week-end</p>
        </div>
        <div class="ligne-tableau-container espace-haut" style="height: 10rem;">
          <button class="icobouton"><img src="../images/icones/gotofirst.svg" alt="<<" width="25rem"></button>
          <p style="max-width: 23rem; margin-left: 2rem;">Permet d'accéder au premier jour où il y a des épreuves organisées.</p>
        </div>
        <div class="ligne-tableau-container espace-haut" style="height: auto;">
          <button class="icobouton"><img src="../images/icones/gotolast.svg" alt=">>" width="25rem"></button>
          <p style="max-width: 23rem; margin-left: 2rem;">Permet d'accéder au dernier jour où il y a des épreuves organisées.</p>
        </div>
        <?php
        if (!$affiche_colonne) {
          ?>
          <div class="ligne-tableau-container espace-haut" style="height: auto;">
            <button class="icobouton"><img src="../images/icones/cercle.svg" alt="Aujourd'hui" width="25rem"></button>
            <p style="max-width: 23rem; margin-left: 2rem;">Permet d'accéder à aujourd'hui.</p>
          </div>
          <?php
        }
        ?>
      </div>
    </div>
    <script type="text/javascript" src="front/components/Calendar/calendar.js"></script>
    <?php
  }
}

?>