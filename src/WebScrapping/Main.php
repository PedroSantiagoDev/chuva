<?php

namespace Chuva\Php\WebScrapping;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

/**
 * Runner for the Webscrapping exercice.
 */
class Main
{

    /**
     * Main runner, instantiates a Scrapper and runs.
     */
    public static function run(): void
    {
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadHTMLFile(__DIR__ . '/../../assets/origin.html');

        $data = (new Scrapper())->scrap($dom);

        // Write your logic to save the output file bellow.
        $white = WriterEntityFactory::createXLSXWriter();
        $white->openToFile(__DIR__ . '/../../assets/origin.xlsx');

        $header = [
            WriterEntityFactory::createCell('ID'),
            WriterEntityFactory::createCell('Title'),
            WriterEntityFactory::createCell('Type'),
            WriterEntityFactory::createCell('Author 1'),
            WriterEntityFactory::createCell('Author 1 Institution'),
            WriterEntityFactory::createCell('Author 2'),
            WriterEntityFactory::createCell('Author 2 Institution'),
            WriterEntityFactory::createCell('Author 3'),
            WriterEntityFactory::createCell('Author 3 Institution'),
            WriterEntityFactory::createCell('Author 4'),
            WriterEntityFactory::createCell('Author 4 Institution'),
            WriterEntityFactory::createCell('Author 5'),
            WriterEntityFactory::createCell('Author 5 Institution'),
            WriterEntityFactory::createCell('Author 6'),
            WriterEntityFactory::createCell('Author 6 Institution')
        ];
        $headerRow = WriterEntityFactory::createRow($header);
        $white->addRow($headerRow);

        foreach ($data as $row) {
            $authors = $row->getAuthors();
            $rowData = [
                $row->getId(),
                preg_replace('/\s+/', ' ', $row->getTitle()),
                $row->getType(),
            ];
            foreach ($authors as $author) {
                $rowData[] = $author['author'] ?? '';
                $rowData[] = $author['institution'] ?? '';
            }
            $dataRow = WriterEntityFactory::createRowFromArray($rowData);
            $white->addRow($dataRow);
        }

        $white->close();
    }

}
