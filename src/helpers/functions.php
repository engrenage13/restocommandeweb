<?php

/**
 * Vérifie si un élément est présent dans une liste.
 * @param string $valeur La valeur recherchée.
 * @param array $liste La liste dans laquelle on cherche.
 * @return bool True si la liste contient la valeur recherchée.
 */
function exist_in_list(string $valeur, array $liste): bool {
  $reponse = false;
  $i = 0;
  while (!$reponse && $i < sizeof($liste)) {
    if ($liste[$i] == $valeur) {
      $reponse = true;
    } else {
      $i++;
    }
  }
  return $reponse;
}

/**
 * Trouve la position d'un élément dans une liste.
 * @param string $valeur La valeur recherchée.
 * @param array $liste La liste dans laquelle on cherche.
 * @return int La position de l'élément recherchée ou -1 s'il n'est pas dans la liste.
 */
function get_position_in_list(string $valeur, array $liste): int {
  $reponse = -1;
  $i = 0;
  while ($reponse == -1 && $i < sizeof($liste)) {
    if ($liste[$i] == $valeur) {
      $reponse = $i;
    } else {
      $i++;
    }
  }
  return $reponse;
}

/**
 * Extrait l'année d'une date.
 * @param string $date Date au format aaaa-mm-jj.
 * @return string L'année de la date.
 */
function extract_year_of_date(string $date): string {
  return substr($date, 0, 4);
}

/**
 * Extrait le mois d'une date.
 * @param string $date Date au format aaaa-mm-jj.
 * @return string Le mois de la date.
 */
function extract_month_of_date(string $date): string {
  return substr($date, 5, 2);
}

/**
 * Extrait le jour d'une date.
 * @param string $date Date au format aaaa-mm-jj.
 * @return string Le jour de la date.
 */
function extract_day_of_date(string $date): string {
  return substr($date, 8, 2);
}

/**
 * Vérifie si un élément est présent dans une liste.
 * @param string $valeur La valeur recherchée.
 * @param array $liste La liste dans laquelle on cherche.
 * @return bool True si la liste contient la valeur recherchée.
 */
function is_in_list(string $value, array $list): bool {
  $answer = false;
  $i = 0;
  while (!$answer && $i < sizeof($list)) {
    if ($list[$i] == $value) {
      $answer = true;
    } else {
      $i++;
    }
  }
  return $answer;
}

/**
 * Vérifie si la route testée existe réélement.
 * @param string $route La route à tester.
 * @return bool True si la route existe.
 */
function check_route_exist(string $route): bool {
  // On liste toutes les routes existantes.
  $routes = scandir('.');
  array_splice($routes, 0, 2);
  // On vérifie si la route passée en paramètres existe dans la liste des routes.
  return is_in_list($route, $routes);
}

/**
 * Teste la route passée en paramètre et la renvoie si elle est validée, ou une route d'erreur dans le cas contraire.
 * @param string $route La route testée.
 * @return string La route retournée (celle passée à la fonction ou une route d'erreur).
 */
function re_route(string $route): string {
  if (check_route_exist($route)) {
    $reponse = $route;
  } else {
    $reponse = "404.php";
  }
  return $reponse;
}

?>
