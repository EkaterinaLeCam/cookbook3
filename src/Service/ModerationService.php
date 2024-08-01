<?php

namespace App\Service;

use OpenAI;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ModerationService
{
    private $param;
    public function __construct(ParameterBagInterface $param)
    {
        $this->param = $param;
    }
    /**
     * Modéraition des commentaires :
     * 
     * L'utilisateur soumet le formulaire de commentaire
     * Récupération des données du formulaire (contenu)
     * Envoi du contenu + prompt à OpenAI
     * Si la réponse est `true`
     * Alors le statut du commentaire est `true`
     * Sinon le statut du commentaire est `false`
     * 
     * @param string $contenu
     * @return bool
     */

    public function checkComment(string $contenu): bool
    {
        $prompt = "Tu es un modérateur de commentaires sur un réseau social culinaire. Ton rôle consiste à vérifier si le commentaire suivant est correct, c'est-à-dire : sans insultes en français ou anglais, sans violence dans le contenu, sans discrimination des individus et tout autre forme qui peut être associé aux éléments cités avant. Si le commentaire est correct, renvoit la réponse 'true', sinon renvoit 'false'. \n\n Commentaire : " . $contenu . "\n\n Ce commentaire contient-il correct ? Réponse :
";
        $yourApiKey = $this->param->get('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        $result = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => $prompt],
            ],
        ]);

        if ($result->choices[0]->message->content == 'true') {
            return true;
        } else {
            return false;
        }
    }
}
