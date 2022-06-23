<?php

namespace Src\Domain\Service;

use Google\Service\Sheets;
use Google\Service\Sheets\Spreadsheet;
use Google\Service\Sheets\ValueRange;
use Src\Domain\Entity\GoogleApiSheet;
use Src\Domain\Entity\GoogleApiSheetCollection;
use Src\Middleware\Connectors\SheetApiConnector;

class GoogleSheetsAPIService
{
    private Sheets $sheets;

    public function __construct(
        private readonly SheetApiConnector $connector,
    )
    {
        $this->sheets = (new \Google_Service_Sheets($this->connector->getConnection()));
    }

    public function apiSheetCreate(string $filename): Spreadsheet
    {
        $spreadsheet = new Spreadsheet([
            'properties' => [
                'title' => $filename
            ]
        ]);

        return $this->sheets->spreadsheets->create($spreadsheet, ['fields' => 'spreadsheetId']);
    }

    public function apiSheetUpdate(Spreadsheet $spreadsheet, GoogleApiSheetCollection $requestBody): string
    {
        $values = [];
        /** @var GoogleApiSheet $item */
        foreach ($requestBody as $item) {
            $values[] = [
                $item->getEntityId(), $item->getLink(), $item->getPrice()
            ];
        }
        $body = new ValueRange(['values' => $values]);
        $params = ['valueInputOption' => 'RAW'];
        $result = $this->sheets->spreadsheets_values->append(
            $spreadsheet->getSpreadsheetId(), 'Sheet1', $body, $params);
        return $result->getSpreadsheetId();
    }

    public function getSheets(): Sheets
    {
        return $this->sheets;
    }
}