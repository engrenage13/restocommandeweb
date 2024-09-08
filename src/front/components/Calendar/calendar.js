// Liste des fonctions utilisées par le calendrier pour son fonctionnement interne

/**
 * Affiche ou cache la légende du calendrier.
 */
function afficheCacheLegende() {
  const blocLegende = document.getElementById("legende");
  // Vérifie si la légende est cachée.
  if (blocLegende.classList.contains("invisible")) {
    // Si c'est le cas, on la révèle.
    blocLegende.classList.remove("invisible");
  } else {
    // Sinon, on la cache.
    blocLegende.classList.add("invisible");
  }
}