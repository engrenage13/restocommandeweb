// Fonctions utilisées dans la gestion des divers formulaire utilisés sur les pages de création, modification et suppression d'entités.

/**
 * Affiche et cache différent éléments de la page de suppression lorsque que l'on appuie sur le bouton "Supprimer", pour afficher une demande de confirmation.
 */
function afficheConfirmation() {
  const btSup = document.getElementById('btSup');
  const btAnnuleSup = document.getElementById('btAnnuleSup');
  const ligneBtConfSup = document.getElementById('ligneBtConfSup');
  btSup.classList.add('invisible');
  btAnnuleSup.classList.remove('invisible');
  ligneBtConfSup.classList.remove('invisible');
}

/**
 * Affiche et cache différent éléments de la page de suppression lorsque que l'on appuie sur le bouton "Annuler la suppression", pour revenir à l'affichage de base.
 */
function cacheConfirmation() {
  const btSup = document.getElementById('btSup');
  const btAnnuleSup = document.getElementById('btAnnuleSup');
  const ligneBtConfSup = document.getElementById('ligneBtConfSup');
  btSup.classList.remove('invisible');
  btAnnuleSup.classList.add('invisible');
  ligneBtConfSup.classList.add('invisible');
}

/**
 * Vérifie si la valeur du champ debut est inférieur à la valeur du champ fin.
 * @returns true si debut < fin.
 */
function verifDebutInferieurAFin() {
  const debut = document.getElementById('debut');
  const fin = document.getElementById('fin');
  let reponse = false;
  if (debut.value < fin.value) {
    reponse = true;
  } else {
    reponse = false;
  }
  return reponse;
}

/**
 * Cache ou révèle des éléments d'interface en fonction des données saisies dans les champs de début et fin lors de la saisie ou modification d'un PV.
 */
function modifFormDebutEtFin() {
  const verif = verifDebutInferieurAFin();
  const warningDebut = document.getElementById('warning-debut');
  const warningFin = document.getElementById('warning-fin');
  const message = document.getElementById('info-deb-fin');
  const btSubmit = document.getElementById('submit-pv');
  if (verif) {
    if (btSubmit.disabled == true) {
      warningDebut.classList.add('invisible');
      warningFin.classList.add('invisible');
      message.classList.add('invisible');
      btSubmit.disabled = false;
    }
  } else {
    if (btSubmit.disabled == false) {
      warningDebut.classList.remove('invisible');
      warningFin.classList.remove('invisible');
      message.classList.remove('invisible');
      btSubmit.disabled = true;
    }
  }
}

/**
 * Echange l'heure de début et l'heure de fin.
 */
function switchHeures() {
  const debut = document.getElementById('debut');
  const fin = document.getElementById('fin');
  const heureDebut = debut.value;
  debut.value = fin.value;
  fin.value = heureDebut;
  // Lance la vérification des heures pour voir si le début est inférieur à la fin.
  modifFormDebutEtFin();
}

/**
 * Vérifie si un surveillant a été sélectionné pour activer le bouton d'ajout du PV passé en paramètre.
 * @param {number} pv Identifiant du PV pour lequel on fait la vérification. 
 */
function activeAddSurveillant(pv) {
  const select = document.getElementById("surveillant-"+pv);
  const submit = document.getElementById("submit-add-surveillant-"+pv);
  if (select.value == 0) {
    submit.disabled = true;
  } else {
    submit.disabled = false;
  }
}

/**
 * Etend ou repli la capsule désignée en fonction de la valeur d'un champ.
 * @param {string} capsule Identifiant de la capsule.
 * @param {string} entete_capsule Identifiant de l'entête de la capsule.
 * @param {string} contenu_capsule Identifiant du bloc de contenu de la capsule.
 * @param {string} parametre Identifiant du champ de saisie pour lequel on veut récupérer la valeur.
 */
function etendRepliCapsule(capsule, entete_capsule, contenu_capsule, parametre) {
  const html_capsule = document.getElementById(capsule);
  const entete = document.getElementById(entete_capsule);
  const contenu = document.getElementById(contenu_capsule);
  const interrupteur = document.getElementById(parametre);
  if (interrupteur.value == 0) {
    // Capsule
    html_capsule.classList.add('capsule_champs_desactive');
    html_capsule.classList.remove('capsule_champs');
    // Entête
    entete.classList.add('entete_capsule_champs_desactive');
    entete.classList.remove('entete_capsule_champs');
    // Contenu
    contenu.classList.add('invisible');
  } else {
    // Capsule
    html_capsule.classList.add('capsule_champs');
    html_capsule.classList.remove('capsule_champs_desactive');
    // Entête
    entete.classList.add('entete_capsule_champs');
    entete.classList.remove('entete_capsule_champs_desactive');
    // Contenu
    contenu.classList.remove('invisible');
  }
}
