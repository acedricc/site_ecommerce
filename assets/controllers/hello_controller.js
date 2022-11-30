import { Controller } from '@hotwired/stimulus';

/*
 * Ceci est un exemple de contrôleur Stimulus !
 *
 * Tout élément avec un attribut data-controller="hello" provoquera
 * ce contrôleur à exécuter. Le nom "hello" vient du nom de fichier :
 * bonjour_controller.js -> "bonjour"
 *
 * Supprimez ce fichier ou adaptez-le à votre usage !
 */
export default class extends Controller {
    connect() {
        this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
    }
}
