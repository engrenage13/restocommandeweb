<?php

/**
 * Interface de tous les objets de l'application.
 */
interface Objet {
  public function affiche();
  public function getChamps(): array;
}

?>