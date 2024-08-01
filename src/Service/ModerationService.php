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
        $prompt = "Vous êtes un modérateur de commentaires. Vous devez vérifier si le commentaire suivant est correct, c'est-à-dire : sans insultes, sans violence, sans discrimination. Si le commentaire est correct, renvoyez la réponse `true`, sinon renvoyez `false`. \n\nCommentaire : " . $contenu;
        $yourApiKey = $this->param->get('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);

        $result = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return $result->choices[0]->message->content; 
    }
}
