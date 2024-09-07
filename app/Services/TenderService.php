<?php

namespace App\Services;

use App\Models\Tender;
use Carbon\Carbon;
use DiDom\Document;

class TenderService
{
    // Основной метод для парсинга тендеров
    public function parseTenders()
    {
        $domain = 'https://com.ru-trade24.ru';
        $url = $domain . '/query/Filter?MainPageFilterTradeStatus=IsParticipanceOpened';

        // Бесконечный цикл для обхода страниц с тендерами
        while (true) {
            // Загружаем HTML-документ с текущей страницы
            $document = new Document($url, true);
            // Находим все карточки тендеров на странице
            $cards = $document->find('.trade-card');

            // Обрабатываем каждую карточку тендера
            foreach ($cards as $card) {
                // Получаем ссылку на тендер
                $cardUrl = $card->first('a')->getAttribute('href');

                // Извлекаем номер тендера и название организации
                $tenderNum = preg_replace('#[^0-9]#', '', $card->first('.trade-card__type')->text());
                $tenderOrganization = $card->first('.trade-card__name')->text();
                $tenderLink = $domain . $cardUrl;

                // Загружаем страницу тендера для получения дополнительных данных
                $cardDocument = new Document($tenderLink, true);
                $tenderStartDate = $cardDocument->xpath('//*[@id="maininfo"]/div[13]/div')[0]->text();
                $tenderStartDate = Carbon::createFromFormat('d.m.Y H:i', $tenderStartDate);

                // Проверяем, существует ли тендер с таким номером
                if (Tender::where('tender_number', $tenderNum)->exists()) {
                    continue; // Пропускаем, если тендер уже существует
                }

                // Создаем новый тендер в базе данных
                $tender = Tender::query()->create([
                    'tender_number' => $tenderNum,
                    'organization' => $tenderOrganization,
                    'link' => $tenderLink,
                    'start_date' => $tenderStartDate
                ]);

                // Получаем документы тендера
                $tenderDocumentsDoc = $cardDocument->xpath('//*[@id="blockdoc"]');

                // Обрабатываем каждый документ
                foreach ($tenderDocumentsDoc as $doc) {
                    foreach ($doc->find('a') as $docLink) {
                        $docName = $docLink->text();
                        $docLinkUrl = $domain . $docLink->getAttribute('href');
                        // Сохраняем информацию о документе в базе данных
                        $tender->files()->create([
                            'file_name' => $docName,
                            'file_link' => $docLinkUrl
                        ]);
                    }
                }
            }

            // Проверяем наличие ссылки на следующую страницу
            $nextPageLink = $document->first('.paging__arrow--next');

            // Если следующей страницы нет, выходим из цикла
            if (!$nextPageLink) {
                break;
            }

            // Получаем URL следующей страницы
            $nextPageUrl = $nextPageLink->getAttribute('href');

            // Если URL не полный, добавляем домен
            if (!preg_match('#^http#', $nextPageUrl)) {
                $nextPageUrl = $domain . $nextPageUrl;
            }

            // Обновляем URL для следующей итерации
            $url = $nextPageUrl;
        }
    }
}
