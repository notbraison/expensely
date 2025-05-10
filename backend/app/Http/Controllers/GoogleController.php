<?

namespace App\Http\Controllers;

use App\Services\GoogleContactsService;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    protected $googleContactsService;

    public function __construct(GoogleContactsService $googleContactsService)
    {
        $this->googleContactsService = $googleContactsService;
    }

    public function handleGoogleCallback(Request $request)
    {
        $googleContacts = $this->googleContactsService->getContacts();

        // Extract the contacts from Google and return them to the frontend
        $contacts = collect($googleContacts)->map(function ($contact) {
            return [
                'name' => $contact->getNames()[0]->getDisplayName(),
                'email' => $contact->getEmailAddresses()[0]->getValue(),
            ];
        });

        return response()->json($contacts);
    }
}
