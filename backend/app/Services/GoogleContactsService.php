<?
namespace App\Services;

use Google\Client;
use Google\Service\PeopleService;

class GoogleContactsService
{
    protected $client;
    protected $peopleService;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('app/google-credentials.json')); // Your credentials file
        $this->client->addScope(PeopleService::CONTACTS_READONLY); // Define the scope to access contacts
        $this->client->setAccessType('offline');
        $this->peopleService = new PeopleService($this->client);
    }

    public function getContacts()
    {
        // Get the authenticated user's contacts
        $contacts = $this->peopleService->people_connections->listPeopleConnections('people/me', [
            'personFields' => 'names,emailAddresses',
        ]);

        return $contacts->getConnections();
    }
}
