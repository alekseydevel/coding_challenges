<?php

namespace Transport\Export;

use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_BatchUpdateValuesRequest;
use Google_Service_Sheets_ValueRange;
use GuzzleHttp\Client;

class GoogleSheetWriter implements Writeable
{

    /*
     * connect to goole spreadsheets API didn't work. What has been tried out:
     * 1. API_KEY not working with non-public resources
     * 2. service account even with Owner role doesn't work
     * 2.1 Troubleshooting section says that the role should be called "Other", but didn't find it
     * 2.2 PHP samples github issues section has plenty of Oauth failures and questions
     * 2.3 Examples that fix it usually use Oauth2 (desktop, web) apps. We need server (cli) one.
     * Things to consider:
     * - make bulk request because Google SpreadSheets API has request limits
     */

    public function write(array $data): void
    {
        $sheetId = $_ENV['GOOGLE_SHEETS_SHEET_ID'];

        $client = $this->getClient();

        $service = new Google_Service_Sheets($client);

        $spreadsheetId = $sheetId;

        $requestBody = new Google_Service_Sheets_BatchUpdateValuesRequest();

        $response = $service->spreadsheets_values->batchUpdate($spreadsheetId, $requestBody);
    }

    private function getClient()
    {
        $client = new \Google\Client();
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
        $client->setAuthConfig('/var/www/config/config.json');
        $client->setAccessType('offline');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = '/var/www/config/token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new \Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }
}
