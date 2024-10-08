<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testSomething(): void
    {
        // 1. creer un faux client(navigateur) de pointer vers une url
        $client = static::createClient();
        $client->request('GET', '/inscription');

        // 2. remplir les champs du formulaire(firstname, lastname, email, password, confirmPassword)
        $client->submitForm('S\'inscrire',[
            'register_user[email]' => 'test4@gmail.com',
            'register_user[plainPassword][first]' => '0123456789',
            'register_user[plainPassword][second]' => '0123456789',
            'register_user[firstname]'  => 'test',
            'register_user[lastname]' => 'test',
        ]);
        self::assertResponseRedirects('/connexion');
        $client->followRedirect();
        // 3. Est ce que j'ai le message de succès suivant : "Votre compte a bien été créé, vous pouvez vous connecter"
        self::assertSelectorExists('div:contains("Votre compte a bien été créé, vous pouvez vous connecter")');
    }
}
