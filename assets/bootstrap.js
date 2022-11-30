import { startStimulusApp } from '@symfony/stimulus-bridge';

// Enregistre les contrôleurs Stimulus depuis controllers.json et dans le répertoire controllers/
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

// enregistrez ici tous les contrôleurs tiers personnalisés
// app.register('some_controller_name', SomeImportedController);